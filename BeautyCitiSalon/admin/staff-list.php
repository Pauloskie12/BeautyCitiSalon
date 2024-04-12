<?php
session_start();
// error_reporting(0);
include('includes/dbconnection.php');
include_once "../connections/connect.php";
$conn = $lib->openConnection();
if (strlen($_SESSION['bpmsaid']==0)) {
  header('location:logout.php');
} else{

        if(isset($_GET['delid'])){
			$sid=$_GET['delid'];

			$stmt = $conn->prepare("SELECT * FROM tbl_staff WHERE staff_id = ? ");
			$stmt->execute([$sid]);

			if($stmt->rowCount() > 0){

				$row = $stmt->fetch();
				$staff_email = $row['staff_email'];
				$staff_contact = $row['staff_contact'];
				
				mysqli_query($con,"DELETE FROM tbl_users WHERE users_email ='$staff_email' AND users_contact = '$staff_contact'");

				mysqli_query($con,"DELETE FROM tbl_staff WHERE staff_id ='$sid'");

				echo "<script>alert('Data Deleted');</script>";
				echo "<script>window.location.href='staff-list.php'</script>";
			}

			
        }

        if(isset($_POST['btn_add'])){
            $targetDir = "images/";
            $targetFile = $targetDir . basename($_FILES["profile"]["name"]);
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $contact = $_POST['contact'];
            $position = $_POST['position'];

    
            if (move_uploaded_file($_FILES["profile"]["tmp_name"], $targetFile)) {
                $stmt = $conn->prepare("INSERT INTO tbl_staff (`staff_firstname`,`staff_lastname`,`staff_email`,`staff_address`,`staff_contact`,`staff_position`,`staff_image`) VALUES(?,?,?,?,?,?,?)");
                $stmt->execute([$fname,$lname,$email,$address,$contact,$position, $_FILES["profile"]["name"]]);
    
    			$stmt2 = $conn->prepare("INSERT INTO tbl_users (`users_firstname`,`users_lastname`,`users_email`,`users_address`,`users_contact`,`users_type`,`type`,`users_password`) VALUES(?,?,?,?,?,?,?,?)");
                $stmt2->execute([$fname,$lname,$email,$address,$contact,1,1, "1234"]);
    
                echo "<script>window.alert('Staff Added!');</script>";
                echo "<script>window.location.href='staff-list.php';</script>";
            }
    


        }
        
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
        
        	$stmt02 = $conn->prepare("UPDATE tbl_users SET `users_firstname` = ?,`users_lastname` = ?,`users_email` = ?,`users_address` = ?,`users_contact` = ?,`users_type` = ?,`type` = ? WHERE `users_staffid` = ?");
        	
        	if($stmt02->execute([$fname,$lname,$email,$address,$contact,1,1, $staff_id ])){
            
            ?>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script>window.alert('Staff Updated!');</script>
            <script>window.location.href='staff-list.php';</script>
            <?php
        
        	}
        
        
        }
        


?>
<!DOCTYPE HTML>
<html>
<head>
<title>BeautyCiti Salon || Staff List</title>

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
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<!-- DataTables Buttons CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.0/css/buttons.dataTables.min.css">
<!-- DataTables Column Visibility CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.0/css/buttons.dataTables.min.css">

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
				<div class="tables">
					<h3 class="title1">Staff List</h3>
					
					
                    <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add Staff</button>
					
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-body">
                <div class="myform" style="ma">
                    <div id="LOGIN">
                        <h1 class="text-center">Add Staff</h1>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3 mt-4">
                                <label for="exampleInputEmail1" class="form-label">Firstname</label>
                                <input type="text" name="fname" class="form-control" id="exampleInputEmail1" placeholder="Enter firstname" required>
                            </div><br>
                            <div class="mb-3 mt-4">
                                <label for="exampleInputEmail1" class="form-label">Lastname</label>
                                <input type="text" name="lname" class="form-control" id="exampleInputEmail1" placeholder="Enter lastname" required>
                            </div><br>
                            <div class="mb-3 mt-4">
                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email address" required>
                            </div><br>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Mobile Number</label>
                                <input type="text" maxlength="11" name="contact" class="form-control" id="exampleInputPassword1" placeholder="Enter password" required>
                            </div><br>
                            <div class="mb-3 mt-4">
                                <label for="exampleInputEmail1" class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" id="exampleInputEmail1" placeholder="Enter address" required>
                            </div><br>
                            <div class="mb-3 mt-4">
                                <label for="exampleInputEmail1" class="form-label">Position</label>
                                <select class="form-control" name="position" required>
                                    <option value="" selected disabled> --- </option>
                                    <?php 
                                    $pos = $conn->prepare("SELECT * FROM tbl_job");
                                    $pos->execute();

                                    while($job = $pos->fetch()){
                                    
                                    ?>
                                    <option value="<?=$job['job_id'];?>"><?=$job['job_name']?></option>
                                    <?php } ?>
                                </select>
                            </div><br>
                            
                            <div class="mb-3 mt-4">
                                <label for="exampleInputEmail1" class="form-label">Image</label>
                                <input type="file" name="profile" class="form-control" id="exampleInputEmail1" required>
                            </div>
                            
                            <br>
                            
                            <br>
                            <div style="text-align: center">
                                <button type="submit" name="btn_add" class="btn btn-primary mt-3">ADD</button>
                            </div>
                        </form>
                    </div>
                </div>
                </div>
                </div>
            </div>
            </div>

                    
                    <div class="table-responsive bs-example widget-shadow">
						<h4>Staff List:</h4>
						<table class="table table-bordered" id="example1"> 
							<thead> 
								<tr> 
									<th>#</th> 
									<th>Profile Image</th>
									<th>Name</th>
									<th>Address</th> 
									<th>Mobile Number</th>
									<th>Email</th> 
									<th>Position</th> 
									<th>Action</th> 
								</tr> 
							</thead> 
							<tbody>
							<?php
							$ret=mysqli_query($con,"SELECT * FROM tbl_staff ts JOIN tbl_job tj ON ts.staff_position = tj.job_id");
							$cnt=1;
							while ($row=mysqli_fetch_array($ret)) {

							?>

						 	<tr> 
								<th scope="row"><?php echo $cnt;?></th> 
								<td><img src="images/<?=$row['staff_image']; ?>" width="100" height="100"></td>
								<td><?php  echo $row['staff_firstname'];?> <?php  echo $row['staff_lastname'];?></td> 
								<td><?php  echo $row['staff_address'];?></td>
								<td><?php  echo $row['staff_contact'];?></td>
								<td><?php  echo $row['staff_email'];?></td>
								<td><?php  echo $row['job_name'];?></td>
						 		<td> 
									<!-- <a href="add-customer-services.php?addid=<?php echo $row['staff_id'];?>" class="btn btn-primary">Assign Services</a> -->
									<a href="#" class="btn btn-info" data-toggle="modal" data-target="#editStaff<?php echo $row['staff_id'];?>">Edit</a>
									<a href="staff-list.php?delid=<?php echo $row['staff_id'];?>" class="btn btn-danger" onClick="return confirm('Are you sure you want to delete?')">Delete</a>
									
									
                                    <div class="modal fade" id="editStaff<?php echo $row['staff_id'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-body">
                                        <div class="myform" style="ma">
                                            <div id="LOGIN">
                                                <h1 class="text-center">Edit Staff</h1>
                                                <form method="POST">
                                                    <input type="hidden" name="staff_id" value="<?php echo $row['staff_id'];?>">
                                                    <div class="mb-3 mt-4">
                                                        <label for="exampleInputEmail1" class="form-label">Firstname</label>
                                                        <input type="text" name="fname" class="form-control" 
                                                            id="exampleInputEmail1" 
                                                            value="<?php  echo $row['staff_firstname'];?>" placeholder="Enter firstname">
                                                    </div><br>
                                                    <div class="mb-3 mt-4">
                                                        <label for="exampleInputEmail1" class="form-label">Lastname</label>
                                                        <input type="text" name="lname" class="form-control" 
                                                        id="exampleInputEmail1"
                                                        value="<?php  echo $row['staff_lastname'];?>" placeholder="Enter lastname">
                                                    </div><br>
                                                    <div class="mb-3 mt-4">
                                                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                                                        <input type="email" name="email" class="form-control" 
                                                        id="exampleInputEmail1"
                                                        value="<?php  echo $row['staff_email'];?>" 
                                                        placeholder="Enter email address">
                                                    </div><br>
                                                    <div class="mb-3">
                                                        <label for="exampleInputPassword1" class="form-label">Mobile Number</label>
                                                        <input type="text" maxlength="11" name="contact" class="form-control" 
                                                        id="exampleInputPassword1" 
                                                        value="<?php  echo $row['staff_contact'];?>"
                                                        placeholder="Enter password">
                                                    </div><br>
                                                    <div class="mb-3 mt-4">
                                                        <label for="exampleInputEmail1" class="form-label">Address</label>
                                                        <input type="text" name="address" class="form-control" 
                                                        id="exampleInputEmail1"
                                                        value="<?php  echo $row['staff_address'];?>"
                                                        placeholder="Enter address">
                                                    </div><br>
                                                    <div class="mb-3 mt-4">
                                                        <label for="exampleInputEmail1" class="form-label">Position</label>
                                                        <select class="form-control" name="position">
                                                            <option value="" selected disabled> --- </option>
                                                            <?php 
                                                            $pos = $conn->prepare("SELECT * FROM tbl_job");
                                                            $pos->execute();
                        
                                                            while($job = $pos->fetch()){
                                                            
                                                            ?>
                                                            <option value="<?=$job['job_id'];?>" <?php if($job['job_id'] == $row['job_id']){ echo 'selected';} ?>><?=$job['job_name']?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div><br>
                                                    
                                                    <div class="mb-3 mt-4">
                                                        <label>Profile Image</label><br>
                                                        <!--<input type="file" name="profile" >-->
                                                        <center>
                                                            <img src="images/<?php  echo $row['staff_image'];?>" style="width: 200px; height: 200px">
                                                        
                                                        <br><br>
                                                        <a href="staff_updimg.php?id=<?=$row['staff_id'];?>" class="btn btn-sm btn-success">Change Image</a>
                                                        </center>
                                                    </div>
                                                    <br>
                                                    <div style="text-align: center">
                                                        <button type="submit" name="btn_edit" class="btn btn-block btn-primary mt-3">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
						 		</td> 
							</tr>   
							<?php 
							$cnt=$cnt+1;
							}?>
							</tbody> 
						</table> 
					</div>
				</div>
			</div>
		</div>
		<!--footer-->
		 <?php include_once('includes/footer.php');?>
        <!--//footer-->
	</div>
	<!-- Classie -->
	<!-- DataTables JavaScript -->
	<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<!-- DataTables Buttons JavaScript -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.0/js/buttons.print.min.js"></script>

<!-- DataTables Column Visibility JavaScript -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.0/js/buttons.colVis.min.js"></script>

		<script src="js/classie.js"></script>
		<script>
			$(document).ready(function() {
				$('#example1').DataTable( {
					dom: 'Bfrtip',
					buttons: [
						{
							extend: 'pdf',
							text: 'Export to PDF',
							title: 'Custom PDF Title',
							filename: 'custom_pdf_filename',
							customize: function (doc) {
								// Customize PDF document if needed
							}
						},
						{
							extend: 'csv',
							text: 'Export to CSV',
							filename: 'custom_csv_filename',
							customize: function (csv) {
								// Customize CSV output if needed
							}
						},
						'print'
					],
					columnDefs: [{
						targets: -1, // Last column
						visible: true // By default visible
					}],
					buttons: [
						'colvis', 'print', 'pdf' // Column visibility toggle button
					]
				} );
			} );

		</script>
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
<?php }  ?>