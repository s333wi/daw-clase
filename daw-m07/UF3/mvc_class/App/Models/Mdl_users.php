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
}
