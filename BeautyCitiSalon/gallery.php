<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include_once "./connections/connect.php";
$conn = $lib->openConnection();
error_reporting(0);

if(isset($_POST['submit']))
  {
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $phone=$_POST['phone'];
    $email=$_POST['email'];
    $message=$_POST['message'];
     
    $query=mysqli_query($con, "insert into tblcontact(FirstName,LastName,Phone,Email,Message) value('$fname','$lname','$phone','$email','$message')");
    if ($query) {
   echo "<script>alert('Your message was sent successfully!.');</script>";
echo "<script>window.location.href ='contact.php'</script>";
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


    <title>BeautiCiti Salon | Gallery</title>

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <style>
                

        /*--------------------------------------------------------------
        # Portfolio
        --------------------------------------------------------------*/
        .portfolio .portfolio-item {
        margin-bottom: 30px;
        }

        .portfolio #portfolio-flters {
        padding: 0;
        margin: 0 auto 20px auto;
        list-style: none;
        text-align: center;
        }

        .portfolio #portfolio-flters li {
        cursor: pointer;
        display: inline-block;
        padding: 8px 15px 10px 15px;
        font-size: 14px;
        font-weight: 600;
        line-height: 1;
        text-transform: uppercase;
        color: #444444;
        margin-bottom: 5px;
        transition: all 0.3s ease-in-out;
        border-radius: 3px;
        }

        .portfolio #portfolio-flters li:hover,
        .portfolio #portfolio-flters li.filter-active {
        color: #fff;
        background: #d9232d;
        }

        .portfolio #portfolio-flters li:last-child {
        margin-right: 0;
        }

        .portfolio .portfolio-wrap {
        transition: 0.3s;
        position: relative;
        overflow: hidden;
        z-index: 1;
        background: rgba(85, 98, 112, 0.6);
        }

        .portfolio .portfolio-wrap::before {
        content: "";
        background: rgba(85, 98, 112, 0.6);
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        transition: all ease-in-out 0.3s;
        z-index: 2;
        opacity: 0;
        }

        .portfolio .portfolio-wrap img {
        transition: all ease-in-out 0.3s;
        }

        .portfolio .portfolio-wrap .portfolio-info {
        opacity: 0;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 3;
        transition: all ease-in-out 0.3s;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        align-items: flex-start;
        padding: 20px;
        }

        .portfolio .portfolio-wrap .portfolio-info h4 {
        font-size: 20px;
        color: #fff;
        font-weight: 600;
        }

        .portfolio .portfolio-wrap .portfolio-info p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 14px;
        text-transform: uppercase;
        padding: 0;
        margin: 0;
        font-style: italic;
        }

        .portfolio .portfolio-wrap .portfolio-links {
        text-align: center;
        z-index: 4;
        }

        .portfolio .portfolio-wrap .portfolio-links a {
        color: rgba(255, 255, 255, 0.6);
        margin: 0 5px 0 0;
        font-size: 28px;
        display: inline-block;
        transition: 0.3s;
        }

        .portfolio .portfolio-wrap .portfolio-links a:hover {
        color: white;
        }

        .portfolio .portfolio-wrap:hover::before {
        opacity: 1;
        }

        .portfolio .portfolio-wrap:hover img {
        transform: scale(1.2);
        }

        .portfolio .portfolio-wrap:hover .portfolio-info {
        opacity: 1;
        }

        /*--------------------------------------------------------------
        # Portfolio Details
        --------------------------------------------------------------*/
        .portfolio-details {
        padding-top: 40px;
        }

        .portfolio-details .portfolio-details-slider img {
        width: 100%;
        }

        .portfolio-details .portfolio-details-slider .swiper-pagination {
        margin-top: 20px;
        position: relative;
        }

        .portfolio-details .portfolio-details-slider .swiper-pagination .swiper-pagination-bullet {
        width: 12px;
        height: 12px;
        background-color: #fff;
        opacity: 1;
        border: 1px solid #d9232d;
        }

        .portfolio-details .portfolio-details-slider .swiper-pagination .swiper-pagination-bullet-active {
        background-color: #d9232d;
        }

        .portfolio-details .portfolio-info {
        padding: 30px;
        box-shadow: 0px 0 30px rgba(85, 98, 112, 0.08);
        }

        .portfolio-details .portfolio-info h3 {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
        }

        .portfolio-details .portfolio-info ul {
        list-style: none;
        padding: 0;
        font-size: 15px;
        }

        .portfolio-details .portfolio-info ul li+li {
        margin-top: 10px;
        }

        .portfolio-details .portfolio-description {
        padding-top: 30px;
        }

        .portfolio-details .portfolio-description h2 {
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 20px;
        }

        .portfolio-details .portfolio-description p {
        padding: 0;
        }
    </style>
  </head>
  <body id="home">
<?php include_once('includes/header.php');?>


<!-- breadcrumbs -->
<section class="w3l-inner-banner-main">
    <div class="about-inner contact ">
        <div class="container">   
            <div class="main-titles-head text-center">
            <h3 class="header-name ">Gallery</h3>
        </div>
</div>
</div>
<div class="breadcrumbs-sub">
<div class="container">   
<ul class="breadcrumbs-custom-path">
    <li class="right-side propClone"><a href="index.php" class="text-danger">Home <span class="fa fa-angle-right" aria-hidden="true"></span></a> <p></li>
    <li class="active ">Gallery</li>
</ul>
</div>
</div>
    </div>
</section>
<!-- breadcrumbs //-->
<section class="w3l-contact-info-main" id="contact">
    <div class="contact-sec	">
        <div class="container">

    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio">
      <div class="container">

        <div class="row">
          <div class="col-lg-12 d-flex justify-content-center">
            <ul id="portfolio-flters">
              <li data-filter="*" class="filter-active">All</li>

              <?php 

                $stmt = $conn->prepare("SELECT * FROM tbl_category");
                $stmt->execute();

                while($row = $stmt->fetch()){
              
              ?>
                <li data-filter=".filter-<?=$row['category_id'];?>"><?=$row['category_name'];?></li>
              <?php } ?>

            </ul>
          </div>
        </div>

        <div class="row portfolio-container">

            <?php 

            $stmt2 = $conn->prepare("SELECT * FROM tbl_subcategory ts JOIN tbl_category tc ON ts.subcategory_categoryid = tc.category_id");
            $stmt2->execute();

            while($row = $stmt2->fetch()){

            ?>

          <div class="col-lg-4 col-md-6 portfolio-item filter-<?=$row['subcategory_categoryid'];?>">
            <div class="portfolio-wrap">
              <img src="assets/images/<?=$row['subcategory_image'];?>" style="width: 100%" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4><?=$row['subcategory_name'];?></h4>
                <p><?=$row['category_name'];?></p>
                <div class="portfolio-links">
                  <a href="assets/images/<?=$row['subcategory_image'];?>" style="width: 100%" data-gallery="portfolioGallery" class="portfolio-lightbox" title="<?=$row['subcategory_name'];?>"><i class="bx bx-plus"></i></a>
                  <!-- <a href="portfolio-details.html" class="portfolio-details-lightbox" data-glightbox="type: external" title="Portfolio Details"><i class="bx bx-link"></i></a> -->
                </div>
              </div>
            </div>
          </div>

          <?php } ?>

        </div>

      </div>
    </section><!-- End Portfolio Section -->
   
        </div>
    </div>
</section>


<?php include_once('includes/footer.php');?>
<!-- move top -->
<button onclick="topFunction()" id="movetop" title="Go to top">
	<span class="fa fa-long-arrow-up"></span>
</button>

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
<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
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
(function() {
  "use strict";

  /**
   * Easy selector helper function
   */
  const select = (el, all = false) => {
    el = el.trim()
    if (all) {
      return [...document.querySelectorAll(el)]
    } else {
      return document.querySelector(el)
    }
  }

  /**
   * Easy event listener function
   */
  const on = (type, el, listener, all = false) => {
    let selectEl = select(el, all)
    if (selectEl) {
      if (all) {
        selectEl.forEach(e => e.addEventListener(type, listener))
      } else {
        selectEl.addEventListener(type, listener)
      }
    }
  }

  /**
   * Easy on scroll event listener 
   */
  const onscroll = (el, listener) => {
    el.addEventListener('scroll', listener)
  }

  /**
   * Toggle .header-scrolled class to #header when page is scrolled
   */
  let selectHeader = select('#header')
  if (selectHeader) {
    const headerScrolled = () => {
      if (window.scrollY > 100) {
        selectHeader.classList.add('header-scrolled')
      } else {
        selectHeader.classList.remove('header-scrolled')
      }
    }
    window.addEventListener('load', headerScrolled)
    onscroll(document, headerScrolled)
  }

  /**
   * Back to top button
   */
  let backtotop = select('.back-to-top')
  if (backtotop) {
    const toggleBacktotop = () => {
      if (window.scrollY > 100) {
        backtotop.classList.add('active')
      } else {
        backtotop.classList.remove('active')
      }
    }
    window.addEventListener('load', toggleBacktotop)
    onscroll(document, toggleBacktotop)
  }

  /**
   * Mobile nav toggle
   */
  on('click', '.mobile-nav-toggle', function(e) {
    select('#navbar').classList.toggle('navbar-mobile')
    this.classList.toggle('bi-list')
    this.classList.toggle('bi-x')
  })

  /**
   * Mobile nav dropdowns activate
   */
  on('click', '.navbar .dropdown > a', function(e) {
    if (select('#navbar').classList.contains('navbar-mobile')) {
      e.preventDefault()
      this.nextElementSibling.classList.toggle('dropdown-active')
    }
  }, true)

  /**
   * Hero carousel indicators
   */
  let heroCarouselIndicators = select("#hero-carousel-indicators")
  let heroCarouselItems = select('#heroCarousel .carousel-item', true)

  heroCarouselItems.forEach((item, index) => {
    (index === 0) ?
    heroCarouselIndicators.innerHTML += "<li data-bs-target='#heroCarousel' data-bs-slide-to='" + index + "' class='active'></li>":
      heroCarouselIndicators.innerHTML += "<li data-bs-target='#heroCarousel' data-bs-slide-to='" + index + "'></li>"
  });

  /**
   * Porfolio isotope and filter
   */
  window.addEventListener('load', () => {
    let portfolioContainer = select('.portfolio-container');
    if (portfolioContainer) {
      let portfolioIsotope = new Isotope(portfolioContainer, {
        itemSelector: '.portfolio-item'
      });

      let portfolioFilters = select('#portfolio-flters li', true);

      on('click', '#portfolio-flters li', function(e) {
        e.preventDefault();
        portfolioFilters.forEach(function(el) {
          el.classList.remove('filter-active');
        });
        this.classList.add('filter-active');

        portfolioIsotope.arrange({
          filter: this.getAttribute('data-filter')
        });
      }, true);
    }

  }); 

  /**
   * Initiate portfolio lightbox 
   */
  const portfolioLightbox = GLightbox({
    selector: '.portfolio-lightbox'
  });

  /**
   * Portfolio details slider
   */
  new Swiper('.portfolio-details-slider', {
    speed: 400,
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false
    },
    pagination: {
      el: '.swiper-pagination',
      type: 'bullets',
      clickable: true
    }
  });

  /**
   * Initiate portfolio details lightbox 
   */
  const portfolioDetailsLightbox = GLightbox({
    selector: '.portfolio-details-lightbox',
    width: '90%',
    height: '90vh'
  });

  /**
   * Skills animation
   */
  let skilsContent = select('.skills-content');
  if (skilsContent) {
    new Waypoint({
      element: skilsContent,
      offset: '80%',
      handler: function(direction) {
        let progress = select('.progress .progress-bar', true);
        progress.forEach((el) => {
          el.style.width = el.getAttribute('aria-valuenow') + '%'
        });
      }
    })
  }

})()
</script>
<!-- /move top -->
</body>

</html>