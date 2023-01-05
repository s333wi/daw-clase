<?php

namespace App\Controllers;

class Ctl_main
{

    function default_page()
    {

        include 'App/views/main.php';
    }

    function register()
    {
        include 'App/views/users/register.phtml';
    }

    function login()
    {
        if (isset($_COOKIE['username'])) {
            $_SESSION['username'] = $_COOKIE['username'];
            header('Location: index.php?action=dashboard');
            exit;
        }

        include 'App/views/users/login.phtml';
    }

    function logout()
    {
        session_destroy();
        header('Location: index.php');
    }

    function dashboard()
    {
        include 'App/views/users/dashboard.phtml';
    }
}
