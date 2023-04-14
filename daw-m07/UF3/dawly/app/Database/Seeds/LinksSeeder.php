<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class LinksSeeder extends Seeder
{
    public function run()
    {
        $linkModel = model('LinkModel');
        $fake = Factory::create('es_ES');

        for ($i = 0; $i < 100; $i++) {
            $linkModel->insert([
                'link' => $fake->url,
                'custom_link' => $fake->url,
                'description' => $fake->text,
                'user_id' => $fake->numberBetween(1, 10),
                'expires_at' => $fake->dateTimeBetween('now', '+1 years')->format('Y-m-d'),
            ]);
        }
    }
}
