<?php 
session_start();
error_reporting(0);
include_once "./connections/connect.php";
$conn = $lib->openConnection();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './phpmailer/src/Exception.php';
require './phpmailer/src/PHPMailer.php';
require './phpmailer/src/SMTP.php';

$count_notif = $conn->prepare("SELECT * FROM tbl_notif WHERE user_id = ? AND stat = ?");
$count_notif->execute([$_SESSION['bpmsuid'], 0]);
$total_count_notif = $count_notif->rowCount();

if(isset($_REQUEST['stat'])){
    $_SESSION['bpmsuid'] = $_GET['id'];
    echo "<script>window.location.href= 'index.php'; </script>";
}

if(isset($_SESSION['bpmsuid'])){

    $check_user = $conn->prepare("SELECT * FROM tbl_users WHERE users_id = ?");
    $check_user->execute([$_SESSION['bpmsuid']]);

    $users = $check_user->fetch();

}

if(isset($_POST['btn_login'])){

    $email    = $_POST['email'];
    $password = $_POST['password'];
    $check_login = $conn->prepare("SELECT * FROM tbl_users tu
    INNER JOIN tbl_otp otp ON tu.users_id = otp.otp_userid
    WHERE users_email = ? AND users_password = ? AND otp.otp_stat = ?");
    $check_login->execute([$email, $password, 1]);
    $account = $check_login->fetch();

    if($check_login->rowCount() > 0){
        if($account['users_type'] == 0){
            $_SESSION['bpmsuid'] = $account['users_id'];
            echo "<script>window.location.href= 'index.php'; </script>";
        }

        if($account['users_type'] == 1){
            $_SESSION['bpmsaid'] = $account['users_id'];
            echo "<script>window.location.href= './admin/dashboard.php'; </script>";
        }
    }else{
        
        ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            (async () => {
                  const { value: password } = await Swal.fire({
                    title: "Email Verification",
                    input: "number",
                    inputLabel: "We've sent a verification code to your email!",
                    inputPlaceholder: "Enter your otp code here",
                    inputAttributes: {
                      maxlength: "10",
                      autocapitalize: "off",
                      autocorrect: "off"
                    }
                  });
                  if (password) {
                    $.ajax({
                        type: 'POST',
                        url: 'process.php', // URL to your PHP script
                        data: { otp: `${password}`, email: `<?=$email;?>`, password: `<?=$password;?>` }, // Form data
                        success: function(response){
                            if(response == 'success'){
                                // Swal.fire({
                                //   title: "Email Verification",
                                //   text: "",
                                //   icon: "success"
                                // });
                                
                                const Toast = Swal.mixin({
                                  toast: true,
                                  position: "top-end",
                                  showConfirmButton: false,
                                  timer: 3000,
                                  timerProgressBar: true,
                                  didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                    <?php
                                    $check_user_verified = $conn->prepare("SELECT * FROM tbl_users WHERE users_email = ? AND users_password = ?");
                                    $check_user_verified->execute([$email, $password]);
                                    $row_user_verified = $check_user_verified->fetch();
                                    
                                    ?>
                                    setTimeout(function(){
                                        window.location.href = 'index.php?id='+<?=$row_user_verified['users_id'];?>+'&stat=ok';
                                    }, 3000);
                                    
                                  }
                                });
                                Toast.fire({
                                  icon: "success",
                                  title: "Successfully Verified!"
                                });
                                
                                
                                
                                
                            }
                            if(response == 'failed'){
                                    Swal.fire({
                                      title: "Email Verification",
                                      text: "OTP doesn't matched, please try again!",
                                      icon: "error"
                                    });
                                
                                
                            }
                        }
                    });
                    
                  }
                })()
        </script>
        <?php
        
    }


}

if(isset($_POST['btn_signup'])){

    $fname    = $_POST['fname'];
    $lname    = $_POST['lname'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $address  = $_POST['address'];
    $contact  = $_POST['contact'];

    $check_email = $conn->prepare("SELECT * FROM tbl_users WHERE users_email = ? AND users_password = ?");
    $check_email->execute([$email, $password]);

    if($check_email->rowCount() > 0){
        echo "<script>window.alert('Email already exist!');</script>";
    }else{
        
        function generateOTP($length = 6) {
            // Generate a random string of numbers
            $characters = '0123456789';
            $otp = '';
            $max = strlen($characters) - 1;
            for ($i = 0; $i < $length; $i++) {
                $otp .= $characters[random_int(0, $max)];
            }
            return $otp;
        }
        
        $otp_code = generateOTP(6);
        
        $stmt = $conn->prepare("INSERT INTO tbl_users(`users_firstname`,`users_lastname`,`users_middlename`,`users_email`,`users_address`,`users_contact`,`users_password`,`users_type`) VALUES(?,?,?,?,?,?,?,?)");
        $stmt->execute([$fname, $lname , '', $email, $address, $contact, $password, 0]);
        $uid = $conn->lastInsertId();
        $userid_email =  $email;
        $userid_name = $fname." ".$lname;
        
        $stmt12 = $conn->prepare("INSERT INTO tbl_otp (`otp_code`,`otp_userid`) VALUES(?,?)");
        
        
        if($stmt12->execute([$otp_code, $uid])){
            // Create a new PHPMailer instance
            $mail = new PHPMailer(true); // Passing `true` enables exceptions
    
            try {
                // Server settings
                $mail->isSMTP(); // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
                $mail->SMTPAuth = true; // Enable SMTP authentication
                $mail->Username = 'beautycitisalon@gmail.com'; // SMTP username
                $mail->Password = 'kzkjnjnovsmerefb'; // SMTP password
                $mail->SMTPSecure = 'ssl'; // Enable SSL encryption
                $mail->Port = 465; // TCP port to connect to
            
                // Recipients
                $mail->setFrom('beautycitisalon@gmail.com', 'BeautyCiti Salon');
                $mail->addAddress($userid_email, $userid_name); // Add a recipient
            
                // Content
                $mail->isHTML(true); // Set email format to HTML
                $mail->Subject = 'Email Verification';
                $mail->Body    = '<p style="padding: 10px 20px; border-left: 10px groove dodgerblue; color: white; background: #000; font-size: 18px">Dear <span style="color: crimson"><b>'.$userid_name.'</b></span>,<br><br>Your one-time password (OTP) for account verification is: <br><span style="font-size: 20px; color: yellow">'.$otp_code.'</span><br><br>Please enter this code on the verification page to complete the process. </p>';
            
                $mail->send();
                // echo 'Message has been sent';
            } catch (Exception $e) {
                // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
        
        echo "<script>window.alert('Registered successfully!');</script>";
        echo "<script>window.location.href= 'index.php'; </script>";
        
    }
    
}


?>
<style>
    /* Hide the browser's default checkbox */
    #container #checkmark {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
      }

      /* Create a custom checkbox */
      .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
      }

      /* On mouse-over, add a grey background color */
      #container:hover input ~ .checkmark {
        background-color: #ccc;
      }

      /* When the checkbox is checked, add a blue background */
      #container input:checked ~ .checkmark {
        background-color: #2196F3;
      }

      /* Create the checkmark/indicator (hidden when not checked) */
      .checkmark:after {
        content: "";
        position: absolute;
        display: none;
      }

      /* Show the checkmark when checked */
      #container input:checked ~ .checkmark:after {
        display: block;
      }

      /* Style the checkmark/indicator */
      #container .checkmark:after {
        left: 9px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
      }
</style>
<section class=" w3l-header-4 header-sticky">
    <header class="absolute-top"  style="background: #222 !important">
        <div class="container" >
        <nav class="navbar navbar-expand-lg" >
            <h1><a class="navbar-brand" href="index.php"> <!--<span class="fa fa-line-chart" aria-hidden="true"></span> -->
            <img src="assets/images/logo.png" alt="" width="500px" height="60px" class="d-inline-block align-text-top">
            </a></h1>
            <button class="navbar-toggler bg-gradient collapsed" type="button" data-toggle="collapse"
                data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="fa icon-expand fa-bars text-white" style="border: none !important"></span>
                <span class="fa icon-close fa-times text-white" style="border: none !important"></span>
            </button>
      
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About Us</a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="services.php">Services</a>
                    </li> 

                    <li class="nav-item">
                        <a class="nav-link" href="gallery.php">Gallery</a>
                    </li>
                     
                     <?php if (strlen($_SESSION['bpmsuid']==0)) {?>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="admin/index.php">Admin</a>
                    </li> -->
                     <!-- <li class="nav-item">
                        <a class="nav-link" href="signup.php">Signup</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" type="button" data-toggle="modal" data-target="#exampleModalToggle">Login</a>
                    </li><?php }?>
                    <?php if (strlen($_SESSION['bpmsuid']>0)) {?>

                    <li class="nav-item">
                        <a class="nav-link" href="booking-history.php" role="button" aria-expanded="false">
                            Booking History
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                            Hi <?= $users['users_firstname']; ?>
                        </a>

                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="profile.php">Profile</a>
                            <a class="dropdown-item" href="change-password.php">Setting</a>
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="notification.php" role="button" aria-expanded="false" style="position: relative">
                            <i class="fa fa-bell"></i></i>
                            <?php
                            if($total_count_notif > 0){
                                ?>
                                <span class="badge badge-danger" style="position: absolute; top: 0; right: 0"><?=$total_count_notif;?></span>
                                <?php
                            }else{
                                echo '';
                            }
                            ?>
                        </a>
                    </li>
                                        
                    
                  <?php }?>
                </ul>
                
            </div>

            <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content"  style="background: #222; color: #f2f2f2">
                <div class="modal-body">
                <div class="myform">
                    <div id="LOGIN">
                        <h1 class="text-center">Login Form</h1>
                        <form method="POST">
                            <div class="mb-3 mt-4">
                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter your email" id="exampleInputEmail1" required>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter your password" id="exampleInputPassword1" required>
                            </div>
                            <div style="text-align: right">
                                <button type="submit" name="btn_login" class="btn btn-light mt-3">LOGIN</button>
                            </div>
                        </form>
                        <center><p>Not a member? <a type="button" id="link_signup">Signup now</a></p></center>
                        
                    </div>
                        
                    <div id="SIGNUP" style="display: none">
                        <h1 class="text-center">Signup Form</h1>
                        <form method="POST">
                            <div class="mb-3 mt-4">
                                <label for="exampleInputEmail1" class="form-label">Firstname</label>
                                <input type="text" name="fname" class="form-control" placeholder="Input your firstname" id="exampleInputEmail1" required>
                            </div>
                            <div class="mb-3 mt-4">
                                <label for="exampleInputEmail1" class="form-label">Lastname</label>
                                <input type="text" name="lname" class="form-control" placeholder="Input your lastname" id="exampleInputEmail1" required>
                            </div>
                            <div class="mb-3 mt-4">
                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                <input type="email" name="email" class="form-control" placeholder="Input your email address" id="exampleInputEmail1" required>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Input your password" id="exampleInputPassword1" required>
                            </div>
                            <div class="mb-3 mt-4">
                                <label for="exampleInputEmail1" class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" placeholder="Input your address" id="exampleInputEmail1" required>
                            </div>
                            <div class="mb-3 mt-4">
                                <label for="exampleInputEmail1" class="form-label">Contact No.</label>
                                <input type="text" name="contact" maxlength="11" class="form-control" placeholder="Input your mobile number" id="exampleInputEmail1" required>
                            </div>
                            <div class="form-group form-check">
                                <label id="container"> 
                                    <a href="#" style="margin-left: 10px" id="link_terms">I hereby accept the terms and privacy policy</a>
                                    <input type="checkbox" class="check-group" id="checkmark" value="">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div style="text-align: right">
                                <button type="submit" name="btn_signup" id="btn_signup" class="btn btn-light mt-3" disabled>SIGNUP</button>
                            </div>
                        </form>
                        <center><p>Already a member? <a type="button" id="link_login">Login now</a></p></center>
                    </div>

                    <div id="TERMS" style="display: none">
                        <center><h3>*Terms and Conditions*</h3></center>
                        <hr>
                        <p>

                            <b>By using our services or making a booking, you agree to the following terms and conditions:</b>
                            <br><br>
                            1. *No Refunds*: All bookings made through our platform are non-refundable. Once a booking is confirmed and payment is processed, there will be no refunds provided under any circumstances.
                            <br><br>
                            2. *Timeliness*: It is essential to adhere to the specified schedule and check-in/check-out times. Any late arrivals or departures may result in an automatic cancellation of your booking, and no refunds will be issued in such cases.
                            <br><br>
                            3. *No Record of Payment*: We do not retain or provide evidence of payment for bookings. It is your responsibility to retain any payment receipts or confirmation emails for your records.
                            <br><br>
                            4. *Cancellation Policy*: In addition to the automatic cancellation for late arrivals, please note that certain bookings may have specific cancellation policies. You are advised to review these policies before making a booking.
                            <br><br>
                            5. *Liability*: We are not liable for any losses, damages, or inconveniences resulting from adherence to these terms and conditions, including the no refund policy and automatic cancellation for late arrivals.
                            <br><br>
                            6. *Acceptance*: Your use of our services and the completion of a booking signify your acceptance of these terms and conditions. It is your responsibility to review and understand these terms before proceeding with any booking.
                            <br><br><br>
                            Please read these terms and conditions carefully. If you do not agree with any part of these terms, we advise against using our services. If you have any questions or concerns, please contact us before making a booking.
                            </p>
                            <br><br>
                        <center><button type="button" class="btn btn-info" id="link_signup2">I accept</button></center>
                    </div>

                    </div>
                </div>
                </div>
                </div>
            </div>
            </div>
        

        </div>

        </nav>
    </div>
      </header>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        // Triggered when any checkbox with class "checkbox-group" is changed
        $('.check-group').change(function(){
            if($('.check-group:checked')){
                $('#btn_signup').removeAttr('disabled');
            }else{
                $('#btn_signup').attr('disabled');
            }

        });
    });
</script>
<script>

    $(document).ready(function(){
        $('#link_signup').on('click', function(){
            $('#SIGNUP').show();
            $('#LOGIN').hide();
            $('#TERMS').hide();
        });        
        $('#link_signup2').on('click', function(){
            $('#SIGNUP').show();
            $('#LOGIN').hide();
            $('#TERMS').hide();
        });
        $('#link_login').on('click', function(){
            $('#SIGNUP').hide();
            $('#LOGIN').show();
            $('#TERMS').hide();
        });
        $('#link_terms').on('click', function(){
            $('#SIGNUP').hide();
            $('#LOGIN').hide();
            $('#TERMS').show();
        });
    })
</script>