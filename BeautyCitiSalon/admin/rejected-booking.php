<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include_once "../connections/connect.php";
$conn = $lib->openConnection();
$check_user = $conn->prepare("SELECT * FROM tbl_users WHERE users_id = ?");
$check_user->execute([$_SESSION['bpmsaid']]);

$user = $check_user->fetch();
$staff_id = $user['users_staffid'];

if (strlen($_SESSION['bpmsaid']==0)) {
  header('location:logout.php');
  } else{


  ?>
<!DOCTYPE HTML>
<html>
<head>
<title>BeautyCiti Salon || Rejected List</title>

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
					<h3 class="title1">Rejected List</h3>
					
					
				
					<div class="table-responsive bs-example widget-shadow">
						<div class="row" style="background: #f2f2f2">
							<div class="col-md-6"><br><h4>Rejected List:</h4></div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6"><label>From:</label><br><input type="date" id="from" value="<?php if(isset($_GET['from'])){ echo $_GET['from']; } ?>" class="form-control"></div>
									<div class="col-md-6"><label>To:</label><br><input type="date" id="to"   value="<?php if(isset($_GET['to'])){ echo $_GET['to']; } ?>"  class="form-control" disabled></div>
								</div>
								<br>
							</div>
						</div>
						<table class="table table-bordered" id="example1"> 
							<thead> 
								<tr> 
									<th>#</th> 
									<th>Booking Number</th> 
									<th>Name</th>
									<th>Mobile Number</th> 
									<th>Booking Date</th>
									<th>Status</th>
									<th>Action</th> 
								</tr> 
							</thead> 
							<tbody>
							<?php

							if(isset($_GET['from'])){
								if(isset($_GET['to'])){
									$from = $_GET['from'];
									$to = $_GET['to'];

									if($user['type'] == 0){

										$ret=mysqli_query($con,"SELECT * FROM tblbook tb
										INNER JOIN tbl_users tu ON tu.users_id=tb.tblbook_userid 
										WHERE tb.tblbook_status = 'Rejected' AND tb.tblbook_bookingdate BETWEEN '$from' AND '$to'
										GROUP BY tb.tblbook_bookingnumber
										ORDER BY tb.tblbook_id DESC");
	
									}
	
									if($user['type'] == 1){
	
										$ret=mysqli_query($con,"SELECT * FROM tblbook tb
										INNER JOIN tbl_users tu ON tu.users_id=tb.tblbook_userid 
										WHERE tb.tblbook_status = 'Rejected' AND tb.tblbook_staffid = '$staff_id' AND tb.tblbook_bookingdate BETWEEN '$from' AND '$to'
										GROUP BY tb.tblbook_bookingnumber
										ORDER BY tb.tblbook_id DESC");
			
									}
								}
							}else{
								if($user['type'] == 0){

									$ret=mysqli_query($con,"SELECT * FROM tblbook tb
									INNER JOIN tbl_users tu ON tu.users_id=tb.tblbook_userid 
									WHERE tb.tblbook_status = 'Rejected'
									GROUP BY tb.tblbook_bookingnumber
									ORDER BY tb.tblbook_id DESC");

								}

								if($user['type'] == 1){

									$ret=mysqli_query($con,"SELECT * FROM tblbook tb
									INNER JOIN tbl_users tu ON tu.users_id=tb.tblbook_userid 
									WHERE tb.tblbook_status = 'Rejected' AND tb.tblbook_staffid = '$staff_id'
									GROUP BY tb.tblbook_bookingnumber
									ORDER BY tb.tblbook_id DESC");
		
								}
							}




							$cnt=1;
							while ($row=mysqli_fetch_array($ret)) {

							?>

						 	<tr> 
							<th scope="row"><?php echo $cnt;?></th> 
							<td><?php  echo $row['tblbook_bookingnumber'];?></td> 
							<td><?php  echo $row['users_firstname'];?> <?php  echo $row['users_lastname'];?></td>
							<td><?php  echo $row['users_contact'];?></td>
							<td><?php  echo $row['tblbook_bookingdate'];?></td> 
							<?php if($row['tblbook_status']==""){ ?>
                     			<td class="font-w600"><?php echo "Not Updated Yet"; ?></td>
                     		<?php } else { ?>
                      			<td><?php  echo $row['tblbook_status'];?></td><?php } ?> 
                                <td>
									<a href="view-booking.php?viewid=<?php echo $row['tblbook_bookingnumber'];?>" class="btn btn-primary">View</a>
									
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
			$(document).ready(function(){
				$('#from').on('change', function(){
					var from = $('#from').val();
					$('#to').removeAttr('disabled');

					$('#to').on('change', function(){
						var to = $('#to').val();

						window.location.href = "rejected-booking.php?from="+from+"&to="+to;
					})
				})
			})
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