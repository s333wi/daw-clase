<?php

namespace App\Controllers;

defined('MVC_APP') or die('Access denied');
session_start();

use App\Models\Mdl_users;
use App\Models\Mdl_news;


class Ctl_main
{
    //Mostra la pagina principal de noticies
    function default_page(): void
    {
        $news_model = new Mdl_news();
        $info_news = $news_model->fetchAllNews();
        include 'App/views/main.php';
    }

    //Mostra pagina de registre
    function register(): void
    {
        include 'App/views/users/register.phtml';
    }

    //Mostra pagina de login
    function login(): void
    {
        include 'App/views/users/login.phtml';
    }

    //Funcio que destrueix la sessio i redirigeix a la pagina principal
    function logout(): void
    {
        session_destroy();
        header('Location: index.php');
        exit;
    }

    //A les pagines que estan a dins del portal farem les comprovacions de sessio i de nivell d'usuari

    //Mostra el dashboard
    function dashboard(): void
    {
        if (!isset($_SESSION['username'])) {
            header('Location: index.php');
            exit;
        }
        $usr_model = new Mdl_users();
        $level = $usr_model->getUserLevel($_SESSION['username']);
        include 'App/views/users/dashboard.phtml';
    }

    //Mostra la vista per afegir una noticia
    function viewAddNews(int $id = 0): void
    {
        if (!isset($_SESSION['username'])) {
            header('Location: index.php');
            exit;
        }
        $usr_model = new Mdl_users();
        $level = $usr_model->getUserLevel($_SESSION['username']);
        if ($level < 5) {
            header('Location: index.php?action=dashboard');
            exit;
        }

        //Si rebem un id, vol dir que volem guardar/editar una noticia
        if (!empty($id)) {
            $news_model = new Mdl_news();
            $info_news = $news_model->getNews($id);
        }
        include 'App/views/news/addNews.phtml';
    }

    //Mostra la vista per afegir un usuari
    function viewAddUsers(string $id = ''): void
    {
        if (!isset($_SESSION['username'])) {
            header('Location: index.php');
            exit;
        }
        $usr_model = new Mdl_users();
        $level = $usr_model->getUserLevel($_SESSION['username']);
        if ($level < 10) {
            header('Location: index.php?action=dashboard');
            exit;
        }

        //Si rebem un id, vol dir que volem guardar/editar un usuari
        if (!empty($id)) {
            $usr_model = new Mdl_users();
            $info_user = $usr_model->getUser($id);
        }
        include 'App/views/users/addUsers.phtml';
    }

    //Mostra la vista per canviar la contrasenya d'un propi usuari
    public function change_pass_view(): void
    {
        if (!isset($_SESSION['username'])) {
            header('Location: index.php');
            exit;
        }

        include 'App/views/users/change_pass.phtml';
    }
}
