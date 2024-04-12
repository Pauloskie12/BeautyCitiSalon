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
            NAME.subcategory_name as Services,
            COUNT(*) AS Total_Client,
            NAME.subcategory_price AS Price
        FROM
            tbl_booking_services AS service
        LEFT JOIN 
            tbl_subcategory AS NAME
        ON
            service.booking_services_categoryID = NAME.subcategory_id
        LEFT JOIN 
            tbl_booking AS book
        ON
            service.booking_services_schedID = book.booking_id
        WHERE
            book.booking_status IN ('Approved', 'Walk In')
        AND 
            DATE(book.booking_date) <= CURRENT_DATE()
        GROUP BY 
            service.booking_services_categoryID
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
} else {
    echo '<option value="">No Data</option>';
}

echo json_encode($output);


?>