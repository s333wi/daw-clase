<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class NewsController extends BaseController
{

    public function index()
    {
        $model = model('NewsModel');

        $data['title'] = "Llista noticies";
        $data['news'] = $model->getNews();

        echo view("news/news_list", $data);
    }

    /**
     * view
     * $slug=null
     */
    public function view($slug = null)
    {
        $model = model('NewsModel');

        $data['news'] = $model->getNews($slug);

        if (empty($data['news'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the news item: ' . $slug);
        }

        $data['title'] = $data['news']['title'];

        echo view("news/news_view", $data);
    }

    /**
     * create
     */
    public function create_news_form(): string
    {
        $data['title'] = "Create news";
        return view("news/news_create", $data);
    }

    public function create_post(): \CodeIgniter\HTTP\RedirectResponse | string
    {
        $model = model('NewsModel');

        // NOTE: https://codeigniter.com/user_guide/libraries/validation.html
        $validationRules = [
            'title' => 'required|min_length[3]|max_length[128]',
            'body' => 'required',
        ];

        if ($this->validate($validationRules)) {

            $title = $this->request->getPost('title');

            // NOTE: https://codeigniter.com/user_guide/helpers/url_helper.html#url_title
            $body = $this->request->getPost('body');
            $slug = url_title($title);

            $model->addNoticia($title, $body, $slug);

            // $model->addNoticia($title, $slug, $body);

            return view("news/news_added");
        } else {
            return redirect()->back()->withInput();
        }
    }
}
