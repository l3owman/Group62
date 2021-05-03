<?php
session_start();
include('config.php');

$sql = "UPDATE Listing SET status_id = 1 WHERE listing_id =
 (SELECT listing_id FROM Complaints WHERE complaint_id = 
 ( SELECT Min(complaint_id) FROM Complaints WHERE active_comp = 0));";


if (mysqli_query($conn, $sql)) {
    echo "it worked";
    header('Location: admin.php');
} else {
    echo "Error Removing Listing : " . mysqli_error($conn);
}


?>
