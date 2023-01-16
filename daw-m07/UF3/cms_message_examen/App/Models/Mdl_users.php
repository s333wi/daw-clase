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

    //Funcio que retorna un llistat de tots els usuaris
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

    //Funcio que inserta o guarda un usuari segons si existeix o no el nick
    public function saveUser(
        string $nick,
        string $name,
        string $email,
        int $age,
        string $password,
        string $level = '0',
    ): bool {

        //Aquest check el faig perque al editar un usuari, si deixa el camp nivell buit el fico a 0
        if ($level == '') {
            $level = '0';
        }

        // Apliquem el hash a la contrasenya
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $name = ucwords($name);

        // Preparem la sentencia SQL i mirem si es un insert o un update
        $stmt = $this->db->prepare("SELECT * FROM users WHERE nick = ?");
        $stmt->bind_param("s", $nick);
        $stmt->execute();
        $result = $stmt->get_result();
        //Comprovem si el usuari ja existeix
        if ($result->num_rows > 0) {
            //En cas de que existeixi, fem un update dels camps
            $sql = "UPDATE users SET nick = ?, nomcognoms = ?, contrasenya = ?, mail = ?, edat = ?, nivell = ? WHERE nick = ?";
            $stmt = $this->db->prepare($sql);

            //Vinculem els parametres 
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
            //En cas de que no existeixi, fem un insert
            $sql = "INSERT INTO users (nick,nomcognoms,contrasenya,mail,edat,nivell) VALUES (?, ?, ?, ?, ?,?)";
            $stmt = $this->db->prepare($sql);

            //Vinculem els parametres
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

    //Funcio que mira si un usuari existeix i si la contrasenya es correcta
    function loginUser(string $nick, string $password): bool
    {
        //Prearem la sentencia SQL
        $sql = "SELECT * FROM users WHERE nick = ?";
        $stmt = $this->db->prepare($sql);

        if ($stmt) {
            //Vinculem els parametres i executem la sentencia
            $stmt->bind_param("s", $nick);
            $stmt->execute();

            // Obtenim el resultat de la sentencia
            $result = $stmt->get_result();

            //Si existeix l'usuari comprovem la contrasenya
            if ($result) {

                $row = $result->fetch_assoc();

                //Comprovem la contrasenya coincideix amb el hash de la BBDD
                if (isset($row['contrasenya']) && password_verify($password, $row['contrasenya'])) {
                    $result = true;
                } else {
                    $result = false;
                }
            } else {
                $result = false;
            }
        }

        // Return result
        return $result;
    }

    //Funcio que retorna el nivell d'un usuari
    function getUserLevel(string $nick)
    {
        $sql = "SELECT nivell FROM users WHERE nick = ?";
        $stmt = $this->db->prepare($sql);
        if ($stmt) {
            // Vinculem els parametres i executem la sentencia
            $stmt->bind_param("s", $nick);
            $stmt->execute();

            $result = $stmt->get_result();
            if ($result) {
                //Agafem el nivell de l'usuari
                $row = $result->fetch_assoc();
                return $row['nivell'];
            }
        }
        //Si no s'ha trobat l'usuari retornem 0
        return "0";
    }

    //Funcio que retorna un usuari segons el nick
    function getUser(string $id)
    {
        // Preparem la sentencia SQL
        $sql = "SELECT * FROM users WHERE nick = ?";
        $stmt = $this->db->prepare($sql);
        if ($stmt) {
            // Vinculem els parametres i executem la sentencia
            $stmt->bind_param("s", $id);
            $stmt->execute();

            $result = $stmt->get_result();
            if ($result) {
                //Agafem el nivell de l'usuari
                $row = $result->fetch_assoc();
                return $row;
            }
        }
        //Si no s'ha trobat l'usuari retornem null
        return null;
    }

    //Funcio que esborra un usuari segons el nick
    function deleteUser(string $id)
    {
        $sql = "DELETE FROM users WHERE nick = ?";
        $stmt = $this->db->prepare($sql);
        if ($stmt) {
            // Vinculem els parametres i executem la sentencia
            $stmt->bind_param("s", $id);
            $stmt->execute();
        }
    }


    //Funcio que canvia la contrasenya d'un usuari especific
    function changePass(string $contrasenya, string $nick)
    {   
        //Encriptem la contrasenya amb un hash
        $hashedPassword = password_hash($contrasenya, PASSWORD_DEFAULT);

        // Preparem la sentencia SQL
        $sql = "UPDATE users SET contrasenya = ? WHERE nick = ?";
        $stmt = $this->db->prepare($sql);

        // Vinculem els parametres i executem la sentencia
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
