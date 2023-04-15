<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index($customLink = '')
    {
        helper('auth');
        
        $linkModel = model('LinkModel');
        if ($customLink) {
            $link = $linkModel->getLink($customLink);
            if ($link) {
                return redirect()->to($link->link);
            } else {
                return redirect()->to('/');
            }
        }
        return view('Home/index');
    }

    public function shortenUrl()
    {
        helper('auth');
        $linkModel = model('LinkModel');
        $url = $this->request->getPost('url');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            //Genero un alias aleatori per al link
            $customLink = $this->generateRandomString();
            //Comprovo si ja existeix
            while ($linkModel->checkCustomLink($customLink)) {
                $customLink = $this->generateRandomString();
            }

            $data = [
                'link' => $url,
                'custom_link' => $customLink,
            ];

            if (logged_in()) {
                $data['user_id'] = user_id();
            }

            $linkModel->insert($data);

            return redirect()->to($url);
        } else {
            return redirect()->to('/');
        }
    }

    private function generateRandomString($length = 16)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
