<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class NewsController extends BaseController
{
    /**
     * Llista de noticies
     * @return view 
     */
    public function index(): string
    {
        $model = model('NewsModel');

        $data['title'] = "Llista noticies";
        $data['info_news'] = $model->getNews();
        $data['pager'] = $model->pager;
        return view("news/news_list", $data);
    }

    /**
     * Veure una noticia en concret
     * @param string $slug
     * @return 
     */
    public function view($slug = null): string
    {
        $model = model('NewsModel');

        $data['news'] = $model->getNews($slug);

        if (empty($data['news'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the news item: ' . $slug);
        }

        $data['title'] = $data['news']['title'];

        return view("news/news_view", $data);
    }

    /**
     * Crear una noticia
     * @return view
     */

    public function create(): string
    {
        $model = model('NewsModel');
        helper(["form"]);
        if ($this->request->getMethod() == 'post') {
            $model->insertNews($this->request->getPost());
            return view("news/news_added", ['title' => 'Afegit correctament']);
        }

        return view("news/news_create", ['title' => 'Crear noticia']);
    }

    /**
     * Actualitzar una noticia
     * @param string $slug
     * @return view
     */
    public function update(string $slug = null)
    {
        $model = model('NewsModel');
        $data['title'] = "Actualitzar noticia";
        helper(["form"]);
        $data['news'] = $model->getNews($slug);
        if (empty($data['news'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the news item: ' . $slug);
        }

        if ($this->request->getMethod() == 'post') {
            $model->updateNews($slug, $this->request->getPost());
            return view("news/news_updated", ['title' => 'Actualitzat correcte']);
        }
        return view("news/news_update", $data);
    }

    /**
     * Borrar una noticia
     * @param int $id
     * @return view
     */

    public function delete(int $id = 0): string
    {
        $model = model('NewsModel');
        $model->deleteNews($id);
        return view("news/news_deleted", ['title' => 'Borrat correcte']);
    }

    public function dashboard()
    {
        //agafem les variables del get request
        $order = $this->request->getVar('order');
        $sort = $this->request->getVar('so');


        $model = model('NewsModel');

        if ($order != null && $sort != null) {
            if (strtolower($sort) == 'asc') {
                $sort = 'desc';
            } else if (strtolower($sort) == 'desc') {
                $sort = 'asc';
            }
            $data['info_news'] = $model->getNewsBeforeToday($order, $sort);
        } else {
            $sort = 'asc';
            $data['info_news'] = $model->getNewsBeforeToday();
        }

        $data['title'] = "Dashboard";
        $data['pager'] = $model->pager;
        $data['sort'] = $sort;
        return view("news/news_dashboard", $data);
    }
}
