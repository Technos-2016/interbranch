<?php
$postdata = $_POST;
error_reporting(0);
session_start();
include_once 'includes/dbconnect.php';
//$member_id = $postdata['member_id'];
$branch_id = $postdata['branch_id'];
$available_balance = $postdata['available_balance'];
$transaction_id = $postdata['transaction_id'];
$sql =  mysqli_query($con,"UPDATE `transaction_notification` SET balance_amount='$available_balance' where transaction_id='$transaction_id'");
$response='';
$sql="SELECT * from transaction_notification trn 
LEFT JOIN member_detail as md ON (md.member_id=trn.member_id) 
LEFT JOIN branch as br ON (br.branch_id=trn.branch_id)
where trn.branch_id='$branch_id' AND trn.transaction_id ='$transaction_id'"; 
$result=mysqli_query($con, $sql);
$count=mysqli_num_rows($result);


if($count > 0){
	//if(($available_balance) >= 0){
		
		//$response = $response ."<th>Approve</th>";
		
	//}
	//else{
		//$response = $response ."<th>Reject</th>";
	//}
	
while($row=mysqli_fetch_array($result)) {
	if(($available_balance) >= 0){
		
		
		
	if($row['is_check_approve']==1)
		{
			$response = $response ."<th>Approved</th>";
			$response .= "<td>&nbsp;<input type='checkbox' checked='checked' onClick=checkstatusApprove('" . $row['transaction_id']. "','" . $row['member_id']. "','" . $row['branch_id']. "','" . $row['source_branch']. "','" . $row['destination_branch']. "'); name='check_status_approve' id='check_status_approve' disabled /></td>";
			if($row['is_check_reject']==0){
			$response = $response ."<th>&nbsp;&nbsp;&nbsp;Reject</th>";
			$response = $response ."<td>&nbsp;<input type='checkbox' onClick=checkstatusReject('" . $row['transaction_id']. "','" . $row['member_id']. "','" . $row['branch_id']. "','" . $row['source_branch']. "','" . $row['destination_branch']. "'); name='check_status_reject' id='check_status_reject' disabled></td>";
		}
		
		}
		else if(($available_balance) > 0){
			
			$response = $response ."<th>Approve</th>";
			$response .= "<td>&nbsp;<input type='checkbox' onClick=checkstatusApprove('" . $row['transaction_id']. "','" . $row['member_id']. "','" . $row['branch_id']. "','" . $row['source_branch']. "','" . $row['destination_branch']. "'); name='check_status_approve' id='check_status_approve'/></td>";
			$response = $response ."<th>&nbsp;&nbsp;&nbsp;Reject</th>";
			$response .= "<td>&nbsp;<input type='checkbox' onClick=checkstatusReject('" . $row['transaction_id']. "','" . $row['member_id']. "','" . $row['branch_id']. "','" . $row['source_branch']. "','" . $row['destination_branch']. "'); name='check_status_reject' id='check_status_reject' ></td>";
	
		}
		
		else if(($available_balance) != is_nan(0)){
			
			$response = $response ."<th>Approve</th>";
			$response .= "<td>&nbsp;<input type='checkbox' onClick=checkstatusApprove('" . $row['transaction_id']. "','" . $row['member_id']. "','" . $row['branch_id']. "','" . $row['source_branch']. "','" . $row['destination_branch']. "'); name='check_status_approve' id='check_status_approve' disabled/></td>";
			$response = $response ."<th>&nbsp;&nbsp;&nbsp;Reject</th>";
			$response .= "<td>&nbsp;<input type='checkbox' onClick=checkstatusReject('" . $row['transaction_id']. "','" . $row['member_id']. "','" . $row['branch_id']. "','" . $row['source_branch']. "','" . $row['destination_branch']. "'); name='check_status_reject' id='check_status_reject' disabled></td>";
	
		}
		
		else
		{
			$response = $response ."<th>Approve</th>";
			$response .= "<td>&nbsp;<input type='checkbox' onClick=checkstatusApprove('" . $row['transaction_id']. "','" . $row['member_id']. "','" . $row['branch_id']. "','" . $row['source_branch']. "','" . $row['destination_branch']. "'); name='check_status_approve' id='check_status_approve'/></td>";
			$response = $response ."<th>&nbsp;&nbsp;Reject&nbsp;</th>";
			$response .= "<td>&nbsp;<input type='checkbox' onClick=checkstatusReject('" . $row['transaction_id']. "','" . $row['member_id']. "','" . $row['branch_id']. "','" . $row['source_branch']. "','" . $row['destination_branch']. "'); name='check_status_reject' id='check_status_reject'></td>";
	
		}
	}
	else{
	if($row['is_check_reject']!=1){
		$response = $response ."<th>Reject</th>";
		$response = $response ."<td>&nbsp;<input type='checkbox' onClick=checkstatusReject('" . $row['transaction_id']. "','" . $row['member_id']. "','" . $row['branch_id']. "','" . $row['source_branch']. "','" . $row['destination_branch']. "'); name='check_status_reject' id='check_status_reject'></td>";
	}
	else{
		$response = $response ."<th>Rejected&nbsp;</th>";
		$response = $response . "<td><input type='checkbox' checked='checked'  onClick=checkstatusReject('" . $row['transaction_id']. "','" . $row['member_id']. "','" . $row['branch_id']. "','" . $row['source_branch']. "','" . $row['destination_branch']. "'); name='check_status_reject' id='check_status_reject' disabled/></td>"; 
		}
	}
	}
}

print $response;
