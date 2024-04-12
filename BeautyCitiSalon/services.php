
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include_once "./connections/connect.php";
$conn = $lib->openConnection();
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
      .container #checkmark {
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

<script src="assets/js/jquery-3.3.1.min.js"></script> <!-- Common jquery plugin -->
<!--bootstrap working-->
<script src="assets/js/bootstrap.min.js"></script>
<!-- //bootstrap working-->
<!-- disable body scroll which navbar is in active -->
<script>
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
$(function () {
  $('.navbar-toggler').click(function () {
    $('body').toggleClass('noscroll');
  })
});
</script>
<!-- disable body scroll which navbar is in active -->

<!-- breadcrumbs -->
<section class="w3l-inner-banner-main">
    <div class="about-inner services ">
        <div class="container">   
            <div class="main-titles-head text-center">
            <h3 class="header-name ">
                Our Service
            </h3>
        </div>
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
    </div>
</section>
<!-- breadcrumbs //-->
<section class="w3l-recent-work-hobbies" > 
    <div class="recent-work ">
        <div class="container">
            <div class="row">

            
              <div class="col-md-2" style="background: #f2f2f2">
                <div style="position: sticky; top:20px; left: 0">
                <h5>All Categories</h5><hr>
                <?php
                    $ret= $conn->prepare("SELECT * FROM tbl_category");
                    $ret->execute();
                    $cnt=1;
                    if($ret->rowCount() > 0){
                    while ($row=$ret->fetch()) {

                  ?><ul style="list-style-type: roman">
                      <li><a href="#<?=$row['category_id'];?>" style="font-size: 16px" class="cat-link">* <?=$row['category_name'];?></a><br></li>
                    </ul>
                  <?php $cnt=$cnt+1; } }?>
                  </div>
                  <br><br>
              </div>

              <div class="col-md-6 ">

                <?php

                $stmt = $conn->prepare("SELECT * FROM tbl_category");
                $stmt->execute();

                while($val = $stmt->fetch()){

                ?>


                  <h3 id="<?=$val['category_id'];?>"><?=$val['category_name'];?></h3><hr>
                  <?php
                    $ret= $conn->prepare("SELECT * FROM tbl_subcategory WHERE subcategory_categoryid = ?");
                    $ret->execute([$val['category_id']]);
                    $cnt=1;
                    if($ret->rowCount() > 0){
                    while ($row=$ret->fetch()) {

                  ?>
                  <div class="card">
                  <div class="card-body">
                  <div class="row">
                      <div class="col-md-6">

                        <label class="container"><?=$row['subcategory_name'];?>
                          <input type="checkbox" class="check-group" id="checkmark" value="<?=$row['subcategory_id'];?>">
                          <span class="checkmark"></span>
                        </label>
                        <small style="padding-left: 30px"><?=$row['subcategory_duration'];?> mins</small>
                      </div>
                      <div class="col-md-3" style="text-align: right">
                        <img src="./assets/images/<?=$row['subcategory_image'];?>" width="100" height="100">
                      </div>
                      <div class="col-md-3" style="text-align: right">
                        <b>&#8369; <?=number_format($row['subcategory_price'],2);?></b>
                      </div>
                  </div>
                  </div>
                  </div>
                  <br>
                  <?php $cnt=$cnt+1; } }?>

                  <?php } ?>

              </div>

              <div class="col-md-4" style="background: #f3f3f3">

                <div class="card" style="position: sticky; top:20px; left: 0">
                    <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <center><h5><b>Selected Sevices</b></h5></center><hr>
                      </div>
                      <div id="selected_service" style="width: 100%;"></div>
                    </div>
                    </div>
                </div>

              </div>

            </div>
        </div>
    </div>
</section>

<!-- <div id="mobile_view" class="alert alert-info" style="position: fixed; padding: 10px 20px; width: 100vw; bottom: -20px; left: 0"></div> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
