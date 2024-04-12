<?php
include_once "../connections/connect.php";
$conn = $lib->openConnection();

if(isset($_POST['btn_edit'])){
    $staff_id = $_POST['staff_id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $position = $_POST['position'];

    $stmt01 = $conn->prepare("UPDATE tbl_staff SET `staff_firstname` = ?,`staff_lastname` = ?,`staff_email` = ?,`staff_address` = ?,`staff_contact` = ?,`staff_position` = ? WHERE `staff_id` = ?");
    $stmt01->execute([$fname,$lname,$email,$address,$contact,$position, $staff_id]);

	$stmt02 = $conn->prepare("UPDATE tbl_users SET `users_firstname` = ?,`users_lastname` = ?,`users_email` = ?,`users_address` = ?,`users_contact` = ?,`users_type` = ?,`type = ?` WHERE `users_staffid` = ?");
    $stmt02->execute([$fname,$lname,$email,$address,$contact,1,1, $staff_id ]);
    
    ?>
    
    <script>window.alert('Staff Updated!');</script>
    <script>window.location.href='staff-list.php';</script>
    <?php




}

?>