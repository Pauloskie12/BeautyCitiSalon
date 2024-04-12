<?php 
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['bpmsuid']==0)) {
  header('location:logout.php');
  } else{
if(isset($_POST['submit']))
  {
    $uid=$_SESSION['bpmsuid'];
    $fname=$_POST['firstname'];
    $lname=$_POST['lastname'];
    $query=mysqli_query($con, "UPDATE tbl_users SET users_firstname='$fname', users_lastname='$lname' where users_id='$uid'");


    if ($query) {
 echo '<script>alert("Profile updated successully.")</script>';
echo '<script>window.location.href=profile.php</script>';
  }
  else
    {
     
      echo '<script>alert("Something Went Wrong. Please try again.")</script>';
    }

}


  ?>
<!doctype html>
<html lang="en">
  <head>
 

    <title>BeautiCiti Salon | Signup Page</title>

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
  </head>
  <body id="home">
<?php include_once('includes/header.php');?>

<script src="assets/js/jquery-3.3.1.min.js"></script> <!-- Common jquery plugin -->
<!--bootstrap working-->
<script src="assets/js/bootstrap.min.js"></script>
<!-- //bootstrap working-->
<!-- disable body scroll which navbar is in active -->
<script>
$(function () {
  $('.navbar-toggler').click(function () {
    $('body').toggleClass('noscroll');
  })
});
</script>

<!-- disable body scroll which navbar is in active -->

<!-- breadcrumbs -->
<section class="w3l-inner-banner-main">
    <div class="about-inner contact ">
        <div class="container">   
            <div class="main-titles-head text-center">
            <h3 class="header-name ">Profile</h3>
            <!-- <p class="tiltle-para ">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Hic fuga sit illo modi aut aspernatur tempore laboriosam saepe dolores eveniet.</p> -->
        </div>
</div>
</div>
<div class="breadcrumbs-sub">
<div class="container">   
<ul class="breadcrumbs-custom-path">
    <li class="right-side propClone"><a href="index.php" class="text-danger">Home <span class="fa fa-angle-right" aria-hidden="true"></span></a> <p></li>
    <li class="active ">profile</li>
</ul>
</div>
</div>
    </div>
</section>
<!-- breadcrumbs //-->
<section class="w3l-contact-info-main" id="contact">
    <div class="contact-sec	">
        <div class="container">

            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <center><h3>User Profile!!</h3></center>
                    <form method="post" name="signup" onsubmit="return checkpass();">
                    <?php
                    $uid=$_SESSION['bpmsuid'];
                    $ret=mysqli_query($con,"select * from tbl_users where users_id='$uid'");
                    $cnt=1;
                    while ($row=mysqli_fetch_array($ret)) {

                    ?>
                        <div style="padding-top: 30px;">
                            <label>First Name</label>
                            
                            <input type="text" class="form-control" name="firstname" value="<?php  echo $row['users_firstname'];?>" required="true"></div>
                           <div style="padding-top: 30px;">
                            <label>Last Name</label>
                            
                            <input type="text" class="form-control" name="lastname" value="<?php  echo $row['users_lastname'];?>" required="true">
                        </div>
                        <div style="padding-top: 30px;">
                            <label>Mobile Number</label>
                           
                           <input type="text" class="form-control" name="mobilenumber" value="<?php  echo $row['users_contact'];?>"  readonly="true"></div>
                           <div style="padding-top: 30px;">
                            <label>Email address</label>
                            
                            <input type="text" class="form-control" name="email" value="<?php  echo $row['users_email'];?>"  readonly="true">
                        </div>
                         
                     
                      <?php }?>
                      <br>
                      <br>
                        <center><button type="submit" class="btn btn-danger" name="submit">Save Change</button></center>
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>
   
        </div>
    </div>
</section>

<?php include_once('includes/footer.php');?>
<!-- move top -->
<button onclick="topFunction()" id="movetop" title="Go to top">
	<span class="fa fa-long-arrow-up"></span>
</button>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        setInterval(function(){
            
            $.ajax({ // Start AJAX request
                url: "fetch.php", // URL to which the request is sent
                type: "POST", // Specify the type of request
                success: function(result){ // Function to be executed if the request succeeds
                    // window.alert(result);
                }
            });
        },1000)

    })
</script>
<script>
	// When the user scrolls down 20px from the top of the document, show the button
	window.onscroll = function () {
		scrollFunction()
	};

	function scrollFunction() {
		if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
			document.getElementById("movetop").style.display = "block";
		} else {
			document.getElementById("movetop").style.display = "none";
		}
	}

	// When the user clicks on the button, scroll to the top of the document
	function topFunction() {
		document.body.scrollTop = 0;
		document.documentElement.scrollTop = 0;
	}
</script>
<!-- /move top -->
</body>

</html>
<?php } ?>