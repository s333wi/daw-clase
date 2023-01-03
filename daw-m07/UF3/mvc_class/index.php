<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* Block time: 20221205 20:31:49*/

use App\Controllers\Ctl_users;
use App\Controllers\Ctl_main;


define('MVC_APP', 'APP');

// Auto loader de classes, l'arxiu mateix nom que la classe

// Autoload via funció
// spl_autoload_register(function ($class_name) {
//   include $class_name . '.php';
// });


// Autoload via classe 
require __DIR__ . '/Loader.php';
Loader::init(__DIR__ . '/App');    // definir carpeta on cercar -> Loader::init(__DIR__.'/src' );


include_once "App/config/db.php";


/********* MANAGE ROUTES AND ACTIONS **************************/

if (isset($_GET['action']) && $_GET['action'] == 'users') //mostra una pagina concreta
{
  $usr = new Ctl_users();
  $usr->users_list();
} else if (isset($_GET['action']) && $_GET['action'] == 'register') {
  $register = new Ctl_main();
  $register->register();
} else { //Si no existeix GET o POST -> mostra la pagina principal
  $main = new Ctl_main();
  $main->default_page();
}
