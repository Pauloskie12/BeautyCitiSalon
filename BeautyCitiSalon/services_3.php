
<?php
// session_start();
// error_reporting(0);
include('includes/dbconnection.php');
include_once "./connections/connect.php";
$conn = $lib->openConnection();

$stmt = $conn->prepare("SELECT * FROM tbl_selected tss
INNER JOIN tbl_job tj ON job_categoryid = selected_categoryid
GROUP BY selected_categoryid");
$stmt->execute();
$total_limit = $stmt->rowCount();
$page_limit = $total_limit - 1;
$limit2 = $total_limit - $page_limit;

if(isset($_GET['limit'])){
    $limit = $_GET['limit'];
}else{
    $limit = 0;
}

$selected = $conn->prepare("SELECT * FROM tbl_selected");
$selected->execute();

$sel_cat = $conn->prepare("SELECT * FROM tbl_selected tss
INNER JOIN tbl_subcategory ts ON tss.selected_subcategoryid = ts.subcategory_id
GROUP BY tss.selected_categoryid LIMIT $limit, $limit2");
$sel_cat->execute();
$row_cat = $sel_cat->rowCount();



?>
<!doctype html>
<html lang="en">
  <head>
    

    <title>BeautyCiti Salon | service Page </title>

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <style>

      #img_categ:hover{
        transform:scale(1.1);
        transition: 0.5s;
      }

      /* Customize the label (the container) */
      .container {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      /* Hide the browser's default checkbox */
      .container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
      }

      /* Create a custom checkbox */
      .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
      }

      /* On mouse-over, add a grey background color */
      .container:hover input ~ .checkmark {
        background-color: #ccc;
      }

      /* When the checkbox is checked, add a blue background */
      .container input:checked ~ .checkmark {
        background-color: #2196F3;
      }

      /* Create the checkmark/indicator (hidden when not checked) */
      .checkmark:after {
        content: "";
        position: absolute;
        display: none;
      }

      /* Show the checkmark when checked */
      .container input:checked ~ .checkmark:after {
        display: block;
      }

      /* Style the checkmark/indicator */
      .container .checkmark:after {
        left: 9px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
      }

      .cat-link{
        color: #222;
      }

      .cat-link:hover{
        color: crimson;
      }

      #selected_service{
        display: none;
      }
      #mobile_view{
        display: none;
      }

      /* Styles for screens up to 767 pixels wide (typical mobile phones) */
      @media only screen and (max-width: 767px) {
        #selected_service{
          display: none;
        }
        #mobile_view{
          display: block;
        }
      }

    </style>
  </head>
  <body id="home">
<?php include_once('includes/header.php');?>

<script src="assets/js/jquery-3.3.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script>
    $(function () {
    $('.navbar-toggler').click(function () {
        $('body').toggleClass('noscroll');
    })
    });
</script>

<section class="w3l-inner-banner-main">
    <div class="about-inner services ">
        <div class="container">   
            <div class="main-titles-head text-center"><h3 class="header-name "> Our Service </h3></div>
        </div>
    </div>
    <div class="breadcrumbs-sub">
        <div class="container">   
            <ul class="breadcrumbs-custom-path">
                <li class="right-side propClone"><a href="index.php" class="text-danger">Home <span class="fa fa-angle-right" aria-hidden="true"></span></a> <p></li>
                <li class="active ">Services</li>
            </ul>
        </div>
    </div>
</section>
<!-- breadcrumbs //-->
<section class="w3l-recent-work-hobbies" > 
    <div class="recent-work ">
        <div class="container">
            <div class="row">
                
                <div class="col-md-8">
                    <form method="POST">
                        <?php 
                        
                        $arr2 = [];
                        $count = 0;
                        if($total_limit > 0){
                            while($row = $stmt->fetch()){
                                if(isset($_GET['limit'])){
                                    if($_GET['limit'] == $count){
                                    ?>
                                    <a href="services_3.php?limit=<?=$count?>#date" id="next-btn" class="btn" style="background: yellow"><?=$row['job_name'];?></a>
                                    <?php
                                    }else{
                                        ?>
                                        <a href="services_3.php?limit=<?=$count?>#date" id="next-btn" class="btn btn-dark" style=""><?=$row['job_name'];?></a>
                                        <?php
                                    }
                                }else{
                                ?>
                                <a href="services_3.php?limit=<?=$count?>#date" id="next-btn" class="btn btn-dark" style=""><?=$row['job_name'];?></a>
                                <?php
                                }
                            $count++;
                            }
                        }
                        ?>

                        <?php while($vall = $sel_cat->fetch()){ ?>
                            <?php $total_duration += $vall['subcategory_duration']; ?>
                            <br><br>
                            <label id="staff">Select Staff</label><br>
                            <?php 
                                $sel_staff = $conn->prepare("SELECT * FROM tbl_staff ts 
                                INNER JOIN tbl_job tj ON ts.staff_position = tj.job_id
                                INNER JOIN tbl_selected tss ON tss.selected_categoryid = tj.job_categoryid
                                WHERE tss.selected_categoryid = ?
                                GROUP BY ts.staff_id");
                                $sel_staff->execute([$vall['selected_categoryid']]);

                                $stmt_mins = $conn->prepare("SELECT * FROM tbl_selected ts1
                                INNER JOIN tbl_subcategory ts2 ON ts1.selected_subcategoryid = ts2.subcategory_id
                                WHERE ts1.selected_categoryid = ?");
                                $stmt_mins->execute([$vall['selected_categoryid']]);
                                
                                $total_duration = 0;
                                while($mins_row = $stmt_mins->fetch()){

                                    $total_duration += $mins_row['subcategory_duration'];

                                }
                                ?>
                                <div class="row">
                                <?php
                                while($row = $sel_staff->fetch()){ ?>
                                    
                                    <?php if(isset($_REQUEST['staff_id'])){ ?>

                                        <?php if($_REQUEST['staff_id'] == $row['staff_id']){ ?>
                                            <div class="col-md-3 card bg-dark">
                                            <center>
                                            <a href="services_3.php?staff_id=<?=$row['staff_id'];?>&limit=<?=$limit?>#staff">
                                                <span class="badge"><?=$row['staff_firstname'];?> <?=$row['staff_lastname'];?></span>
                                                <img src="admin/images/<?=$row['staff_image'];?>" style="width: 100px; height: 100px; border-radius: 10px; margin-right: 10px">
                                            </a>
                                            </center>
                                            </div>
                                        <?php }else{ ?>
                                            <div class="col-md-3 card">
                                            <center>
                                            <a href="services_3.php?staff_id=<?=$row['staff_id'];?>&limit=<?=$limit?>#staff">
                                                <span class="badge"><?=$row['staff_firstname'];?> <?=$row['staff_lastname'];?></span>
                                                <img src="admin/images/<?=$row['staff_image'];?>" style="width: 100px; height: 100px; border-radius: 10px; margin-right: 10px">
                                            </a>
                                            </center>
                                            </div>
                                        <?php } ?>
                                        <br>

                                    <?php }else{ ?>              
                                        <div class="col-md-3 card">
                                        <center>
                                        <a href="services_3.php?staff_id=<?=$row['staff_id'];?>&limit=<?=$limit?>#staff">
                                            <span class="badge" style=""><?=$row['staff_firstname'];?> <?=$row['staff_lastname'];?></span>
                                            <img src="admin/images/<?=$row['staff_image'];?>" style="width: 100px; height: 100px; border-radius: 10px; margin-right: 10px">
                                            </a>
                                            
                                    </center>
                                    </div>
                                    <?php } ?>
                                <?php } ?>
                                </div>
                                <br><br>




                            <?php if(isset($_REQUEST['staff_id'])){ ?>
                            <label id="date">Choose A Date</label><br>
                            <?php
                            // Get the current month and year
                            $currentMonth = date('m');
                            $currentYear = date('Y');
                            $currentDay = date('d');

                            // Calculate the next month and year
                            $nextMonth = ($currentMonth == 12) ? 1 : $currentMonth + 1;
                            $nextYear = ($currentMonth == 12) ? $currentYear + 1 : $currentYear;

                            // Get the number of days in the current month
                            $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
                            
                            // Get the number of days in the next month
                            $numberOfDaysNextMonth = cal_days_in_month(CAL_GREGORIAN, $nextMonth, $nextYear);
                            
                            // Get the month name
                            $monthname = date('F', mktime(0, 0, 0, $currentMonth, 1, $currentYear));
                            // Get the month name
                            $monthnameNextMonth = date('F', mktime(0, 0, 0, $nextMonth, 1, $nextYear));

                            if(!isset($_REQUEST['set'])){
                            ?>
                            
                                <div id="current">
                                <?php
                                // Generate buttons for each day of the month
                                for ($day = 1; $day <= $numberOfDays; $day++) {
                                    // Construct the date in YYYY-MM-DD format

                                    $date = sprintf("%04d-%02d-%02d", $currentYear, $currentMonth, $day);
                                    
                                    $dayOfWeek = date('N', strtotime($date));


                                    if($dayOfWeek == 1){ $dayname = "Mon"; }
                                    if($dayOfWeek == 2){ $dayname = "Tue"; }
                                    if($dayOfWeek == 3){ $dayname = "Wed"; }
                                    if($dayOfWeek == 4){ $dayname = "Thu"; }
                                    if($dayOfWeek == 5){ $dayname = "Fri"; }
                                    if($dayOfWeek == 6){ $dayname = "Sat"; }
                                    if($dayOfWeek == 7){ $dayname = "Sun"; }

                                    if($day >= $currentDay){
                                        if(isset($_REQUEST['date'])){
                                            if($_REQUEST['date'] == $date){
                                            ?>
                                            <a href="services_3.php?staff_id=<?=$_REQUEST['staff_id'];?>&date=<?=$date;?>&limit=<?=$limit?>#date" class="btn btn-warning" style="border: 4px solid #222; font-weight: 800; margin-bottom: 10px; border-radius: 10px; width: 100px;; text-align: left"><?=$dayname;?> <?=$day;?><br><small><?=$monthname;?></small></a>
                                            <?php
                                            }else{
                                                ?>                                
                                                <a href="services_3.php?staff_id=<?=$_REQUEST['staff_id'];?>&date=<?=$date;?>&limit=<?=$limit?>#date" class="btn btn-white" style="border: 4px solid #222; font-weight: 800; margin-bottom: 10px; border-radius: 10px; width: 100px; text-align: left"><?=$dayname;?> <?=$day;?><br><small><?=$monthname;?></small></a>
                                                <?php
                                            }

                                        }else{
                                            ?>
                                                                            
                                            <a href="services_3.php?staff_id=<?=$_REQUEST['staff_id'];?>&date=<?=$date;?>&limit=<?=$limit?>#date" class="btn btn-white" style="border: 4px solid #222; font-weight: 800; margin-bottom: 10px; border-radius: 10px; width: 100px; text-align: left"><?=$dayname;?> <?=$day;?><br><small><?=$monthname;?></small></a>

                                            <?php

                                        }
                                    }else{
                                        ?>
                                                                            
                                        <button class="btn" disabled style="border: 4px solid #222; font-weight: 800; margin-bottom: 10px; border-radius: 10px; width: 100px; text-align: left"><?=$dayname;?> <?=$day;?><br><small><?=$monthname;?></small></button>

                                        <?php    
                                    }
                                }
                                ?>
                                </div>
                                <hr>
                                <center>
                                    <a href="#date" id="prev-btn" class="btn " disabled style="color: grey"><< Previous</a>
                                    <a href="services_3.php?staff_id=<?=$_REQUEST['staff_id'];?>&date=<?=$_REQUEST['date'];?>&set=1&limit=<?=$limit?>#date" id="next-btn" class="btn " style="">Next >></a>
                                </center>

                            
                            <?php }else{ ?>


                                <div id="next">
                                <?php
                                // Generate buttons for each day of the month
                                for ($day = 1; $day <= $numberOfDaysNextMonth; $day++) {
                                    // Construct the date in YYYY-MM-DD format

                                    $date = sprintf("%04d-%02d-%02d", $nextYear, $nextMonth, $day);
                                    
                                    $dayOfWeek = date('N', strtotime($date));


                                    if($dayOfWeek == 1){ $dayname = "Mon"; }
                                    if($dayOfWeek == 2){ $dayname = "Tue"; }
                                    if($dayOfWeek == 3){ $dayname = "Wed"; }
                                    if($dayOfWeek == 4){ $dayname = "Thu"; }
                                    if($dayOfWeek == 5){ $dayname = "Fri"; }
                                    if($dayOfWeek == 6){ $dayname = "Sat"; }
                                    if($dayOfWeek == 7){ $dayname = "Sun"; }

                                    if(isset($_REQUEST['date'])){
                                        if($_REQUEST['date'] == $date){
                                        ?>
                                        <a href="services_3.php?staff_id=<?=$_REQUEST['staff_id'];?>&date=<?=$date;?>&set=1&limit=<?=$limit?>#date" class="btn btn-warning" style="border: 4px solid #222; font-weight: 800; margin-bottom: 10px; border-radius: 10px; width: 100px;; text-align: left"><?=$dayname;?> <?=$day;?><br><small><?=$monthnameNextMonth;?></small></a>
                                        <?php
                                        }else{
                                            ?>                                
                                            <a href="services_3.php?staff_id=<?=$_REQUEST['staff_id'];?>&date=<?=$date;?>&set=1&limit=<?=$limit?>#date" class="btn btn-white" style="border: 4px solid #222; font-weight: 800; margin-bottom: 10px; border-radius: 10px; width: 100px; text-align: left"><?=$dayname;?> <?=$day;?><br><small><?=$monthnameNextMonth;?></small></a>
                                            <?php
                                        }

                                    }else{
                                        ?>
                                                                        
                                        <a href="services_3.php?staff_id=<?=$_REQUEST['staff_id'];?>&date=<?=$date;?>&set=1&limit=<?=$limit?>#date" class="btn btn-white" style="border: 4px solid #222; font-weight: 800; margin-bottom: 10px; border-radius: 10px; width: 100px; text-align: left"><?=$dayname;?> <?=$day;?><br><small><?=$monthnameNextMonth;?></small></a>

                                        <?php

                                    }
                                
                                }
                                
                                ?> 
                                </div>
                                <hr>
                                <center>
                                    <a href="services_3.php?staff_id=<?=$_REQUEST['staff_id'];?>&date=<?=$_REQUEST['date'];?>&limit=<?=$limit?>#date" id="prev-btn" class="btn " style=""><< Previous</a>
                                    <a href="#date" id="next-btn" class="btn" disabled style="color: grey">Next >></a>
                                </center>
                            <?php }  ?>
                            <br>

                            <!-- PARA SA TIME -->
                            <?php
                            if(isset($_GET['date'])){
                                ?>
                                <label id="date">Choose A Time</label><br>
                                <div id="time" class="row">
                                    <?php
                                    // if(isset($_REQUEST['time'])){

                                        $date = $_REQUEST['date'];
                                        $arr = [];

                                        $sql = $conn->prepare("SELECT * FROM tbl_sched");
                                        $sql->execute();

                                        $sql2 = $conn->prepare("SELECT * FROM tbl_sched AS ts 
                                        INNER JOIN tblbook AS tb ON ts.sched_id = tb.tblbook_bookingtime 
                                        INNER JOIN tbl_subcategory AS t ON t.subcategory_id = tb.tblbook_subcategoryid WHERE (tb.tblbook_status = ? OR tb.tblbook_status = ?) AND tb.tblbook_userid = ? AND DATE(tb.tblbook_bookingdate) = ?");
                                        $sql2->execute(["", "Accepted", $_SESSION['bpmsuid'], $date]);


                                        while($val2 = $sql2->fetch()){
                                            array_push($arr, $val2['tblbook_bookingtime']);

                                        }

                                        while($val = $sql->fetch()){
                                            if(in_array($val['sched_id'], $arr)){

                                                ?>

                                                <div class="col-lg-3" style="background: crimson; cursor: pointer; color: white; padding: 10px 20px; border-radius: 10px; border: 4px solid #222">
                                                    <a href="#time" style="text-decoration: none; color: white"><?=$val['sched_time'];?></a>
                                                </div>
                                                
                                                <?php

                                            }else{
                                                
                                                if($_REQUEST['time'] == $val['sched_id']){
                                                    $from_mins =  $val['sched_mins'];
                                                    $to_mins =  $from_mins + $total_duration;

                                                    $stmt_selected = $conn->prepare("SELECT * FROM tbl_sched
                                                    WHERE sched_mins BETWEEN ? AND ?");
                                                    $stmt_selected->execute([$from_mins, $to_mins]);
                                                    
                                                    

                                                    $check_tbl_mins = $conn->prepare("SELECT * FROM tbl_mins");
                                                    $check_tbl_mins->execute();

                                                    if($check_tbl_mins->rowCount() > 0){

                                                        $check_tbl_mins_staff = $conn->prepare("SELECT * FROM tbl_mins WHERE mins_staffid = ?");
                                                        $check_tbl_mins_staff->execute([$_GET['staff_id']]);

                                                        if($check_tbl_mins_staff->rowCount() > 0){

                                                            $stmt_emp_mins = $conn->prepare("DELETE FROM tbl_mins WHERE mins_staffid = ?");
                                                            $stmt_emp_mins->execute([$_GET['staff_id']]);

                                                            echo "<script>window.location.reload();</script>";
                                                            // echo "<script>window.location.href = './services_3.php?staff_id=".$_REQUEST['staff_id']."&date=".$_REQUEST['date']."&limit=$limit&time=".$val['sched_id']."#time';</script>";
                                                            

                                                        }else{
                                                            while($row_selected = $stmt_selected->fetch()){
                                                                
                                                                array_push($arr2, $row_selected['sched_id']);
        
                                                                $stmt_ins_mins = $conn->prepare("INSERT INTO tbl_mins(`mins_schedid`,`mins_staffid`,`mins_date`) VALUES(?,?,?)");
                                                                $stmt_ins_mins->execute([$row_selected['sched_id'], $_REQUEST['staff_id'], $_REQUEST['date']]);
    
                                                            ?>
                                                            <div class="col-lg-3" style="background: goldenrod; cursor: pointer; color: #222; padding: 10px 20px; border-radius: 10px; border: 4px solid #222">
                                                                <a href="./services_3.php?staff_id=<?=$_REQUEST['staff_id'];?>&date=<?=$_REQUEST['date'];?>&limit=<?=$limit?>&time=<?=$row_selected['sched_id'];?>#time" style="text-decoration: none; color: #222"><?=$row_selected['sched_time'];?></a>
                                                                <input type="hidden" name="atime" value="<?=$row_selected['time'];?>">
                                                            </div>
                                                            
                                                            <?php
                                                            }
                                                        }

                                                    }else{
                                                        while($row_selected = $stmt_selected->fetch()){
                                                            
                                                            array_push($arr2, $row_selected['sched_id']);
    
                                                            $stmt_ins_mins = $conn->prepare("INSERT INTO tbl_mins(`mins_schedid`,`mins_staffid`,`mins_date`) VALUES(?,?,?)");
                                                            $stmt_ins_mins->execute([$row_selected['sched_id'], $_REQUEST['staff_id'], $_REQUEST['date']]);

                                                        ?>
                                                        <div class="col-lg-3" style="background: goldenrod; cursor: pointer; color: #222; padding: 10px 20px; border-radius: 10px; border: 4px solid #222">
                                                            <a href="./services_3.php?staff_id=<?=$_REQUEST['staff_id'];?>&date=<?=$_REQUEST['date'];?>&limit=<?=$limit?>&time=<?=$row_selected['sched_id'];?>#time" style="text-decoration: none; color: #222"><?=$row_selected['sched_time'];?></a>
                                                            <input type="hidden" name="atime" value="<?=$row_selected['time'];?>">
                                                        </div>
                                                        
                                                        <?php
                                                        }
                                                    }

                                                    

                                                    
                                                    
                                                }else{
                                                    
                                                    if(in_array($val['sched_id'], $arr2)){
                                                    }else{
                                                        $check_stmt_mins = $conn->prepare("SELECT * FROM tbl_mins WHERE mins_schedid = ? AND mins_date = ?");
                                                        $check_stmt_mins->execute([$val['sched_id'], $_REQUEST['date']]);
                                                        $mins_row = $check_stmt_mins->fetch();
                                                    
                                                        if($val['sched_id'] == $mins_row['mins_schedid']){
                                                            
                                                            ?>
                                                            <div class="col-lg-3" style="background: crimson; cursor: pointer; color: #222; padding: 10px 20px; border-radius: 10px; border: 4px solid #222">
                                                                <a href="#time" style="text-decoration: none; color: white"><?=$val['sched_time'];?></a>
                                                            </div>
                                                            
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <div class="col-lg-3" style="background: white; cursor: pointer; color: #222; padding: 10px 20px; border-radius: 10px; border: 4px solid #222">
                                                                <a href="./services_3.php?staff_id=<?=$_REQUEST['staff_id'];?>&date=<?=$_REQUEST['date'];?>&limit=<?=$limit?>&time=<?=$val['sched_id'];?>#time" style="text-decoration: none; color: #222"><?=$val['sched_time'];?></a>
                                                            </div>
                                                            
                                                            <?php
                                                        }

                                                    }
                                                }

                                            }
                                        }

                                    // }
                                    ?>
                                </div>
                                <br>
                                <hr>
                                <center>
                                <?php
                                if(isset($_GET['time'])){
                                    if($total_limit == ($limit + 1)){
                                        ?>                                        
                                        <a href="services_3_action.php?staff_id=<?=$_REQUEST['staff_id'];?>&date=<?=$_REQUEST['date'];?>&time=<?=$_GET['time'];?>&limit=<?=$limit + 1?>&total_duration=<?=$total_duration;?>&type=2#date" id="next-btn" class="btn btn-block btn-success" style="">Book Now</a>
                                        <?php
                                    }else{
                                        ?>                                        
                                        <a href="services_3_action.php?staff_id=<?=$_REQUEST['staff_id'];?>&date=<?=$_REQUEST['date'];?>&time=<?=$_GET['time'];?>&limit=<?=$limit + 1?>&total_duration=<?=$total_duration;?>&type=1#date" id="next-btn" class="btn btn-block btn-success" style="">Proceed</a>
                                        <?php
                                    }
                                }
                                ?>
                                </center>
                                <?php
                            }
                            ?>
                        <?php } ?>
                                        
                        <br><br>
                        <?php } ?>
                        <br><br>
                        <?php ?>
                    </form>
                </div>

                <div class="col-md-4" style="background: #f3f3f3">
                    <div class="card" style="position: sticky; top:20px; left: 0">
                        <div class="card-body">
                        <div class="row">
                        <div class="col-md-12">
                            <center><h5><b>Selected Sevices</b></h5></center><hr>
                        </div>
                        </div>
                        
                        <?php
                        $tot = 0;
                        $cnt = 0;
                        $stmt = $conn->prepare("SELECT * FROM tbl_selected ts 
                        INNER JOIN tbl_subcategory tsub ON ts.selected_subcategoryid = tsub.subcategory_id");
                        $stmt->execute();

                        if($stmt->rowCount() > 0){
                            while($val = $stmt->fetch()){
                                ?>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6 col-12" style="padding: 10px 30px">
                                        <p style="font-size: 16px; font-weight: 700"><?=$val['subcategory_name'];?><br><small><?=$val['subcategory_duration'];?> mins</small></p>
                                    </div>

                                    <div class="col-sm-6 col-md-6 col-12" style="padding: 10px 30px">
                                        <h5>
                                            <span>&#8369; <?=$val['subcategory_price'];?> </span>
                                            <a href="del_item.php?id=<?=$val['selected_id'];?>" onClick="del_item(<?=$val['selected_id'];?>)" ><span class="badge badge-danger">&times;</span></a>
                                        </h5>
                                    </div>
                                    
                                </div>
                                <?php
                                $cnt++;
                                $tot += $val['subcategory_price'];
                            }
                        }

                        ?>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10 alert alert-success" style="text-align: right;">
                                <h1>&#8369; <?=number_format($tot, 2);?></h1>
                                <?php if($cnt == 1){ ?>
                                    <small><?=$cnt;?> Service</small>
                                <?php }else{ ?>
                                    <small><?=$cnt;?> Services</small>
                                <?php } ?>
                                <br>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                        </div>
                    </div>
                
                </div>

            </div>
        </div>
    </div>
</section>

<!-- <div id="mobile_view" class="alert alert-info" style="position: fixed; padding: 10px 20px; width: 100vw; bottom: -20px; left: 0"></div> -->

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
        },10000)

    })
</script>
<script>
    function del_item(id){
        var confirm = window.confirm("Are you sure want to remove this item?");

        if(confirm){
            window.location.href = 'del_item.php?id='+id;
        }
        
    }
</script>
<script>
    $(document).ready(function(){
        // Triggered when any checkbox with class "checkbox-group" is changed
        $('.check-group').change(function(){
            // Array to store the checked values
            var checkedValues = [];

            // Loop through all checked checkboxes and push their values to the array
            $('.check-group:checked').each(function(){
                checkedValues.push($(this).val());
            });

            $.ajax({
                type: 'POST',
                url: 'fetch01.php', // Replace with your server endpoint
                data: {data: checkedValues}, // Convert data to JSON string if needed
                success: function(response){
                  $('#selected_service').html(response);
                  $('#selected_service').show();
                }
            });

        });

    });
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

</html>
