<?php
  include('config.php');
  $sql = 'SELECT DATE_FORMAT(end_time, "%Y-%m") AS Month, SUM(bid_highest)
    FROM Listing
    WHERE status_id = 3
    GROUP BY DATE_FORMAT(end_time, "%Y-%m") 
    ORDER BY Month;' ;

  $result = mysqli_query($conn, $sql);
  $transaction_data = array();

  while($row =mysqli_fetch_assoc($result))
    {$transaction_data[] = $row;}

  $json = json_encode($transaction_data, JSON_PRETTY_PRINT);
  $file_name = date('d-m-y') . '.json';
  file_put_contents($file_name, $json);
  $decoded_array = json_decode($json, true);
  $sales_array = array(
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

  if (isset($_SESSION['year'])) {
    $start_year = $_SESSION["year"];
  }else {
    $start_year = date('Y');
  }

  foreach ($decoded_array as $arr) {
    if (date("Y-m",strtotime($arr['Month']))>= date('Y-m',strtotime($start_year.'-01' ) ) && date("Y-m",strtotime($arr['Month']))<= date('Y-m', strtotime('+1 year', strtotime($start_year.'-01') ))){
      $sales_array[substr($arr['Month'], -2)] = $arr['SUM(bid_highest)'] ;
    }
  }
?>
