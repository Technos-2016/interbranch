<?php
session_start();
if (isset($_SESSION['usr_id']) == "") {
    header("Location: login.php");
}
include_once 'includes/dbconnect.php';
$uid = $_SESSION['usr_id'];
$branch_id = $_SESSION['branch_id'];
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
                    <a class="navbar-brand" href="headquarter.php" sytle="">JBS ABBS DEPOSIT</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">

                        <li class="text-center" style="margin-right:220px;margin-top:15px;color:#FFF;font-weight:bold;"><?php echo strtoupper($_SESSION['branch_name']); ?></li>
                        <li><a href="headquarter.php" >Home</a></li>
                        <li><a href="total_deposit_history_head.php" >History</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" ><?php if (isset($_SESSION['usr_id'])) { ?> Welcome <?php echo $_SESSION['usr_name']; ?><span class="caret"></span></a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="change-head-password.php">Change Password
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


                    <div id="exampleForm"> 
                        <form class="form-inline" role="form" >

                            <div class="form-group">
                                <input type="text" class="form-control" id="txtSearch" placeholder="Enter Code/Member Name/Member Code.." name="txtSearch" maxlength="50" />&nbsp; 
                                <img id="imgSearch"  src="images/dismis.png" alt="Cancel" title="Cancel" style="width:150px;width:25px;height:20px;" />
                            </div>


                            <div class="form-group pull-right" >
                                <!-- <a class="btn btn-sm btn-success" href="#" onClick ="$('.alldeposit').tableExport({type: 'pdf', pdfLeftMargin:2, pdfFontSize: '7', ignoreColumn: [2,3],escape: 'false'});">PDF</a>-->
                                <a class="btn btn-sm btn-success" href="#" onClick ="$('.alldeposit').tableExport({type: 'excel', escape: 'false'});">XLS</a>
                            </div>

                            <div class="form-group pull-right" style="margin-right:10px;">
                                <label><input type="radio" name="approval" id="approval" value="Rejected"  onchange="callajax()">Rejected</label>
                            </div>

                            <div class="form-group pull-right" style="margin-right:10px;">
                                <label><input type="radio" name="approval" id="approval" value="Approved" onchange="callajax()">Approved</label>
                            </div>


                            <div class="form-group pull-right" style="margin-right:10px;">
                                <label><input type="radio" name="approval" id="approval" value="Pending" checked onchange="callajax()">ALL</label>
                            </div>
                        </form>
                    </div><!-- End of Example Form-->

                    <hr>
                    <span class="alldeposit">



                        <table id="tblSearch" class="table table-striped table-bodered responsive-table">
                            <thead>
                                <tr>
                                    
                                    <th>Date</th>
                                    <th>From Branch</th>
                                    <th>To Branch</th>
                                    <th>Spouse/Father-IN-Law</th>
                                    <th>Member Name</th>
                                    <th>Member/Center Code</th>
                                    <th>Amount</th>
                                    <th>Depositor Name</th>
                                    <th>Status</th>
                                </tr> 

                            </thead>
                            <?php
                            $query1 = "SELECT * FROM deposit as ds LEFT JOIN transaction_notification_depositor as trn ON (trn.member_id = ds.id) WHERE ds.source_branch_id='$branch_id' ORDER BY date DESC";


                            $res = mysqli_query($con, $query1);
                            while ($row1 = mysqli_fetch_array($res)) {
                                ?>
                                <tbody>


                                
                                <td><?php echo $row1['date']; ?></td>
                                <td><?php echo $row1['source_branch_name']; ?></td>
                                <?php
                                if ($row1['branch_id'] != $row1['source_branch_id']) {
                                    $to_branch = $row1['branch_id'];
                                    $branch_name = "SELECT branch_name from branch where branch_id = '$to_branch'";
                                    $result = $con->query($branch_name);
                                    $branchName = $result->fetch_all(MYSQLI_ASSOC);
                                    echo "<td>" . $branchName[0]['branch_name'] . "</td>";
                                } else {
                                    echo "<td>" .$row1['source_branch_name']. "</td>";
                                }
                                ?>

                                <td><?php echo $row1['spouse']; ?></td>
                                <td><?php echo $row1['member_name']; ?></td>
                                <td><?php echo $row1['member_code']; ?></td>
                                <td><?php echo $row1['amount']; ?></td>
                                <td><?php echo $row1['depositor']; ?></td>
                                <?php if ($row1['deposite_type'] == 'Approved') { ?>
                                    <td style="color:Green;font-weight:bold;"><?php echo $row1['deposite_type']; ?></td>
                                <?php } else if ($row1['deposite_type'] == 'Rejected') { ?><td style="color:red;font-weight:bold;"><?php echo $row1['deposite_type']; ?></td><?php } else {
                                    ?>
                                    <td style="color:#123;font-weight:bold;"><?php echo $row1['deposite_type']; ?></td><?php
                                }
                                ?>

                            <?php }
                            ?>
                            </tbody>
                        </table>

                    </span> <!-- end of all deposite-->  

                </div><!--end of total deposit-->

                <div class="tab-pane fade" id="totalpayment" style="margin-top:10px;">

                       <div id="exampleForm1"> 
                        <form class="form-inline" role="form" >


                            <div class="form-group">
                                <input type="text" class="form-control" id="txtPayment" placeholder="Enter Code/Member Name/Member Code.." name="txtPayment" maxlength="50" />&nbsp; 
                                <img id="imgPayment"  src="images/cancel.png" alt="Cancel Search" title="Cancel Search" style="width:150px;width:25px;height:20px;" />
                            </div>

                            <div class="form-group pull-right" style="margin-right:10px;">
                                <!-- <a class="btn btn-sm btn-success" href="#" onClick ="$('.alldeposit').tableExport({type: 'pdf', pdfLeftMargin:2, pdfFontSize: '7', ignoreColumn: [2,3],escape: 'false'});">PDF</a>-->
                                <a class="btn btn-sm btn-success" href="#" onClick ="$('.allpayment').tableExport({type: 'excel', escape: 'false'});">XLS</a>
                            </div>


                            <div class="form-group pull-right" style="margin-right:10px;">
                                <label><input type="radio" name="payment" id="payment" value="Rejected"  onchange="callajax1()">Rejected</label>
                            </div>

                            <div class="form-group pull-right" style="margin-right:10px;">
                                <label><input type="radio" name="payment" id="payment" value="Approved" onchange="callajax1()">Approved</label>
                            </div>


                            <div class="form-group pull-right" style="margin-right:10px;">
                                <label><input type="radio" name="payment" id="payment" value="Pending" checked onchange="callajax1()">ALL</label>
                            </div>


                        </form>
                    </div><!-- End of Example Form-->

                    <hr>
                    <span class="allpayment">

                        <table id="tblPayment" class="table table-strpied table-bodered table-responsive">
                            <thead>
                                <tr>

                                    <th>Date</th>
                                    <th>From Branch</th>
                                    <th>To Branch</th>
                                    <th>Member Name</th>
                                    <th>Member/Center Code</th>
                                    <th>Cheque Number</th>
                                    <th>Cheque Amount</th>
                                    <th>Bearer Name</th>
                                    <th>Remaining Amount</th>
                                    <th>Status</th>
                                </tr> 

                            </thead>
                            <?php
                            $query1 = "SELECT *
                                FROM transaction_notification trn
                                LEFT JOIN member_detail md ON (md.member_id = trn.member_id)
                                LEFT JOIN branch as br ON (br.branch_id = trn.branch_id) WHERE trn.source_branch='$branch_id'
                                GROUP BY md.member_id ORDER BY deposite_type ASC";

                            $res = mysqli_query($con, $query1);
                            while ($row1 = mysqli_fetch_array($res)) {
                                ?>
                                <tbody>



                                <td><?php echo $row1['date']; ?></td>
                                
                                <?php
                                if ($row1['source_branch'] != $row1['destination_branch']) {
                                    $to_branch = $row1['source_branch'];
                                    $branch_name = "SELECT branch_name from branch where branch_id = '$to_branch'";
                                    $result = $con->query($branch_name);
                                    $branchName = $result->fetch_all(MYSQLI_ASSOC);
                                    echo "<td>" . $branchName[0]['branch_name'] . "</td>";
                                } else {
                                    echo "<td>" . $row1['branch_name'] . "</td>";
                                }
                                ?>

                                <td><?php echo $row1['branch_name']; ?></td>
                                <td><?php echo $row1['member_name']; ?></td>
                                <td><?php echo $row1['member_code']; ?></td>
                                <td><?php echo $row1['member_check_number']; ?></td>
                                <td><?php echo $row1['amount']; ?></td>
                                <td><?php echo $row1['payee_name']; ?></td>
                                 <td><?php echo $row1['balance_amount']; ?></td>
                                <?php if ($row1['deposite_type'] == 'Approved') { ?>
                                    <td style="color:Green;font-weight:bold;"><?php echo $row1['deposite_type']; ?></td>
                                <?php } else if ($row1['deposite_type'] == 'Rejected') { ?><td style="color:red;font-weight:bold;"><?php echo $row1['deposite_type']; ?></td>
                                <?php } else {
                                    ?>
                                    <td style="color:#123;font-weight:bold;"><?php echo $row1['deposite_type']; ?></td><?php
                                }
                                ?>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>


                    </span>


                </div><!--end of Cheque History-->


            </div><!--end of tab-content-->
            <hr>


        </div><!--End of Container-->

        <script type="text/javascript">
            /*function callajax() {
             $.ajax({
             type: "POST",
             url: "deposite_slice.php",
             data: {mname: $("#exampleForm input[name='mname']").val(),radio: $("#exampleForm input[name='approval']:checked").val()},
             success: function(data) {
             $(".alldeposit").html(data); 
             }
             });
             }*/
            function callajax1() {
             $.ajax({
             type: "POST",
             url: "payment_slice_head.php",
             data: {radio: $("#exampleForm1 input[name='payment']:checked").val()},
             success: function(data) {
             $(".allpayment").html(data); 
             }
             });
             }

            function callajax() {
                $.ajax({
                    type: "POST",
                    url: "deposite_slice_head.php",
                    data: {radio: $("#exampleForm input[name='approval']:checked").val()},
                    success: function (data) {
                        $(".alldeposit").html(data);
                    }
                });
            }

        </script>

        <script language="javascript" type="text/javascript">
            jQuery.expr[":"].containsNoCase = function (l, k, g) {
                var find = g[3];
                if (!find)
                    return false;
                return eval("/" + find + "/k").test($(l).text());
            };

            jQuery(document).ready(function () {
                // used for the first example in the blog post
                jQuery('li:contains(\'DotNetNuke1\')').css('color', '#0000ff').css('font-weight', 'bold');

                // hide the cancel search image
                jQuery('#imgSearch').hide();

                // reset the search when the cancel image is clicked
                jQuery('#imgSearch').click(function () {
                    reset();
                });

                // cancel the search if the user presses the ESC key
                jQuery('#txtSearch').keyup(function (event) {
                    if (event.keyCode == 27) {
                        reset();
                    }
                });

                // execute the search
                jQuery('#txtSearch').keyup(function () {
                    // only search when there are 3 or more characters in the textbox
                    if (jQuery('#txtSearch').val().length > 2) {
                        // hide all rows
                        jQuery('#tblSearch tr').hide();
                        // show the header row
                        jQuery('#tblSearch tr:first').show();
                        // show the matching rows (using the containsNoCase from Rick Strahl)
                        jQuery('#tblSearch tr td:containsNoCase(\'' + jQuery('#txtSearch').val() + '\')').parent().show();
                        // show the cancel search image
                        jQuery('#imgSearch').show();
                    } else if (jQuery('#txtSearch').val().length == 0) {
                        // if the user removed all of the text, reset the search
                        reset();
                    }

                    // if there were no matching rows, tell the user
                    if (jQuery('#tblSearch tr:visible').length == 1) {
                        // remove the norecords row if it already exists
                        jQuery('.norecords').remove();
                        // add the norecords row
                        jQuery('#tblSearch').append('<tr class="norecords"><td colspan="5" class="Normal">No records were found</td></tr>');
                    }
                });
            });

            function reset() {
                // clear the textbox
                jQuery('#txtSearch').val('');
                // show all table rows
                jQuery('#tblSearch tr').show();
                // remove any no records rows
                jQuery('.norecords').remove();
                // remove the cancel search image
                jQuery('#imgSearch').hide();
                // make sure we re-focus on the textbox for usability
                jQuery('#txtSearch').focus();
            }


        </script>
        
        <script>
             jQuery.expr[":"].containsNoCase = function (el, i, m) {
                var search = m[3];
                if (!search)
                    return false;
                return eval("/" + search + "/i").test($(el).text());
            };

            jQuery(document).ready(function () {
                // used for the first example in the blog post
                jQuery('li:contains(\'DotNetNuke\')').css('color', '#0000ff').css('font-weight', 'bold');

                // hide the cancel search image
                jQuery('#imgPayment').hide();

                // reset the search when the cancel image is clicked
                jQuery('#imgPayment').click(function () {
                    resetSearch();
                });

                // cancel the search if the user presses the ESC key
                jQuery('#txtPayment').keyup(function (event) {
                    if (event.keyCode == 27) {
                        resetSearch();
                    }
                });

                // execute the search
                jQuery('#txtPayment').keyup(function () {
                    // only search when there are 3 or more characters in the textbox
                    if (jQuery('#txtPayment').val().length > 2) {
                        // hide all rows
                        jQuery('#tblPayment tr').hide();
                        // show the header row
                        jQuery('#tblPayment tr:first').show();
                        // show the matching rows (using the containsNoCase from Rick Strahl)
                        jQuery('#tblPayment tr td:containsNoCase(\'' + jQuery('#txtPayment').val() + '\')').parent().show();
                        // show the cancel search image
                        jQuery('#imgPayment').show();
                    } else if (jQuery('#txtPayment').val().length == 0) {
                        // if the user removed all of the text, reset the search
                        resetSearch();
                    }

                    // if there were no matching rows, tell the user
                    if (jQuery('#tblPayment tr:visible').length == 1) {
                        // remove the norecords row if it already exists
                        jQuery('.norecords').remove();
                        // add the norecords row
                        jQuery('#tblPayment').append('<tr class="norecords"><td colspan="5" class="Normal">No records were found</td></tr>');
                    }
                });
            });

            function resetSearch() {
                // clear the textbox
                jQuery('#txtPayment').val('');
                // show all table rows
                jQuery('#tblPayment tr').show();
                // remove any no records rows
                jQuery('.norecords').remove();
                // remove the cancel search image
                jQuery('#imgPayment').hide();
                // make sure we re-focus on the textbox for usability
                jQuery('#txtPayment').focus();
            }
        
        </script>


        <script src="js/bootstrap.min.js"></script>
    </body>
</html>