<?php
$user_exists = false;
if (isset($_POST['btnSubmit'])) {
    $postArr = filter_input_array(INPUT_POST); //Extrec totes les variables del post
    extract($postArr);
    //Recupero els usuaris ja enregistrats per poder veure si existeix un amb el mateix username,
    // en cas de que si missatge d'error
    $user = unserialize(file_get_contents('users.php'));
    if (empty($user[$username])) {
        $user[$username] = ['password' => $pass, 'rol' => 'usuari'];
        //Si no existeix un usuari amb el mateix username torno a escriure en el fitxer els usuaris
        file_put_contents('users.php', serialize($user));
        header("Location:index.php");
    } else {
        $user_exists = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <div class="login-box">
        <h1 style="color:green">Register</h1>
        <form target="_self" method="post">
            <div class="user-box">
                <input type="text" name="username" required="">
                <label>Username</label>
            </div>
            <div class="user-box">
                <input type="password" name="pass" required="">
                <label>Password</label>
            </div>
            <button value='submit' name='btnSubmit'>SUBMIT</button>
            <?php
            if ($user_exists) echo '<p style="color:red">Username no disponible</p>';
            ?>
        </form>
    </div>
</body>

</html>