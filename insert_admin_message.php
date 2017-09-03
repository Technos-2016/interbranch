<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

$branch_id = $_SESSION['branch_id'];

if(isset($_SESSION['usr_id'])=="") {
	header("Location: login.php");
}
include_once 'includes/dbconnect.php';
//$postdata = $_POST;
$user_role = $_SESSION['usr_role'];
$message = $_POST['message'];
$date = date('Y-m-d');
$sql = mysqli_query($con,"INSERT INTO `admin` (message,date) VALUES('$message','$date')"); 

if( $sql === TRUE ){
    echo "<script>alert('Message Successfully Posted');window.location='message.php'; </script>";
               
    
    exit; 
} else {
   echo "<script>alert('Error Processing Message');window.location='admin.php'; </script>";
               exit; 
}
$con->close();
?>

