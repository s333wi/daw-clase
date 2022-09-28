<?php
session_start();
echo '<pre>';
print_r('USER =>' . $_COOKIE['username']);
print_r($_POST);
print_r($_SESSION);
print_r($_COOKIE);
echo '</pre>';
$validation = false;
$msg = '';
$master_user = 'daw';
$master_pass = '2022';
$user = '';
$wrong_pass = false;
if (isset($_POST['submit'])) {
    $user = $_POST['username'];
    if ($master_pass == $_POST['pass'] && $master_user == $user) {
        $validation = true;
    } else {
        $wrong_pass = true;
    }
}
?>

<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Log In</title>
        <link rel="stylesheet" type='text/css' href='./login.css' />
    </head>

    <body>
        <?php
        if ($validation) /* Missatge benvinguda */ {
            include './menu.php';
            ?>
        <?php } else { ?>
            <div class="login-box">
                <h2>Login</h2>
                <form method='POST' autocomplete="off">
                    <div class="user-box">
                        <input type="text" name="username" required="" value='<?= $_COOKIE['username'] ?>'>
                        <label>Username</label>
                    </div>
                    <div class="user-box">
                        <input type="password" name="pass" required="">
                        <label>Password</label>
                    </div>
                    <?php if ($wrong_pass) { /* Check contrasenya */ ?>
                        <div>
                            <p style="color: red;">Wrong password</p>
                        </div>
                    <?php } ?>
                    <label id='remembercb'><input type='checkbox' id='cbox1' name='formRememberCb' value='remember_cb' <?= isset($_COOKIE['username']) ? 'checked' : '' ?>>
                        Remember me</label><br>
                    <a>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <button value='submit' name='submit'>SUBMIT</button>
                    </a>
                </form>
            </div>
        <?php } ?>
    </body>

</html>