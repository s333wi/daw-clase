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

    public function addNews(string $titol, string $descripcio, int $id = 0): bool
    {
        $dateToday = date("Y-m-d");
        $titol=ucfirst($titol);
        $descripcio=ucfirst($descripcio);
    
        if ($id == 0) {
            $sql = "INSERT INTO news (titol, descripcio, data) VALUES (?,?,?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sss", $titol, $descripcio, $dateToday);
        } else {
            echo $id;
            $sql = "UPDATE news SET titol=?, descripcio=?, data=? WHERE codin=?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sssi", $titol, $descripcio, $dateToday, $id);
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

    public function deleteNews(int $id)
    {
            echo $id;
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

    public function getNews(int $id){
        $sql = "SELECT * FROM news WHERE codin=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        if(!$stmt->execute()){
            $error = $stmt->error;
            echo "<pre>";
            print_r($error);
            echo "</pre>";
            return false;
        }
        
        $result = $stmt->get_result();
        $res = $result->fetch_assoc();
        return $res;
    }
}
