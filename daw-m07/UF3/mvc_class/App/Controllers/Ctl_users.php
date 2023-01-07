<?php

namespace App\Controllers;

defined('MVC_APP') or die('Access denied');
session_start();

use App\Models\Mdl_users;

class Ctl_users
{

    public function register_user(): void
    {
        $data = filter_input_array(INPUT_POST);
        extract($data);

        $usr_model = new Mdl_users();

        //La variable result es la que passo a la vista per a mostrar el resultat de la inserció en el toast
        $result = $usr_model->saveUser($nick, $nomcognoms, $mail, $edat, $contrasenya);

        header('Location: index.php');
    }

    public function login_user(): void
    {
        $data = filter_input_array(INPUT_POST);
        extract($data);

        $usr_model = new Mdl_users();
        $result_login = $usr_model->loginUser($nick, $contrasenya);
        if ($result_login === false) {
            include 'App/views/users/login.phtml';
        } else {
            if ($connected === 'on') {
                setcookie('username', $nick, time() + 3600);
            } else if (empty($connected)) {
                setcookie('username', $nick, time() - 3600);
            }

            $_SESSION['username'] = $nick;
            header('Location: index.php?action=dashboard');
            exit;
        }
    }

    public function loadView()
    {
        $usr_model = new Mdl_users();
        $info_users = $usr_model->getAllUsers();
        $level = $usr_model->getUserLevel($_SESSION['username']);
        include 'App/views/users/users.phtml';
    }

    public function addUser()
    {
        $data = filter_input_array(INPUT_POST);
        extract($data);

        $usr_model = new Mdl_users();
        $result = $usr_model->saveUser($nick, $nomcognoms, $mail, $edat, $contrasenya, $level);

        $info_users = $usr_model->getAllUsers();
        $level = $usr_model->getUserLevel($_SESSION['username']);

        header('Location: index.php?action=manage_users');
    }

    public function change_pass()
    {
        $data = filter_input_array(INPUT_POST);
        extract($data);

        if ($contrasenya != $contrasenya2) {
            header('Location: index.php?action=dashboard');
            exit;
        }
        $usr_model = new Mdl_users();
        $result = $usr_model->changePass($contrasenya, $nick);

        header('Location: index.php?action=dashboard?success=1');
        exit;
    }
}
