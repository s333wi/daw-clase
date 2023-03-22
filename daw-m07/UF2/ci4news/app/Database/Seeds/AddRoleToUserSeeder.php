<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AddRoleToUserSeeder extends Seeder
{
    public function run()
    {
        $model = new \App\Models\UserModel();
        $model->update(1, ['role_code' => 'ADM']);
        $model->update(2, ['role_code' => 'USR']);
        $model->insert([
            'name' => 'editor',
            'email' => 'editor@me.local',
            'password' => password_hash('1234', PASSWORD_DEFAULT),
            'role_code' => 'EDT'
        ]);
        $model->insert([
            'name' => 'gestor',
            'email' => 'gestor@me.local',
            'password' => password_hash('1234', PASSWORD_DEFAULT),
            'role_code' => 'GST'
        ]);
    }
}
