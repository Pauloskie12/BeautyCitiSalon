<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include_once "./connections/connect.php";
$conn = $lib->openConnection();

$datas1 = $_GET['data1'];
$datas2 = $_GET['data2'];

$dataArray1 = explode(",", $datas1);
$dataArray2 = explode(",", $datas2);

$combinedArray = array_combine($dataArray1, $dataArray2);

$check_tbl = $conn->prepare("SELECT * FROM tbl_selected");
$check_tbl->execute();

if($check_tbl->rowCount() > 0){
  $empty_tbl = $conn->prepare("DELETE FROM tbl_selected");
  $empty_tbl->execute();
}

foreach($combinedArray as $data1 => $data2){
  $stmt = $conn->prepare("INSERT INTO tbl_selected (`selected_subcategoryid`, `selected_categoryid`) VALUES (?,?)");
  $stmt->execute([$data1, $data2]);
}

echo header("Location: services_3.php?limit=0");
?>
