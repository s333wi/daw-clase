<?php
/* Block time: 20221205 20:36:51*/
defined('MVC_APP') or die('Permission denied');

function getAllGuests()
{
    // Create connection
    $conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM myguests";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // $res = $result->fetch_assoc();
        $res = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $res = null;
    }
    $conn->close();
    return $res;
}
