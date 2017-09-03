<?php
include_once 'includes/dbconnect.php';
$postdata = $_POST;
$destination_branch_id = $postdata['destination_branch_Id'];
$notification_id = $postdata['notification_Id']; 
$member_id = $postdata['member_id'];
$branch_id = $postdata['branch_Id']; 
$source_branch_id = $postdata['source_branch_Id'];
 
if($postdata['is_approve'] == 'on')
{
$is_approved = $postdata['is_approve'];
if($is_approved== 'on')
{
$is_approved = '1';
}



$sql =  mysqli_query($con,"UPDATE `transaction_notification` SET is_check_approve='$is_approved',deposite_type='approved' where transaction_id='$notification_id'");

if($destination_branch_id != $source_branch_id){
 
$sql = mysqli_query($con,"INSERT INTO `transaction_notification`(member_id,branch_id,is_check_submitted,is_check_approve,source_branch,destination_branch,deposite_type,is_another_branch) VALUES('$member_id','$source_branch_id','0','1','$source_branch_id','$destination_branch_id','approved','1')"); 
}	
if ($sql === TRUE) {
    echo json_encode(array("status"=>"success","message"=> "Check approved by branch successfully"), 200); exit;
} else {
   echo json_encode(array("status"=>"error","message"=> "Error")); exit;
}
$conn->close();
}
?>


