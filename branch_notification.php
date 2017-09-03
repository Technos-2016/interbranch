<?php
session_start();
include_once 'includes/dbconnect.php';
$branch_id = $_SESSION['branch_id'];
$sql="SELECT * FROM `branch` br where branch_id IN (SELECT branch_id
FROM `member_detail` where branch_id='$branch_id')"; 
$branches=mysqli_query($con, $sql);
$branchnotificationcount = sizeof($branches);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Notification Detail</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" >
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
</head>
<body>

<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<!-- add header -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php"></a>
		</div>
		<!-- menu items -->
		<div class="collapse navbar-collapse" id="navbar1">
			<ul class="nav navbar-nav navbar-right">
				<?php if (isset($_SESSION['usr_id'])) { ?>
				<li><p class="navbar-text">Signed in as <?php echo $_SESSION['usr_name'];?> </p></li>
				<li><a href="logout.php">Log Out</a></li>
				<?php  } else {?><li class="active"><a href="login.php">Login</a></li> <?php }?>
			</ul>
		</div>
	</div>
</nav>

<div class="container">
	<div class="row">
	  <div class="col-sm-3 col-md-12 col-lg-3 col-xs-3">
	  <div class="form-group">
				<label for="branch" class="field prepend-icon">Headquarter Branch <em class="required">*</em>
				<select id="sel_branch_search" name="sel_branch_search" class="gui-input" required data-bv-notempty-message="Please select branch.">
					<option value="">Select Branch</option>
						<?php foreach($branches as $branch){
						echo '<option value="'.$branch['branch_id'].'">'.$branch['branch_name'].'</option>';
						}?>
				</select>
				</label>
			</div>
	   </div>
			<div class="col-sm-3 col-md-12 col-lg-3 col-xs-3">
			<div class="form-group">
				<label for="branch" class="field prepend-icon">Headquarter Branch Status<em class="required">*</em>
				<select id="sel_branch_status" name="sel_branch_status" class="gui-input" required data-bv-notempty-message="Please select branch status.">
					<option value="">Select Branch </option>
					<option value="1">approved</option>
					<option value="0">disapproved</option>
				</select>
				</label>
			</div>
		    </div>	
		<div class="form-group">
		 <button class="btn btn-success" value="Search" id="searchResult" type="button" onclick="getsearchResult()">Search</button>
		 </div>
		</div>
	<div class="row">
		
              <div id="notification-latest"></div>
            
	</div>
	<div class="row">
		<!--<div class="col-md-4 col-md-offset-4 text-center">	
		New User? <a href="register.php">Sign Up Here</a>
		</div>-->
	</div>
</div>



  <div class="modal fade" id="checkReject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header">
							<h4>Why you want to reject the check ?</h4>
						  </div>
						  <form method="POST" action="" id="frm_newsfeed" name="frm_newsfeed" class="admin-form">
						  <div class="modal-body">
                      <input type="hidden" name="member_id" id="member_id" value="">
							  <div class="form-group">
									<label for="subcategory" class="field prepend-icon">Comments<em class="required">*</em></label>
									<textarea class="form-control" id="reject_cheque_comment"  name="reject_cheque_comment" placeholder="Comments for reject a check" required data-bv-notempty-message="Please enter your comments" title="Comments for reject a cheque"></textarea>
							</div>
						  </div>
						  <div class="modal-footer">
							<button type="submit" class="btn btn-primary"> Save </button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						  </div>
						  </form>
						</div>
					  </div>
					</div>
<?php include_once ('includes/footer.php');?>
<script type="text/javascript">

	$(document).ready(function() {
		$.ajax({
			url: "view_branch_notification.php",
			type: "POST",
			processData:false,
			success: function(data){
				$("#notification-count").remove();					
				$("#notification-latest").show();
                                $("#notification-latest").html(data);
			},
			error: function(){}           
		});
	 
	});
    function checkstatusApprove(notificationId,memberId,branchId,sourcebranchId,destinationbranchId)
    {
		
		if($('input[name=check_status_approve]').is(':checked')) 
    {
	var is_approve =$('input[name=check_status_approve]').val();
    $.ajax({
		 data: { 'is_approve':is_approve,'notification_Id':notificationId,'member_id':memberId,'branch_Id':branchId,'source_branch_Id':sourcebranchId,'destination_branch_Id':destinationbranchId },
		 dataType: "json",	
         type: "post",
         url: "approve_check.php",
         success: function(json){
              alert(json.message);
			  $("#check_status_approve").val('input:checkbox').prop('checked', false);
			  location.reload(true);
         }
	  });
    }
	}
	
	function checkstatusRead(notificationId,memberId,branchId)
    {
		
		if($('input[name=check_status_read]').is(':checked')) 
    {
	var is_read =$('input[name=check_status_read]').val();
    $.ajax({
		 data: { 'is_read':is_read,'notification_Id':notificationId,'member_id':memberId,'branch_Id':branchId },
		 dataType: "json",	
         type: "post",
         url: "read_branch_notification.php",
         success: function(json){
              alert(json.message);
			  $("#check_status_read").val('input:checkbox').prop('checked', false);
			  location.reload(true);
         }
	  });
    }
	}
	
	function depositReject(memberId)
    {
	$('#member_id').val(memberId);
	if($('input[name=check_status_reject]').is(':checked')) 
    {
		$('#checkReject').modal('show');
	} 
	}
	
	
function details(id)
    {
		   var id=id; 
            $.ajax({
                type: 'POST',
                data: { 'userid':id },
                url: 'update_branch_notification.php',
                success: function(data) {
                   alert(data);
				   window.location.href = "branch_notification.php";
                   
                }
            });
    }
	function getsearchResult()
    {
	  var branchName = $('#sel_branch_search').val();
	  var branchStatus = $('#sel_branch_status').find(":selected").text();
	  $.ajax({
                type: 'POST',
                data: { 'branchName':branchName,'branchStatus':branchStatus },
                url: 'view_branch_notification.php',
                success: function(data) {
                                   $("#notification-latest").hide();
				   $("#notification-latest").show();
				   $("#notification-latest").html(data);
                }
            });
    }
</script>
</body>
</html>

