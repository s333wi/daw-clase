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
        <h2>Register</h2>
        <form method='POST' action="index.php" autocomplete="off">
            <div class="user-box">
                <input type="text" name="username" required>
                <label>Username</label>
            </div>
            <div class="user-box">
                <input type="password" name="pass" required>
                <label>Password</label>
            </div>
            <a>
                <button value='submit' name='submit'>REGISTER</button>
            </a>
        </form>
    </div>

</body>
</html>