<?php
session_start();
include_once"../connections/connect.php";
$conn = $lib->openConnection();


$today = time();  
$cur_time = date('h:i: a', strtotime('-4 hours', $today));


$stmt_bookingtime1 = $conn->prepare("SELECT * FROM tbl_mins tm
INNER JOIN tbl_sched ts ON ts.sched_id = tm.mins_schedid
INNER JOIN tblbook ON tblbook.tblbook_bookingdate = tm.mins_date
WHERE tm.mins_stat = ?
ORDER BY tm.id ASC ");
$stmt_bookingtime1->execute([1]);

while($bookingtime_row1 = $stmt_bookingtime1->fetch()){
    $bt = $bookingtime_row1['sched_time'];
    $timestamp = strtotime($bt);
    $bt_time = date('h:i: a', strtotime('-20 minutes',  $timestamp));
    if($cur_time >= $bt_time){
        
        $notif = $conn->prepare("INSERT INTO tbl_notif (`notification`,`user_id`,`sender_id`) VALUES(?,?,?)");
        $notif->execute(['You have 20 minutes left before your book time expire!', $bookingtime_row1['tblbook_userid'], $_SESSION['bpmsaid']]);

    }
}
// echo $bt;
// echo $bt_time;
// echo $cur_time;
?>