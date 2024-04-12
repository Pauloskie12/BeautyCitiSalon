<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['bpmsaid']==0)) {
  header('location:logout.php');
  } else{

if($_GET['delid']){
$sid=$_GET['delid'];
mysqli_query($con,"DELETE FROM tbl_users WHERE users_id ='$sid'");
echo "<script>alert('Data Deleted');</script>";
echo "<script>window.location.href='customer-list.php'</script>";
          }

  ?>
<!DOCTYPE HTML>
<html>
<head>
<title>BeautiCiti Salon || Customer List</title>

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
					<h3 class="title1">Customer List</h3>
					
					
				
					<div class="table-responsive bs-example widget-shadow">
						<h4>Customer List:</h4>
						<table class="table table-bordered" id="example1"> 
							<thead> 
								<tr> 
									<th>#</th> 
									<th>Name</th> 
									<th>Mobile Number</th>
									<th>Email</th> 
									<th>Action</th> 
								</tr> 
							</thead> 
							<tbody>
							<?php
							$ret=mysqli_query($con,"SELECT * FROM tbl_users WHERE users_type != 1");
							$cnt=1;
							while ($row=mysqli_fetch_array($ret)) {

							?>

						 	<tr> 
								<th scope="row"><?php echo $cnt;?></th> 
								<td><?php  echo $row['users_firstname'];?> <?php  echo $row['user_lastname'];?></td> 
								<td><?php  echo $row['users_contact'];?></td>
								<td><?php  echo $row['users_email'];?></td>
						 		<td> 
									<!-- <a href="add-customer-services.php?addid=<?php echo $row['users_id'];?>" class="btn btn-primary">Assign Services</a> -->
									<a href="customer-list.php?delid=<?php echo $row['users_id'];?>" class="btn btn-danger" onClick="return confirm('Are you sure you want to delete?')">Delete</a>
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