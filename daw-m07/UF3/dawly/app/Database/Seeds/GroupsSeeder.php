<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GroupsSeeder extends Seeder
{
    public function run()
    {
        $groupModel = model(\Myth\Auth\Models\GroupModel::class);
        $groupModel->insert([
            'name' => 'Administrators',
            'description' => 'Administrators can manage users, groups, and permissions.'
        ]);
        $groupModel->insert([
            'name' => 'Guests',
            'description' => 'Guests can only access the public areas of the site.'
        ]);
        $groupModel->insert([
            'name' => 'Users',
            'description' => 'Users can access the public areas of the site and their own private areas.'
        ]);
    }
}
