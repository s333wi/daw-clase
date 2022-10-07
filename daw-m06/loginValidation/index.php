<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" type='text/css' href='./login.css' />
    <script src="check.js"></script>
</head>

<body>
    <div class="login-box">
        <h2>Login</h2>
        <form method='POST' name="loginForm" id="loginForm" action="index.php" autocomplete="off">
            <div class="user-box">
                <input type="text" id="formEmail" name="email" required="">
                <label>Username</label>
            </div>
            <div class="user-box">
                <input type="password" name="pass" id="formPass" required="">
                <label>Password</label>
            </div>
            <div class="user-box">
                <input type="password" name="passConfirm" id="formPassConfirm" required="">
                <label>Confirm password</label>
            </div>

            <button value='submit' name='btnSubmit' id="btnSubmit" onclick="formValidation()">SUBMIT</button>

            <div id="inpCheck">
            </div>
        </form>
    </div>
</body>

</html>