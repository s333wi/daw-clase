<?php
session_start();
if (empty($_SESSION['username'])) {
    header("Location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Private 1</title>
    <link rel="stylesheet" href="login.css" />
</head>

<body>
    <div class="login-box">
        <h2 style="color: green;">Welcome <?= $_SESSION['username'] ?></h2>
        <p style='color:#fff'>Contrary to popular belief, Lorem Ipsum is not simply random text.
            It has roots in a piece of classical latin literature from 45 BC, making it over 2000 years old.</p>
        <a href="menu.php">Go back</a>
        <a href="logout.php">Log Out</a>
    </div>
</body>

</html>
<?php
