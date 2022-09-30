<?php
session_start();
echo '<pre>';
print_r($_POST);
print_r($_SESSION);
print_r($_COOKIE);
echo '</pre>';
if (empty($_SESSION['username'])) {
    $_SESSION['username'] = $master_user;
    if (empty($_POST)) {
        header("Location:index.php");
    }
}


if (isset($_POST['formRememberCb']) && empty($_COOKIE['username'])) {
    setcookie('username', $_POST['username'], time() + 3600);
    echo 'cookie creada';
} else if (!isset($_POST['formRememberCb']) && !empty($_SESSION['username'])) {
    setcookie('username', '');
    echo 'cookie borrada';
}
?>

<html>
    <head>
        <title>Menu</title>
        <link rel="stylesheet" href="login.css"/>
    </head>
    <body>
        <div class="login-box">
            <h2 style="color: green;">Welcome <?php
                if ($_COOKIE['username']) {
                    echo $_COOKIE['username'];
                } else {
                    echo $user;
                }
                ?></h2>
            <a href="private1.php">Privada 1</a>
            <a href="private2.php">Privada 2</a></br>
            <a href="index.php">Go back</a>
            <a href="logout.php">Log Out</a>
        </div>
    </body>
</html>
