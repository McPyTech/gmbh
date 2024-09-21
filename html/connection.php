<?php

$server = "localhost";
$username = "garrett";
$password = "bayley";
$db = "mydatabase";

$conn = new mysqli($server, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

?>
