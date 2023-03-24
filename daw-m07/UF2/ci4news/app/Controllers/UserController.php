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

            echo "<pre>";
            print_r($data);
            echo "</pre>";
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
                //if validation succeeds, save the data to the database
                $model = new \App\Models\UserModel();
                $newData = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => password_hash($data['password'], PASSWORD_DEFAULT)
                ];
                $model->save($newData);
                //redirect to the login page
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
