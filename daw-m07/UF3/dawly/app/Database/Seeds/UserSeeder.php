<?php

namespace App\Database\Seeds;

use App\Entities\User;
use CodeIgniter\Database\Seeder;
use Faker\Factory;
use Myth\Auth\Password;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = model('UserModel');
        $fake = Factory::create('es_ES');

        for ($i = 1; $i <= 10; $i++) {
            $userModel->withGroup('Guests')->insert([
                'email' => $fake->email,
                'username' => $fake->userName,
                'password_hash' => Password::hash('12345678'),
                'active' => 1
            ]);
        }
    }
}
