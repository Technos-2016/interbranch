<?php
session_start();
include_once 'includes/dbconnect.php';
$name = $_SESSION['usr_name'];
$sql="SELECT * from transaction_notification trn 
JOIN member_detail as md ON (md.member_id=trn.member_id) 
JOIN branch as br ON (br.branch_id=trn.branch_id)
AND TRN.is_check_submitted = '3'";
$result=mysqli_query($con, $sql);
$branchnotificationcount = sizeof($result); 
$response='';
if($branchnotificationcount > 0){
	$response = $response ."<table class='table'>"."<tr>"."<th>Member Name"."</th>"."<th>Member Code"."</th>"."<th>Member Check Number"."</th>"."<th>Payee Name"."</th>"."<th>Amount"."</th>"."<th>Available Balance"."</th>"."<th>Status"."</th>"."</tr>";
while($row=mysqli_fetch_array($result)) {
	$proceedtoPay = "<input type='button' class='btn btn-primary payment_proceed' id='payment_proceed' value='Proceed to pay' onClick=paymentDone('" . $row['transaction_id']. "','". $row['member_id']. "','". $row['branch_id']. "')>";
	
	$paymentDone = "<input type='button' class='btn btn-primary payment_done' id='payment_done' value='Payment done'>";	
    $response = $response ."<tr>"."<td class='notification-subject'>". $row["member_name"] . "</td>" . "<td class='notification-subject'>". $row["member_code"] . "</td>"."<td class='notification-subject'>". $row["member_check_number"]."</td>".
	
	"<td class='payee_name'>". $row["payee_name"]."</td>"."<td class='check_amount'>".$row["amount"]."</td>"."<td class='notification-subject'>".$row["balance_amount"]."</td>";
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


}else{
	echo "<h1>No Record Found</h1>";
}
?>