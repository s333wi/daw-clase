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
        <h2>Log In</h2>
        <form method='POST' action="dbLogin.php" autocomplete="off">
            <div class="user-box">
                <input type="text" name="username" required>
                <label>Username</label>
            </div>
            <div class="user-box">
                <input type="password" name="password" required>
                <label>Password</label>
            </div>
            <a>
                <button value='submit' name='submit'>LOG IN</button>
            </a>
            <?php
            //Tractament d'errors
            if (!empty($_GET['errUser'])) { ?>
                <p style="color: red;">No existeix l'usuari</p>
            <?php } elseif (!empty($_GET['errPass'])) { ?>
                <p style="color:red">Contrasenya incorrecta</p>
            <?php
            }
            ?>
        </form>
    </div>

</body>

</html>