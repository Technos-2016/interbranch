<?php
session_start();
include_once 'includes/dbconnect.php';

//$sql="UPDATE comments SET status=1 WHERE status=0";	
//$result=mysqli_query($conn, $sql);
$name = $_SESSION['usr_name'];
//echo $sql="select * from member_detail where member_name='$name'";
//$result=mysqli_query($con, $sql);

$sql="select * from transaction_notification where is_check_approve='1'"; 
$result=mysqli_query($con, $sql);
$count=mysqli_num_rows($result);

if(!empty($count)) {
	print $count;
}


?>