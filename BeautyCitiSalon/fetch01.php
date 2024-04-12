<?php 
session_start();
include_once "./connections/connect.php";
$conn = $lib->openConnection();

if(isset($_POST['data'])){
    $datas = $_POST['data'];
    $cnt = 0;
    $tot = 0;
    $arr1 = [];
    $arr2 = [];
    foreach($datas as $data){
        $stmt = $conn->prepare("SELECT * FROM tbl_subcategory WHERE subcategory_id = ?");
        $stmt->execute([$data]);

        while($row = $stmt->fetch()){

        ?>
        <div class="row">
            <div class="col-md-6" style="padding: 10px 30px">
                <p style="font-size: 16px; font-weight: 700"><?=$row['subcategory_name'];?><br><small><?=$row['subcategory_duration'];?> mins</small></p>
            </div>

            <div class="col-md-6" style="text-align: right; padding: 10px 30px">
                <h5><span style="margin-right: 20px">&#8369; <?=$row['subcategory_price'];?> </span></h5>
            </div>
        </div>
        <?php
            $tot += $row['subcategory_price'];
            array_push($arr2, $row['subcategory_categoryid']);
        }
        $cnt += 1;
        array_push($arr1, $data);
        $stringFromArray1 = implode(',', $arr1);
        $stringFromArray2 = implode(',', $arr2);
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
            <?php if(isset($_SESSION['bpmsuid'])){ ?>
            <center><a href="services_2.php?data1=<?=$stringFromArray1;?>&data2=<?=$stringFromArray2;?>" class="btn btn-danger">Proceed</a></center>
            <?php }else{ ?>
                
            <center><a href="#" data-toggle="modal" data-target="#exampleModal" class="btn btn-danger">Proceed</a></center>
            <?php } ?>
        </div>
        <div class="col-md-1"></div>
    </div>
    <?php
}else{
    echo "";
}


?>