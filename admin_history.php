<?php
error_reporting(0);
session_start();
if (isset($_SESSION['usr_id']) == "") {
    header("Location: login.php");
}
include_once 'includes/dbconnect.php';
$uid = $_SESSION['usr_id'];
$branch_id = $_SESSION['branch_id'];

$sql = "SELECT * from branch";
$branches = mysqli_query($con, $sql);
$branchnotificationcount = sizeof($branches);
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>ABBS SYSTEM - Jeevan Bikas Samaj</title>
        <script src="js/jquery.min.js"></script>
        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="css/heroic-features.css" rel="stylesheet">
        <script type="text/javascript" src="js/tableExport.js"></script>
        <script type="text/javascript" src="js/jquery.base64.js"></script>




    </head>

    <body>

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
                    <a class="navbar-brand" href="admin.php" sytle="">JBS ABBS DEPOSIT</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">

                        <li class="text-center" style="margin-right:220px;margin-top:15px;color:#FFF;font-weight:bold;"><?php echo strtoupper($_SESSION['branch_name']); ?></li>
                        <li><a href="admin.php" >Dashboard</a></li>
                        <li><a href="admin_history.php" >History</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" ><?php if (isset($_SESSION['usr_id'])) { ?> Welcome <?php echo $_SESSION['usr_name']; ?><span class="caret"></span></a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="admin-password.php">Change Password
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

                                <!--<li><a href="register.php">Sign Up</a></li>-->
                            </ul>
                        </li>



                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>


        <div class="container" style="border:1px solid #39d;">



            <!-- Jumbotron Header -->
            <header >
                <h1 class="text-center">Welcome To ABBS SYSTEM</h1>
            </header>

            <ul class="nav nav-pills nav-justified">
                <li class="active">
                    <a class="btn btn-success btn-large " href="#totaldeposit" style="margin-right:30px" data-toggle="tab">Deposit History</a></li>
                <li>   <a class="btn btn-primary btn-large" href="#totalpayment" style="margin-right:30px" data-toggle="tab">Payment History</a></li>
                <!--<a class="btn btn-info btn-large" href="#">Cheque Desposit</a>-->
            </ul>


            <!-- Page Features -->
            <div class="tab-content clearfix">
                <div class="tab-pane fade in active" id="totaldeposit" style="margin-top:10px;">



                    <form class="form-inline" role="form" >
                        <div class="row">
                            <div class="col-md-6">
                            
                            <div class="form-group pull-left" style="margin-right:10px;margin-top:30px;">
                                <label> From Date <input type="date" name="date1" id="date1"  ></label>
                            </div>
                            <div class="form-group pull-left" style="margin-right:10px;margin-top:30px;">
                                <label> To Date <input type="date" name="date2" id="date2"  ></label>
                            </div>
                                </div>
                            
                                <button  style="margin-top:30px;" class="btn btn-sm btn-success" value="Search" id="searchResult" type="button" onclick="getsearch()">Search</button>
                           
                                <div class="col-md-6">
                                 <div class="form-group pull-right" style="margin-right:10px;" >
                                <!-- <a class="btn btn-sm btn-success" href="#" onClick ="$('.alldeposit').tableExport({type: 'pdf', pdfLeftMargin:2, pdfFontSize: '7', ignoreColumn: [2,3],escape: 'false'});">PDF</a>-->
                                <a class="btn btn-sm btn-success pull-right" href="#" onClick ="$('.alldeposit').tableExport({type: 'excel', escape: 'false'});">XLS</a>
                                </div>

                                <div class="form-group pull-right" style="margin-right:10px;">
                                    <label><input type="radio" name="approval" id="approval" value="Rejected"  onchange="callajax()">Rejected</label>
                                </div>

                                <div class="form-group pull-right" style="margin-right:10px;">
                                    <label><input type="radio" name="approval" id="approval" value="Approved" onchange="callajax()">Approved</label>
                                </div>


                                <div class="form-group pull-right" style="margin-right:10px;">
                                    <label><input type="radio" name="approval" id="approval" value="all" checked onchange="callajax()">ALL</label>
                                </div>
                                </div>


                        </div><!-- End of row-->
                    </form>


                    <hr>

                    <span class="alldeposit"></span>
                </div><!--end of total deposit-->




                <div class="tab-pane fade" id="totalpayment" style="margin-top:10px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group pull-left" style="margin-top:20px;">
                                <label> Start Date <input type="date" name="date3" id="date3"  ></label>
                            </div>
                             <div class="form-group pull-left" style="margin-top:20px;">
                                <label> End Date <input type="date" name="date4" id="date4"  ></label>
                            </div>
                            <button  style="margin-top:35px;margin-left:10px;" class="btn btn-sm btn-success" value="Search" id="searchResult" type="button" onclick="getsearchResult()">Search</button>
                   
                        </div>

                        <div class="col-md-6">
                            <div class="form-group pull-right" style="margin-right:10px;">
                             <a  style="margin-top:20px; " class="btn btn-sm btn-success pull-right" href="#" onClick ="$('.allpayment').tableExport({type: 'excel', escape: 'false'});">XLS</a>
                             </div>
                            <div class="form-group pull-right" style="margin-right:10px;">
                                <label><input type="radio" name="payment" id="approval" value="Rejected"  onchange="callajax1()">Rejected</label>
                            </div>

                            <div class="form-group pull-right" style="margin-right:10px;">
                                <label><input type="radio" name="payment" id="approval" value="Approved" onchange="callajax1()">Approved</label>
                            </div>


                            <div class="form-group pull-right" style="margin-right:10px;">
                                <label><input type="radio" name="payment" id="approval" value="Pending" checked onchange="callajax1()">ALL</label>
                            </div>
                        </div>

                    </div><!-- End of row-->
                    <hr>

                    <span class="allpayment"></span>




                </div><!--end of Cheque History-->


            </div><!--end of tab-content-->
            <hr>





            <!--<div id="return">-->



        </div><!--End of Container-->



        <script language="javascript" type="text/javascript">
            
            $(document).ready(function () {


                $.ajax({
                    url: "admin_deposit_history.php",
                    type: "POST",
                    processData: true,
                    success: function (data) {

                        $(".alldeposit").html(data);
                    },
                    error: function () {}
                });

            });
            
            function callajax() {
                $.ajax({
                    type: "POST",
                    url: "admin_slice.php",
                    data: {radio: $("#totaldeposit input[name='approval']:checked").val()},
                    success: function (data) {
                        $(".alldeposit").html(data);
                    }
                });
            }
            
            function callajax1() {
                $.ajax({
                    type: "POST",
                    url: "admin_payment_slice.php",
                    data: {radio: $("#totalpayment input[name='payment']:checked").val()},
                    success: function (data) {
                        $(".allpayment").html(data);
                    }
                });
            }

            function getsearch()
            {

                //var branchStatus = $('#sel_branch_status').find(":selected").text();
                var branchStatus = $('#date1').val();
                var branchName = $('#date2').val();

                $.ajax({
                    type: 'POST',
                    data: {'branchName': branchName, 'branchStatus': branchStatus},
                    url: 'admin_deposit_history.php',
                    success: function (data) {

                        $(".alldeposit").html(data);
                    }
                });
            }

            $(document).ready(function () {


                $.ajax({
                    url: "admin_notification.php",
                    type: "POST",
                    processData: true,
                    success: function (data) {

                        $(".allpayment").html(data);
                    },
                    error: function () {}
                });

            });

            function getsearchResult()
            {
                //var branchName = $('#sel_branch_search').find(":selected").text();
                //var branchName = $('#sel_branch_search').val();
                //var branchStatus = $('#sel_branch_status').find(":selected").text();
                //var branchStatus = $('#sel_branch_status').val();
                var branchStatus = $('#date3').val();
                var branchName = $('#date4').val();
                $.ajax({
                    type: 'POST',
                    data: {'branchName': branchName, 'branchStatus': branchStatus},
                    url: 'admin_notification.php',
                    success: function (data) {

                        $(".allpayment").html(data);
                    }
                });
            }
        </script>


        <script src="js/bootstrap.min.js"></script>
    </body>
</html>