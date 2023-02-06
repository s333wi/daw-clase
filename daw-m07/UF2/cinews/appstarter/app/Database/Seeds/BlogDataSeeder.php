<?php

namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
use Faker\Factory;
class BlogDataSeeder extends Seeder
{
    public function run()
    {
        $fake = Factory::create("es_ES");

        for ($i = 0; $i < 10; $i++) {
            $data = [
                'blog_title' => $fake->realText(25),  //$title => $fake->sentence(6)
                'blog_description'  => $fake->realText(100) //$desc => $fake->text(100)
            ];

            $this->db->table('blog')->insert($data);
            // Produces: INSERT INTO blog (blog_title, blog_description) VALUES ('{$title}', '{$desc}')
        }
    }
}