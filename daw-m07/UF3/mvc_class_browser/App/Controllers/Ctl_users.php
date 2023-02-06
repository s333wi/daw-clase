<?php
namespace App\Controllers;
session_start();

use App\Models\Mdl_users;

class Ctl_users
{

    public function users_list(): void
    {
        $usr_model = new Mdl_users();

        $info_guests = $usr_model->getAllGuests();
        $info_users = $usr_model->getAllUsers();

        echo "<pre>";
        print_r($info_users);
        echo "</pre>";

        include 'App/views/users/page.php';
    }

    public function register_user(): void
    {
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        extract($data);

        $usr_model = new Mdl_users();
        $result = $usr_model->saveUser($nick, $nomcognoms, $mail, $edat, $contrasenya);

        include 'App/views/main.php';
    }

    public function login_user(): void
    {
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        extract($data);

    

        $usr_model = new Mdl_users();
        $result_login = $usr_model->loginUser($nick, $contrasenya);
        if($result_login === false){
            include 'App/views/users/login.php';
        } else {
            if($connected==='on'){
                setcookie('username', $nick, time() + 3600);
            } else if(empty($connected)){
                setcookie('username', $nick, time() - 3600);
            }

            $_SESSION['username'] = $nick;
            header('Location: index.php?action=dashboard');
            exit;
        }
    }
}
