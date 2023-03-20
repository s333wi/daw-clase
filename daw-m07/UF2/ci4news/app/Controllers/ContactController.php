<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ContactController extends BaseController
{
    public function index()
    {
        $config = [
            "textColor" => '#2cb58c',
            "backColor" => '#ffffff',
            "noiceColor" => '#5c00ce',
            "imgWidth" => 180,
            "imgHeight" => 40,
            "noiceLines" => 40,
            "noiceDots" => 20,
            "length" => 6,
            "expiration" => 5 * MINUTE
        ];

        $timage = new \App\Libraries\Text2Image($config);

        if ($this->request->getMethod() != 'post') {
            return view('contact/index', ['title' => 'Contacte', 'captcha' => $timage]);
        }

        $session = \Config\Services::session();
        $captcha = $session->get('captcha_text');

        $validationRules = [
            'name' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'El nom és obligatori',
                    'min_length' => 'El nom ha de tenir almenys 3 caràcters'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'L\'email és obligatori',
                    'valid_email' => 'L\'email no es vàlid'
                ]
            ],
            'subject' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'El subjecte és obligatori',
                    'min_length' => 'El subjecte ha de tenir almenys 3 caràcters'
                ]
            ],
            'message' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'El missatge és obligatori',
                    'min_length' => 'El missatge ha de tenir almenys 3 caràcters'
                ]
            ],
        ];
        
        if ($this->validate($validationRules)) {
            $name = $this->request->getPost('name');
            $email = $this->request->getPost('email');
            $subject = $this->request->getPost('subject');
            $message = $this->request->getPost('message');
            $captcha = $this->request->getPost('captcha');

            if ($captcha == $session->get('captcha_text')) {
                $session->setFlashdata('success', 'El missatge s\'ha enviat correctament');
                return redirect()->to('/contact');
            } else {
                $session->setFlashdata('error', 'El captcha no és correcte');
                return redirect()->to('/contact')->withInput();
            }
        } else {
            $session->setFlashdata('error', 'Hi ha errors en el formulari');
            return redirect()->to('/contact')->withInput();
        }
    }
}
