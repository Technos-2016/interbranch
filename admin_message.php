<?php
session_start();
include_once 'includes/dbconnect.php';
$user_role = $_SESSION['usr_role'];
$postdata = $_POST;
$id = $postdata['rId']; 
if($postdata['Id'] == 'on')
{
	
$is_active = $postdata['Id'];
if($is_active== 'on')
{
$is_active = '1';
}

$sql = "UPDATE `admin` SET is_active='$is_active' WHERE id='$id'";	
if ($con->query($sql) === TRUE) {
    echo json_encode(array("status"=>"success","message"=> "Message Successfully Posted to all Branch"), 200); exit;
} else {
   echo json_encode(array("status"=>"error","message"=> "Error")); exit;
}

}
/*else{
$postdata = $_POST;
$id = $postdata['rId']; 
if($postdata['Id'] == 'no')
{
	
$is_active = $postdata['Id'];
if($is_active== 'no')
{
$is_active = '0';
}

$sql1 = "UPDATE `admin` SET is_active='$is_active' WHERE id='$id'";	
if ($con->query($sql1) === TRUE) {
    echo json_encode(array("status"=>"success","message"=> "Message Successfully Deactivated"), 200); exit;
} else {
   echo json_encode(array("status"=>"error","message"=> "Error")); exit;
}

}

}*/
$con->close();

?>


