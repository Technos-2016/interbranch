<?php

session_start();

include_once 'includes/dbconnect.php';

if (isset($_SESSION['usr_id']) == "") {

    header("Location: login.php");
}

$branch_id = $_SESSION['branch_id'];


$sql = "SELECT * from admin";
$result = mysqli_query($con, $sql);
$messagecount = sizeof($result);

if ($messagecount > 0) {
    while ($row = mysqli_fetch_array($result)) {
        if($row['is_active']=='1'){
        echo $row['message'];
        }
        else{
            echo "No New Notifcation Today";
        }
    }
}

?>