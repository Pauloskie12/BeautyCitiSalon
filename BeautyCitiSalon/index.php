<?php 
include('includes/dbconnection.php');
 
     ?>
<!doctype html>
<html lang="en">
  <head>
   
    <title>BeautyCiti Salon | Home Page</title>

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <style>
          .w3l-hero-headers-9 .slide-one {
    background-image: url("./assets/images/Background.png"); }
  .w3l-hero-headers-9 .slide-two {
    background-image: url("./assets/images/Background.png"); }
  .w3l-hero-headers-9 .slide, .w3l-hero-headers-9 .css-slider {
    height: 700px; }
    
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
$(function () {
  $('.navbar-toggler').click(function () {
    $('body').toggleClass('noscroll');
  })
});
</script>
<!-- disable body scroll which navbar is in active -->

<div class="w3l-hero-headers-9">
  <div class="css-slider">
    <input id="slide-1" type="radio" name="slides" checked>
    <section class="slide slide-one">
      <div class="container">
        <div class="banner-text">
          <h4 style="font-family: cursive">Welcome To</h4>
          <h3>BeautyCiti<br><br> </h3>

          <a href="services.php" class="btn btn-danger top-margin">BOOK NOW</a>
        </div>
      </div>
      
    </section>
    <input id="slide-2" type="radio" name="slides">
    <section class="slide slide-two">
      <div class="container">
        <div class="banner-text">
          <h4 style="font-family: cursive">Welcome To</h4>
          <h3>BeautyCiti<br><br> </h3>

          <a href="services.php" class="btn btn-danger top-margin">BOOK NOW</a>
        </div>
      </div>
    </section>
    <header>
      <label for="slide-1" id="slide-1"></label>
      <label for="slide-2" id="slide-2"></label>
    </header>
  </div>
</div> 

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

</html>