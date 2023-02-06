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
} else if (isset($_GET['action']) && $_GET['action'] == 'register_user') {
  $register = new Ctl_users();
  $register->register_user();
} else if (isset($_GET['action']) && $_GET['action'] == 'login') {
  $login = new Ctl_main();
  $login->login();
} else if (isset($_GET['action']) && $_GET['action'] == 'login_user') {
  $login = new Ctl_users();
  $login->login_user();
} else if (isset($_GET['action']) && $_GET['action'] == 'logout') {
  $logout = new Ctl_main();
  $logout->logout();
} else if (isset($_GET['action']) && $_GET['action'] == 'delete_user') {
  $delete = new Ctl_users();
  // $delete->delete_user();
} else if (isset($_GET['action']) && $_GET['action'] == 'update_user') {
  $update = new Ctl_users();
  // $update->update_user();
} else if (isset($_GET['action']) && $_GET['action'] == 'update_user_form') {
  $update = new Ctl_users();
  // $update->update_user_form();
} else if (isset($_GET['action']) && $_GET['action'] == 'dashboard') {
  $dashboard = new Ctl_main();
  $dashboard->dashboard();
} else { //Si no existeix GET o POST -> mostra la pagina principal
  $main = new Ctl_main();
  $main->default_page();
}
