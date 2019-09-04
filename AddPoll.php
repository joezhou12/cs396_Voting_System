<?php
// require db file for connection
require('db.php');
// check if data is posted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // store data from post to local variables
    $pollQuestion = $_POST["pollQuestion"];
    $choices = $_POST["choices"];
    $res = insertData($pollQuestion,$choices);
    if($res == true){
        header("Location: index.php");
        die();
    }else{

    }
  
}

// insert data into table
function insertData($poll,$choices) {
    $sql = "INSERT INTO polls (name)
    VALUES ('".$poll."')";
    global $conn;
    
    if ($conn->query($sql) === TRUE) {
        // if poll data is saved then get its id and save choices and foreign key to choices table
        $poll_id = $conn->insert_id;
        foreach($choices as $choice){
            $sql = "INSERT INTO choices (text,poll_id)
            VALUES ('".$choice."','".$poll_id."')";
            $conn->query($sql);
        }
        
        return true;
    } else {
        return false;
    }
    
    $conn->close();

}



?>