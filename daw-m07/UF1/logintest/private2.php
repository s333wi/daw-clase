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
    <title>Private 2</title>
    <link rel="stylesheet" href="login.css" />
</head>

<body>
    <div class="login-box"  style="text-align: unset;">
        <h2 style="color: green;">Welcome <?= $_SESSION['username'] ?></h2>
        <div>
            <p style='color:#fff'><em>“You’re right, we are mortal and fragile. But even if we are tortured or wounded,
                    we’ll fight to survive. You should feel the pain we feel and understand. I am the messenger that will
                    deliver you to that pain and understanding.” – Guts</em></p>

        </div>
        <div id="gutsGif" style="width:100%;height:0;padding-bottom:75%;position:relative;">
            <iframe src="https://giphy.com/embed/pUp9Nb1czvHMY" width="100%" height="100%" style="position:absolute"
                 title="gutsGigaChad" class="giphy-embed" allowFullScreen>
            </iframe>
        </div>
        <a href="menu.php">Go back</a>
        <a href="logout.php">Log Out</a>
    </div>
</body>

</html>