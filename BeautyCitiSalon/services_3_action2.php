<?php
session_start();
include_once "connections/connect.php";
$con = $lib->openConnection();

$stmt = $con->prepare("SELECT * FROM tbl_selected2");
$stmt->execute();

function generateInvoiceID($prefix = 'BID') {
    // Generate a unique identifier (timestamp)
    $uniqueID = date('YmdHis');

    // Combine prefix and unique identifier
    $invoiceID = $prefix . '-' . $uniqueID;

    return $invoiceID;
}

// Usage example
$invoiceID = generateInvoiceID();


while($row = $stmt->fetch()){
    $stmt1 = $con->prepare("INSERT INTO tblbook(`tblbook_userid`,`tblbook_bookingdate`,`tblbook_subcategoryid`,`tblbook_bookingnumber`,`tblbook_staffid`) VALUES(?,?,?,?,?)");
    $stmt1->execute([$_SESSION['bpmsuid'], $row['selected_bookingdate'], $row['selected_subcategoryid'], $invoiceID, $row['selected_staffid']]);
}


$stmt2 = $con->prepare("DELETE FROM tbl_selected");
$stmt2->execute();
$stmt3 = $con->prepare("DELETE FROM tbl_selected2");
$stmt3->execute();

echo "<script>window.alert('Your request has been sent! Please wait for admin approval!');</script>";
echo "<script>window.location.href = 'services.php';</script>";





?>