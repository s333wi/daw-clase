<?php

namespace App\Controllers;
//Comprovem que l'usuari estigui logejat
defined('MVC_APP') or die('Access denied');
session_start();



use App\Models\Mdl_users;

class Ctl_users
{
    //Funcio que comprova la sessio i el nivell de l'usuari
    public function checkSessionLevel()
    {
        if (!isset($_SESSION['username'])) {
            header('Location: index.php');
            exit;
        }

        $usr_model = new Mdl_users();
        $level = $usr_model->getUserLevel($_SESSION['username']);
        if ($level < 10) {
            header('Location: index.php?action=dashboard');
            exit;
        }
    }

    //Aquestes dues pagines no fan falta comprovacion perque fan part de la pagina principal

    //Funcio que registra un usuari
    public function register_user(): void
    {
        //Agafem les dades del formulari, aixo el que fa es filtrar el $_POST i les passa a un array
        //despres amb el metode extract() les passa a variables individuals. Extraure el $_POST d'aquesta manera a tota la practica

        $data = filter_input_array(INPUT_POST);
        extract($data);

        $usr_model = new Mdl_users();

        //La variable result es la que passo a la vista per a mostrar el resultat de la inserció en el toast
        $result = $usr_model->saveUser($nick, $nomcognoms, $mail, $edat, $contrasenya);
        //Redirigim a la pagina principal i li passem la variable result per a mostrar el toast
        header('Location: index.php?register=' . ($result ? '1' : '0'));
    }

    //Funcio que logueja un usuari
    public function login_user(): void
    {
        //Extreiem el post amb el metode habitua
        $data = filter_input_array(INPUT_POST);
        extract($data);


        //Instanciem el model d'usuaris i fem la consulta
        $usr_model = new Mdl_users();

        $result_login = $usr_model->loginUser($nick, $contrasenya);

        //Si el resultat es false vol dir que no s'ha trobat l'usuari o la contrasenya es incorrecta
        if ($result_login === false) {
            include 'App/views/users/login.phtml';
        } else {
            //Si el resultat es true vol dir que l'usuari i la contrasenya son correctes
            //Mirem si el checkbox de recordar esta marcat
            if ($connected === 'on') {
                setcookie('username', $nick, time() + 36000);
                setcookie('remember', $connected, time() + 36000);
            } else if (empty($connected)) { //Si no esta marcat el checkbox de recordar, esborrem les cookies
                setcookie('username', $nick, time() - 36000);
                setcookie('remember', $connected, time() - 36000);
            }

            //Guardem les dades de l'usuari a la sessio
            $_SESSION['username'] = $nick;

            //Redirigim al portal
            header('Location: index.php?action=dashboard');
            exit;
        }
    }

    //Mostra la vista principal de la pagina de gestio d'usuaris
    public function loadView()
    {

        //Comprovem que l'usuari estigui logejat i que tingui el nivell correcte
        $this->checkSessionLevel();

        //Agafem totes les dades dels usuaris
        $usr_model = new Mdl_users();
        $info_users = $usr_model->getAllUsers();
        $level = $usr_model->getUserLevel($_SESSION['username']);
        //Carreguem la vista
        include 'App/views/users/users.phtml';
    }

    //Funcio que guarda/afegeix un usuari
    public function addUser()
    {
        //Comprovem que l'usuari estigui logejat i que tingui el nivell correcte
        $usr_model = new Mdl_users();
        $this->checkSessionLevel();

        //Extreiem el post amb el metode habitual
        $data = filter_input_array(INPUT_POST);
        extract($data);
        $level = intval($level);

        //Guardem les dades del formulari a la base de dades
        $result = $usr_model->saveUser($nick, $nomcognoms, $mail, $edat, $contrasenya, $level);

        header('Location: index.php?action=manage_users');
    }

    //Funcio que borra un usuari
    public function deleteUser(string $nick)
    {
        //Comprovem que l'usuari estigui logejat i que tingui el nivell correcte
        $this->checkSessionLevel();

        //Instanciem el model d'usuaris i fem la consulta
        $usr_model = new Mdl_users();
        $usr_model->deleteUser($nick);

        //Redirigim a la pagina principal
        header('Location: index.php?action=manage_users');
    }

    //Funcio que canvia la contrasenya d'un mateix usuari
    public function change_pass()
    {
        //Comprovem que l'usuari estigui logejat
        if (!isset($_SESSION['username'])) {
            header('Location: index.php');
            exit;
        }

        //Extreiem el post amb el metode habitual
        $data = filter_input_array(INPUT_POST);
        extract($data);

        //Comprovem que les contrasenyes siguin iguals, no fa falta mirar si se sap la contrasenya actual
        //ja que es fa a la vista dins del portal despres de loguejar-se
        if ($contrasenya != $contrasenya2) {
            header('Location: index.php?action=change_pass_view&error=1');
            exit;
        }

        //Instanciem el model d'usuaris i fem la consulta
        $usr_model = new Mdl_users();
        $result = $usr_model->changePass($contrasenya, $nick);

        //Redirigim a la pagina principal
        header('Location: index.php?action=dashboard&change_pass=' . ($result ? '1' : '0'));
        exit;
    }
}
