<?php 
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include_once "connections/connect.php";
$conn = $lib->openConnection();
if (strlen($_SESSION['bpmsuid']==0)) {
  header('location:logout.php');
  } else{



  ?>
<!doctype html>
<html lang="en">
  <head>
 

    <title>BeautyCiti Salon | Booking History</title>

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
            <h3 class="header-name ">Booking History</h3>
            <!-- <p class="tiltle-para ">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Hic fuga sit illo modi aut aspernatur tempore laboriosam saepe dolores eveniet.</p> -->
        </div>
</div>
</div>
<div class="breadcrumbs-sub">
<div class="container">   
<ul class="breadcrumbs-custom-path">
    <li class="right-side propClone"><a href="index.php" class="text-danger">Home <span class="fa fa-angle-right" aria-hidden="true"></span></a> <p></li>
    <li class="active ">Booking History</li>
</ul>
</div>
</div>
    </div>
</section>
<!-- breadcrumbs //-->
<section class="w3l-contact-info-main" id="contact">
    <div class="contact-sec	">
        <div class="container">

            <div>
                <div class="cont-details">
                   <div class="table-content table-responsive cart-table-content m-t-30">
                   <h4 style="padding-bottom: 20px;text-align: center;color: blue;">Booking Details</h4>
                        <?php
                        $cid=$_GET['bookingnumber'];
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
                              <th>Booking Date</th>
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

                                    ;?>
                              </td>
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
                    </div> </div>
                
    </div>
   
    </div></div>
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

</html><?php } ?>