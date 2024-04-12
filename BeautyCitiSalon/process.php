<?php
include_once "./connections/connect.php";
$con = $lib->openConnection();

$otp = $_POST['otp'];
$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $con->prepare("SELECT * FROM tbl_users tu
INNER JOIN tbl_otp otp ON tu.users_id = otp.otp_userid
WHERE tu.users_email = ? AND tu.users_password = ? AND otp.otp_code = ? AND otp.otp_stat = ?");
$stmt->execute([$email, $password, $otp, 0]);

if($stmt->rowCount() > 0){
    $row = $stmt->fetch();
    $stmt2 = $con->prepare("UPDATE tbl_otp SET otp_stat = ? WHERE otp_userid = ?");
    $stmt2->execute([1, $row['users_id']]);
    
    echo 'success';
}else{
    echo 'failed';
}





?>