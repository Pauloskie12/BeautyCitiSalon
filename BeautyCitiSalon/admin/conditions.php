<?php
session_start();
include_once "../connections/connect.php";
$conn = $lib->openConnection();
$today = date("Y-m-d");
$cur_time = date("H:i");

// $stmt = $conn->prepare("SELECT * FROM tblbook tb
// 						INNER JOIN tbl_users tu ON tu.users_id=tb.tblbook_userid 
// 						INNER JOIN 
// 						WHERE tb.tblbook_status = 'Accepted'
// 						GROUP BY tb.tblbook_bookingnumber");

$stmt = $conn->prepare("SELECT * FROM tbl_mins 
INNER JOIN tblbook ON tblbook.tblbook_staffid = tbl_mins.mins_staffid
INNER JOIN tbl_sched ON tbl_sched.sched_id = tbl_mins.mins_schedid
WHERE tbl_mins.mins_stat = ? AND DATE(tbl_mins.mins_date) = ? AND DATE(tbl_sched.sched_time) = ?
GROUP BY tbl_mins.mins_date LIMIT 1
");

$stmt->execute([1, $today, $cur_time]);

if($stmt->rowCount() > 0){
    while($val = $stmt->fetch()){
        
        $ched_time = $val['sched_time'];
        
        $notif = $conn->prepare("INSERT INTO tbl_notif (`notification`,`user_id`,`sender_id`) VALUES(?,?,?)");
        $notif->execute(['You have 20 minutes left before your book time expire!', $val['tblbook_userid'], $_SESSION['bpmsaid']]);
        echo "<script>window.alert(".$sched_time.");</script>";
    }
}

?>