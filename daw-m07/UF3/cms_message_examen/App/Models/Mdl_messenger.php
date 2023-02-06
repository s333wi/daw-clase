<?php

namespace App\Models;


class Mdl_messenger
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

    public function fetchAllMessages(string $nick)
    {

        $sql = "SELECT * FROM messages WHERE receptor = ? order by id desc";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $nick);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $res = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $res = null;
        }
        return $res;
    }

    public function getMessage(int $id)
    {
        $sql = "SELECT * FROM messages WHERE id = '$id' order by id asc";
        $result = $this->db->query($sql);

        if ($result->num_rows > 0) {
            //fetch first row only 
            $res = $result->fetch_assoc();
        } else {
            $res = null;
        }
        return $res;
    }

    public function saveMessage(string $assumpte, string $text, string $receptor, string $emisor)
    {
        $data_enviament = date("Y-m-d");
        $sql = "INSERT INTO messages (assumpte,text,receptor,emissor,data_env) VALUES (?,?,?,?,?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sssss", $assumpte, $text, $receptor, $emisor, $data_enviament);
        $stmt->execute();
        $stmt->close();
    }


    //Funcio per enviar missatge a tots els usuaris
    public function sendMessageAll(string $assumpte, string $text, string $emisor)
    {
        //Agafo la data actual
        $data_enviament = date("Y-m-d");
        //Agafo tots els usuaris
        $mdl_users = new Mdl_users();
        $users = $mdl_users->getAllUsers();
        //Per cada usuari envio el missatge
        foreach ($users as $user) {
            //Si l'usuari es el que envia el missatge 
            //no s'envia el missatge a ell mateix
            if ($user['nick'] != $emisor) {
                //Nomes canvio el receptor i envio
                $receptor = $user['nick'];
                $sql = "INSERT INTO messages (assumpte,text,receptor,emissor,data_env) VALUES (?,?,?,?,?)";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("sssss", $assumpte, $text, $receptor, $emisor, $data_enviament);
                $stmt->execute();
                $stmt->close();
            }
        }
    }


    //Funcio per borrar un missatge amb un id
    public function deleteMessage(int $id)
    {
        $sql = "DELETE FROM messages WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }


    //Funcio per marcar un missatge com a llegit
    public function setSeenMessage(int $id)
    {
        $data_apertura = date("Y-m-d h:i:s");
        $sql = "UPDATE messages SET data_apertura = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("si", $data_apertura, $id);
        $stmt->execute();
        $stmt->close();
    }

    //Funcio per agafar tots els missatges enviats per un usuari
    public function fetchAllMessagesSent(string $nick)
    {
        $sql = "SELECT * FROM messages WHERE emissor = ? order by id desc";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $nick);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $res = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $res = null;
        }
        return $res;
    }
}
