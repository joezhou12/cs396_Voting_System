<?php
//include database connection code
require('db.php');

//get poll id from url
$poll_id = $_GET["poll"];


// get poll
$sql = "select * from polls where id = '".$poll_id."'";
$result = $conn->query($sql);
$poll = $result->fetch_assoc();

//get all votes answer of the voted poll
$sql = "select * from votes where poll_id = '".$poll_id."'";
$result2 = $conn->query($sql);
//total count answers of the selected poll
$total = $result2->num_rows;
//fetch voted answers from result
$voted_answers = [];
while($row = $result2->fetch_assoc()) {
    $voted_answers[] = $row;
}


$sql = "select * from choices where poll_id = '".$poll_id."'";
$result3 = $conn->query($sql);
$answers = [];
while($row = $result3->fetch_assoc()) {
    // for getting percentage of each choice in poll
    $sql = "select COUNT(*) as total_count_of_answer FROM votes WHERE choice_id='".$row['id']."'";
    $result4 = $conn->query($sql);
    $count = $result4->fetch_assoc();
    $total_answers = $count['total_count_of_answer'];
    $item["count"] = $total_answers;
    $item["percentage"] = number_format((float)($total_answers/$total)*100, 2, '.', '');
    array_push($row, $item);
    $answers[] =  $row;
}

$sql = "select c.text from votes as v, choices as c
where v.choice_id = c.id
AND	v.id = (select max(id) from votes)";
    $result5 = $conn->query($sql);
    $yourchoiceA = $result5->fetch_assoc();
    $yourchoice = implode("",$yourchoiceA);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="lib/css/bootstrap.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Voting system - Results</title>

    <style>
    
    dd{
        -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    }
    .bar {
    margin-bottom: 10px;
    color: #fff;
    height:25px;
    padding: 4px;
    text-align: center;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    }






    </style>

</head>
<body>
    
<nav class="nav bg-secondary mb-2 p-2">
  <a class="nav-link page-link mx-4 rounded" href="addpoll.html">Add Poll</a>
  <a class="nav-link page-link rounded" href="index.php">Polls</a>
</nav>

<div class="container">
        <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <h2 class="card-header text-light text-center bg-dark">
                            Results
                        </h2>
                                   <div class="card-body">
                            <P>Poll: <strong class="ml-2"><?= $poll['name'] ?></strong> </P>
                            <P>Total Votes : <strong class="ml-2"><?= $total ?></strong> </P>
                            <P>Your Vote : <strong class="ml-2"><?= $yourchoice ?></strong> </P>
                        
                  
                        
                        <?php
                        echo '<dl>';
                        foreach($answers as $answer){
                            ?>
                            <strong><span class="mr-2"><?= $answer['text'] ?></span></strong><br>
                            - Number of Votes: <?= $answer[0]['count'] ?> <span class="ml-1 badge badge-info"><?=$answer[0]['percentage']?>%</span>
                            <dd class="mt-1 bg-dark"><div class="bar bg-success" style="width: <?=$answer[0]['percentage']?>%"></div></dd>
                            </dl>

   
                            <?php
                        }
                        
                            echo '<br>';
                            echo '</dl >';
                            echo '<script>';
                            echo 'var myAnswers = {
                              
                          ';
                            foreach($answers as $answer){
                                ?>
                             "<strong><?= $answer['text'] ?></strong> " : <?=$answer[0]['percentage']?>,
                             
                            <?php
                            } 

                            echo '}; console.log(Object.keys(myAnswers).length); </script>';
                            // echo '</dl>';
                        ?>
                        
                        <!-- pie chart -->
                        <div class="row">
                        <div class="col-md-12">
                        <div class="w-50 mx-auto">
                        <canvas id="myCanvas" width="400" height="400"></canvas>
                        <div id="myLegend" class="w-50 mt-4"></div>
                        
                        </div>
                        
                        </div>
                        </div>
                        <!-- pie chart ends -->

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
