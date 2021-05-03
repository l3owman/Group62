<?php
session_start();
include('config.php');

$sql = "UPDATE Complaints SET active_comp = 1 WHERE active_comp = 0 ORDER BY complaint_id LIMIT 1;";


if (mysqli_query($conn, $sql)) {
    echo "it worked";
    header('Location: admin.php');
} else {
    echo "Error Removing Complaint : " . mysqli_error($conn);
}


?>