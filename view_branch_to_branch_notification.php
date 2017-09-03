<?php
//error_reporting(0);
session_start();
include_once 'includes/dbconnect.php';
$name = $_SESSION['usr_name'];


//$branch_id2 = $_SESSION['destination_branch'];
$branch_id = $_SESSION['branch_id'];
$sql="SELECT * from transaction_notification trn 
 RIGHT JOIN member_detail as md ON (md.member_id=trn.member_id) 
 JOIN branch as br ON (br.branch_id=trn.branch_id) 
AND trn.is_another_branch = '1' AND trn.branch_id='$branch_id' AND is_check_approve ='1' ORDER BY date DESC"; 
$result=mysqli_query($con, $sql);
$count=mysqli_num_rows($result);
$response='';

	

	

if($count > 0){
	$response = $response ."<table class='table table-striped table-condensed'>"."<tr>"."<th>Date"."</th>"."<th>Member Name"."</th>"."<th>Member Code"."</th>"."<th>Member Check Number"."</th>"."<th>Payee Name"."</th>"."<th>Amount"."</th>"."<th>Branch Name"."</th>"."<th>Action"."</th>"."</tr>";
while($row=mysqli_fetch_array($result)) {
 
		if($row['source_branch']!=$row['destination_branch']){ 
		$source_branch = $row['destination_branch'];
		$branch_name = "SELECT branch_name from branch where branch_id = '$source_branch'"; 
		$res = $con->query($branch_name);
		$branchName = $res->fetch_all(MYSQLI_ASSOC);	
		$destination_branch=$branchName[0]["branch_name"];
		}

	
	$proceedtoPay = "<input type='button' class='btn btn-primary payment_proceed' id='payment_proceed' value='Proceed to pay' onClick=paymentDone('" . $row['transaction_id']. "','". $row['member_id']. "','". $row['branch_id']. "')>";
	
	$paymentDone = "<input type='button' class='btn btn-success payment_done' id='payment_done' value='Payment done'>";	
   
	$response = $response ."<tr>"."<td class='notification-subject'>". $row["date"] . "</td>"."<td class='notification-subject'>". $row["member_name"] . "</td>" . "<td class='notification-subject'>". $row["member_code"] . "</td>"."<td class='notification-subject'>". $row["member_check_number"]."</td>".
	
	
	
	"<td class='payee_name'>". $row["payee_name"]."</td>"."<td class='check_amount'>".$row["amount"]."</td>"."<td class='notification-subject'>".$destination_branch."</td>";
	
	
	
	
	

	if($row["is_payment_done"] != '1'){

	$response = $response ."<td class='notification-subject'>".$proceedtoPay."</td>";
	if($row['branch_notification']==1)
	$response = $response . "<td class='branch_notification'>Check Approved</td>";
	"</tr>";
	}
	
	else{
		
		$response = $response ."<td class='notification-subject'>".$paymentDone."</td>"."</tr>";
	}
   }
   
   
   $response = $response ."</table>";
	if(!empty($response)) {
	print $response;
}


}

else{
	echo "<h1>No Record Found</h1>";
}







?>