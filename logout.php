

<?php

session_start();
if (isset($_SESSION['usr_id']) == "") {

    header("Location: login.php");
    exit;
}
include_once 'includes/dbconnect.php';
$id = $_SESSION['usr_id'];
$mysqli = "UPDATE users SET live_status='0' WHERE id='$id'";
if (mysqli_query($con, $mysqli)) {
    session_unset();
    session_destroy();
    header("Location: login.php");
} else
    echo "Something went wrong!";
//session_destroy();
//$_SESSION = array();
//header("location: login.php");
?>
