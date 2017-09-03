<?php
$postdata = $_POST;
session_start();
include_once 'includes/dbconnect.php';
$name = $_SESSION['usr_name'];
$branch_id = $_SESSION['branch_id'];
$response='';
//$_POST['branchName'] = '';
//$_POST['branchStatus'] = '';
//echo $branch = count($_POST['branchName']);
//echo $status = count($_POST['branchStatus']); 
if (empty($postdata)){
	
$sql="SELECT * from transaction_notification trn 
LEFT JOIN member_detail as md ON (md.member_id=trn.member_id) 
LEFT JOIN branch as br ON (br.branch_id=trn.branch_id)
where trn.branch_id='$branch_id' AND is_check_submitted ='2' AND is_notification_read != '2'"; 
$result=mysqli_query($con, $sql);
$count=mysqli_num_rows($result);

if($count > 0){
	$response = $response ."<table class='table'>"."<tr>"."<th>Member Name"."</th>"."<th>Member Code"."</th>"."<th>Check Number"."</th>"."<th>Payee Name"."</th>"."<th>Branch Name"."</th>"."<th>Amount"."</th>"."<th>Approve"."</th>"."<th>Reject"."</th>"."<th> check image"."</th>"."<th> check image"."</th>"."</tr>";
while($row=mysqli_fetch_array($result)) {
	//print_r($row); die;
	if($row['is_notification_read'] == '1'){
		 
		$status ="Approved";
	   }
	else{
		$status ="Disapproved";
		}
	$response = $response ."<tr>"."<td class='member_name'>". $row["member_name"] . "</td>"."<td class='member_code'>". $row["member_code"] . "</td>"."<td class='member_check_number'>". $row["member_check_number"]."</td>".
	"<td class='payee_name'>". $row["payee_name"]."</td>".
	"<td class='branch_name'>". $row["branch_name"]."</td>"."<td class='check_amount'>". $row["amount"]."</td>";
	if($row['is_check_approve']==1)
	{
		$response .= "<td><input type='checkbox' checked='checked' onClick=checkstatusApprove('" . $row['transaction_id']. "'); name='check_status_approve' id='check_status_approve' disabled /></td>";
                $response = $response ."<td><input type='checkbox' onClick=checkstatusReject('" . $row['transaction_id']. "','" . $row['member_id']. "','" . $row['branch_id']. "','" . $row['source_branch']. "','" . $row['destination_branch']. "'); name='check_status_reject' id='check_status_reject' disabled></td>";
	
	
	}
	else
	{
		$response .= "<td><input type='checkbox' onClick=checkstatusApprove('" . $row['transaction_id']. "','" . $row['member_id']. "','" . $row['branch_id']. "','" . $row['source_branch']. "','" . $row['destination_branch']. "'); name='check_status_approve' id='check_status_approve'/></td>";
                $response = $response ."<td><input type='checkbox' onClick=checkstatusReject('" . $row['transaction_id']. "','" . $row['member_id']. "','" . $row['branch_id']. "','" . $row['source_branch']. "','" . $row['destination_branch']. "'); name='check_status_reject' id='check_status_reject'></td>";
	
	
	}
	
	
	$response = $response . "<td><img src='". $row['check_image']."' alt='HTML5 Icon' style='width:50px;height:50px'>"."</td>";
	$response = $response . "<td><img src='images/member_profile_images/".$row['member_picture']."' alt='HTML5 Icon' style='width:50px;height:50px'>"."</td>";
	if($row['headquarter_notification']==1)
	$response = $response . "<td class='member_check_number'>Check submitted</td>";
	$response = $response ."</tr>";
}
}
$response = $response ."</table>";
if(!empty($response)) {
	print $response;
}

else{
	echo "No Record Found";
}
}
else {
	$branchnotificationcountsearch = '0';
	$branchStatus = $postdata['branchStatus']; 
	$branchId = $postdata['branchName'];
	if($branchStatus == 'approved'){
		$branchStatus = '1';
	}else{
		$branchStatus = '0';
	}
	
	$sqlsearch="SELECT * FROM `member_detail` md LEFT JOIN `branch` br ON md.branch_id=br.branch_id  where member_name='$name' AND is_branch_read = '$branchStatus' AND md.branch_id='$branchId'"; 
	$resultsearch=mysqli_query($con, $sqlsearch);
	$branchnotificationcountsearch = count($resultsearch); 
	if($branchnotificationcountsearch >= 0){
	$response = $response ."<table class='table'>"."<tr>"."<th>Member Name"."</th>"."<th>Member Code"."</th>"."<th>Member Check Number"."</th>"."<th>Payee Name"."</th>"."<th>Amount"."</th>"."<th>Status"."</th>"."</tr>";
    while($row=mysqli_fetch_array($resultsearch)) {
	if($row['is_branch_read'] == '1'){
		$status ="Approved";
	   }
	else{
		$status ="Disapproved";
		}
	$response = $response ."<tr>"."<td class='notification-subject'>". $row["member_name"] . "</td>" . "<td class='notification-subject'>". $row["member_code"] . "</td>"."<td class='notification-subject'>". $row["member_check_number"]."</td>".
	"<td class='notification-subject'>". $row["payee_name"]."</td>"."<td class='notification-subject'>". $row["amount"]."</td>"."<td class='details' data-id=".$row['member_id']." name='details' id='details' onClick= details('" . $row['member_id']. "');>". $status."</td>"."</tr>";
}
}
else {echo "No record found";}
$response = $response ."</table>";
print $response;
}
?>