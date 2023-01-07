<?php

namespace App\Controllers;

defined('MVC_APP') or die('Access denied');
session_start();

use App\Models\Mdl_users;
use app\Models\Mdl_news;

class Ctl_news
{
    function loadView()
    {
        $usr_model = new Mdl_users();
        $news_model = new Mdl_news();
        $info_news = $news_model->fetchAllNews();
        $level = $usr_model->getUserLevel($_SESSION['username']);
        include 'App/views/news/news.phtml';
    }



    function addNews()
    {
        $data = filter_input_array(INPUT_POST);
        extract($data);

        $usr_news = new Mdl_news();
        $result = $usr_news->addNews(trim($titol),trim($descripcio),intval($id));

        header('Location: index.php?action=manage_news');
    }

    function deleteNews(int $id)
    {   
        $usr_news = new Mdl_news();
        $result = $usr_news->deleteNews($id);

        header('Location: index.php?action=manage_news');
    }
}
