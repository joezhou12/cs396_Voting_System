<?php
require('db.php');

$sql = "SELECT * FROM polls";
$result = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="lib/css/bootstrap.css">
    <title>Voting system - all polls</title>
</head>
<body>
      <!-- navigations -->
<nav class="nav bg-secondary mb-2 p-2">
  <a class="nav-link page-link mx-4 rounded" href="addpoll.html">Add Poll</a>
  <a class="nav-link page-link rounded" href="index.php">Polls</a>
</nav>
    <div class="container">
        <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <h2 class="card-header text-light text-center bg-dark">
                            All Polls
                        </h2>
                        <div class="card-body">
                        <?php
                        if ($result->num_rows > 0) {
                            // output data of each row in accordion
                            echo '<div class="accordion" id="accordionPoll">';
                            while($row = $result->fetch_assoc()) {
                                ?>

                                    
                                        <div class="card">
                                            <div class="card-header" id="poll-<?= $row['id'] ?>">
                                            <h5 class="mb-0">
                                                <!-- button to collapse and show accordion data -->
                                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?= $row['id'] ?>" aria-expanded="true" aria-controls="collapse<?= $row['id'] ?>">
                                                    <?= $row['name'] ?>
                                                </button>
                                            </h5>
                                            </div>
                                            <!-- collapsed data -->
                                            <div id="collapse<?= $row['id'] ?>" class="collapse" aria-labelledby="poll-<?= $row['id'] ?>" data-parent="#accordionPoll">
                                            <div class="card-body">
                                                <h6>Select a choice for poll</h6>
                                                <?php
                                                // get choices of the selected poll
                                                    $sql = "SELECT * FROM choices where poll_id = '".$row['id']."'";
                                                    $result2 = $conn->query($sql);
                                                    if ($result2->num_rows > 0) {
                                                        while($row2 = $result2->fetch_assoc()) {
                                                            ?>
                                                                <div class="input-group mb-3">
                                                                    <input type="text" class="form-control" value="<?=$row2['text']?>" disabled aria-label="poll's choice" aria-describedby="button-poll-<?= $row['id'] ?>-choice-<?= $row2['id'] ?>">
                                                                    <div class="input-group-append">
                                                                        <a class="btn btn-outline-secondary" href="vote.php?poll=<?=$row['id']?>&choice=<?=$row2['id']?>" id="button-poll-<?= $row['id'] ?>-choice-<?= $row2['id'] ?>">Vote</a>
                                                                    </div>
                                                                </div>
                                                            
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                                
                                            </div>
                                            </div>
                                        </div>
                                    
                                <?php
                               
                            }

                            echo '</div>';
                
                        }
                        else{
                            echo '<h4>NO POLLS YET</h4>';
                        }

                ?>
                        </div>
                    </div>
                
                </div>
        </div>    
    </div>


        <script src="lib/js/jquery-3.3.1.js"></script>
        <script src="lib/js/bootstrap.js"></script>
        <script src="lib/js/custom.js"></script>
</body>
</html>
