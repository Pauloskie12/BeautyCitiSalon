<?php
header('Content-Type: application/json');
include_once "./config.php";
$con = $lib->openConnection();

function rndRGBColorCode()
{
    $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
    $color = '#' . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)];
    return $color;
}

$sql = "
        SELECT
            COUNT(*) As Total_client,
            category_name As Services
        FROM
            `tbl_category` as cat
        INNER JOIN
            tbl_subcategory as sub
        ON
            cat.category_id = sub.subcategory_categoryid
        GROUP BY
            cat.category_id
        ";

$stmt = $connect->prepare($sql);
$stmt->execute();

$array = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($array) {
    $output = array();
    foreach ($array as $key => $value) {
        $output[$key] = array(
            "label" => $array[$key]["Services"],
            "data" => $array[$key]["Total_Client"],
            'backgroundColor' => rndRGBColorCode()
        );
    }
}

echo json_encode($output);


?>