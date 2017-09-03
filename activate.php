<?php
	session_start();
	if(!isset($_SESSION['usr_id'])) {
		header('Location:login.php');
	}
	
	include_once 'includes/dbconnect.php';
	
	$get_userid = $_GET['userid'];
	
	$result=mysqli_query($con,"Select * From users Where id='$get_userid'");
	//$result->execute();
	while($row = mysqli_fetch_array($result)){	
		echo $curr_status = $row['user_status'];
	}
		
	if($curr_status == "Deactive") {
		$sql = "UPDATE users SET user_status='Active' WHERE id='$get_userid'";
		mysqli_query($con,$sql);
		
		header("location: manage_users.php");
	} else {
		$sql = "UPDATE users SET user_status='Deactive' WHERE id='$get_userid'";
		 mysqli_query($con,$sql);
		
		header("location: manage_users.php");
	}
?>

