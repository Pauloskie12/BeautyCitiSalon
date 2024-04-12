<?php
session_start();
// error_reporting(0);
include_once "../connections/connect.php";
$conn = $lib->openConnection();
include('includes/dbconnection.php');
if (strlen($_SESSION['bpmsaid']==0)) {
  header('location:logout.php');
  } else{
		if(isset($_GET['delid'])){
			$sid=$_GET['delid'];
			mysqli_query($con,"DELETE FROM tbl_subcategory where subcategory_id ='$sid'");
			echo "<script>alert('Data Deleted');</script>";
			echo "<script>window.location.href='manage-services2.php'</script>";
		}

		if(isset($_POST['btn_add'])){

			$category_id = $_POST['category_id'];
			$subcategory_name = $_POST['subcategory_name'];
			$subcategory_duration = $_POST['subcategory_duration'];
			$subcategory_price = $_POST['subcategory_price'];

			$image=$_FILES["image"]["name"];
			// get the image extension
			$extension = substr($image,strlen($image)-4,strlen($image));
			// allowed extensions
			$allowed_extensions = array(".jpg",".JPG",".jpeg",".JPEG",".png",".PNG",".gif");
			// Validation for allowed extensions .in_array() function searches an array for a specific value.
			if(!in_array($extension,$allowed_extensions))
			{
			echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
			}
			else
			{
				//rename the image file
				$newimage=md5($image).time().$extension;
				// Code for move image into directory
				move_uploaded_file($_FILES["image"]["tmp_name"],"../assets/images/".$newimage);
				
				$stmt = $conn->prepare("INSERT INTO tbl_subcategory(`subcategory_categoryid`,`subcategory_name`,`subcategory_duration`,`subcategory_price`,`subcategory_image`) VALUES(?,?,?,?,?)");
				$stmt->execute([$category_id, $subcategory_name, $subcategory_duration, $subcategory_price, $newimage]);
				$cid = $conn->lastInsertId();
	
				
				
				echo "<script>window.alert('New Service Added!');</script>";
				echo "<script>window.location.href='manage-services2.php';</script>";
	
			
			}
		}


  ?>
<!DOCTYPE HTML>
<html>
<head>
<title>BeautyCiti Salon || Manage Services</title>

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
<body class="cbp-spmenu-push" style="overflow: visible">
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
					<h3 class="title1">Manage Services</h3>
					
					<button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add Services</button>
					
					<!-- Modal -->
					<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
						<div class="modal-body">
						<div class="myform" style="ma">
							<div id="LOGIN">
								<h1 class="text-center">Add Services</h1>
								<form method="POST" enctype="multipart/form-data">
									
									<div class="mb-3 mt-4">
										<label for="exampleInputEmail1" class="form-label">Choose Category</label>
										<select class="form-control" name="category_id">
											<option value="" selected disabled> --- </option>
											<?php 
											$category = $conn->prepare("SELECT * FROM tbl_category");
											$category->execute();
		
											while($cat = $category->fetch()){
											
											?>
											<option value="<?=$cat['category_id'];?>"><?=$cat['category_name']?></option>
											<?php } ?>
										</select>
									</div><br>
									<div class="mb-3 mt-4">
										<label for="exampleInputEmail1" class="form-label">Service Name</label>
										<input type="text" name="subcategory_name" class="form-control" id="exampleInputEmail1" placeholder="Enter firstname">
									</div><br>
									<div class="mb-3 mt-4">
										<label for="exampleInputEmail1" class="form-label">Service Fee</label>
										<input type="number" name="subcategory_price" class="form-control" id="exampleInputEmail1" placeholder="Enter firstname">
									</div><br>
									<div class="mb-3 mt-4">
										<label for="exampleInputEmail1" class="form-label">Service Duration</label>
										<input type="number" name="subcategory_duration" class="form-control" id="exampleInputEmail1" placeholder="Enter firstname">
									</div><br>

									<div class="mb-3 mt-4">
										<label for="exampleInputEmail1">Image</label> 
										<input type="file" class="form-control" id="image" name="image" value="" required="true"> 
									</div>
									
									
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
						<h4>Update Services:</h4>
						<table class="table table-bordered table-responsive" id="example1"> 
							<thead> 
								<tr> 
									<th>#</th> 
									<th>Service Name</th> 
									<th>Service Category</th> 
									<th>Service Price</th> 
									<th>Action</th> 
								</tr> 
							</thead> 
							<tbody>
								<?php 

								$stmt = $conn->prepare("SELECT * FROM tbl_subcategory ts INNER JOIN tbl_category tc ON ts.subcategory_categoryid = tc.category_id");
								$stmt->execute();
								$cnt = 1;
								if($stmt->rowCount() > 0){
									while($row = $stmt->fetch()){

								?>
						 		<tr> 
									<th scope="row"><?php echo $cnt;?></th> 
									<td><?php  echo $row['subcategory_name'];?></td> 
									<td><?php  echo $row['category_name'];?></td> 
									<td>&#8369;<?php  echo number_format($row['subcategory_price'],2);?></td> 
									<td>
										<a href="edit-services2.php?editid=<?php echo $row['subcategory_id'];?>" class="btn btn-primary">Edit</a>
										<a href="manage-services2.php?delid=<?php echo $row['subcategory_id'];?>" class="btn btn-danger" onClick="return confirm('Are you sure you want to delete?')">Delete</a>

						 			</td> 
								
								</tr>  
								<?php $cnt += 1; } } ?>

						
 							</tbody> 
						</table> 
					</div>
				</div>
			</div>
		</div>
		<!--footer-->
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