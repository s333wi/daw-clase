<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\NewsModel;
use Faker\Factory;

class NewsDataSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('es_ES');
        $model = new NewsModel();
        $data = [];
        for ($i = 0; $i < 10; $i++) {
            $title = $faker->sentence(6);
            $data = [
                'title' => $title,
                'slug' => url_title($title) . '-' . $faker->unique()->randomNumber(5),
                'body' => $faker->paragraph(10),
                'data_pub' => ($faker->dateTimeBetween('-1 years', 'now'))->format('Y-m-d H:i:s') //Genera una data entre ara i fa un any
            ];
            $model->insertNews($data);
        }
    }
}
