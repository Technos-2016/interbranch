<?php
session_start();
include_once 'dbconnect.php';
//$sql="UPDATE comments SET status=1 WHERE status=0";	
//$result=mysqli_query($conn, $sql);
$name = $_SESSION['usr_name'];
$sql="select * from member_detail where member_name='$name' AND is_branch_read='0'";
$result=mysqli_query($con, $sql);
$response='';
while($row=mysqli_fetch_array($result)) {
	$response = $response . "<div>"."<table class='table'>"."<tr class='details' data-id=".$row['member_id']." name='details' id='details' onClick=details('" . $row['member_id']. "');>"."<td class='notification-subject'>". $row["member_name"] . "</td>" . "<td class='notification-subject'>". $row["member_code"] . "</td>"."</tr>"."</table>"."</div>";
}
if(!empty($response)) {
	print $response;
}
?>