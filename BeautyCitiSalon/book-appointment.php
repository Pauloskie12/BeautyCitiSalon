<?php 
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include_once "./connections/connect.php";
$conn = $lib->openConnection();
if (strlen($_SESSION['bpmsuid']==0)) {
  header('location:logout.php');
  } else{

    $subcat_id = $_GET['subcat'];

    $check_subcat = $conn->prepare("SELECT * FROM tbl_subcategory WHERE subcategory_id = ?");
    $check_subcat->execute([$subcat_id]);
    $subcat = $check_subcat->fetch();

    $get_sched = $conn->prepare("SELECT * FROM tbl_sched");
    $get_sched->execute();
    $sched_cnt = $get_sched->rowCount();

    if(isset($_POST['submit']))
    {

        $uid=$_SESSION['bpmsuid'];
        $adate=$_POST['adate'];
        $atime=$_POST['atime'];
        // $msg=$_POST['message'];
        $aptnumber = mt_rand(100000000, 999999999);
    
        $query=mysqli_query($con,"INSERT INTO tblbook(tblbook_userid, tblbook_bookingnumber, tblbook_bookingdate, tblbook_bookingtime) value('$uid','$aptnumber','$adate','$atime')");

        if ($query) {
            $ret=mysqli_query($con,"SELECT tblbook_bookingnumber FROM tblbook WHERE tblbook.tblbook_userid='$uid' ORDER BY tblbook_id DESC LIMIT 1");
            $result=mysqli_fetch_array($ret);
            $_SESSION['bookno']=$result['tblbook_bookingnumber'];
            echo "<script>window.location.href='thank-you.php'</script>";  
        }
        else
        {
        echo '<script>alert("Something Went Wrong. Please try again")</script>';
        }

    
    }
?>
<!doctype html>
<html lang="en">
  <head>
 

    <title>BeautyCiti Salon | Appointment Page</title>

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
            <h3 class="header-name ">Book A Service</h3>
            <!-- <p class="tiltle-para ">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Hic fuga sit illo modi aut aspernatur tempore laboriosam saepe dolores eveniet.</p> -->
        </div>
</div>
</div>
<div class="breadcrumbs-sub">
<div class="container">   
<ul class="breadcrumbs-custom-path">
    <li class="right-side propClone"><a href="index.php" class="text-danger">Home <span class="fa fa-angle-right" aria-hidden="true"></span></a> <p></li>
    <li class="active ">Book A Service</li>
</ul>
</div>
</div>
    </div>
</section>
<!-- breadcrumbs //-->
<section class="w3l-contact-info-main" id="contact">
    <div class="contact-sec	">
        <div class="container">

            <div class="d-grid contact-view">
                
                <div class="map-content-9 mt-lg-0 mt-4">
                    <div class="row">
                        <div class="col-md-12" style="background: #f2f2f2">
                            <center><img src="assets/images/<?=$subcat['subcategory_image'];?>" style="width: 80%;"></center>
                        </div>
                        <div class="col-md-12">
                            <br>
                            <div class="row">
                                <div class="col-md-8"><h3 style="font-size: 20px"><?=$subcat['subcategory_name'];?></h3><br></div>
                                <div class="col-md-4"><h3>&#8369; <?=number_format($subcat['subcategory_price'], 2);?></h3></div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                
                <div class="map-content-9 mt-lg-0 mt-4">
                    <form method="post">
                        <div style="padding-top: 30px;">
                            <label>Staff</label>
                            <select class="form-control" name="staff_position">
                                <option value="" selected disabled> --- </option>
                                <?php 
                                    $staff = $conn->prepare("SELECT * FROM tbl_staff ts JOIN tbl_job tj ON ts.staff_position = tj.job_id WHERE tj.job_categoryid = ?");
                                    $staff->execute([$subcat['subcategory_categoryid']]);

                                    while($row = $staff->fetch()){
                                ?>
                                <option value="<?=$row['staff_position'];?>"><?=$row['staff_firstname'];?> <?=$row['staff_lastname'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div style="padding-top: 30px;">
                            <label>Booking Date</label>
                            <input type="date" class="form-control appointment_date" placeholder="Date" name="adate" id='adate' required="true">
                        </div>
                        <div style="padding-top: 30px;">
                            <label>Booking Time</label>
                            <input type="hidden" id="subcateg_price" value="<?=$subcat['subcategory_price']?>">
                            <input type="hidden" id="subcateg_id" value="<?=$subcat['subcategory_id']?>">

                            <div id="cont" class="row">

                            <?php

                            if(isset($_REQUEST['time'])){

                                $date = $_REQUEST['date'];
                                $arr = [];

                                $sql = $conn->prepare("SELECT * FROM tbl_sched");
                                $sql->execute();

                                $sql2 = $conn->prepare("SELECT * FROM tbl_sched AS ts 
                                INNER JOIN tblbook AS tb ON ts.sched_id = tb.tblbook_bookingtime 
                                INNER JOIN tbl_subcategory AS tsub ON tb.tblbook_subcategoryid = tsub.subcategory_id WHERE tb.tblbook_status = ? AND DATE(tb.tblbook_bookingdate) = ?");
                                $sql2->execute([1, $date]);




                                while($val2 = $sql2->fetch()){

                                    array_push($arr, $val2['tblbook_bookingtime']);

                                }

                                while($val = $sql->fetch()){
                                    if(in_array($val['sched_id'], $arr)){

                                        ?>

                                        <div class="col-lg-6" style="background: crimson; cursor: pointer; color: white; padding: 10px 20px; border-radius: 4px; border: 4px solid white">
                                            <a href="#" style="text-decoration: none; color: white"><?=$val['sched_time'];?></a>
                                        </div>
                                        
                                        <?php

                                    }else{
                                        
                                        if($_REQUEST['time'] == $val['sched_id']){
                                            ?>
                                            <div class="col-lg-6" style="background: goldenrod; cursor: pointer; color: white; padding: 10px 20px; border-radius: 4px; border: 4px solid white">
                                                <a href="./book-appointment.php?subcat=<?=$_REQUEST['subcat'];?>&price=<?=$price;?>&date=<?=$date;?>&time=<?=$val['sched_id'];?>" style="text-decoration: none; color: white"><?=$val['sched_time'];?></a>
                                                <input type="hidden" name="atime" value="<?=$_REQUEST['time'];?>">
                                            </div>
                                            
                                            <?php
                                        }else{
                                            ?>
                                            <div class="col-lg-6" style="background: dodgerblue; cursor: pointer; color: white; padding: 10px 20px; border-radius: 4px; border: 4px solid white">
                                                <a href="./book-appointment.php?subcat=<?=$_REQUEST['subcat'];?>&price=<?=$price;?>&date=<?=$date;?>&time=<?=$val['sched_id'];?>" style="text-decoration: none; color: white"><?=$val['sched_time'];?></a>
                                            </div>
                                            
                                            <?php
                                        }

                                    }
                                }

                            }

                            ?>


                            </div>
                           




                        <div style="padding-top: 30px;">
                        <!-- <textarea class="form-control" id="message" name="message" placeholder="Message" required=""></textarea></div> -->
                        <button type="submit" class="btn btn-contact" name="submit">BOOK NOW</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
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
$(function(){
    var dtToday = new Date();
    
    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();
    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString();
    
    var maxDate = year + '-' + month + '-' + day;
    $('#adate').attr('min', maxDate);
});</script>

<script>
    $(document).ready(function(){
          
        var subcateg_id = $('#subcateg_id').val();
        var price = $('#subcateg_price').val();


        $('#adate').on('change', function(){
            window.alert($(this).val());
            $.ajax({
                type: "POST",
                url: "fetch04.php",
                data: { date : $(this).val(), subcateg_id : subcateg_id, price : price } ,
                success: function (result) {
                    $('#cont').html(result);
                }
            });
        })
    })
</script>
<!-- /move top -->
</body>

</html><?php } ?>