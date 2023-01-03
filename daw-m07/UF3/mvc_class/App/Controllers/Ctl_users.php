<?php
namespace App\Controllers;

use App\Models\Mdl_users;

class Ctl_users
{

    public function users_list()
    {
        $usr_model=new Mdl_users();

        $info_guests = $usr_model->getAllGuests();
        $info_users = $usr_model->getAllUsers();
        
        echo "<pre>";
        print_r ($info_users);
        echo "</pre>";
        
        include 'App/views/users/page.php';
    }
}
