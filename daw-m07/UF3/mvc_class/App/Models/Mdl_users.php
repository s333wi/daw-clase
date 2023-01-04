<?php

namespace App\Models;


class Mdl_users
{

    private $db;

    public function __construct()
    {
        // Create connection
        $this->db = new \mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

        // Check connection
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function __destruct()
    {
        if ($this->db != null)
            $this->db->close();
    }

    public function getAllGuests()
    {
        $sql = "SELECT * FROM myguests";
        $result = $this->db->query($sql);

        if ($result->num_rows > 0) {
            $res = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $res = null;
        }
        return $res;
    }

    public function getAllUsers()
    {
        $sql = "SELECT * FROM user";
        $result = $this->db->query($sql);

        if ($result->num_rows > 0) {
            $res = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $res = null;
        }
        return $res;
    }

    //Funcio que inserta o guarda un usuari
    public function saveUser(
        string $nick,
        string $name,
        string $email,
        int $age,
        string $password,
        int $id = 0
    ): bool {

        //Comprovem si la contrasenya es valida(es podrien fer mes comprovacions)
        if (strlen($password) < 8) {
            return false;
        }

        // Apliquem el hash a la contrasenya
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        //Print all the vars and format them
        echo "<pre>";
        print_r ($nick);
        echo "</pre>";
        echo "<pre>";
        print_r ($name);
        echo "</pre>";
        echo "<pre>";
        print_r ($email);
        echo "</pre>";
        echo "<pre>";
        print_r ($age);
        echo "</pre>";
        echo "<pre>";
        print_r ($hashedPassword);
        echo "</pre>";
        echo "<pre>";
        print_r ($id);
        echo "</pre>";
        


        // Preparem la sentencia SQL i mirem si es un insert o un update
        if ($id == 0) {
            //El nivell el canvio jo manualment a la BBDD
            echo "entra";
            $sql = "INSERT INTO user (nick,nomcognoms,contrasenya,mail,edat) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sssss", $nick, $name, $hashedPassword, $email, $age);
        } else {
            $sql = "UPDATE user SET nick=?, nomcognoms=?, mail=?, contrasenya=?,edat=? WHERE id=?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sssssi", $nick, $name, $email, $hashedPassword, $age, $id);
        }

        // Executem la sentencia i retornem el resultat
        if (!$stmt->execute()) {
            // An error occurred
            $error = $stmt->error;
            // You could log the error, display an error message to the user, or take other appropriate action
            
            echo "<pre>";
            print_r ($error);
            echo "</pre>";
            
            return false;
        } else {
            return true;
        }
        
    }
}
