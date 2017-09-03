<?php
$postdata = $_POST;

session_start();


if(isset($_SESSION['usr_id'])=="") {
	header("Location: login.php");
}

include_once 'includes/dbconnect.php';

$reject_cheque_comment = $postdata['deposite_comment']; 
$notification_id = $postdata['deposite_notification_id'];
if($postdata['is_reject'] == 'on')
{
$is_reject = $postdata['is_reject'];
if($is_reject== 'on')
{
$is_reject = '1';
}
$sql =  mysqli_query($con,"UPDATE `transaction_notification_depositor` SET is_reject='$is_reject',comment='$reject_cheque_comment',is_notification_read ='1',deposite_type='Rejected' where transaction_id='$notification_id'"); 
if ($sql === TRUE) {
    echo json_encode(array("status"=>"success","message"=> "Deposit Rejected"), 200); exit;
} else {
   echo json_encode(array("status"=>"error","message"=> "Error")); exit;
}
$conn->close();
}

?>


