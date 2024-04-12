<?php
session_start();
// error_reporting(0);
include('includes/dbconnection.php');
include_once "../connections/connect.php";
$conn = $lib->openConnection();

if (strlen($_SESSION['bpmsaid']==0)) {
  header('location:logout.php');
  } else{
      
      if(isset($_POST['upload']))
    {
        $adminid=$_SESSION['bpmsaid'];
        $file_name = $_FILES['profile']['name'];
        $file_tmp = $_FILES['profile']['tmp_name'];
        // Move uploaded file to target folder
        $target_dir = "./images/";
        $target_file = $target_dir . basename($file_name);
        
        move_uploaded_file($file_tmp, $target_file);
        
        $stmt = $conn->prepare("UPDATE tbl_users SET users_image = ? WHERE users_id = ?");
        if($stmt->execute([$file_name, $adminid])){
            $msg="Admin profile image has been updated.";
            echo "<script>window.alert('Admin profile image has been updated.');</script>";
            echo "<script>window.location.href='admin-profile.php';</script>";
         
        }else{
            
            echo "<script>window.location.href='admin-profile.php';</script>";
        }
        }

  ?>
<!DOCTYPE HTML>
<html>
<head>
<title>BeautyCiti Salon | Admin Profile</title>

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
							<form method="post" enctype="multipart/form-data">
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
							            <img src="./images/admin.png" style="border: 10px groove #f2f2f2; border-radius: 50%; width: 200px; height: 200px">
							            <?php }else{ ?>
							            <img src="./images/<?php  echo $row['users_image'];?>" style="border: 10px groove #f2f2f2; border-radius: 50%; width:200px; height: 200px">
							            <?php } ?>
							            </div>
							            <h2><?php  echo $row['users_firstname'];?> <?php  echo $row['users_lastname'];?></h2>
							            <br>
							        </center>
							    </div>
							</div>
							<div class="form-group"> 
								<label for="exampleInputEmail1">Upload Image</label> 
								<input type="file" class="form-control" name="profile"> 
							</div> 
					

							
							<a href="admin-profile.php" class="btn btn-danger">Go Back</a>
							<button type="submit" name="upload" class="btn btn-default">Update</button> 
							</form> 
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