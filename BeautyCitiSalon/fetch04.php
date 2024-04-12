<?php 
include_once "./connections/connect.php";
$conn = $lib->openConnection();

$subcateg_id = $_POST['subcateg_id'];
$price = $_POST['price'];

 

 $date = $_POST['date'];
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
         
         
             ?>
             <div class="col-lg-6" style="background: dodgerblue; cursor: pointer; color: white; padding: 10px 20px; border-radius: 4px; border: 4px solid white">
                 <a href="./book-appointment.php?subcat=<?=$subcateg_id;?>&price=<?=$price;?>&date=<?=$date;?>&time=<?=$val['sched_id'];?>" style="text-decoration: none; color: white"><?=$val['sched_time'];?></a>
             </div>
             
             <?php
         

     }
 }



?>