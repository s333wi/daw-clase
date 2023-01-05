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
        $this->__destruct();
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
        $this->__destruct();

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
            echo "La contrasenya ha de tenir almenys 8 caracters";
            return false;
        }

        // Apliquem el hash a la contrasenya
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $name=ucwords($name);
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

            echo "<pre>";
            print_r($error);
            echo "</pre>";
            return false;
        }
        return true;
    }

    function loginUser(string $nick, string $password): bool
    {   
        // Set up SQL query
        $sql = "SELECT * FROM user WHERE nick = ?";
        $stmt = $this->db->prepare($sql);
        if ($stmt) {
            // Bind parameters and execute query
            $stmt->bind_param("s", $nick);
            $stmt->execute();

            // Get query result
            $result = $stmt->get_result();
            if ($result) {
                // Fetch first row as associative array
                $row = $result->fetch_assoc();

                // Check if provided password matches hashed password in database
                if (isset($row['contrasenya']) && password_verify($password, $row['contrasenya'])) {
                    $result = true;
                    echo 'la contrasenya es correcta';
                } else {
                    echo 'la contrasenya no es correcta';
                    $result = false;
                }
            }
        }

        // Return result
        return $result;
    }
}
