<?php

include_once "connections/connect.php";
$con = $lib->openConnection();

$id = $_GET['id'];

$stmt = $con->prepare("DELETE FROM tbl_selected WHERE selected_id = ?");
$stmt->execute([$id]);

echo "<script>window.alert('Removed from list.');</script>";
echo "<script>window.history.back();</script>";

?>



