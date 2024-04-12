<?php
header('Content-Type: application/json');
require_once "./config.php";

function rndRGBColorCode()
{
    $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
    $color = '#' . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)];
    return $color;
}

$sql = "
        SELECT 
            COUNT(*) AS Total_Client,
            booking_status AS Status
        FROM
            tbl_booking
        GROUP BY
            booking_status
        ";

$stmt = $connect->prepare($sql);
$stmt->execute();

$array = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($array) {
    $output = array();
    foreach ($array as $key => $value) {
        $output[$key] = array(
            "label" => $array[$key]["Status"],
            "data" => $array[$key]["Total_Client"],
            'backgroundColor' => rndRGBColorCode()
        );
    }
} else {
    echo '<option value="">No Data</option>';
}

echo json_encode($output);


?>