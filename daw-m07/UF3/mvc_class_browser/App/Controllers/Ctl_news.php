<?php

namespace App\Controllers;

defined('MVC_APP') or die('Access denied');
session_start();

use App\Models\Mdl_users;
use app\Models\Mdl_news;

class Ctl_news
{
    //Funcio que comprova la sessio i el nivell de l'usuari
    public function checkSessionLevel()
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
    }

    //Mostra la pagina principal de noticies
    function loadView()
    {
        //Comprovem la sessio i el nivell de l'usuari
        $this->checkSessionLevel();

        //Instanciem el model de noticies i extreiem les noticies
        $news_model = new Mdl_news();
        $info_news = $news_model->fetchAllNews();
        $usr_model = new Mdl_users();
        $level = $usr_model->getUserLevel($_SESSION['username']);
        include 'App/views/news/news.phtml';
    }


    //Funcio que afegeix una noticia
    function addNews()
    {
        $this->checkSessionLevel();

        //Extreiem el post amb el metode habitual
        $data = filter_input_array(INPUT_POST);
        extract($data);

        //Instanciem el model de noticies i afegim la noticia
        $usr_news = new Mdl_news();
        $result = $usr_news->addNews(trim($titol), trim($descripcio), intval($id));

        //Redirigim a la pagina de gestio de noticies
        header('Location: index.php?action=manage_news');
    }

    function deleteNews(int $id)
    {
        //Comprovem la sessio i el nivell de l'usuari
        $this->checkSessionLevel();

        //Instanciem el model de noticies i eliminem la noticia
        $usr_news = new Mdl_news();
        $result = $usr_news->deleteNews($id);

        //Redirigim a la pagina de gestio de noticies
        header('Location: index.php?action=manage_news');
    }
}
