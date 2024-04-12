<?php
include_once "../connections/connect.php";
$conn = $lib->openConnection();
$check_user = $conn->prepare("SELECT * FROM tbl_users WHERE users_id = ?");
$check_user->execute([$_SESSION['bpmsaid']]);

$user = $check_user->fetch();
$staff_id = $user['users_staffid'];

?>
  <div class=" sidebar" role="navigation">
      <div class="navbar-collapse">
        <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
          <ul class="nav" id="side-menu">

            <li>
              <a href="dashboard.php"><i class="fa fa-home nav_icon"></i>Dashboard</a>
            </li>

            <?php if($user['type'] == 0){ ?>

                <!-- SERVICES -->
                <li>
                  <a href="manage-services.php"><i class="fa fa-cogs nav_icon"></i>Services<span class="fa arrow"></span> </a>
                  <ul class="nav nav-second-level collapse">
                    <li>
                      <a href="manage-services.php">Manage Category</a>
                    </li>
                    <li>
                      <a href="manage-services2.php">Manage Subcategory</a>
                    </li>
                  </ul>
                </li>
              
                <!-- BOOKINGS -->
                <li>
                  <a href="all-booking.php"><i class="fa fa-check-square-o nav_icon"></i>Booking<span class="fa arrow"></span></a>
                  <ul class="nav nav-second-level collapse">
                    <li>
                      <a href="all-booking.php">All Bookings</a>
                    </li>
                    <li>
                      <a href="today-booking.php">Today's List</a>
                    </li>
                    <li>
                      <a href="new-booking.php">New Book</a>
                    </li>
                    <li>
                      <a href="accepted-booking.php">Accepted List</a>
                    </li>
                    <li>
                      <a href="rejected-booking.php">Rejected List</a>
                    </li>
                    <li>
                      <a href="paid-booking.php">Paid List</a>
                    </li>
                  </ul>
                  <!-- //nav-second-level -->
                </li>
              
                <!-- STAFF LISTS -->
                <li>
                  <a href="staff-list.php" class="chart-nav"><i class="fa fa-users nav_icon"></i>Staff List</a>
                </li>

                <!-- JOB LISTS -->
                <li>
                  <a href="job-list.php" class="chart-nav"><i class="fa fa-users nav_icon"></i>Job List</a>
                </li>

                <!-- CUSTOMER LISTS -->
                <li>
                  <a href="customer-list.php" class="chart-nav"><i class="fa fa-users nav_icon"></i>Customer List</a>
                </li>

                <!-- REPORTS -->
                <li>
                  <a href="sales.php"><i class="fa fa-check-square-o nav_icon"></i>Reports<span class="fa arrow"></span></a>
                  <ul class="nav nav-second-level collapse">
                    <!--<li><a href="bwdates-reports-ds.php"> B/w dates</a></li>-->
                    <li><a href="sales.php"> Sales </a></li>
                  </ul>
                  <!-- //nav-second-level -->
                </li>

                <!-- PAGES -->
                <!-- <li class="">
                  <a href="about-us.php"><i class="fa fa-book nav_icon"></i>Pages <span class="fa arrow"></span></a>
                  <ul class="nav nav-second-level collapse">
                    <li>
                      <a href="about-us.php">About Us</a>
                    </li>
                    <li>
                      <a href="contact-us.php">Contact Us</a>
                    </li>
                  </ul>
                </li> -->
            <?php } ?>
          
            <?php if($user['type'] == 1){ ?>

                <!-- BOOKINGS -->
                <li>
                  <a href="all-booking.php"><i class="fa fa-check-square-o nav_icon"></i>Booking<span class="fa arrow"></span></a>
                  <ul class="nav nav-second-level collapse">
                    <li>
                      <a href="all-booking.php">All Bookings</a>
                    </li>
                    <li>
                      <a href="today-booking.php">Today's List</a>
                    </li>
                    <li>
                      <a href="new-booking.php">New Book</a>
                    </li>
                    <li>
                      <a href="accepted-booking.php">Accepted List</a>
                    </li>
                    <li>
                      <a href="rejected-booking.php">Rejected List</a>
                    </li>
                    <li>
                      <a href="paid-booking.php">Paid List</a>
                    </li>
                  </ul>
                  <!-- //nav-second-level -->
                </li>

                <!-- REPORTS -->
                <li>
                  <a href="sales.php"><i class="fa fa-check-square-o nav_icon"></i>Reports<span class="fa arrow"></span></a>
                  <ul class="nav nav-second-level collapse">
                    <!--<li><a href="bwdates-reports-ds.php"> B/w dates</a></li>-->
                    
                    <li><a href="sales.php"> Sales </a></li>
                  </ul>
                  <!-- //nav-second-level -->
                </li>

            <?php } ?>

          </ul>
          <div class="clearfix"> </div>
          <!-- //sidebar-collapse -->
        </nav>
      </div>
    </div>