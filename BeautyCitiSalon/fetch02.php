<?php 
include_once "./connections/connect.php";
$conn = $lib->openConnection();

if(isset($_POST['data'])){
    $datas = $_POST['data'];
    $cnt = 0;
    $tot = 0;
    foreach($datas as $data){
        $stmt = $conn->prepare("SELECT * FROM tbl_subcategory WHERE subcategory_id = ?");
        $stmt->execute([$data]);

        while($row = $stmt->fetch()){ $tot += $row['subcategory_price']; }
        $cnt += 1;

    }
    
    ?> 
    <h1>&#8369; <?=number_format($tot, 2);?></h1>          
    <?php if($cnt == 1){ ?>
        <small><?=$cnt;?> Service</small>
    <?php }else{ ?>
        <small><?=$cnt;?> Services</small>
    <?php } ?>
    <button class="btn btn-lg btn-info" style="float: right; margin-top: -30px; margin-right: 20px">Book Now</button>
    <?php
}else{
    echo "";
}


?>