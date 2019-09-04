<?php
require('db.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (empty($_GET)) {
        header("Location: index.php");
        die();
    }
    
    $poll = $_GET["poll"];
    $choice = $_GET["choice"];

    $sql = "INSERT INTO votes (poll_id,choice_id)
    VALUES ('".$poll."','".$choice."')";
    if ($conn->query($sql) === TRUE) {
        header("Location: results.php?poll=".$poll);
        die();
    }
  
}


?>