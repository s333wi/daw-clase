<?php
session_start();
if (empty($_POST['btnSubmit']) && empty($_SESSION['username'])) {
    include_once 'logout.php';
}


if (!empty($_POST['formMaintainCookie'])) {
    $_SESSION['maintainCookie'] = $_POST['formMaintainCookie'];
}

$_SESSION['username'] = "daw";
if (!empty($_POST['formRememberCb']) && empty($_COOKIE['username'])) {
    $_SESSION['maintainCookie'] = $_POST['formRememberCb'];
    setcookie('username', $_POST['username'], time() + 3600);
    echo 'cookie creada';
} elseif (empty($_SESSION['maintainCookie']) && !empty($_COOKIE['username'])) {
    setcookie('username', '');
    echo 'cookie borrada';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="login.css"/>
</head>

<body>
    <div class="login-box">
        <h2 style="color: green;">Welcome to DAW</h2>
        <a href="browser.php">BROWSER</a>
        <a href="private1.php">Privada 1</a>
        <a href="private2.php">Privada 2</a></br>
        <a href="index.php">Go back</a>
        <a href="logout.php">Log Out</a>
    </div>
</body>

</html>