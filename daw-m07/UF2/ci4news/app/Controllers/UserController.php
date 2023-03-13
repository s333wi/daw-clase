<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class UserController extends BaseController
{
    public function index()
    {
        //
    }

    public function loginAction()
    {
        return view('user/login', ['title' => 'Log In']);
    }

    public function registerAction()
    {
        //see if the request is post
        if($this->request->getMethod() == 'post') {
            //get the data from the form
            $data = $this->request->getPost();
            dd($data);
            //validate the data
            $rules = [
                'name' => 'required|min_length[3]|max_length[20]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]|max_length[255]',
                'password_confirm' => 'matches[password]'
            ];
            if (!$this->validate($rules)) {
                //if validation fails, return to the form with errors
                return view('user/register', ['title' => 'Register', 'validation' => $this->validator]);
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
}
