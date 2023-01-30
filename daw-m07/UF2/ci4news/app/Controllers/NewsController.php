<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Model;

class NewsController extends BaseController
{
    /**
     * Llista de noticies
     * @return view
     */
    public function index()
    {
        $model = model('NewsModel');

        $data['title'] = "Llista noticies";
        $data['news'] = $model->getNews();

        return view("news/news_list", $data);
    }

    /**
     * Veure una noticia en concret
     * @param string $slug
     * @return 
     */
    public function view($slug = null)
    {
        $model = model('NewsModel');

        $data['news'] = $model->getNews($slug);

        if (empty($data['news'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the news item: ' . $slug);
        }

        $data['title'] = $data['news']['title'];

        return view("news/news_view", $data);
    }

    public function create()
    {
        $model = model('NewsModel');
        helper(["form"]);
        if ($this->request->getMethod() == 'post') {
            $model->insertNews($this->request->getPost());
            return view("news/news_added");
        }

        return view("news/news_create", ['title' => 'Create news']);
    }
}
