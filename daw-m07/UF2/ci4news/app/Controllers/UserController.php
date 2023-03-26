<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class UserController extends BaseController
{
    private $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        helper(['form']);
    }

    public function index()
    {
        //
    }

    public function dashboard()
    {
        $order = $this->request->getVar('order');
        $sort = $this->request->getVar('sort');

        $model = model('UserModel');

        if ($order != null && $sort != null) {
            if (strtolower($sort) == 'asc') {
                $sort = 'desc';
            } else if (strtolower($sort) == 'desc') {
                $sort = 'asc';
            }
            $data['info_users'] = $model->fetchUsers($order, $sort);
        } else {
            $sort = 'asc';
            $data['info_users'] = $model->fetchUsers();
        }
        $data['title'] = "Dashboard users";
        $data['pager'] = $model->pager;
        $data['sort'] = $sort;
        return view("user/user_dashboard", $data);
    }

    public function update($usrId = null)
    {
        $usrModel = model('UserModel');
        $rolModel = model('RolesModel');
        $data['user'] = $usrModel->find($usrId);
        if (empty($data['user'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('No s\'ha trobat l\'usuari amb usrId: ' . $usrId);
        }

        $data['roles'] = $rolModel->findAll();
        $data['title'] = "Update user";

        if ($this->request->getMethod() == 'post') {
            $usrModel->updateUsr($usrId, $this->request->getPost());
            return redirect()->to('/users/dashboard');
        }
        return view("user/update", $data);
    }

    public function delete($usrId = null)
    {
        $usrModel = model('UserModel');
        $usrModel->delete($usrId);
        return redirect()->to('/users/dashboard');
    }

    public function loginAction()
    {
        if ($this->session->get('isLoggedIn') || $this->session->get('remember')) {
            return redirect()->to('/private_dashboard');
        }
        if ($this->request->getMethod() != 'post') {
            return view('user/login', ['title' => 'Log In']);
        }

        $validationRules = [
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'L\'email és obligatori',
                    'valid_email' => 'L\'email no es vàlid'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[4]',
                'errors' => [
                    'required' => 'La contrasenya és obligatòria',
                    'min_length' => 'La contrasenya ha de tenir almenys 4 caràcters'
                ]
            ]
        ];

        if ($this->validate($validationRules)) {
            $model = model('UserModel');

            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $remember = $this->request->getPost('remember');

            $user = $model->getUserByEmailOrName($email);
            if ($user) {
                if (password_verify($password, $user['password'])) {
                    $sessionData = [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'role' => $user['role_code'],
                        'isLoggedIn' => true
                    ];
                    if ($remember) {
                        $sessionData['remember'] = true;
                    }
                    $this->session->set($sessionData);
                    return redirect()->to('/private_dashboard');
                } else {
                    session()->setFlashdata('error', 'Credencials incorrectes');
                    return redirect()->to('/login')->withInput();
                }
            } else {
                session()->setFlashdata('error', 'Credencials incorrectes');
                return redirect()->to('/login')->withInput();
            }
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function registerAction()
    {
        helper('form');
        if ($this->request->getMethod() == 'post') {

            $data = $this->request->getPost();
            $rules = [
                'name' => [
                    'rules' => 'required|min_length[3]|max_length[20]',
                    'errors' => [
                        'required' => 'El nom és obligatori',
                        'min_length' => 'El nom ha de tenir almenys 3 caràcters',
                        'max_length' => 'El nom ha de tenir com a màxim 20 caràcters'
                    ]
                ],
                'email' => [
                    'rules' => 'required|valid_email|is_unique[users.email]',
                    'errors' => [
                        'required' => 'L\'email és obligatori',
                        'valid_email' => 'L\'email no és vàlid',
                        'is_unique' => 'Aquest email ja està registrat'
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[4]',
                    'errors' => [
                        'required' => 'La contrasenya és obligatòria',
                        'min_length' => 'La contrasenya ha de tenir almenys 4 caràcters'
                    ]
                ],
                'password_confirm' => [
                    'rules' => 'required|matches[password]',
                    'errors' => [
                        'required' => 'La confirmació de la contrasenya és obligatòria',
                        'matches' => 'Les contrasenyes no coincideixen'
                    ]
                ]
            ];
            if (!$this->validate($rules)) {
                session()->setFlashdata('error', 'Hi ha errors en el formulari');
                return redirect()->back()->withInput();
            } else {
                $model = new \App\Models\UserModel();
                $newData = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'role_code' => 'USR',
                    'password' => password_hash($data['password'], PASSWORD_DEFAULT)
                ];
                $model->save($newData);
                return redirect()->to('/login');
            }
        }

        return view('user/register', ['title' => 'Register']);
    }
    public function logoutAction()
    {
        $this->session->destroy();
        return redirect()->to('/');
    }

    public function privateDashboardAction()
    {
        return view('user/private_dashboard', ['title' => 'Private Dashboard']);
    }
}
