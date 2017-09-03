<?php
error_reporting(0);
session_start();
include_once 'includes/dbconnect.php';

//$sql="UPDATE comments SET status=1 WHERE status=0";	
//$result=mysqli_query($conn, $sql);
$name = $_SESSION['usr_name'];
$branch_id = $_SESSION['branch_id'];
//echo $sql="select * from member_detail where member_name='$name'";
//$result=mysqli_query($con, $sql);
 $sql="SELECT DATE_FORMAT(date, '%d-%b-%y') AS displaydate,ds.id as depostitorId,ds.*,trn.*,br.* from deposit as ds JOIN transaction_notification_depositor as trn ON (trn.member_id=ds.id) JOIN branch as br ON (br.branch_id=trn.branch_id) where trn.branch_id='$branch_id' AND trn.is_notification_read != '1' ORDER BY displaydate DESC"; 

$result=mysqli_query($con, $sql);
$count=mysqli_num_rows($result);
if(!empty($count)) {
	print $count;
}


?>