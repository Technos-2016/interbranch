<?php
session_start();

if (isset($_SESSION['usr_id']) == "") {
    header("Location: login.php");
}

$user_id = $_SESSION['usr_id'];
include_once 'includes/dbconnect.php';
$transaction_id = $_GET['transactionId'];
$member_id = $_GET['memberId'];
$branch_id = $_GET['branchId'];
$sql = "SELECT * from transaction_notification trn 
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
                    <a class="navbar-brand" href="index.php" sytle="">JBS ABBS DEPOSIT</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                       <li><a  href="javascript:window.print()">Print</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" ><?php if (isset($_SESSION['usr_id'])) { ?> Welcome <?php echo $_SESSION['usr_name']; ?><span class="caret"></span></a>

                                <ul class="dropdown-menu">
								<li>
                                        <a href="change-password.php">Change Password
                                        </a>
                                    </li>
								<li>
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
                       
					   <div class="row">
						   <div class="col-md-offset-2 col-md-8 col-md-offset-2">
							<img class="img img-rounded" src="<?php echo $memberDetail[0]['check_image'] ?>">
						   </div>
					   </div>
					   <div class="row" style="padding-top:10px;">
						   <div class="col-md-12">
								<table class="table  table-responsive">
									<tr>
								
										<td style="font-weight:bold;">Member Name : <?php echo $memberDetail[0]['member_name'];?></td>
										<td style="font-weight:bold;">Member Code : <?php echo $memberDetail[0]['member_code'];?></td>
										<td style="font-weight:bold;">Member Branch : <?php echo $memberDetail[0]['branch_name'];?></td>
										<td style="font-weight:bold;">Bearer Name : <?php echo $memberDetail[0]['payee_name'];?></td>
									
									</tr>
							
								
						   </div>
					   </div>
					   
								
										<input type="hidden" name="mamount" id="mamount" value="<?php echo $memberDetail[0]['amount'];?>">
										<input type="hidden" name="transaction_id" id="transaction_id" value="<?php echo $memberDetail[0]['transaction_id'];?>">
										<input type="hidden" name="branch_id" id="branch_id" value="<?php echo $memberDetail[0]['branch_id'];?>">
					   
					    <div class="row" style="padding-top:10px;">
						   <div class=" col-md-12">
								
									<tr>
								
										<td style="font-weight:bold;">Cheque Number : <?php echo $memberDetail[0]['member_check_number'];?></td>
										<td style="font-weight:bold;">Cheque Amount : <?php echo $memberDetail[0]['amount'];?></td>
										<td style="font-weight:bold;" >Transaction Branch : <?php if($memberDetail[0]['source_branch']!=$memberDetail[0]['destination_branch']){ 
										$source_branch = $memberDetail[0]['source_branch'];
										$branch_name = "SELECT branch_name from branch where branch_id = '$source_branch'"; 
										$result = $con->query($branch_name);
										$branchName = $result->fetch_all(MYSQLI_ASSOC);
										echo $branchName[0]['branch_name'];
										}else {
											echo $memberDetail[0]['branch_name'];
										}?></td>
										<td style="font-weight:bold;">Cheque Status : <?php echo  $memberDetail[0]['deposite_type'] ?></td>
									
									</tr>
							
								
						   </div>
					   </div>
					   
					   <div class="row" style="padding-top:10px;">
								<?php if($memberDetail[0]['is_check_reject']==1 ){?>
							   <tr>
									
										<td style="font-weight:bold;">Balance Sort By : <?php echo $memberDetail[0]['balance_amount']?></td>
										<td style="font-weight:bold;">Reason : <?php echo $memberDetail[0]['comment']?></td>
									
										
										<td></td>
							   </tr>
							   <?php } 
							   else if($memberDetail[0]['is_check_approve']==1){?>
							   <tr>
										<td style="font-weight:bold;">Approved Balance : <?php echo $memberDetail[0]['amount']?></td>
										<td style="font-weight:bold;">Remaining Balance : <?php echo $memberDetail[0]['balance_amount']?></td>
										 <td style="font-weight:bold;" ><?php if (isset($_SESSION['usr_id'])) {  
                                                                                     
                                                                                     
                                                                                     echo "Approved By : ". $_SESSION['usr_name'];} ?></td>
										<td></td>
										<td></td>
									
							   </tr>
							   
							   <?php
							   }
							  
							   
							   else{?>
							   <tr>
									
										<td style="font-weight:bold;">Balance Before Payment
											<input type="text" name="balance" id="balance" onchange="availableBalance();" required></td>
										<td style="font-weight:bold;">	<div  id="balanceData" placeholder="Balance Calculation"></div> </td>
										 <td style="font-weight:bold;" id="balanceStatus"></td>
										 <td style="font-weight:bold;" ><?php if (isset($_SESSION['usr_id'])) {  echo "Approver : ". $_SESSION['usr_name'];} ?></td>
							   </tr>
							   
							   <?php
							   }
							   ?>
					   </div>
					   
					   
					   
					</div>
                <!-- /.row -->
                <!-- Footer -->
               <!-- <footer>
                    <div class="row">
                        <div class="col-lg-12">
                            <p>Copyright &copy; Jeevan Bikas Samaj - 2073</p>
                        </div>
                    </div>
                </footer>-->
            </div>
        </div>
        <!-- /.container -->

        
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

<?php include_once ('includes/footer.php'); ?>
        <script>
		
		
			function getConfirmation(){
               var retVal = confirm("Are you sure you want to Approve?");
               if( retVal == true ){
				   
				 return true;
               }
               else{
				   location.reload();
				   $("#check_status_approve").val('input:checkbox').prop('checked', false);
                  //document.write ("User does not want to continue!");
                  return false;
				  
				  
               }
            }
         
            function checkstatusApprove(notificationId, memberId, branchId, sourcebranchId, destinationbranchId)
            {
				getConfirmation();
                if ($('input[name=check_status_approve]').is(':checked'))
                {
					
                    var is_approve = $('input[name=check_status_approve]').val();
                    $.ajax({
                        data: {'is_approve': is_approve, 'notification_Id': notificationId, 'member_id': memberId, 'branch_Id': branchId, 'source_branch_Id': sourcebranchId, 'destination_branch_Id': destinationbranchId},
                        dataType: "json",
                        type: "post",
                        url: "approve_check.php",
                        success: function (json) {
                            //alert(json.message);
							
                            $("#check_status_approve").val('input:checkbox').prop('checked', false);
							alert(json.message);
							location.reload();
                            //location.reload(true);
                        }
                    });
                }
            }

            function checkstatusReject(transactionId)
            {

                $('#transaction_comment_id').val(transactionId);
                if ($('input[name=check_status_reject]').is(':checked'))
                {
                    $('#checkReject').modal('show');
                }
            }
            //$(document).ready(function(){	 
            //var frmdeposit = $("#frmdeposit");
            //frmdeposit.bootstrapValidator()
            //.on('success.form.bv', function(e) {
            // e.preventDefault();
            $('#submit').click(function () {
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
            });

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

            function availableBalance() {
                var mAmount = $('#mamount').val();
                var transactionId = $('#transaction_id').val();
                var branchId = $('#branch_id').val();
                var remaingBalane = $('#balance').val();
                var availableBalance = (parseInt(remaingBalane) - parseInt(mAmount));
                document.getElementById("balanceData").innerHTML = availableBalance;
                $.ajax({
                    data: {'available_balance': availableBalance, 'transaction_id': transactionId, 'branch_id': branchId},
                    type: 'POST',
                    dataType: 'html',
                    url: 'insert_balance.php',
                    cache: false,
                    success: function (data)
                    {
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
        <!-- Bootstrap Core JavaScript
        <script src="js/bootstrap.min.js"></script> -->
    </body>
</html>
