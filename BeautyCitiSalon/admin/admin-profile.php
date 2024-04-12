<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['bpmsaid']==0)) {
  header('location:logout.php');
  } else{
    if(isset($_POST['submit']))
  {
    $adminid=$_SESSION['bpmsaid'];
    $fname=$_POST['adminfname'];
    $lname=$_POST['adminlname'];
    $email=$_POST['adminemail'];
  	$mobno=$_POST['contactnumber'];
  
    $query=mysqli_query($con, "UPDATE tbl_users SET users_email = '$email', users_firstname ='$fname', users_lastname = '$lname', users_contact='$mobno' WHERE users_id='$adminid' AND users_type = 1");
    if ($query) {
    $msg="Admin profile has been updated.";
  }
  else
    {
      $msg="Something Went Wrong. Please try again.";
    }
  }
  ?>
<!DOCTYPE HTML>
<html>
<head>
<title>BeautiCiti Salon | Admin Profile</title>

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!-- font CSS -->
<!-- font-awesome icons -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons -->
 <!-- js-->
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/modernizr.custom.js"></script>
<!--webfonts-->
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
<!--//webfonts--> 
<!--animate-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
<!-- Metis Menu -->
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<link href="css/custom.css" rel="stylesheet">
<!--//Metis Menu -->
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<!--left-fixed -navigation-->
		 <?php include_once('includes/sidebar.php');?>
		<!--left-fixed -navigation-->
		<!-- header-starts -->
	 <?php include_once('includes/header.php');?>
		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
				<div class="forms">
					<h3 class="title1">Admin Profile</h3>
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>Update Profile :</h4>
						</div>
						<div class="form-body">
							<form method="post">
								<p style="font-size:16px; color:red" align="center"> <?php if($msg){
								echo $msg;
							}  ?> </p>

							<?php
								$adminid=$_SESSION['bpmsaid'];
								$ret=mysqli_query($con,"SELECT * FROM tbl_users WHERE users_id='$adminid' AND users_type = 1");
								$cnt=1;
								while ($row=mysqli_fetch_array($ret)) {

								?>
							<div class="row">
							    <div class="col-md-12">
							        <center>
							            <div id="img-cont" style="position: relative">
							            <?php 
							            
							            if(empty($row['users_image'])){
							            ?>
							            <img src="images/admin.png" style="border: 10px groove #f2f2f2; border-radius: 50%; width: 200px; height: 200px">
							            <?php }else{ ?>
							            <img src="images/<?php  echo $row['users_image'];?>" style="border: 10px groove #f2f2f2; border-radius: 50%; width:200px; height: 200px">
							            <?php } ?>
							            </div>
							            <h2><?php  echo $row['users_firstname'];?> <?php  echo $row['users_lastname'];?></h2>
							            <br>
							            <a href="admin_profile_updimg.php" class="btn btn-info">Update Image</a>
							        </center>
							    </div>
							</div>
							<div class="form-group"> 
								<label for="exampleInputEmail1">Admin Firstname</label> 
								<input type="text" class="form-control" id="adminfname" name="adminfname" placeholder="Admin Firstname" value="<?php  echo $row['users_firstname'];?>"> 
							</div> 
							<div class="form-group"> 
								<label for="exampleInputEmail1">Admin Lastname</label> 
								<input type="text" class="form-control" id="adminlname" name="adminlname" placeholder="Admin lastname" value="<?php  echo $row['users_lastname'];?>"> 
							</div> 
							<div class="form-group"> 
								<label for="exampleInputPassword1">Email address</label> 
								<input type="email" id="email" name="adminemail" class="form-control" value="<?php  echo $row['users_email'];?>" > 
							</div>  
							 <div class="form-group"> 
								<label for="exampleInputPassword1">Contact Number</label> 
								<input type="text" id="contactnumber" name="contactnumber" class="form-control" value="<?php  echo $row['users_contact'];?>"> 
							</div>

							<button type="submit" name="submit" class="btn btn-default">Update</button> </form> 
						</div>
						<?php } ?>
					</div>
				
				
			</div>
		</div>
		 <?php include_once('includes/footer.php');?>
	</div>
	<!-- Classie -->
		<script src="js/classie.js"></script>
		<script>
			var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showLeftPush = document.getElementById( 'showLeftPush' ),
				body = document.body;
				
			showLeftPush.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( body, 'cbp-spmenu-push-toright' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeftPush' );
			};
			
			function disableOther( button ) {
				if( button !== 'showLeftPush' ) {
					classie.toggle( showLeftPush, 'disabled' );
				}
			}
		</script>
	<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.js"> </script>
</body>
</html>
<?php } ?>