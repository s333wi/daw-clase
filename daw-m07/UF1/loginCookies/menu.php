<?php
session_start();
echo '<pre>';
print_r($_POST);
print_r($_COOKIE);
echo '</pre>';
if (empty($_SESSION['username'])) {
    include 'logout.php';
}

$_SESSION['username'] = 'daw';


if (isset($_POST['preserveCookieCb'])) {
    $_SESSION['reserveCookie'] = $_POST['preserveCookieCb'];
}

if (isset($_POST['formRememberCb']) && empty($_COOKIE['username'])) {
    setcookie('username', $_POST['username'], time() + 3600);
    echo 'cookie creada';
} else if (!isset($_SESSION['reserveCookie']) && !empty($_COOKIE['username'])) {
    setcookie('username', '');
    echo 'cookie borrada';
}
?>

<html>

<head>
    <title>Menu</title>
    <link rel="stylesheet" href="login.css" />
</head>

<body>
    <div class="login-box">
        <h2 style="color: green;">Welcome <?= $_SESSION['username'] ?></h2>
        <a href="private1.php">Privada 1</a>
        <a href="private2.php">Privada 2</a></br>
        <a href="index.php">Go back</a>
        <a href="logout.php">Log Out</a>
    </div>
</body>

</html>