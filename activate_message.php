<?php
	session_start();
	if(!isset($_SESSION['usr_id'])) {
		header('Location:login.php');
	}
	
	include_once 'includes/dbconnect.php';
	
	$get_userid = $_GET['userid'];
	
	$result=mysqli_query($con,"Select * From admin Where id='$get_userid'");
	//$result->execute();
	while($row = mysqli_fetch_array($result)){	
		echo $curr_status = $row['status'];
	}
		
	if($curr_status == "Deactive") {
		$sql = "UPDATE admin SET status='Active' WHERE id='$get_userid'";
		mysqli_query($con,$sql);
		echo "<script>alert('Message Successfully Activated');window.location='message.php'; </script>";
		//header("location: message.php");
	} else {
		$sql = "UPDATE admin SET status='Deactive' WHERE id='$get_userid'";
		 mysqli_query($con,$sql);
		echo "<script>alert('Message Successfully Deactivated');window.location='message.php'; </script>";
		//header("location: message.php");
	}
?>

