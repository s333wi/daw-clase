<?php
session_start();
//Extrec els users
$users = unserialize(file_get_contents('users.php'));
$wrong_user = false;
if (isset($_POST['btnSubmit'])) {
    $user = $_POST['username'];
    $password = $_POST['pass'];
    //Si existeix el user canvio la contrasenya
    if (!empty($users[$user])) {
        $users[$user]['password'] = $password;
        file_put_contents('users.php', serialize($users));
        //Una vegada canviada la contrasenya torno a escriure al fitxer
        header("Location: ./login.php");
    } else {
        $wrong_user = true; //Missatge d'error en el cas que no existeixi
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" type='text/css' href='./login.css' />
</head>

<body>

    <div class="login-box">
        <h2>Change password</h2>
        <form method='POST' target="_self" autocomplete="off">
            <div class="user-box">
                <input type="text" name="username" required="">
                <label>Username</label>
            </div>
            <div class="user-box">
                <input type="password" name="pass" required="">
                <label>Password</label>
            </div>
            <?php if ($wrong_user) { /* Check username */ ?>
                <div>
                    <p style="color: red;">User inexistent</p>
                </div>
            <?php } ?>
            <button value='submit' name='btnSubmit'>SUBMIT</button>
        </form>

    </div>


</html>