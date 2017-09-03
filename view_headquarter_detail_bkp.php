<?php
session_start();

if (isset($_SESSION['usr_id']) == "") {
    header("Location: login.php");
}
$user_role = $_SESSION['usr_role'];
$user_id = $_SESSION['usr_id'];
include_once 'includes/dbconnect.php';
$transaction_id = $_GET['transactionId'];
$member_id = $_GET['memberId'];
$branch_id = $_GET['branchId'];
$sql="SELECT * from transaction_notification trn 
LEFT JOIN member_detail as md ON (md.member_id=trn.member_id) 
LEFT JOIN branch as br ON (br.branch_id=trn.branch_id)
where trn.branch_id='$branch_id' AND trn.transaction_id ='$transaction_id'"; 
$result = $con->query($sql); 
$memberDetail = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
	    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>ABBS DEPOSIT- Jeevan Bikas Samaj</title>
        <!-- jQuery -->
        <script src="js/jquery.js"></script>
        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="css/heroic-features.css" rel="stylesheet">
        <script src="js/bootstrapValidator.js" type="text/javascript"></script>


</head>

    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
				 
                    <!--<a class="navbar-brand" href="index.php" sytle="">JBS ABBS DEPOSIT</a>-->
					<a class="navbar-brand" href="headquarter.php">JBS ABBS DEPOSIT</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
					<li class="text-center" style="margin-right:220px;margin-top:15px;color:#FFF;font-weight:bold;"><?php echo strtoupper($_SESSION['branch_name']);?></li>
                       <!-- <li><a href="notification.php" >Notification
                                &nbsp;<span class="countnotification" style="color:red;"></span></a></li>-->
								<li><a  href="javascript:window.print()">Print</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" ><?php if (isset($_SESSION['usr_id'])) { ?> Welcome <?php echo $_SESSION['usr_name']; ?><span class="caret"></span></a>

                                <ul class="dropdown-menu"<li>
                                        <a href="logout.php">Log Out
                                        </a>
                                    </li>
                                <?php } else { ?>
                                    <li class="active">
                                        <a href="login.php">Login
                                        </a>
                                    </li> 


                                <?php } ?>

                               
                            </ul>
                        </li>



                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>

        <!-- Page Content -->
        <div class="container">

            <!-- Jumbotron Header -->
            <header >
                <h1 class="text-center">Cheque Detail</h1>
			</header>

            <hr>
           
            
            <!-- Title -->
            <div class="row">
                <div class="col-lg-12">
                    
                        <div class="pull-left form-group em-form" style="width:100%;">
							<table class="table data-table">
								
								<tbody>
									<tr>
									<td></td>
									<td colspan="3" center><img height='300' width='700' src="<?php echo $memberDetail[0]['check_image']?>"></td>
									<td></td>
									</tr>
                               
																	
									<tr>
										<td style="font-weight:bold;">Payee Name : <?php echo $memberDetail[0]['payee_name'];?></td>
										<td style="font-weight:bold;">Member Name : <?php echo $memberDetail[0]['member_name'];?></td>
										
										<td style="font-weight:bold;">Cheque Number : <?php echo $memberDetail[0]['member_check_number'];?></td>
										<td style="font-weight:bold;">Cheque Amount : <?php echo $memberDetail[0]['amount'];?></td>
										<td style="font-weight:bold;"></td>
									</tr>
									<tr>
										<td><img height='150' width='150' src="images/member_profile_images/<?php echo $memberDetail[0]['member_picture']?>"></td>
										<td style="font-weight:bold;">Member Code : <?php echo $memberDetail[0]['member_code'];?></td>
																			
										<td style="font-weight:bold;">Source Branch : <?php echo $memberDetail[0]['branch_name'];?></td>
										
										<?php if($memberDetail[0]['source_branch']!=$memberDetail[0]['destination_branch']){ 
										$source_branch = $memberDetail[0]['source_branch'];
										$branch_name = "SELECT branch_name from branch where branch_id = '$source_branch'"; 
										$result = $con->query($branch_name);
										$branchName = $result->fetch_all(MYSQLI_ASSOC);
										echo "<td class='check_amount' style='font-weight:bold;'>Destination Branch : ". $branchName[0]["branch_name"]."</td>";
										}else {
											echo "------";
										}?>
										<input type="hidden" name="mamount" id="mamount" value="<?php echo $memberDetail[0]['amount'];?>">
										<input type="hidden" name="transaction_id" id="transaction_id" value="<?php echo $memberDetail[0]['transaction_id'];?>">
										<input type="hidden" name="branch_id" id="branch_id" value="<?php echo $memberDetail[0]['branch_id'];?>">
										

									</tr>
									
								
									  <tr>
									  <?php if($memberDetail[0]['is_check_reject']!=1 AND $memberDetail[0]['is_check_approve']!=1){
										  ?>
										<th>Check Approve</th>
									  
										<th>Check Reject</th>
										<td><b>Balance Before Payment</b> &nbsp;<input type="text" name="balance" id="balance" onchange="availableBalance();"></td>
										
										<?php } ?>
										<th><div  id="balanceData" placeholder="Balance Calculation"></div></th>
										<th></th>
									</tr>
									<tr>
	<?php 
	if($memberDetail[0]['is_check_reject']!=1 AND $memberDetail[0]['is_check_approve']!=1){
	if($memberDetail[0]['is_check_approve']==1)
		{ ?>
			<td>
			<input type='checkbox' checked='checked' onClick="checkstatusApprove('<?php echo  $memberDetail[0]['transaction_id']?>','<?php echo $memberDetail[0]['member_id']?>','<?php echo $memberDetail[0]['branch_id']?>','<?php echo $memberDetail[0]['source_branch']?>',
			'<?php echo $memberDetail[0]['destination_branch']?>')"; name='check_status_approve' id='check_status_approve' disabled class='checkbox-primary'/></td>
		<?php }
		
		else
		{ ?>
		<td><input type='checkbox' onClick="checkstatusApprove('<?php echo  $memberDetail[0]['transaction_id']?>','<?php echo $memberDetail[0]['member_id']?>','<?php echo $memberDetail[0]['branch_id']?>','<?php echo $memberDetail[0]['source_branch']?>',
		'<?php echo $memberDetail[0]['destination_branch']?>')"; name='check_status_approve' id='check_status_approve'/></td>
		<?php } if($memberDetail[0]['is_check_reject']!=1){ ?>
		<td><input type='checkbox' onClick="checkstatusReject('<?php echo  $memberDetail[0]['transaction_id']?>','<?php echo $memberDetail[0]['member_id']?>','<?php echo $memberDetail[0]['branch_id']?>','<?php echo $memberDetail[0]['source_branch']?>','<?php echo $memberDetail[0]['destination_branch']?>')" name='check_status_reject' id='check_status_reject'></td>
	<?php } 
	
	else{ ?>
		<td><input type='checkbox' checked='checked'  onClick="checkstatusReject('<?php echo  $memberDetail[0]['transaction_id']?>','<?php echo $memberDetail[0]['member_id']?>','<?php echo $memberDetail[0]['branch_id']?>','<?php echo $memberDetail[0]['source_branch']?>','<?php echo $memberDetail[0]['destination_branch']?>')" name='check_status_reject' id='check_status_reject' disabled class='checkbox-primary'/></td> 
	<?php } } ?>
									</tr>
									 <tr>
										<th>Check Status</th>
										<th>Remaining Balance</th>
										
										
								<?php if($memberDetail[0]['is_check_reject']==1){ ?>
								<th>Comment</th> <?php }?>
										<th></th>
										<th></th>
									</tr>
									<tr>
									
									  <td><?php echo $memberDetail[0]['deposite_type']?></td>
									  <td><?php echo $memberDetail[0]['balance_amount']?></td>
									  <?php if($memberDetail[0]['is_check_reject']==1){ ?>
									  <td><?php echo $memberDetail[0]['comment']?></td>
									  
									  <?php }?>
									  <td></td>
									  <td></td>
									</tr>
									<tr>
										<!--<th>Balance Amount</th>-->
										<th></th>
										<th></th>
										<th></th>
									</tr>
									<tr>
									  <td><?php //echo $memberDetail[0]['balance_amount']?></td>
									  <td></td>
									  <td></td>
									  <td></td>
									</tr>
								</tbody>
							</table>
                        </div>
                    </div>
       <!-- /.row -->
            <!-- Footer -->
            <footer>
                <div class="row">
                    <div class="col-lg-12">
                        <p>Copyright &copy; Jeevan Bikas Samaj - 2073</p>
                    </div>
                </div>
            </footer>
        </div>
		</div>
        <!-- /.container -->

        <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-body">
                        <h4>Are you sure you want to submit the following details?</h4>

                        <!-- We display the details entered by the user here -->
                        <table class="table">
                            <tr>
                                <th>Depositor Name</th>
                                <td id="dname"></td>
                            </tr>
                            <tr>
                                <th>Account Holder Name</th>
                                <td id="m_name"></td>
                            </tr>
                            <tr>
                                <th> Account Holder Code No</th>
                                <td id="m_code"></td>
                            </tr>
                            <tr>
                                <th>Branch Name</th>
                                <td id="branch_name_display"></td>
                            </tr>

                            <tr>
                                <th>Amount</th>
                                <td id="amounts"></td>
                            </tr>

                        </table>

                    </div>
                    <div class="modal-footer">
                        <a href="#" id="submit" class="btn  btn-primary  pull-left" data-dismiss="modal">Send</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
		<div class="modal fade" id="checkReject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header">
							<h4>Why you want to reject the check ?</h4>
						  </div>
						  <form method="POST" action="" id="frm_checkReject" name="frm_checkReject" class="admin-form">
						  <div class="modal-body">
                      <input type="hidden" name="transaction_comment_id" id="transaction_comment_id" value="">
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
        <script>
		$('#previewBtn').click(function () {
                var branchName = $('#sel_branch').find(":selected").text();
                /* when the button in the form, display the entered values in the modal */
                var name = $.trim($('#name').val());
                if (name === '') {
                    alert('Depositor Name is empty.');
                    return false;
                }
                $('#dname').text($('#name').val());
                
                var name = $.trim($('#member_name').val());
                if (name === '') {
                    alert('Account Holder Name is empty.');
                    return false;
                }
                $('#m_name').text($('#member_name').val());
                
                var name = $.trim($('#member_code').val());
                if (name === '') {
                    alert('Account Holder Code is empty.');
                    return false;
                }
                $('#m_code').text($('#member_code').val());
                
               
                $('#branch_name_display').text(branchName);
                
                
                var name = $.trim($('#amount').val());
                if (name === '') {
                    alert('Please Enter the Amount you want to Deposit');
                    return false;
                }
                $('#amounts').text($('#amount').val());

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
              
			  $("#check_status_approve").val('input:checkbox').prop('checked', false);
			  alert(json.message);
			  location.reload();
         }
	  });
    }
	}
	
	function checkstatusReject(transactionId)
    {
		
	$('#transaction_comment_id').val(transactionId);
	if($('input[name=check_status_reject]').is(':checked')) 
    {
		$('#checkReject').modal('show');
	} 
	}
            //$(document).ready(function(){	 
            //var frmdeposit = $("#frmdeposit");
            //frmdeposit.bootstrapValidator()
            //.on('success.form.bv', function(e) {
            // e.preventDefault();
            /*$('#submit').click(function () {
                alert('submitting');
                var frmdeposit = $("#frmdeposit");
                var formData = new FormData(frmdeposit[0]);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    url: "insert_deposit.php",
                    data: formData,
                    error: function (xhr, status) {
                        alert(status);
                    },
                    success: function (json) {

                        console.log(json.status);
                        if (json.status === 'failed') {
                            alert(json.message);
                            //console.log(json.status);
                        } else if (json.status === 'error') {

                            alert(json.message);
                            location.reload();
                        } else if (json.status === 'success') {
                            $('.checkReject').modal("hide");
                            ;
                            alert(json.message);
                            location.reload();
                        }

                    }
                });
            });*/

            /* $(document).ready(
             function () {
             
             setInterval(function () {
             $.ajax({
             url: 'show_count.php',
             cache: false,
             success: function (data)
             {
             $('.countnotification').html(data);
             },
             });
             }, 1000);
             });*/
        
function availableBalance(){
	    var mAmount = $('#mamount').val();
		var transactionId = $('#transaction_id').val();
		var branchId = $('#branch_id').val();
		var remaingBalane = $('#balance').val();
		var availableBalance = (parseInt(remaingBalane) -  parseInt(mAmount));
		//document.getElementById("balanceData").innerHTML = availableBalance;
		document.getElementById("balanceData").innerHTML =  availableBalance ;
		
		$.ajax({
        data: { 'available_balance':availableBalance,'transaction_id':transactionId,'branch_id':branchId},
        type: 'POST',
        dataType: 'html',
        url: 'insert_balance.php' ,
        cache: false,
        success: function(data)
            {
			  alert(json.message);
              $("#balanceStatus").html(data);
		    },
          });
}
</script>
<style>
.data-table tr td {
	border:none !important;
}
.data-table tr th {
	border:none !important;
}
</style>
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
	</body>
</html>
