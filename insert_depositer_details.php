<?php
session_start();
$source_branch_id = $_SESSION['branch_id'];
include_once 'includes/dbconnect.php';
if(isset($_SESSION['usr_id'])=="") {
	header("Location: login.php");
}
$postdata = $_POST;
$user_role = $_SESSION['usr_role'];
$depositor_name = $_POST['name']; 
//$slip_no =  $_POST['slipno'];


//$source_branch_name =  $_POST['source_branch_name'];
$source_branch="SELECT branch_name from branch where branch_id = '$source_branch_id'"; 
$result = $con->query($source_branch);
$branch_Name = $result->fetch_all(MYSQLI_ASSOC);
$source_branch_name = $branch_Name[0]["branch_name"];

$member_name = $_POST['member_name'];
$spouse = $_POST['spouse'];
$member_code = $_POST['member_code']; 
$branch_id = $_POST['sel_branch'];
$amount = $_POST['amount'];
$date = date('Y-m-d H:i:s');
$branch_name = "SELECT branch_name from branch where branch_id = '$branch_id'"; 
$result = $con->query($branch_name);
$branchName = $result->fetch_all(MYSQLI_ASSOC);
$submitbranchName = $branchName[0]["branch_name"];
$sql = mysqli_query($con,"INSERT INTO `deposit` (depositor, member_name,spouse, member_code,amount,branch_id,source_branch_id,source_branch_name,date)
VALUES('$depositor_name','$member_name','$spouse','$member_code','$amount','$branch_id','$source_branch_id','$source_branch_name','$date')"); 

$memberId = $con->insert_id; 

if($user_role == 'branch' || $user_role == 'headquarter'){
	
	$sql1 = mysqli_query($con,"INSERT INTO `transaction_notification_depositor`(is_deposited,member_id,branch_id)
	VALUES('1','$memberId','$branch_id')"); 
	}

if ($sql === TRUE AND $sql1 === TRUE) {
    echo json_encode(array("status"=>"success","message"=> "Your Deposit successfully Sent to branch .$submitbranchName"), 200); exit;
} else {
   echo json_encode(array("status"=>"error","message"=> "Error Depositing Your Amount!")); exit;
}
$con->close();
?>


