<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!doctype html>
<html lang="en">
  <head>
    
    <title>BeautyCiti Salon | About us Page</title>

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
        <div class="about-inner about ">
            <div class="container">   
                <div class="main-titles-head text-center">
                <h3 class="header-name ">About Us</h3>
            </div>
</div>
   </div>
   <div class="breadcrumbs-sub">
   <div class="container">   
    <ul class="breadcrumbs-custom-path">
        <li class="right-side propClone"><a href="index.php" class="text-danger">Home <span class="fa fa-angle-right" aria-hidden="true"></span></a> <p></li>
        <li class="active ">About</li>
    </ul>
</div>
</div>
        </div>
    </section>
<!-- breadcrumbs //-->
<section class="w3l-content-with-photo-4"  id="about">
    <div class="content-with-photo4-block ">
        <div class="container">
            <div class="cwp4-two row">
            <div class="cwp4-image col-xl-6">
                <h1><b>Welcome</b></h1>
                <br>
                <div class="card" style="font-size: 24px">
                <img src="assets/images/photo1.jpg" alt="product" class="img-responsive about-me">
                    <div class="card-body">
                        <p class="card-text">Welcome to our salon! We are thrilled to
                            have you as our guest today. Our team is
                            dedicated to providing you with a top-notch
                            salon experience, and we are committed to
                            making sure you leave feeling refreshed,
                            renewed, and confident.</p>
                    </div>
                </div>
            </div>
            <div class="cwp4-text col-xl-6 ">
                <br>
                <div class="card" style="font-size: 24px">
                    <div class="card-body">
                        <p class="card-text">
                            From the moment you step through our doors, we
                            want you to feel comfortable and at ease. Our
                            friendly staff is here to greet you and answer any
                            questions you may have about our services, products,
                            or policies. We believe that communication is key to a
                            successful salon experience, so please don't hesitate
                            to speak up and let us know how we can best serve
                            you.
                            Whether you're here for a haircut, color treatment,
                            facial, or any other service, we use only the highest
                            quality products and techniques to help you achieve
                            your desired look. Our goal is to create a personalized
                            experience that is tailored to your unique needs and
                            preferences.
                            Thank you for choosing our salon, and we look
                            forward to providing you with an exceptional salon
                            experience that exceeds your expectations!
                        </p>
                    </div>
                </div>

            </div>
            </div>
        </div>
    </div>

</section>

<section class="w3l-recent-work">
	<div class="jst-two-col">
		<div class="container">
<div class="row">
		<div class="my-bio col-lg-6">

	<div class="hair-make">

		<h1><b>The Founder, Edgar Calinacion</b></h1>
		<p class="para mt-2">
        <div class="card" style="font-size: 24px">
            <div class="card-body">
                <p class="card-text">
                    Hello, I'm the owner of a salon with over 10
                    years of experience in the beauty industry.
                    I'm passionate about providing exceptional
                    services to my clients and creating a warm,
                    welcoming atmosphere in my salon. My
                    team and I are dedicated to staying up-todate with the latest trends and techniques to
                    ensure our clients leave feeling confident
                    and refreshed.
                    A good salon provides high-quality services that
                    exceed customers' expectations. The key factors
                    that contribute to the quality of services at a
                    salon include trained and skilled staff, quality
                    products, attention to detail, good customer
                    service, and a relaxing atmosphere. The staff at a
                    salon should be knowledgeable and experienced
                    in their respective fields, and should have a
                    passion for providing the best possible service to
                    their clients.
                    Additionally, using high-quality
                    products and equipment ensures that customers
                    receive the best possible results.
                </p>
            </div>
        </div>
        </p>

	</div>
	
	
	</div>
	<div class="col-lg-6 ">
		<img src="assets/images/admin.jpg" alt="product" class="img-responsive about-me" >
        <div class="card" style="font-size: 24px">
            <div class="card-body">
                <p class="card-text">
                    Attention to
                    detail, such as maintaining a clean and
                    welcoming environment, ensures that customers
                    feel valued and cared for.
                    Good customer service,
                    such aslistening to customers' needs and offering
                    advice, is also crucial. Lastly, a relaxing
                    atmosphere helps customers feel at ease and
                    enjoy their treatments.
                </p>
            </div>
        </div>
	</div>

</div>
		</div>
	</div>
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

</html>