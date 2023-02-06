<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\NewsModel;

class CreateNewsSeeder extends Seeder
{
    public function run()
    {
        $model = new NewsModel();

        $fake = Factory::create("es_ES");

        for ($i = 0; $i < 10; $i++) {
            $title = $fake->sentence(6);
            $data = [
                'title' => $title,
                'slug' =>  url_title($title),
                'body' =>  $fake->text(),
            ];

            $model->insert($data);
        }
    }
}
