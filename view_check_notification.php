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
//if (empty($postdata)){

//$sql = "SELECT trn.id as transaction_id,trn.*,md.*,br.* from transaction_notification as trn JOIN member_detail as md ON (md.member_id=trn.member_id) JOIN branch as br ON (br.branch_id=md.branch_id) where trn.branch_id='$branch_id' AND trn.is_notification_read != '2'";


$sql="SELECT * from transaction_notification trn 
LEFT JOIN member_detail as md ON (md.member_id=trn.member_id) 
LEFT JOIN branch as br ON (br.branch_id=trn.branch_id)
where trn.branch_id='$branch_id' AND is_notification_read != '2'"; 

$result=mysqli_query($con, $sql);
$branchnotificationcount = sizeof($result); 

if($branchnotificationcount > 0){
$i = 1;

$response = $response ."<table class='table'>"."<tr>"."<th>Member Name"."</th>"."<th>Member Code"."</th>"."<th>Check Number"."</th>"."<th>Payee Name"."</th>"."<th>Branch Name"."</th>"."<th>Amount"."</th>"."<th>Status"."</th>"."<th>Action"."</th>"."</tr>";
while($row=mysqli_fetch_array($result)) {
	//print_r($row); die;
	
	$response = $response ."<tr>"."<td class='member_name'>". $row["member_name"] . "</td>"."<td class='member_code'>". $row["member_code"] . "</td>"."<td class='member_check_number'>". $row["member_check_number"]."</td>".
	"<td class='payee_name'>". $row["payee_name"]."</td>".
	"<td class='branch_name'>". $row["branch_name"]."</td>"."<td class='check_amount'>". $row["amount"]."</td>"."<td class='check_amount'>". $row["deposite_type"] . "</td>"
        ."<td class='notification-subject'><button type='button' onClick=displayCheckDetail('" . $row['member_id'] . "','" . $row['branch_id'] . "'); class='btn btn-sm btn-info'>View</button>" . "</td>";
	$response = $response ."</tr>";
        $i++;
}
}
$response = $response ."</table>";
print $response;
//}
/*else {
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
}*/
?>