<?php
$postdata = $_POST;

$notification_id= $postdata['notification_id'];
$member_id = $postdata['member_id'];
$branch_id = $postdata['branch_id'];
include_once 'includes/dbconnect.php';
$sql = mysqli_query($con,"UPDATE `transaction_notification` SET is_check_approve='2' where transaction_id='$notification_id'");  
//$sql1 = mysqli_query($con,"INSERT INTO `transaction_notification`(member_id,branch_id,is_payment_done)
//	VALUES('$member_id','$branch_id','1')");
//$sql = mysqli_query($con,"INSERT INTO `transaction_notification`(branch_id,member_id,is_payment_done)
	//VALUES('$branch_id','$member_id','1')"); 
if ($sql== TRUE) {
    echo json_encode(array("status"=>"success","message"=> "Rejected Succefully."), 200); exit;
} else {
   echo json_encode(array("status"=>"error","message"=> "Error")); exit;
}
$conn->close();

?>


