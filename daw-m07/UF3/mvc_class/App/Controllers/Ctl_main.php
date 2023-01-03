<?php
namespace App\Controllers;

class Ctl_main{

    function default_page(){
        
        include 'App/views/main.php';
    }
    
    function register(){
            
            include 'App/views/users/register.phtml';
    }
}