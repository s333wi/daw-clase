
<?php
include_once './connectionDB.php';

//Amb aquest metode extrec les dades del $_POST i creo
//les variables amb el nom que ve donat per el name dels inputs vinguts per $_POST
$postArr = filter_input_array(INPUT_POST);
if (!empty($postArr)) {
    extract($postArr);
    //Comprovacio si els inputs no estan buits
    if (!empty($username) || !empty($password)) {
        $sql = "SELECT * FROM user WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $usersArr = $result->fetch_assoc();
        //Comprovacio que no existeixi l'user
        if (mysqli_num_rows($result) === 0) {
            //Si no existeix procedim a fer l'insercio
            $sql = "INSERT INTO user (username, password) VALUES (?,?)";
            $passHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $username, $passHash);
            $stmt->execute();
            //Redireccio a la pagina principal
            header('Location:./index.html');
            die();
        } else {
            //Si ja hi ha un user que existeixi tractem aquest error
            header("Location:./registerForm.php?errUser=1");
            die();
        }
        //Tanquem les connexions
        $stmt->close();
    }
}
$conn->close();
