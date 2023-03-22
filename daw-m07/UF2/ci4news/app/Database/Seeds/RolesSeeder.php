<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Administrador',
                'code' => 'ADM',
                'description' => 'Administrador del sistema',
            ],
            [
                'name' => 'Editor',
                'code' => 'EDT',
                'description' => 'Editor de noticias',
            ],
            [
                'name' => 'Usuari',
                'code' => 'USR',
                'description' => 'Usuario del sistema',
            ],
            [
                'name'=>'Gestor',
                'code'=>'GST',
                'description'=>'Gestor de usuaris',
            ]
        ];

        $this->db->table('roles')->insertBatch($data);
    }
}
