<?php

if (isset($_POST)) {
    include_once './connectionDB.php';
    //Amb aquest metode extrec les dades del $_POST i creo
    //les variables amb el nom que ve donat per el name dels inputs vinguts per $_POST
    $postArr  =  filter_input_array(INPUT_POST);
    extract($postArr);
    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $usersArr = $result->fetch_assoc();
    //Comprovacio si existeis l'user
    if (mysqli_num_rows($result) === 0) {
        header('Location:./loginForm.php?errUser=1');
        die();
    }
    //Si existeix mirem si la password es correcta
    if (mysqli_num_rows($result) > 0) {
        if (!password_verify($password, $usersArr['password'])) {
            header('Location:./loginForm.php?errPass=1');
            die();
        }
        //Si tot va be redirigim a l'user a la pagina correcta
        header('Location:./correctLogin.html');
        die();
    }
//Tanquem les connexions
    $stmt->close();
}
$conn->close();
