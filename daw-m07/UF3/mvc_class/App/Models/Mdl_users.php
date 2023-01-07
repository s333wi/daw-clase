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
        $sql = "SELECT * FROM users";
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
        string $level = '0',
    ): bool {

        //Comprovem si la contrasenya es valida(es podrien fer mes comprovacions)
        if (strlen($password) < 8) {
            echo "La contrasenya ha de tenir almenys 8 caracters";
            return false;
        }

        //Aquest check el faig perque al editar un usuari, si deixa el camp nivell buit el fico a 0
        if ($level == '') {
            $level = '0';
        }
        // Apliquem el hash a la contrasenya
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $name = ucwords($name);
        // Preparem la sentencia SQL i mirem si es un insert o un update

        //Comprovem si el usuari ja existeix
        $stmt = $this->db->prepare("SELECT * FROM users WHERE nick = ?");
        $stmt->bind_param("s", $nick);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $sql = "UPDATE users SET nick = ?, nomcognoms = ?, contrasenya = ?, mail = ?, edat = ?, nivell = ? WHERE nick = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param(
                "sssssss",
                $nick,
                $name,
                $hashedPassword,
                $email,
                $age,
                $level,
                $nick
            );
        } else {
            $sql = "INSERT INTO users (nick,nomcognoms,contrasenya,mail,edat,nivell) VALUES (?, ?, ?, ?, ?,?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param(
                "ssssss",
                $nick,
                $name,
                $hashedPassword,
                $email,
                $age,
                $level
            );
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
        $sql = "SELECT * FROM users WHERE nick = ?";
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
                } else {
                    $result = false;
                }
            }
        }

        // Return result
        return $result;
    }

    function getUserLevel(string $nick)
    {
        $sql = "SELECT nivell FROM users WHERE nick = ?";
        $stmt = $this->db->prepare($sql);
        if ($stmt) {
            // Bind parameters and execute query
            $stmt->bind_param("s", $nick);
            $stmt->execute();

            // Get query result
            $result = $stmt->get_result();
            if ($result) {
                //Agafem el nivell de l'usuari
                $row = $result->fetch_assoc();
                return $row['nivell'];
            }
        }
        return "0";
    }

    function getUser(string $id)
    {
        $sql = "SELECT * FROM users WHERE nick = ?";
        $stmt = $this->db->prepare($sql);
        if ($stmt) {
            // Bind parameters and execute query
            $stmt->bind_param("s", $id);
            $stmt->execute();

            // Get query result
            $result = $stmt->get_result();
            if ($result) {
                //Agafem el nivell de l'usuari
                $row = $result->fetch_assoc();
                return $row;
            }
        }
        return null;
    }

    function changePass(string $contrasenya, string $nick)
    {
        $hashedPassword = password_hash($contrasenya, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET contrasenya = ? WHERE nick = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param(
            "ss",
            $hashedPassword,
            $nick
        );
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
}
