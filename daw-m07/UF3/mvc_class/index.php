<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* Block time: 20221205 20:31:49*/

use App\Controllers\Ctl_users;
use App\Controllers\Ctl_main;
use App\Controllers\Ctl_news;

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

if (isset($_GET['action']) && $_GET['action'] == 'register') {
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
  $logout->logout($_SESSION['username']);
} else if (isset($_GET['action']) && $_GET['action'] == 'manage_users') {
  $users = new Ctl_users();
  $users->loadView();
} else if (isset($_GET['action']) && $_GET['action'] == 'dashboard') {
  $dashboard = new Ctl_main();
  $dashboard->dashboard();
} else if (isset($_GET['action']) && $_GET['action'] == 'manage_news') {
  $news = new Ctl_news();
  $news->loadView();
} else if (isset($_GET['action']) && $_GET['action'] == 'view_save_news') {
  $news = new Ctl_main();
  $id = !empty($_GET['id']) ? $_GET['id'] : 0;
  $news->viewAddNews($id);
} else if (isset($_GET['action']) && $_GET['action'] == 'view_save_user') {
  $users = new Ctl_main();
  $id = !empty($_GET['id']) ? $_GET['id'] : '';
  $users->viewAddUsers($id);
} else if (isset($_GET['action']) && $_GET['action'] == 'save_news') {
  $news = new Ctl_news();
  $news->addNews();
} else if (isset($_GET['action']) && $_GET['action'] == 'delete_news') {
  $news = new Ctl_news();
  $news->deleteNews($_GET['id']);
} else if (isset($_GET['action']) && $_GET['action'] == 'save_user') {
  $user = new Ctl_users();
  $user->addUser();
} else if (isset($_GET['action']) && $_GET['action'] == 'delete_user') {
  $news = new Ctl_news();
  $news->deleteNews($_GET['id']);
} else if (isset($_GET['action']) && $_GET['action'] == 'change_pass_view') {
  $user = new Ctl_main();
  $user->change_pass_view();
} else if (isset($_GET['action']) && $_GET['action'] == 'change_pass') {
  $user = new Ctl_users();
  $user->change_pass();
} else { //Si no existeix GET o POST -> mostra la pagina principal
  $main = new Ctl_main();
  $main->default_page();
}
