<?php
session_start();
include_once"./connections/connect.php";
$conn = $lib->openConnection();


$today = time();  
$cur_time = date('h:i: a', strtotime('-4 hours', $today));


$stmt_bookingtime1 = $conn->prepare("SELECT * FROM tbl_mins tm
INNER JOIN tbl_sched ts ON ts.sched_id = tm.mins_schedid
INNER JOIN tblbook ON tblbook.tblbook_bookingdate = tm.mins_date
WHERE tm.mins_stat = ? AND tblbook.tblbook_userid = ? AND tblbook.tblbook_status = ?
GROUP BY tm.mins_staffid ORDER BY tm.id ASC LIMIT 1");
$stmt_bookingtime1->execute([1, $_SESSION['bpmsuid'], 'Accepted']);

while($bookingtime_row1 = $stmt_bookingtime1->fetch()){
    $bt = $bookingtime_row1['sched_time'];
    $notification_msg = 'You have 20 minutes left before your book time expire!';
    $timestamp = strtotime($bt);
    $bt_time = date('h:i: a', strtotime('-20 minutes',  $timestamp));
    $bt_time2 = date('h:i: a', strtotime('-1 minutes',  $timestamp));
    
    $check_u = $conn->prepare("SELECT * FROM tbl_notif WHERE notification = ? AND user_id = ?");
    $check_u->execute([$notification_msg, $_SESSION['bpmsuid']]);
    
    
        if($check_u->rowCount() > 0){

        }else{
            
            if($cur_time >= $bt_time && $cur_time <= $bt){
                $notif = $conn->prepare("INSERT INTO tbl_notif (`notification`,`user_id`) VALUES(?,?)");
                $notif->execute([$notification_msg, $_SESSION['bpmsuid']]);
            }
    
        }
}
// echo $bt;
// echo $bt_time;
// echo $cur_time;
?>