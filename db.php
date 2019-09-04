<?php

$conn;
$servername = "localhost";
// database username
$username = "root";
// database password
$password = "";
// database name
$dbname = "votingDb";    
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>