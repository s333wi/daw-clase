<?php

namespace App\Database\Seeds;

use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

class AddDefaultUsers extends Seeder
{

    public function run()
    {
        $model = new UserModel();

        $model->save([
            'name' => 'admin',
            'email' => 'admin@me.local',
            'password' => password_hash('1234', PASSWORD_DEFAULT)
        ]);

        $model->save([
            'name' => 'user',
            'email' => 'user@me.local',
            'password' => password_hash('1234', PASSWORD_DEFAULT)
        ]);
    }

}
