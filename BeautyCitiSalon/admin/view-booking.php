<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
    if (strlen($_SESSION['bpmsaid']==0)) {
  header('location:logout.php');
  } else{

    
    
if(isset($_POST['submit']))
  {
      

    $cid=$_GET['viewid'];
      $remark=$_POST['remark'];
      $status=$_POST['status'];
   $query=mysqli_query($con, "update  tblbook set Remark='$remark',Status='$status' where ID='$cid'");
    if ($query) {
    
    echo '<script>alert("All remark has been updated.")</script>';
    echo "<script type='text/javascript'> document.location ='all-appointment.php'; </script>";
  }
  else
    {
      echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
}
  ?>
<!DOCTYPE HTML>
<html>
<head>
<title>BPMS || View Appointment</title>

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
				<div class="tables">
					<h3 class="title1">View Booking</h3>
					<div class="table-responsive bs-example widget-shadow">
						
						<h4>View Booking:</h4>
						<?php
            $cid=$_GET['viewid'];
            $ret=mysqli_query($con,"SELECT * FROM tblbook tb 
            INNER JOIN tbl_users tu ON tu.users_id=tb.tblbook_userid 
            WHERE tb.tblbook_bookingnumber='$cid'
            GROUP BY tb.tblbook_bookingnumber");
            $cnt=1;
            while ($row=mysqli_fetch_array($ret)) {

            ?>
		<table class="table table-bordered">
			<tr>
                <th>Booking Number</th>
                <td><?php  echo $row['tblbook_bookingnumber'];?></td>
              </tr>
              <tr>
                <th>Name</th>
                <td><?php  echo $row['users_firstname'];?> <?php  echo $row['users_lastname'];?></td>
              </tr>

              <tr>
                <th>Email</th>
                <td><?php  echo $row['users_email'];?></td>
              </tr>
              <tr>
                <th>Mobile Number</th>
                <td><?php  echo $row['users_contact'];?></td>
              </tr>
              <tr>
                <th>Appointment Date</th>
                <td><?php  echo $row['tblbook_bookingdate'];?></td>
              </tr>
 
  
  
              <tr>
                <th>Apply Date</th>
                <td><?php  echo $row['tblbook_dateadded'];?></td>
              </tr>
              

              <tr>
                <th>Status</th>
                <td> <?php  
                    if($row['tblbook_status']=="")
                    {
                      echo "Not Updated Yet";
                    }

                    if($row['tblbook_status']=="Accepted")
                    {
                      echo "Accepted";
                    }

                    if($row['tblbook_status']=="Rejected")
                    {
                      echo "Rejected";
                    }
                    
                    
                    if($row['tblbook_status']=="Paid")
                    {
                      echo "Paid";
                    }

                ;?></td>
              </tr>
						</table>
						<table class="table table-bordered" width="100%" border="1"> 
								<tr>
								<th colspan="3">Services Details</th>	
								</tr>
								<tr>
								<th>#</th>	
								<th>Service</th>
								<th>Booking Time</th>
								<th>Cost</th>
								</tr>

								<?php
								$ret=mysqli_query($con,"SELECT * FROM tblbook tb
									INNER JOIN tbl_subcategory ts ON ts.subcategory_id=tb.tblbook_subcategoryid 
									WHERE tb.tblbook_bookingnumber='$cid'");
								$cnt=1;
								while ($row=mysqli_fetch_array($ret)) {
									?>

								<tr>
									<th><?php echo $cnt;?></th>
									<td><?php echo $row['subcategory_name']?></td>
									<td>
                                        <?php 
                                        
                                              
                                            $today = time();  
                                            $new_time = date('h:i: a', strtotime('-4 hours -20 minutes', $today));
                                        
                                          $stmt_bookingtime1 = $conn->prepare("SELECT * FROM tbl_mins tm
                                          INNER JOIN tbl_sched ts ON ts.sched_id = tm.mins_schedid
                                          WHERE tm.mins_stat = ? AND tm.mins_date = ? AND tm.mins_staffid = ?
                                          ORDER BY tm.id ASC LIMIT 1");
                                          $stmt_bookingtime1->execute([1, $row['tblbook_bookingdate'], $row['tblbook_staffid']]);
                                          $bookingtime_row1 = $stmt_bookingtime1->fetch();
                    
                                          $stmt_bookingtime2 = $conn->prepare("SELECT * FROM tbl_mins tm
                                          INNER JOIN tbl_sched ts ON ts.sched_id = tm.mins_schedid
                                          WHERE tm.mins_stat = ? AND tm.mins_date = ? AND tm.mins_staffid = ?
                                          ORDER BY tm.id DESC LIMIT 1");
                                          $stmt_bookingtime2->execute([1, $row['tblbook_bookingdate'], $row['tblbook_staffid']]);
                                          $bookingtime_row2 = $stmt_bookingtime2->fetch();
                                          
                                          $bt = $bookingtime_row1['sched_time'];
                    
                                        ?>
                                        <?php echo $bookingtime_row1['sched_time']; ?> - <?php echo $bookingtime_row2['sched_time']; ?>
                    
                                      </td>	
									<td>&#8369;<?php echo number_format($subtotal=$row['subcategory_price'], 2); ?></td>
									</tr>
									<?php 
									
									
									$cnt=$cnt+1;
									$gtotal+=$subtotal;
									} ?>

									<tr>
									<th colspan="3" style="text-align:center">Grand Total</th>
									<th>&#8369;<?php echo number_format($gtotal, 2); ?></th>	

								</tr>
							</table>
            <?php } ?>
						
					</div>
				</div>
			</div>
		</div>
		<!--footer-->
		
        <!--//footer-->
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
<?php }  ?>