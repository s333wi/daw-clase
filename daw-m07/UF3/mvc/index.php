<?php
/* Block time: 20221205 20:31:49*/
define('MVC_APP','APP');

if (isset($_GET['action']) && $_GET['action'] == 'users') //muestra una pagina concreta
{
  require "app/controllers/ctl_users.php";
  users_list();
} else { //Si no existe GET o POST -> muestra la pagina principal
  require "app/controllers/ctl_main.php";
  inici();
}
