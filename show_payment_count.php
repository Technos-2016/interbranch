<?php
session_start();
include_once 'includes/dbconnect.php';

$name = $_SESSION['usr_name'];
$branch_id = $_SESSION['branch_id'];
//$sql="select * from transaction_notification where branch_id='$branch_id' AND is_payment_done='0' AND is_check_approve ='1'"; 
$sql="select * from transaction_notification where branch_id='$branch_id' AND is_another_branch='1' AND is_payment_done='0' AND is_check_approve ='1' "; 

$result=mysqli_query($con, $sql);
$count=mysqli_num_rows($result);
if(!empty($count)) {
	print $count;
}


?>

