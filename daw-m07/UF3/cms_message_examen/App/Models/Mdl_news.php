<?php

namespace App\Models;


class Mdl_news
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

    public function fetchAllNews()
    {
        $sql = "SELECT * FROM news";
        $result = $this->db->query($sql);

        if ($result->num_rows > 0) {
            $res = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $res = null;
        }
        return $res;
    }

    public function addNews(string $titol, string $descripcio, string $autor, int $id = 0): bool
    {
        //Modifiquem les variables avans de fer la consulta
        $dateToday = date("Y-m-d");
        $titol = ucfirst($titol);
        $descripcio = ucfirst($descripcio);
        //Si l'id es 0 vol dir que es una insercio, sino es una actualitzacio
        if ($id == 0) {
            $sql = "INSERT INTO news (titol, descripcio, data,autor) VALUES (?,?,?,?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ssss", $titol, $descripcio, $dateToday, $autor);
        } else {
            echo $id;
            $sql = "UPDATE news SET titol=?, descripcio=?, data=?, autor=? WHERE codin=?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ssssi", $titol, $descripcio, $dateToday, $autor, $id);
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

    //Funcio que elimina una noticia
    public function deleteNews(int $id)
    {
        //Preparem la sentencia
        $sql = "DELETE FROM news WHERE codin=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);

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

    //Funcio que retorna una noticia en concret
    public function getNews(int $id)
    {
        $sql = "SELECT * FROM news WHERE codin=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            $error = $stmt->error;
            echo "<pre>";
            print_r($error);
            echo "</pre>";
            return false;
        }

        //Obtenim el resultat
        $result = $stmt->get_result();
        $res = $result->fetch_assoc();
        return $res;
    }
}
