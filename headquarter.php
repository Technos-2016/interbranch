

<?php
session_start();
if (isset($_SESSION['usr_id']) == "") {
    header("Location: login.php");
}
$user_id = $_SESSION['usr_id'];
include_once 'includes/dbconnect.php';
$branch_id = $_SESSION['branch_id'];
$branch_name = "SELECT branch_name from branch where branch_id = '$branch_id '";
$result = $con->query($branch_name);
$branchName = $result->fetch_all(MYSQLI_ASSOC);
$_SESSION['branch_name'] = $branchName[0]['branch_name'];



?>
<!DOCTYPE html>
<html lang="en">

    <head>
       
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
         <meta name="description" content="JBS ABBS SYSTEM">
        <meta name="author" content="GOPAL KUMAR SHAH">
        
        <title>ABBS SYSTEM - Jeevan Bikas Samaj</title>
        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="css/heroic-features.css" rel="stylesheet">
        
          <script>
            var timer = 0;
            function set_interval() {
                // the interval 'timer' is set as soon as the page loads
                timer = setInterval("auto_logout()", 300000);
                // the figure '10000' above indicates how many milliseconds the timer be set to.
                // Eg: to set it to 5 mins, calculate 5min = 5x60 = 300 sec = 300,000 millisec.
                // So set it to 300000
            }

            function reset_interval() {
                //resets the timer. The timer is reset on each of the below events:
                // 1. mousemove   2. mouseclick   3. key press 4. scroliing
                //first step: clear the existing timer

                if (timer != 0) {
                    clearInterval(timer);
                    timer = 0;
                    // second step: implement the timer again
                    timer = setInterval("auto_logout()", 300000);
                    // completed the reset of the timer
                }
            }

            function auto_logout() {
                // this function will redirect the user to the logout script
                window.location = "logout.php";
            }

// Add the following attributes into your BODY tag
           /* onload = "set_interval()"
            onmousemove = "reset_interval()"
            onclick = "reset_interval()"
            onkeypress = "reset_interval()"
            onscroll = "reset_interval()"*/
        </script>
        
        
        <script>

            (function (global) {

                if (typeof (global) === "undefined") {
                    throw new Error("window is undefined");
                }

                var _hash = "!";
                var noBackPlease = function () {
                    global.location.href += "#";

                    // making sure we have the fruit available for juice (^__^)
                    global.setTimeout(function () {
                        global.location.href += "!";
                    }, 50);
                };

                global.onhashchange = function () {
                    if (global.location.hash !== _hash) {
                        global.location.hash = _hash;
                    }
                };

                global.onload = function () {
                    noBackPlease();
                    set_interval();
                    // disables backspace on page except on input fields and textarea..
                    document.body.onkeydown = function (e) {
                        var elm = e.target.nodeName.toLowerCase();
                        if (e.which === 8 && (elm !== 'input' && elm !== 'textarea')) {
                            e.preventDefault();
                        }
                        // stopping event bubbling up the DOM tree..
                        e.stopPropagation();
                    };
                }

            })(window);



            /*window.location.hash = "no-back-button";
            window.location.hash = "Again-No-back-button";//again because google chrome don't insert first hash into history
            window.onhashchange = function () {
                window.location.hash = "no-back-button";
            }*/
        </script> 
        
        
    </head>

    <body onmousemove = "reset_interval()"
            onclick = "reset_interval()"
            onkeypress = "reset_interval()"
            onscroll = "reset_interval()">

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
                    <a class="navbar-brand" href="headquarter.php" sytle="">JBS ABBS DEPOSIT</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <!-- <li >
                             <a href="login.php" style="color:#fff">Home</a>
                         </li>
                         <li>
                             <a href="notification.php" style="color:#fff">Notification &nbsp;<span class="badge countnotification" style="color:red;"></span></a>
                         </li>
 
                         <li>
                             <a href="editprofile.php" style="color:#fff">My Profile</a>
                         </li>
                         <li>
                             <a href="logout.php" style="color:#fff">Logout</a>
                         </li>-->
                        <li class="text-center" style="margin-right:220px;margin-top:15px;color:#FFF;font-weight:bold;"><?php echo strtoupper($_SESSION['branch_name']); ?></li>
                        <li><a href="headquarter.php" >Home</a></li>
                        <li><a href="total_deposit_history_head.php" >History</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" ><?php if (isset($_SESSION['usr_id'])) { ?> Welcome <?php echo $_SESSION['usr_name']; ?><span class="caret"></span></a>

                                <ul class="dropdown-menu">
                                    <li><a href="change-head-password.php">Change Password</a></li>
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
        <div class="active">
            <marquee>
                <?php
                $sql=  mysqli_query($con, "SELECT message from admin where status='Active'");
                $row=mysqli_fetch_array($sql);
                echo "<b>".$row['message']."</b>";
                ?>
                
            </marquee>
        </div>
        <!-- Page Content -->
        <div class="container">
            <!-- Jumbotron Header -->
            <header >
                <h1 class="text-center">Welcome To ABBS SYSTEM</h1>

                <p class="text-center" >
                    <a class="btn btn-success btn-large " href="head_deposit.php" style="margin-right:30px">Deposit</a>
                    <a class="btn btn-primary btn-large" href="headquarters.php" style="margin-right:30px">Payment</a>
                    <!--<a class="btn btn-info btn-large" href="#">Cheque Desposit</a>-->
                </p>
            </header>
            <hr>

            <!-- Title -->

            <div class="row">
                <div class="col-lg-9">

                    <ul class="nav nav-pills nav-justified">
                        <li class="active"><a href="#all"  data-toggle="tab" style="font-size:12px;">All Notification</a></li>
                        <li><a href="#deposit"  data-toggle="tab" style="font-size:12px;">Deposit List<span class="badge depositnotificationcount"></span></a></li>
                        <li><a href="#approve"  data-toggle="tab" style="font-size:12px;">Cheque Approval <span class="badge countnotification"></span></a></li>
                        <li><a href="#pay"  data-toggle="tab" style="font-size:12px;">Ready to Pay <span class="badge paymentnotification"></span></a></li>
                        <li><a href="#reject"  data-toggle="tab" style="font-size:12px;">Rejected Notification<span class="badge rejectnotification"></span></a></li>
                    </ul>


                    <!-- Page Features -->
                    <div class="tab-content clearfix">
                        <div class="tab-pane fade in active" id="all" style="margin-top:10px;">

                            <span class="depositornotification" style="font-size:12px;"></span>

                        </div><!--end of all notification-->

                        <div class="tab-pane fade" id="deposit" style="margin-top:10px;">

                            <span class="depositedetail" style="font-size:12px;"></span>

                        </div><!--end of Payment Notification-->

                        <div class="tab-pane fade" id="approve" style="margin-top:10px;">
                            <div class="notification-latest" style="font-size:12px;"></div>
                        </div>

                        <div class="tab-pane fade" id="pay" style="margin-top:10px;">
                            <span id="notification-latest" style="font-size:12px;"></span>
                        </div>

                        <div class="tab-pane fade" id="reject" style="margin-top:10px;">
                            <span id="rejected" style="font-size:12px;"></span>
                        </div>
                    </div><!--end of tab-content-->

                </div>

                <div class="col-lg-3">
                    <h4 style="margin-left: 40px;font-size:13px;">List Of Online Staff</h4><hr>
                    <span class="login" style="font-size:10px;"></span>
                </div>



                <!-- /.row -->


                <hr>


                <!-- Footer -->
                <footer>
                    <div class="row">
                        <div class="col-lg-12">
                            <p>Copyright &copy; Jeevan Bikas Samaj - 2073</p>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- /.container -->
            <!-- jQuery -->
            <div class="modal fade" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Depotitor Detail </h4>
                        </div>
                        <div class="modal-body" id="getCode" style="overflow-x: scroll;">
                            //ajax success content here.
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="checkdepositeReject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>Why you want to reject?</h4>
                        </div>
                        <form method="POST" action="" id="frm1_deposite_reject" name="frm1_deposite_reject" class="admin-form">
                            <div class="modal-body">
                                <input type="hidden" name="deposite_notification_id" id="deposite_notification_id" value="">
                                <div class="form-group">
                                    <label for="subcategory" class="field prepend-icon">Comments<em class="required">*</em></label>
                                    <textarea class="form-control" id="reject_deposite_comment"  name="reject_deposite_comment" placeholder="Comments for reject deposite check" required data-bv-notempty-message="Please enter your comments" title="Comments for reject a cheque"></textarea>
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

                $(document).ready(
                        function () {
                            setInterval(function () {
                                $.ajax({
                                    url: 'view_login_users.php',
                                    cache: false,
                                    success: function (data)
                                    {
                                        $('.login').html(data);
                                    },
                                });
                            }, 1000);
                        });

                /* deposit section start*/
                $(document).ready(
                        function () {
                            setInterval(function () {
                                $.ajax({
                                    url: 'view_depositor_detail.php',
                                    cache: false,
                                    success: function (data)
                                    {
                                        $('.depositedetail').html(data);
                                    },
                                });
                            }, 1000);
                        });

                $(document).ready(
                        function () {
                            setInterval(function () {
                                $.ajax({
                                    url: 'notification_all_deposit.php',
                                    cache: false,
                                    success: function (data)
                                    {
                                        $('.depositnotificationcount').html(data);
                                    },
                                });
                            }, 1000);
                        });

                $(document).ready(
                        function () {
                            setInterval(function () {
                                $.ajax({
                                    url: 'view_all_depositor_notification.php',
                                    cache: false,
                                    success: function (data)
                                    {
                                        $('.depositornotification').html(data);
                                    },
                                });
                            }, 1000);
                        });

                function depositApprove(depositeId, branchId)
                {
                    if ($('input[name=check_status_approve]').is(':checked'))
                    {

                        var is_approve = $('input[name=check_status_approve]').val();

                        $.ajax({
                            data: {'is_approve': is_approve, 'notification_Id': depositeId, 'branch_Id': branchId},
                            dataType: "json",
                            type: "post",
                            url: "approve_depositor_check.php",
                            success: function (json) {
                                $("#getCodeModal").modal("hide");
                                toastr.success(json.message);
                                //location.reload(true);
                            }
                        });
                    }

                }

                function depositReject(transactiondepositerId, branchId)
                {

                    $('#deposite_notification_id').val(transactiondepositerId);
                    if ($('input[name=deposite_status_reject]').is(':checked'))
                    {
                        $('#getCodeModal').modal('hide');
                        $('#checkdepositeReject').modal('show');
                    }
                }

                function displaydepositorDetail(depositeid, branchid)
                {
                    $.ajax({
                        data: {'deposite_id': depositeid, 'branch_id': branchid},
                        type: 'POST',
                        dataType: 'html',
                        url: 'view_depositor_notification.php',
                        cache: false,
                        success: function (data)
                        {
                            $("#getCodeModal").modal("toggle");
                            $("#getCode").html(data);
                        },
                    });

                }
                /* deposit section end*/
            </script>

            <script type="text/javascript">

                /*$(document).ready(function() {
              
              
                 $.ajax({
                 url: "view_headquarter_notification.php",
                 type: "POST",
                 processData:false,
                 success: function(data){
              
                 //$("#notification-count").remove();					
                 //$("#notification-latest").show();
                 $("#notification-latest").html(data);
                 },
                 error: function(){}           
                 });
              
                 });*/

                /* for check notification*/
                $(document).ready(
                        function () {
                            setInterval(function () {
                                $.ajax({
                                    url: 'show_branch_count.php',
                                    cache: false,
                                    success: function (data)
                                    {
                                        $('.countnotification').html(data);
                                    }
                                });
                            }, 1000);
                        });

                $(document).ready(
                        function () {
                            setInterval(function () {
                                $.ajax({
                                    url: 'view_head_notification.php',
                                    cache: false,
                                    success: function (data)
                                    {
                                        //$(".notification-count").remove();
                                        //$(".notification-latest").show();
                                        $(".notification-latest").html(data);
                                    }
                                });
                            }, 1000);
                        });

                /* $(document).ready(
                 function () {
                 setInterval(function () {
                 $.ajax({
                 url: 'show_branch_count_other_branch.php',
                 cache: false,
                 success: function (data)
                 {
                 // alert(data);	
                 $('.countnotificationotherbranch').html(data);
                 },
                 });
                 }, 1000);
                 });*/

                $(document).ready(function () {


                    $.ajax({
                        url: "view_branch_to_branch_notification.php",
                        type: "POST",
                        processData: false,
                        success: function (data) {
                            $("#notification-count").remove();
                            $("#notification-latest").show();
                            $("#notification-latest").html(data);
                        },
                        error: function () {}
                    });

                });

                /* payment section start*/
                $(document).ready(
                        function () {
                            setInterval(function () {
                                $.ajax({
                                    url: 'show_payment_count.php',
                                    cache: false,
                                    success: function (data)
                                    {
                                        $('.paymentnotification').html(data);
                                    }
                                });
                            }, 1000);
                        });


                /* show reject count*/
                $(document).ready(
                        function () {
                            setInterval(function () {
                                $.ajax({
                                    url: 'show_reject_count.php',
                                    cache: false,
                                    success: function (data)
                                    {
                                        $('.rejectnotification').html(data);
                                    }
                                });
                            }, 1000);
                        });

                /* show reject List */
                $(document).ready(
                        function () {
                            setInterval(function () {
                                $.ajax({
                                    url: 'view_rejected_list.php',
                                    cache: false,
                                    success: function (data)
                                    {
                                        $('#rejected').html(data);
                                    },
                                });
                            }, 1000);
                        });

                /*for Reject Done*/
                function rejectDone(transactionId, memberId, branchId) {

                    $.ajax({
                        type: 'POST',
                        dataType: "json",
                        data: {'notification_id': transactionId, 'member_id': memberId, 'branch_id': branchId},
                        url: 'reject.php',
                        success: function (json) {
                            if (json.status == 'failed') {
                                alert(json.message);
                            } else if (json.status == 'error') {

                                alert(json.message);
                                location.reload();

                            } else if (json.status == 'success') {
                                $('.checkReject').modal("hide");
                                ;
                                alert(json.message);
                                location.reload();

                            }

                        }
                    });

                }

                /*for Payment Done*/

                function paymentDone(transactionId, memberId, branchId) {

                    $.ajax({
                        type: 'POST',
                        dataType: "json",
                        data: {'notification_id': transactionId, 'member_id': memberId, 'branch_id': branchId},
                        url: 'payment_done_headquarter.php',
                        success: function (json) {
                            if (json.status == 'failed') {
                                alert(json.message);
                            } else if (json.status == 'error') {

                                alert(json.message);
                                location.reload();

                            } else if (json.status == 'success') {
                                $('.checkReject').modal("hide");
                                ;
                                alert(json.message);
                                location.reload();

                            }

                        }
                    });

                }

                /* payment section End*/
                /*function details(id)
                 {
              
                 var id = id;
                 $.ajax({
                 type: 'POST',
                 data: {'userid': id},
                 url: 'update_headquarter_notification.php',
                 success: function (data) {
                 alert(data);
                 window.location.href = "branch_notification.php";
              
                 }
                 });
                 }*/
            </script>

            <script>
                function checkstatusApprove(notificationId, memberId, branchId, sourcebranchId, destinationbranchId)
                {

                    if ($('input[name=check_status_approve]').is(':checked'))
                    {
                        var is_approve = $('input[name=check_status_approve]').val();
                        $.ajax({
                            data: {'is_approve': is_approve, 'notification_Id': notificationId, 'member_id': memberId, 'branch_Id': branchId, 'source_branch_Id': sourcebranchId, 'destination_branch_Id': destinationbranchId},
                            dataType: "json",
                            type: "post",
                            url: "approve_check.php",
                            success: function (json) {
                                alert(json.message);
                                $("#check_status_approve").val('input:checkbox').prop('checked', false);
                                location.reload(true);
                            }
                        });
                    }
                }

                function checkstatusRead(notificationId, memberId, branchId)
                {

                    if ($('input[name=check_status_read]').is(':checked'))
                    {
                        var is_read = $('input[name=check_status_read]').val();
                        $.ajax({
                            data: {'is_read': is_read, 'notification_Id': notificationId, 'member_id': memberId, 'branch_Id': branchId},
                            dataType: "json",
                            type: "post",
                            url: "read_branch_notification.php",
                            success: function (json) {
                                alert(json.message);
                                $("#check_status_read").val('input:checkbox').prop('checked', false);
                                location.reload(true);
                            }
                        });
                    }
                }

                function checkstatusReject(memberId)
                {
                    $('#member_id').val(memberId);
                    if ($('input[name=check_status_reject]').is(':checked'))
                    {
                        $('#checkReject').modal('show');
                    }
                }


                function details(id)
                {
                    var id = id;
                    $.ajax({
                        type: 'POST',
                        data: {'userid': id},
                        url: 'update_branch_notification.php',
                        success: function (data) {
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
                        data: {'branchName': branchName, 'branchStatus': branchStatus},
                        url: 'view_branch_notification.php',
                        success: function (data) {
                            $("#notification-latest").hide();
                            $("#notification-latest").show();
                            $("#notification-latest").html(data);
                        }
                    });
                }
            </script>

    </body>
</html>
