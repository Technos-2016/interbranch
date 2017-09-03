<?php
include_once 'includes/dbconnect.php';
$user_role = $_SESSION['usr_role'];
$postdata = $_POST;
if($postdata['is_read'] == 'on')
{
	
$is_read = $postdata['is_read'];
if($is_read== 'on')
{
$is_read = '2';
}
$notification_id = $postdata['notification_Id'];
$sql = "UPDATE `transaction_notification` SET is_notification_read='$is_read' where transaction_id='$notification_id' ";	
if ($con->query($sql) === TRUE) {
    echo json_encode(array("status"=>"success","message"=> "Notification read by $user_role successfully"), 200); exit;
} else {
   echo json_encode(array("status"=>"error","message"=> "Error")); exit;
}
$conn->close();
}
?>


