<?php

namespace App\Controllers;

defined('MVC_APP') or die('Access denied');
session_start();

use App\Models\Mdl_users;
use App\Models\Mdl_news;


class Ctl_main
{

    function default_page()
    {
        $news_model = new Mdl_news();
        $info_news = $news_model->fetchAllNews();
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

    function logout(string $nick)
    {
        session_destroy();
        //Canviar esto pq estoy tratando la cookie como una session y no es asi
        setcookie('username', $nick, time() - 3600);
        header('Location: index.php');
    }

    function dashboard()
    {
        $usr_model = new Mdl_users();
        $level = $usr_model->getUserLevel($_SESSION['username']);
        include 'App/views/users/dashboard.phtml';
    }

    function viewAddNews(int $id = 0)
    {
        if (!empty($id)) {
            $news_model = new Mdl_news();
            $info_news = $news_model->getNews($id);
        }
        include 'App/views/news/addNews.phtml';
    }

    function viewAddUsers(string $id = '')
    {
        if (!empty($id)) {
            $usr_model = new Mdl_users();
            $info_user = $usr_model->getUser($id);
            
            echo "<pre>";
            print_r ($info_user);
            echo "</pre>";
            
        }
        include 'App/views/users/addUsers.phtml';
    }

    public function change_pass_view(){
        include 'App/views/users/change_pass.phtml';
    }
}
