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
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $contact = $_POST['contact'];
            $position = $_POST['position'];

            $stmt = $conn->prepare("INSERT INTO tbl_staff (`staff_firstname`,`staff_lastname`,`staff_email`,`staff_address`,`staff_contact`,`staff_position`) VALUES(?,?,?,?,?,?)");
            $stmt->execute([$fname,$lname,$email,$address,$contact,$position]);

			$stmt2 = $conn->prepare("INSERT INTO tbl_users (`users_firstname`,`users_lastname`,`users_email`,`users_address`,`users_contact`,`users_type`,`type`,`users_password`) VALUES(?,?,?,?,?,?,?,?)");
            $stmt2->execute([$fname,$lname,$email,$address,$contact,1,1, "1234"]);

            echo "<script>window.alert('Staff Added!');</script>";
            echo "<script>window.location.href='staff-list.php';</script>";



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
<title>BeautyCiti Salon || Sales</title>

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
					<h3 class="title1">Sales</h3>

                    
					<div class="table-responsive bs-example widget-shadow">
						<div class="row" style="background: #f2f2f2">
							<div class="col-md-6"><br><h4>Sales:</h4></div>
							<div class="col-md-6">
								<div class="row">
								    <div class="col-md-4"><label>Filtered By:</label><br>
								    <?php if(isset($_GET['filtered'])){ ?>
								        <select class="form-control" name="filtered" id="filtered">
								            <option value="" selected disabled> --- </option>
								            <option value="1" <?php if($_GET['filtered'] == 1){ echo "selected"; } ?>> Today </option>
								            <option value="2" <?php if($_GET['filtered'] == 2){ echo "selected"; } ?>> This Week </option>
								            <option value="3" <?php if($_GET['filtered'] == 3){ echo "selected"; } ?>> This Month </option>
								        </select>
								    <?php }else{ ?>
								        <select class="form-control" name="filtered" id="filtered">
								            <option value="" selected disabled> --- </option>
								            <option value="1"> Today </option>
								            <option value="2"> This Week </option>
								            <option value="3"> This Month </option>
								        </select>
								    <?php } ?>

								    </div>
									<div class="col-md-4"><label>From:</label><br><input type="date" id="from" value="<?php if(isset($_GET['from'])){ echo $_GET['from']; } ?>" class="form-control"></div>
									<div class="col-md-4"><label>To:</label><br><input type="date" id="to"   value="<?php if(isset($_GET['to'])){ echo $_GET['to']; } ?>"  class="form-control" disabled></div>
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
									<th>Price</th>
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
									    INNER JOIN tbl_subcategory ts ON ts.subcategory_id = tb.tblbook_subcategoryid
										WHERE tb.tblbook_status = 'Paid' AND tb.tblbook_bookingdate BETWEEN '$from' AND '$to'
										ORDER BY tb.tblbook_id DESC");
	
									}
	
									if($user['type'] == 1){
	
										$ret=mysqli_query($con,"SELECT * FROM tblbook tb
										INNER JOIN tbl_users tu ON tu.users_id=tb.tblbook_userid 
									    INNER JOIN tbl_subcategory ts ON ts.subcategory_id = tb.tblbook_subcategoryid
										WHERE tb.tblbook_status = 'Paid' AND tb.tblbook_staffid = '$staff_id' AND tb.tblbook_bookingdate BETWEEN '$from' AND '$to'
										ORDER BY tb.tblbook_id DESC");
			
									}
								}
							}else{
							    
							    if(isset($_GET['filtered'])){
							        
							        $cur_day = time();
							            
                                    $new_time = strtotime('+8 hours', $cur_day);
                                    $current_day = date('Y-m-d', $new_time);
                                    
                                    echo $current_day;
							        
							        //   TODAY
							        if($_GET['filtered'] == 1){
							            
							            
							            
							            if($user['type'] == 0){
    
        									$ret=mysqli_query($con,"SELECT * FROM tblbook tb
        									INNER JOIN tbl_users tu ON tu.users_id=tb.tblbook_userid
        									INNER JOIN tbl_subcategory ts ON ts.subcategory_id = tb.tblbook_subcategoryid
        									WHERE tb.tblbook_status = 'Paid' AND DATE(tb.tblbook_bookingdate) = '$current_day'
        									ORDER BY tb.tblbook_id DESC");
        
        								}
        
        								if($user['type'] == 1){
        
        									$ret=mysqli_query($con,"SELECT * FROM tblbook tb
        									INNER JOIN tbl_users tu ON tu.users_id=tb.tblbook_userid 
        									INNER JOIN tbl_subcategory ts ON ts.subcategory_id = tb.tblbook_subcategoryid
        									WHERE tb.tblbook_status = 'Paid' AND tb.tblbook_staffid = '$staff_id' AND DATE(tb.tblbook_bookingdate) = '$current_day'
        									ORDER BY tb.tblbook_id DESC");
        		
        								}
        								
							        }
							        //   THIS WEEK
							        if($_GET['filtered'] == 2){
							            
							            $current_week_number = date('W');
							            
        								if($user['type'] == 0){
        
        									$ret=mysqli_query($con,"SELECT * FROM tblbook tb
        									INNER JOIN tbl_users tu ON tu.users_id=tb.tblbook_userid
        									INNER JOIN tbl_subcategory ts ON ts.subcategory_id = tb.tblbook_subcategoryid
        									WHERE tb.tblbook_status = 'Paid' AND WEEK(tb.tblbook_bookingdate) = '$current_week_number'
        									ORDER BY tb.tblbook_id DESC");
        
        								}
        
        								if($user['type'] == 1){
        
        									$ret=mysqli_query($con,"SELECT * FROM tblbook tb
        									INNER JOIN tbl_users tu ON tu.users_id=tb.tblbook_userid 
        									INNER JOIN tbl_subcategory ts ON ts.subcategory_id = tb.tblbook_subcategoryid
        									WHERE tb.tblbook_status = 'Paid' AND tb.tblbook_staffid = '$staff_id' AND WEEK(tb.tblbook_bookingdate) = '$current_week_number'
        									ORDER BY tb.tblbook_id DESC");
        		
        								}
							        }
							        if($_GET['filtered'] == 3){
							            
							            $current_month = date('m');
							            
							            if($user['type'] == 0){
    
        									$ret=mysqli_query($con,"SELECT * FROM tblbook tb
        									INNER JOIN tbl_users tu ON tu.users_id=tb.tblbook_userid
        									INNER JOIN tbl_subcategory ts ON ts.subcategory_id = tb.tblbook_subcategoryid
        									WHERE tb.tblbook_status = 'Paid' AND MONTH(tb.tblbook_bookingdate) = '$current_month'
        									ORDER BY tb.tblbook_id DESC");
        
        								}
        
        								if($user['type'] == 1){
        
        									$ret=mysqli_query($con,"SELECT * FROM tblbook tb
        									INNER JOIN tbl_users tu ON tu.users_id=tb.tblbook_userid 
        									INNER JOIN tbl_subcategory ts ON ts.subcategory_id = tb.tblbook_subcategoryid
        									WHERE tb.tblbook_status = 'Paid' AND tb.tblbook_staffid = '$staff_id' AND MONTH(tb.tblbook_bookingdate) = '$current_month'
        									ORDER BY tb.tblbook_id DESC");
        		
        								}
							            
							        }

    								
							    }else{
    								if($user['type'] == 0){
    
    									$ret=mysqli_query($con,"SELECT * FROM tblbook tb
    									INNER JOIN tbl_users tu ON tu.users_id=tb.tblbook_userid
    									INNER JOIN tbl_subcategory ts ON ts.subcategory_id = tb.tblbook_subcategoryid
    									WHERE tb.tblbook_status = 'Paid'
    									ORDER BY tb.tblbook_id DESC");
    
    								}
    
    								if($user['type'] == 1){
    
    									$ret=mysqli_query($con,"SELECT * FROM tblbook tb
    									INNER JOIN tbl_users tu ON tu.users_id=tb.tblbook_userid 
    									INNER JOIN tbl_subcategory ts ON ts.subcategory_id = tb.tblbook_subcategoryid
    									WHERE tb.tblbook_status = 'Paid' AND tb.tblbook_staffid = '$staff_id'
    									ORDER BY tb.tblbook_id DESC");
    		
    								}	        
							    }

							}
							
							
                            function subtractTwentyPercent($whole) {
                                // Calculate 20 percent of the whole number
                                $twentyPercent = $whole * 0.20;
                            
                                // Subtract 20 percent from the whole number
                                $result = $whole - $twentyPercent;
                            
                                return $result;
                            }
                            $gt = 0;
							$cnt=1;
							while ($row=mysqli_fetch_array($ret)) {

							?>

						 	<tr> 
							<td scope="row"><?php echo $cnt;?></td> 
							<td><?php  echo $row['tblbook_bookingnumber'];?></td> 
							<td><?php  echo $row['users_firstname'];?> <?php  echo $row['users_lastname'];?></td>
							<td><?php  echo $row['users_contact'];?></td>
							<td><?php  echo $row['tblbook_bookingdate'];?></td> 
						    <td>&#8369;
						        <?php  echo number_format(subtractTwentyPercent($row['subcategory_price']), 2);; ?>
						    </td> 
						    </tr>
							<?php 
							$gt+=subtractTwentyPercent($row['subcategory_price']); 
							$cnt=$cnt+1; 
							} ?>
							
						</tbody>
							<tfooter>
						        <th colspan="5">Grand Total</th>
						        <th colspan="5">&#8369;<?=number_format($gt, 2);?></th>
						    </tfooter>
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
		    $(document).ready(function(){
		        $('#filtered').on('change', function(){
		            if($(this).val() == 1){
		                window.location.href = 'sales.php?filtered=1';
		            }
		            if($(this).val() == 2){
		                window.location.href = 'sales.php?filtered=2';
		            }
		            if($(this).val() == 3){
		                window.location.href = 'sales.php?filtered=3';
		            }
		        })
		    })
		</script>
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

						window.location.href = "sales.php?from="+from+"&to="+to;
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