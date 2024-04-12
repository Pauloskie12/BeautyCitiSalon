<?php
include_once "connections/connect.php";
$con = $lib->openConnection();

$stmt = $con->prepare("SELECT * FROM tbl_sched");
$stmt->execute();

$count = $stmt->rowCount();
$loop = 1;
$mins = 0;
while($loop <= $count){
    $stmt = $con->prepare("UPDATE tbl_sched SET sched_mins = ? WHERE sched_id = ?");
    $stmt->execute([$mins, $loop]);
    $loop++;
    $mins+=15;
}





?>