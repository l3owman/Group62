<?php

include('config.php');
$query = 'SELECT user_id, postcode FROM User;';
$postcode = mysqli_query($conn, $query);
$postcode_data = array();
while($row =mysqli_fetch_assoc($postcode))
{
  $postcode_data[] = $row;
}

$postcodeArr = array();
foreach($postcode_data as $key => $val){
  $webPostcode = $val['postcode'];
  $filepost = 'http://api.postcodes.io/postcodes/'.$webPostcode;
  $file_headers = get_headers($filepost);

  if(strpos($file_headers[0], '404') !== false){
  } else {
    $locationData = file_get_contents('http://api.postcodes.io/postcodes/'.$webPostcode);
    $jsonLocation = json_decode($locationData, true);
    $jsonLocation = $jsonLocation['result'];
    $postcodeArr[$jsonLocation['admin_district']][] = $jsonLocation['postcode'];
  }
}

$salesArray = array(
    "01" => 0,
    "02" => 0,
    "03" => 0,
    "04" => 0,
    "05" => 0,
    "06" => 0,
    "07" => 0,
    "08" => 0,
    "09" => 0,
    "10" => 0,
    "11" => 0,
    "12" => 0,

);

$newArr = array();
if (isset($_SESSION['location'])) {
  $startLoaction = $_SESSION["location"];
  $newArr = $postcodeArr[$startLoaction];
}else {
  $startLoaction = 'Unset';
}


$result = array();
if($_SESSION['location'] != 'Unset') {
  foreach ($newArr as $postLoop){
    $sqlUserid = "SELECT user_id FROM User WHERE postcode = '$postLoop';";
    $tester = mysqli_query($conn, $sqlUserid);
    $tester = mysqli_fetch_array($tester);
    array_push($result, $tester['user_id']);
  }
}



foreach ($result as $u_id) {
  $sql = "SELECT DATE_FORMAT(end_time, '%Y-%m') AS Month, SUM(bid_highest)
            FROM Listing
            WHERE status_id = 3 AND seller_id = '$u_id'
            GROUP BY DATE_FORMAT(end_time, '%Y-%m')
            ORDER BY Month;";

  $finalSql = mysqli_query($conn, $sql);

  if (mysqli_num_rows($finalSql)!=0) {
    $final_loc_data = array();

    while ($row = mysqli_fetch_assoc($finalSql)) {
      $location_new_data[] = $row;
    }

    $jsonLoc = json_encode($location_new_data, JSON_PRETTY_PRINT);
    $file_name = date('d-m-y') . '.json';
    file_put_contents($file_name, $jsonLoc);
    $decoded_array = json_decode($jsonLoc, true);
  }
}

if (mysqli_num_rows($finalSql)!=0) {

  foreach ($decoded_array as $arr) {
    if (date("Y-m", strtotime($arr['Month'])) <= date('Y-m') && date("Y-m", strtotime($arr['Month'])) >= date("Y-m", strtotime("-1 year"))) {

      $changeSum = $arr['SUM(bid_highest)'];
      $salesArray[substr($arr['Month'], -2)] += (int)$changeSum;
    }
  }
}


?>
