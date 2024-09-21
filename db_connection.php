<?php
$host = 'localhost'; // or your database host
$db = 'mydatabase'; // your database name
$user = 'garrett'; // your database username
$pass = 'bayley'; // your database password

// Create a new mysqli connection
$db = new mysqli($host, $user, $pass, $db);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
