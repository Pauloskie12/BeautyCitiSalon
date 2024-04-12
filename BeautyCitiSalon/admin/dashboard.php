<?php
session_start();
// error_reporting(0);
include('includes/dbconnection.php');
include_once "../connections/connect.php";
$conn = $lib->openConnection();
$current_time = time();

// Add 2 hours to the current time
$new_time = strtotime('+8 hours', $current_time);

// Format the new time
$today_date = date('Y-m-d', $new_time);


if (strlen($_SESSION['bpmsaid']==0)) {
  header('location:logout.php');
} 


$services_available = $conn->prepare("SELECT COUNT(*) As Total_client,category_name As Services
        FROM `tbl_category` as cat
        INNER JOIN tbl_subcategory as sub ON cat.category_id = sub.subcategory_categoryid
        GROUP BY cat.category_id");
$services_available->execute();

$customers_booking = $conn->prepare("SELECT *, COUNT(*) AS total_customer FROM tblbook tb
									INNER JOIN tbl_users tu ON tu.users_id=tb.tblbook_userid 
									INNER JOIN tbl_subcategory ts ON ts.subcategory_id = tb.tblbook_subcategoryid
									INNER JOIN tbl_category tc ON tc.category_id = ts.subcategory_categoryid
									WHERE tb.tblbook_status = 'Paid' AND DATE(tb.tblbook_bookingdate) = '$today_date'
									GROUP BY tc.category_id
									ORDER BY tb.tblbook_id DESC");
$customers_booking->execute();

$salon_sales1 = $conn->prepare("SELECT *, SUM(ts.subcategory_price) AS total_sales FROM tblbook tb 
INNER JOIN tbl_subcategory ts ON ts.subcategory_id = tb.tblbook_subcategoryid
WHERE MONTH(tb.tblbook_bookingdate) = '1'");
$salon_sales1->execute();

$salon_sales2 = $conn->prepare("SELECT *, SUM(ts.subcategory_price) AS total_sales FROM tblbook tb 
INNER JOIN tbl_subcategory ts ON ts.subcategory_id = tb.tblbook_subcategoryid
WHERE MONTH(tb.tblbook_bookingdate) = '2'");
$salon_sales2->execute();

$salon_sales3 = $conn->prepare("SELECT *, SUM(ts.subcategory_price) AS total_sales FROM tblbook tb 
INNER JOIN tbl_subcategory ts ON ts.subcategory_id = tb.tblbook_subcategoryid
WHERE MONTH(tb.tblbook_bookingdate) = '3'");
$salon_sales3->execute();

$salon_sales4 = $conn->prepare("SELECT *, SUM(ts.subcategory_price) AS total_sales FROM tblbook tb 
INNER JOIN tbl_subcategory ts ON ts.subcategory_id = tb.tblbook_subcategoryid
WHERE MONTH(tb.tblbook_bookingdate) = '4'");
$salon_sales4->execute();

$salon_sales5 = $conn->prepare("SELECT *, SUM(ts.subcategory_price) AS total_sales FROM tblbook tb 
INNER JOIN tbl_subcategory ts ON ts.subcategory_id = tb.tblbook_subcategoryid
WHERE MONTH(tb.tblbook_bookingdate) = '5'");
$salon_sales5->execute();

$salon_sales6 = $conn->prepare("SELECT *, SUM(ts.subcategory_price) AS total_sales FROM tblbook tb 
INNER JOIN tbl_subcategory ts ON ts.subcategory_id = tb.tblbook_subcategoryid
WHERE MONTH(tb.tblbook_bookingdate) = '6'");
$salon_sales6->execute();

$salon_sales7 = $conn->prepare("SELECT *, SUM(ts.subcategory_price) AS total_sales FROM tblbook tb 
INNER JOIN tbl_subcategory ts ON ts.subcategory_id = tb.tblbook_subcategoryid
WHERE MONTH(tb.tblbook_bookingdate) = '7'");
$salon_sales7->execute();

$salon_sales8 = $conn->prepare("SELECT *, SUM(ts.subcategory_price) AS total_sales FROM tblbook tb 
INNER JOIN tbl_subcategory ts ON ts.subcategory_id = tb.tblbook_subcategoryid
WHERE MONTH(tb.tblbook_bookingdate) = '8'");
$salon_sales8->execute();

$salon_sales9 = $conn->prepare("SELECT *, SUM(ts.subcategory_price) AS total_sales FROM tblbook tb 
INNER JOIN tbl_subcategory ts ON ts.subcategory_id = tb.tblbook_subcategoryid
WHERE MONTH(tb.tblbook_bookingdate) = '9'");
$salon_sales9->execute();

$salon_sales10 = $conn->prepare("SELECT *, SUM(ts.subcategory_price) AS total_sales FROM tblbook tb 
INNER JOIN tbl_subcategory ts ON ts.subcategory_id = tb.tblbook_subcategoryid
WHERE MONTH(tb.tblbook_bookingdate) = '10'");
$salon_sales10->execute();

$salon_sales11 = $conn->prepare("SELECT *, SUM(ts.subcategory_price) AS total_sales FROM tblbook tb 
INNER JOIN tbl_subcategory ts ON ts.subcategory_id = tb.tblbook_subcategoryid
WHERE MONTH(tb.tblbook_bookingdate) = '11'");
$salon_sales11->execute();

$salon_sales12 = $conn->prepare("SELECT *, SUM(ts.subcategory_price) AS total_sales FROM tblbook tb 
INNER JOIN tbl_subcategory ts ON ts.subcategory_id = tb.tblbook_subcategoryid
WHERE MONTH(tb.tblbook_bookingdate) = '12'");
$salon_sales12->execute();














if($salon_sales1->rowCount()>0){
    $sales1_row = $salon_sales1->fetch();
    $total_sales1=$sales1_row['total_sales'];}else{$total_sales1=0;} 
if($salon_sales2->rowCount()>0){
    $sales2_row = $salon_sales2->fetch();
    $total_sales2=$sales2_row['total_sales'];}else{$total_sales2=0;} 
if($salon_sales3->rowCount()>0){
    $sales3_row = $salon_sales3->fetch();
    $total_sales3=$sales3_row['total_sales'];}else{$total_sales3=0;} 
if($salon_sales4->rowCount()>0){
    $sales4_row = $salon_sales4->fetch();
    $total_sales4=$sales4_row['total_sales'];}else{$total_sales4=0;} 
if($salon_sales5->rowCount()>0){
    $sales5_row = $salon_sales5->fetch();
    $total_sales5=$sales5_row['total_sales'];}else{$total_sales5=0;} 
if($salon_sales6->rowCount()>0){
    $sales6_row = $salon_sales6->fetch();
    $total_sales6=$sales6_row['total_sales'];}else{$total_sales6=0;} 
if($salon_sales7->rowCount()>0){
    $sales7_row = $salon_sales7->fetch();
    $total_sales7=$sales7_row['total_sales'];}else{$total_sales7=0;} 
if($salon_sales8->rowCount()>0){
    $sales8_row = $salon_sales8->fetch();
    $total_sales8=$sales8_row['total_sales'];}else{$total_sales8=0;} 
if($salon_sales9->rowCount()>0){
    $sales9_row = $salon_sales9->fetch();
    $total_sales9=$sales9_row['total_sales'];}else{$total_sales9=0;} 
if($salon_sales10->rowCount()>0){
    $sales10_row = $salon_sales10->fetch();
    $total_sales10=$sales10_row['total_sales'];}else{$total_sales10=0;} 
if($salon_sales11->rowCount()>0){
    $sales11_row = $salon_sales11->fetch();
    $total_sales11=$sales11_row['total_sales'];}else{$total_sales11=0;} 
if($salon_sales12->rowCount()>0){
    $sales12_row = $salon_sales12->fetch();
    $total_sales12=$sales12_row['total_sales'];}else{$total_sales12=0;} 


?>
<!DOCTYPE HTML>
<html>
<head>
<title>BeautyCity Salon | Admin Dashboard</title>

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!-- font CSS -->
<!-- font-awesome icons -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons -->
<!--webfonts-->
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
<!--//webfonts--> 
<!--animate-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<link rel="stylesheet" href="css/clndr.css" type="text/css" />
<link href="css/custom.css" rel="stylesheet">

<!--//Metis Menu -->
</head> 
<body class="cbp-spmenu-push">
<div class="main-content">
		
		 <?php include_once('includes/sidebar.php');?>
		
	<?php include_once('includes/header.php');?>
		<!-- main content start-->
		<div id="page-wrapper" class="row calender widget-shadow">
			<div class="main-page">
				
			<?php if($user['type'] == 0){ ?>
			
				<div class="row calender widget-shadow">
					<div class="row-one">
					    
						<div class="col-md-4 widget">
						    <a href="customer-list.php">
    							<?php $query1=mysqli_query($con,"SELECT * FROM tbl_users WHERE users_type = 0");
    								$totalcust=mysqli_num_rows($query1);
    							?>
    
    							<div class="stats-left " style="height: 100px">
    								<h5></h5>
    								<h5 style="font-size: 30px">Customer</h5>
    							</div>
    
    							<div class="stats-right" style="height: 100px">
    								<label> <?php echo $totalcust;?></label>
    							</div>
							</a>

							<div class="clearfix"> </div>	
							
						</div>
						
						<div class="col-md-4 widget states-mdl">
						    
						    <a href="staff-list.php">
							<?php $query4staff=mysqli_query($con,"SELECT * FROM tbl_staff");
								$totalstaff=mysqli_num_rows($query4staff);
							?>

							<div class="stats-left " style="height: 100px">
								<h5></h5>
								<h5 style="font-size: 30px">Staff</h5>
							</div>

							<div class="stats-right" style="height: 100px">
								<label> <?php echo $totalstaff;?></label>
							</div>
							</a>

							<div class="clearfix"> </div>	
							
						</div>

						<div class="col-md-4 widget states-last">
						    
						    <a href="today-booking.php">
							<?php $query2=mysqli_query($con,"SELECT * FROM tblbook 
							WHERE DATE(tblbook_bookingdate) = '$today_date' AND tblbook_status = 'Accepted'");
								$totalappointment=mysqli_num_rows($query2);
								?>
							<div class="stats-left" style="height: 100px">
								<h5></h5>
								<h5 style="font-size: 30px">Today's List</h5>
							</div>
							<div class="stats-right" style="height: 100px">
								<label> <?php echo $totalappointment;?></label>
							</div>
							</a>
							<div class="clearfix"> </div>	
						</div>

						<div class="clearfix"> </div>	
						
					</div>
						
				</div>

				<div class="row calender widget-shadow">
					<div class="row-one">
						<div class="col-md-4 widget">
						    
						    <a href="rejected-booking.php">
							<?php $query4=mysqli_query($con,"SELECT * FROM tblbook tb WHERE tb.tblbook_status='Rejected'");
								$totalrejapt=mysqli_num_rows($query4);
								?>
							<div class="stats-left" style="height: 100px">
								<h5></h5>
								<h5 style="font-size: 30px">Rejected</h5>
							</div>
							<div class="stats-right" style="height: 100px">
								<label> <?php echo $totalrejapt;?></label>
							</div>
							</a>
							
							<div class="clearfix"> </div>	
						</div>
						
						<div class="col-md-4 widget states-mdl">
						    
						    <a href="accepted-booking.php">
							<?php $query3=mysqli_query($con,"SELECT * FROM tblbook tb WHERE tb.tblbook_status='Accepted'");
								$totalaccapt=mysqli_num_rows($query3);
								?>
							<div class="stats-left" style="height: 100px">
								<h5> </h5>
								<h5 style="font-size: 30px">Accepted</h5>
							</div>
							<div class="stats-right" style="height: 100px">
								<label><?php echo $totalaccapt;?></label>
							</div>
							</a>
							
							<div class="clearfix"> </div>	
						</div>
						
						<div class="col-md-4 widget states-last">
						    
						    <a href="paid-booking.php">
							<?php $query3=mysqli_query($con,"SELECT * FROM tblbook tb WHERE tb.tblbook_status='Paid'");
								$totalaccapt=mysqli_num_rows($query3);
								?>
							<div class="stats-left" style="height: 100px">
								<h5> </h5>
								<h5 style="font-size: 30px">Paid</h5>
							</div>
							<div class="stats-right" style="height: 100px">
								<label><?php echo $totalaccapt;?></label>
							</div>
							</a>
							
							<div class="clearfix"> </div>	
						</div>
						<div class="clearfix"> </div>
						
					</div>
						
				</div>

  			<?php } ?>

			<?php if($user['type'] == 1){ ?>
			
				
				<div class="row calender widget-shadow">
					<div class="row-one">
						<div class="col-md-4 widget">
						    
						    <a href="today-booking.php">
							<?php $query2=mysqli_query($con,"SELECT * FROM tblbook WHERE tblbook_staffid = '$staff_id' AND DATE(tblbook_bookingdate) = '$today_date' AND tblbook_status = 'Accepted'");
								$totalappointment=mysqli_num_rows($query2);
								?>
							<div class="stats-left" style="height: 100px">
								<h5></h5>
								<h5 style="font-size: 30px">Today's List</h5>
							</div>
							<div class="stats-right" style="height: 100px">
								<label> <?php echo $totalappointment;?></label>
							</div>
							</a>
							
							<div class="clearfix"> </div>	
						</div>
						<div class="col-md-4 widget states-mdl">
						    
						    <a href="rejected-booking.php">
							<?php $query4=mysqli_query($con,"SELECT * FROM tblbook tb WHERE tb.tblbook_status='Rejected' AND tb.tblbook_staffid = '$staff_id'");
								$totalrejapt=mysqli_num_rows($query4);
								?>
							<div class="stats-left" style="height: 100px">
								<h5></h5>
								<h5 style="font-size: 30px">Rejected</h5>
							</div>
							<div class="stats-right" style="height: 100px">
								<label> <?php echo $totalrejapt;?></label>
							</div>
							</a>
							
							<div class="clearfix"> </div>	
						</div>
						
						<div class="col-md-4 widget states-last">
						    
						    <a href="accepted-booking.php">
							<?php $query3=mysqli_query($con,"SELECT * FROM tblbook tb WHERE tb.tblbook_status='Accepted' AND tb.tblbook_staffid = '$staff_id'");
								$totalaccapt=mysqli_num_rows($query3);
								?>
							<div class="stats-left" style="height: 100px">
								<h5></h5>
								<h5 style="font-size: 30px">Accepted</h5>
							</div>
							<div class="stats-right" style="height: 100px">
								<label><?php echo $totalaccapt;?></label>
							</div>
							</a>
							
							<div class="clearfix"> </div>	
						</div>
						<div class="col-md-4 widget states-last">
						    
						    <a href="paid-booking.php">
							<?php $query3=mysqli_query($con,"SELECT * FROM tblbook tb WHERE tb.tblbook_status='Paid' AND tb.tblbook_staffid = '$staff_id'");
								$totalaccapt=mysqli_num_rows($query3);
								?>
							<div class="stats-left" style="height: 100px">
								<h5></h5>
								<h5 style="font-size: 30px">Paid</h5>
							</div>
							<div class="stats-right" style="height: 100px">
								<label><?php echo $totalaccapt;?></label>
							</div>
							</a>
							
							<div class="clearfix"> </div>	
						</div>
						<div class="clearfix"> </div>
						
					</div>
						
				</div>

			<?php } ?>
				
			</div>
			
		<div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body row">
                        <div class="col-md-12">
                            <div class="card-header ">
                                <!--<h4 class="card-title">Beauty Salon Sales</h4>-->
                            </div>
                            <div id="chart-container">
                                <div id="chartContainer3" style="height: 300px; width: 100%;"></div>
                            </div>
                            <div class="card-footer ">
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body row">
                        <div class="col-md-12">
                            <div class="card-header ">
                                <!--<h4 class="card-title">Services Available</h4>-->
                            </div>
                            <div class="card-body ">
                                <div class="chart-container pie-chart">
                                    <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body row">
                        <div class="col-md-12">
                            <div class="card-header ">
                                <!--<h4 class="card-title">Customers Booking</h4>-->
                            </div>
                            <div class="card-body ">
                                <div class="chart-container bar-chart">
                                    <div id="chartContainer2" style="height: 300px; width: 100%;"></div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
		</div>
		<!--footer-->
		<?php include_once('includes/footer.php');?>
        <!--//footer-->
	</div>
 <!-- js-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
<script src="js/modernizr.custom.js"></script>
<script src="js/wow.min.js"></script>
<script>
	 new WOW().init();
</script>
<script src="js/underscore-min.js" type="text/javascript"></script>
<script src= "js/moment-2.2.1.js" type="text/javascript"></script>
<script src="js/clndr.js" type="text/javascript"></script>
<script src="js/site.js" type="text/javascript"></script>
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js" integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>-->
<!-- chart -->
<!--<script src="js/Chart.js"></script>-->
<!-- //chart -->
<script type="text/javascript">
    window.onload = function() {
    
    var options = {
    	title: {
    		text: "Services Available"
    	},
    	data: [{
    			type: "pie",
    			startAngle: 45,
    			showInLegend: "true",
    			legendText: "{label}",
    			indexLabel: "{label} ({y})",
    			yValueFormatString:"#,##0.#"%"",
    			dataPoints: [
    			    <?php if($services_available->rowCount() > 0){ ?>
    			    <?php while($row = $services_available->fetch()){ ?>
    				    { label: "<?=$row['Services'];?>", y: <?=$row['Total_client'];?> },
    				<?php } ?>
    				<?php } ?>
    			]
    	}]
    };
    
    //Better to construct options first and then pass it as a parameter
    var options2 = {
    	animationEnabled: true,
    	title: {
    		text: "Customers Booking",                
    		fontColor: "Peru"
    	},	
    	axisY: {
    		tickThickness: 0,
    		lineThickness: 0,
    		valueFormatString: " ",
    		includeZero: true,
    		gridThickness: 0                    
    	},
    	axisX: {
    		tickThickness: 0,
    		lineThickness: 0,
    		labelFontSize: 18,
    		labelFontColor: "Peru"				
    	},
    	data: [{
    		indexLabelFontSize: 18,
    		toolTipContent: "<span style=\"color:#62C9C3\">{indexLabel}:</span> <span style=\"color:#CD853F\"><strong>{y}</strong></span>",
    		indexLabelPlacement: "inside",
    		indexLabelFontColor: "white",
    		indexLabelFontWeight: 600,
    		indexLabelFontFamily: "Verdana",
    		color: "#62C9C3",
    		type: "bar",
    		dataPoints: [
			    <?php if($customers_booking->rowCount() > 0){ ?>
			    <?php while($row = $customers_booking->fetch()){ ?>
    			    { y: <?=$row['total_customer'];?>, label: "<?=$row['total_customer'];?>", indexLabel: "<?=$row['category_name'];?>" },
    			<?php } ?>
    			<?php } ?>
    		]
    	}]
    };
    
    var options3 = {
    	title: {
    		text: "BeautyCiti Salon Sales"              
    	},
    	data: [              
    	{
    		// Change type to "doughnut", "line", "splineArea", etc.
    		type: "column",
    		dataPoints: [
    			{ label: "Jan",  y: <?php if(empty($total_sales1)){echo 0;}else{echo $total_sales1;}?> },
    			{ label: "Feb", y: <?php if(empty($total_sales2)){echo 0;}else{echo $total_sales2;}?>  },
    			{ label: "March", y: <?php if(empty($total_sales3)){echo 0;}else{echo $total_sales3;}?>  },
    			{ label: "April", y: <?php if(empty($total_sales4)){echo 0;}else{echo $total_sales4;}?>  },
    			{ label: "May",  y: <?php if(empty($total_sales5)){echo 0;}else{echo $total_sales5;}?>  },
    			{ label: "Jun",  y: <?php if(empty($total_sales6)){echo 0;}else{echo $total_sales6;}?>  },
    			{ label: "July", y: <?php if(empty($total_sales7)){echo 0;}else{echo $total_sales7;}?>  },
    			{ label: "Aug", y: <?php if(empty($total_sales8)){echo 0;}else{echo $total_sales8;}?>  },
    			{ label: "Sep",  y: <?php if(empty($total_sales9)){echo 0;}else{echo $total_sales9;}?>  },
    			{ label: "Oct",  y: <?php if(empty($total_sales10)){echo 0;}else{echo $total_sales10;}?> },
    			{ label: "Nov",  y: <?php if(empty($total_sales11)){echo 0;}else{echo $total_sales11;}?> },
    			{ label: "Dec", y: <?php if(empty($total_sales12)){echo 0;}else{echo $total_sales12;}?> }
    		]
    	}
    	]
    };
    
    $("#chartContainer").CanvasJSChart(options);
    $("#chartContainer2").CanvasJSChart(options2);
    $("#chartContainer3").CanvasJSChart(options3);
    
    }
</script>

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