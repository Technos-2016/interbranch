<?php
include_once 'includes/dbconnect.php';
$postdata = $_POST;
$notification_id = $postdata['notification_Id']; 
$branch_id = $postdata['branch_Id']; 

 
if($postdata['is_approve'] == 'on')
{
$is_approved = $postdata['is_approve'];
if($is_approved== 'on')
{
$is_approved = '1';
}


$sql = "UPDATE `transaction_notification_depositor` SET is_notification_read='$is_approved',is_approve='1',deposite_type='Approved' where transaction_id='$notification_id' ";


if ($con->query($sql) === TRUE) {
    echo json_encode(array("status"=>"success","message"=> "Successfully Deposited"), 200); exit;
} else {
   echo json_encode(array("status"=>"error","message"=> "Error")); exit;
}
$conn->close();
}
?>


