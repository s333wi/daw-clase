<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully</br>";

$sql = "SELECT * FROM user";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$arrUser = $result->fetch_assoc();
if (mysqli_num_rows($result) > 0) {
    echo "<br>Array: ". print_r($arrUser, true) . "</br>";
}
$conn->close();
