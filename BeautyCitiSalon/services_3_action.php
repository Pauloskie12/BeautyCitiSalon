<?php
include_once "connections/connect.php";
$con = $lib->openConnection();

$staff_id = $_GET['staff_id'];
$date = $_GET['date'];
$time = $_GET['time'];
$limit = $_GET['limit'];

$total_duration = $_GET['total_duration'];

if($_GET['type'] == 1){

    $sel_cat = $con->prepare("SELECT * FROM tbl_selected tss
    INNER JOIN tbl_job tj ON job_categoryid = tss.selected_categoryid
    INNER JOIN tbl_staff ts ON ts.staff_position = tj.job_id
    INNER JOIN tbl_subcategory tc ON tc.subcategory_id = tss.selected_subcategoryid
    WHERE ts.staff_id = ?");
    $sel_cat->execute([$staff_id]);
    
    while($val = $sel_cat->fetch()){
        $stmt = $con->prepare("INSERT INTO tbl_selected2(`selected_subcategoryid`,`selected_staffid`,`selected_bookingdate`, `selected_bookingtime`) VALUES(?,?,?,?)");
        $stmt->execute([$val['selected_subcategoryid'], $staff_id, $date, $time]);
        $stmt_upd_mins = $con->prepare("UPDATE tbl_mins SET mins_stat = ? WHERE mins_staffid = ? AND mins_date = ?");
        $stmt_upd_mins->execute([1, $staff_id, $date]);
        echo "<script>window.location.href='services_3.php?limit=$limit'</script>";
    }

}else{

    $sel_cat = $con->prepare("SELECT * FROM tbl_selected tss
    INNER JOIN tbl_job tj ON job_categoryid = tss.selected_categoryid
    INNER JOIN tbl_staff ts ON ts.staff_position = tj.job_id
    INNER JOIN tbl_subcategory tc ON tc.subcategory_id = tss.selected_subcategoryid
    WHERE ts.staff_id = ?");
    $sel_cat->execute([$staff_id]);
    
    while($val = $sel_cat->fetch()){
        $stmt = $con->prepare("INSERT INTO tbl_selected2(`selected_subcategoryid`,`selected_staffid`,`selected_bookingdate`,`selected_bookingtime`) VALUES(?,?,?,?)");
        $stmt->execute([$val['selected_subcategoryid'], $staff_id, $date, $time]);

        $stmt_upd_mins = $con->prepare("UPDATE tbl_mins SET mins_stat = ? WHERE mins_staffid = ? AND mins_date = ?");
        $stmt_upd_mins->execute([1, $staff_id, $date]);
        echo "<script>window.location.href='services_3_action2.php'</script>";
    }
}



?>