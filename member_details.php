<?php

session_start();

if(isset($_SESSION['usr_id'])=="") {
	header("Location: login.php");
}
$user_role = $_SESSION['usr_role'];
$session_branch_id = $_SESSION['branch_id'];


include_once 'includes/dbconnect.php';
//MicroTime functions For Unique Image
function fnToGetMicroTime()
{
	$fst = explode(" ", microtime()); // Micro Time For Unique Image
	$fst[0] = str_replace("0.","_",$fst[0]); // Micro Time For Unique Image
	$microtime = $fst[1].$fst[0]; // Micro Time For Unique Image
	return $microtime;
		
}
function GetImageExtension($imagetype)
   	 {
       if(empty($imagetype)) return false;
       switch($imagetype)
       {
           case 'image/bmp': return '.bmp';
           case 'image/gif': return '.gif';
           case 'image/jpeg': return '.jpg';
           case 'image/png': return '.png';
           default: return false;
       }
     }
if (!empty($_FILES["mcheckimage"]["name"])) {

	$file_name=$_FILES["mcheckimage"]["name"];
	$temp_name=$_FILES["mcheckimage"]["tmp_name"];
	$imgtype=$_FILES["mcheckimage"]["type"];
	$ext= GetImageExtension($imgtype);
	$imagename=$file_name;
	$target_path = "images/".$imagename; 
	

if(move_uploaded_file($temp_name, $target_path)) {
	
    $check_image = $target_path;
	

} 
}
$check_image = $check_image;
$member_code = $_POST['mcode']; 
$member_name = $_POST['mname'];
$member_check_number = $_POST['mcheckno'];
$amount = $_POST['amount'];
$payee_name = $_POST['payeename'];
$branch_id = $_POST['sel_branch'];
//$Captured_images = $_POST['capture_image'];
$date = date('Y-m-d H:i:s');
$user_id = $_POST['user_id'];
/*if($Captured_images !='')
{
	$encoded_image = $Captured_images;
	$get_microtime = fnToGetMicroTime();
	$url_path = 'images/member_profile_images/member_img_';
	$path = $url_path.$get_microtime;
	$image_name = 'member_img_'.$get_microtime;
	$encoded_data = $encoded_image;
	list($type, $encoded_data) = explode(';', $encoded_data);
	list(,$encoded_data)      = explode(',', $encoded_data);
	$encoded_data = base64_decode($encoded_data);
	//move_uploaded_file($image_name.'.png',$path);
	file_put_contents($path.'.png', $encoded_data);
	$image_name = $image_name.'.png';
}*/
/*if($_FILES['new_student_profile_images']['name'] !='')
					{
						//echo '<pre>';print_r($_FILES);exit();
						$get_microtime = fnToGetMicroTime();
						$strVehicleImgName = $_FILES['new_student_profile_images']['name'];
						//$strFileExt = pathinfo($strVehicleImgName);
						$customVehicleimgName = 'member_img_'.$get_microtime.$strVehicleImgName;
						$arrProDetail07= array();					
						$strVehicleImageTmpName = $_FILES['new_student_profile_images']['tmp_name'];										
						move_uploaded_file($strVehicleImageTmpName,'images/member_profile_images/'.$customVehicleimgName);		
						$image_name = $customVehicleimgName;

						
					}
*/
 /*$sql = mysqli_query($con,"INSERT INTO `member_detail` (member_code, member_name, member_check_number,amount,member_picture,payee_name,branch_id,user_id,check_image,date)

VALUES('$member_code','$member_name','$member_check_number','$amount','$image_name','$payee_name','$branch_id','$user_id','$check_image','$date')"); */

$sql = mysqli_query($con,"INSERT INTO `member_detail` (member_code, member_name, member_check_number,amount,payee_name,branch_id,user_id,check_image,date)

VALUES('$member_code','$member_name','$member_check_number','$amount','$payee_name','$branch_id','$user_id','$check_image','$date')");

$memberId = $con->insert_id; 

if($user_role == 'headquater'){
	
	$sql1 = mysqli_query($con,"INSERT INTO `transaction_notification`(is_check_submitted,member_id,branch_id)
	VALUES('2','$memberId','$branch_id')"); 
	}
else{
	  /*$sql1 = mysqli_query($con,"INSERT INTO `transaction_notification`(is_check_submitted,member_id)
	  VALUES('2','$memberId')"); */
          $sql1 = mysqli_query($con,"INSERT INTO `transaction_notification`(is_check_submitted,is_payment_done,member_id,branch_id,is_another_branch,source_branch,destination_branch)
	  VALUES('2','0','$memberId','$branch_id','0','$session_branch_id','$branch_id')");
}

if ($sql === TRUE AND $sql1 === TRUE) {
    echo json_encode(array("status"=>"success","message"=> "Cheque Processed Successfully"), 200); exit;
} else {
   echo json_encode(array("status"=>"error","message"=> "Error")); exit;
}

$conn->close();
?>


