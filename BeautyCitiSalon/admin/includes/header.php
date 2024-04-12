<?php
include_once "../connections/connect.php";
$conn = $lib->openConnection();
$check_user = $conn->prepare("SELECT * FROM tbl_users WHERE users_id = ?");
$check_user->execute([$_SESSION['bpmsaid']]);

$user = $check_user->fetch();
$staff_id = $user['users_staffid'];

?>
  <div class="sticky-header header-section ">
      <div class="header-left">
        <!--toggle button start-->
        <button id="showLeftPush"><i class="fa fa-bars"></i></button>
        <!--toggle button end-->
        <!--logo -->
        <div class="logo">
          <a href="index.html">
            <h1>BeautyCiti</h1>
            <span>AdminPanel</span>
          </a>
        </div>
        <!--//logo-->
       
       
        <div class="clearfix"> </div>
      </div>
      <div class="header-right">
        <div class="profile_details_left"><!--notifications of menu start -->
          <ul class="nofitications-dropdown">
            <?php
            $ret1=mysqli_query($con,"SELECT tbl_users.users_firstname,tbl_users.users_lastname,tblbook.tblbook_id AS bid, tblbook.tblbook_bookingnumber FROM tblbook 
            JOIN tbl_users on tbl_users.users_id=tblbook.tblbook_userid 
            WHERE tblbook.tblbook_status = ''
            GROUP BY tblbook.tblbook_bookingnumber");
            $num=mysqli_num_rows($ret1);

            ?>  
            <li class="dropdown head-dpdn">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell"></i><span class="badge blue"><?php echo $num;?></span></a>
              
              <ul class="dropdown-menu">
                <li>
                  <div class="notification_header">
                    <h3>You have <?php echo $num;?> new notification</h3>
                  </div>
                </li>
                <li>
            
                   <div class="notification_desc">
                     <?php if($num>0){
                    while($result=mysqli_fetch_array($ret1))
                    {
                    ?>
                 <a class="dropdown-item" href="view-booking.php?viewid=<?php echo $result['tblbook_bookingnumber'];?>">New booking received from <?php echo $result['users_firstname'];?> <?php echo $result['users_lastname'];?> (<?php echo $result['tblbook_bookingnumber'];?>)</a>
                 <hr />
<?php }} else {?>
    <a class="dropdown-item" href="all-booking.php">No New Booked Received</a>
        <?php } ?>
                           
                  </div>
                  <div class="clearfix"></div>  
                 </a></li>
                 
                
                 <li>
                  <div class="notification_bottom">
                    <a href="new-booking.php">See all notifications</a>
                  </div> 
                </li>
              </ul>
            </li> 
          
          </ul>
          <div class="clearfix"> </div>
        </div>
        <!--notification menu end -->
        <div class="profile_details">  
        <?php
          $adid=$_SESSION['bpmsaid'];
          $ret=mysqli_query($con,"SELECT users_firstname, type from tbl_users where users_id='$adid'");
          $row=mysqli_fetch_array($ret);
          $name=$row['users_firstname'];

          ?> 
          <ul>
            <li class="dropdown profile_details_drop">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <div class="profile_img"> 
                  <span class="prfil-img"><img src="images/admin.png" alt="" width="50" height="50"> </span> 
                  <div class="user-name">
                    <?php if($row['type'] == 0){ ?>
                    <p><?php echo $name; ?></p>
                    <span>Administrator</span>
                    <?php } ?>
                    
                    <?php if($row['type'] == 1){ ?>
                    <p><?php echo $name; ?></p>
                    <span>Staff</span>
                    <?php } ?>
                  </div>
                  <i class="fa fa-angle-down lnr"></i>
                  <i class="fa fa-angle-up lnr"></i>
                  <div class="clearfix"></div>  
                </div>  
              </a>
              <ul class="dropdown-menu drp-mnu">
                <li> <a href="change-password.php"><i class="fa fa-cog"></i> Settings</a> </li> 
                <li> <a href="admin-profile.php"><i class="fa fa-user"></i> Profile</a> </li> 
                <li> <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a> </li>
              </ul>
            </li>
          </ul>
        </div>  
        <div class="clearfix"> </div> 
      </div>
      <div class="clearfix"> </div> 
    </div>