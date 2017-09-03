<?php
session_start();

if (isset($_SESSION['usr_id']) == "") {
    header("Location: login.php");
}
$user_id = $_SESSION['usr_id'];
include_once 'includes/dbconnect.php';
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
        <title>ABBS DEPOSIT- Jeevan Bikas Samaj</title>
        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="css/heroic-features.css" rel="stylesheet">
        <link href="css/toastr.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript">
            function validate() {
                x = document.frmdeposit
                input = x.member_code.value
                if (input.length > 8 || input.lent < 8) {
                    alert("The field cannot contain more or less than 8 characters!")
                    return false
                } else {
                    return true
                }
            }
        </script>
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
                        <li><a href="index.php" >Home
                                &nbsp;<span class="countnotification" style="color:red;"></span></a></li>
                        <li><a href="total_deposit_history.php" >History</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" ><?php if (isset($_SESSION['usr_id'])) { ?> Welcome <?php echo $_SESSION['usr_name']; ?><span class="caret"></span></a>

                                <ul class="dropdown-menu">
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
        <!-- Page Content -->
        <div class="container">
            <!-- Jumbotron Header -->
            <header >
                <h1 class="text-center">Please Fill in the Credentials Correctly to Deposit
                </h1>
            </header>
            <hr>
            <?php
            if (isset($_SESSION['message'])) {//echo $_SESSION['message'];
            }
            ?>
            <!-- Title -->
            <div class="row">
                <div class="col-lg-12">
                    <form action=""  method="post" name="frmdeposit" id="frmdeposit" class="" onsubmit="return validate()">
                        <div class="col-md-9 pull-left form-group em-form">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label for="Depositor Name">Depositor Name
                                    </label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="name" placeholder="Please Enter Depositor name" id="name" class="form-control " required data-bv-notempty-message="Please enter depositor name">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <br/> 
                                    <label for="Member Name">Member Name
                                    </label>
                                </div>
                                <div class="col-sm-8">
                                    <br/>
                                    <input type="text" name="member_name" placeholder="Please Enter Member name" id="member_name" class="form-control " required data-bv-notempty-message="Please enter Member name">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <br/> 
                                    <label for="Member Name">Spouse Name/ Father
                                    </label>
                                </div>
                                <div class="col-sm-8">
                                    <br/>
                                    <input type="text" name="spouse" placeholder="Please Enter Spouse/Father-In-Law Name" id="spouse" class="form-control " required data-bv-notempty-message="Please enter Spouse/Father in Law name">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <br/>
                                    <label for="Member Code">Member/Center Code
                                    </label>
                                </div>
                                <div class="col-sm-8">
                                    <br/>
                                    <input type="text" name="member_code" placeholder="Please Enter Member (123.12.2) / Center Code(123)" id="member_code" class="form-control" required data-bv-notempty-message="Please enter in the given format (000.00.0)" data-bv-regexp="true" data-bv-regexp-regexp="^\s*-?[0-9].{1,100}.\s*$" data-bv-regexp-message="Please enter in the given format (000.00.0)" maxlength="8" onkeyup="round_off(this.value)">
                                </div>
                            </div>
                            
                            
                            
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <br/> 
                                    <label for="Branch" class="field prepend-icon" >Branch Name
                                        <em class="required">*
                                        </em>
                                    </label>
                                </div>
                                <div class="col-sm-8">
                                    <br/>
                                    <select id="sel_branch" name="sel_branch" class="gui-input form-control" required data-bv-notempty-message="Please select branch." onchange="getComboA(this)">
                                        <option value="">Select Branch
                                        </option>
                                        <?php
                                        foreach ($branches as $branch) {
                                            echo '<option value="' . $branch['branch_id'] . '">' . "(" . $branch['branch_code'] . ") &nbsp; " . $branch['branch_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <input type="hidden" name="source_branch_name" class="source_branch_name"/> 
                            </div>	
                           <!-- <div class="form-group">
                                <div class="col-sm-3"> 
                                    <br/>
                                    <label for="Amount">Slip Number
                                    </label>
                                </div>
                                <div class="col-sm-8"> 
                                    <br/>
                                    <input type="text" name="slipno" id="slipno" class="form-control" required data-bv-notempty-message="Please enter slip number" data-bv-regexp="true" data-bv-regexp="true" data-bv-regexp-regexp="^\s*-?[0-9]{1,100}\s*$" data-bv-regexp-message="Please enter  only numbers.">
                                </div>
                            </div>-->
                            
                            <div class="form-group">
                                <div class="col-sm-3"> 
                                    <br/>
                                    <label for="Amount">Amount
                                    </label>
                                </div>
                                <div class="col-sm-8"> 
                                    <br/>
                                    <input type="text" placeholder="Please Enter amount in Number" maxlength="7" name="amount" id="amount" class="form-control" required data-bv-notempty-message="Please enter Amount" data-bv-regexp="true" data-bv-regexp-regexp="^\s*-?[0-9]{1,100}\s*$" data-bv-regexp-message="Please enter  only numbers.">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-3 hero-feature pull-right">
                                    <!--<button type="submit" id="headquarterDetail" class="btn btn-lg btn-primary btn-block" value="Save Changes" style="margin:right 40px !important;">Deposit-->
                                    <button type="button"  class="btn btn-lg btn-primary btn-block" value="Deposit" id="previewBtn" data-toggle="modal" data-target="#confirm-submit">Deposit</button>

                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <span class="text-danger">
                        <?php if (isset($errormsg)) {
                            echo $errormsg;
                        } ?>
                    </span>
                    <div class="row">
                        <!--<div class="col-md-4 col-md-offset-4 text-center">	
                New User? <a href="register.php">Sign Up Here</a>
                </div>-->
                    </div>
                    <div class="row">
                        <!--<div class="col-md-4 col-md-offset-4 text-center">	
                New User? <a href="register.php">Sign Up Here</a>
                </div>-->
                    </div>
                </div>	
            </div>
            <!-- /.row -->
            <hr>
            <div class="jumbotron">
                <p class="text-center">Notification..
                </p>
            </div>
            <!-- Footer -->
            <footer>
                <div class="row">
                    <div class="col-lg-12">
                        <p>Copyright &copy; Jeevan Bikas Samaj - 2073
                        </p>
                    </div>
                </div>
            </footer>
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
                                <th>Member Name</th>
                                <td id="m_name"></td>
                            </tr>
                            <tr>
                                <th>Member Name</th>
                                <td id="s_name"></td>
                            </tr>
                            <tr>
                                <th> Member Code No</th>
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

<?php include_once ('includes/footer.php'); ?>

        <script>
            /*$('#previewBtn').click(function() {
     
             var branchName = $('#sel_branch').find(":selected").text();
             $('#member_name').text($('#mname').val());
             $('#member_code').text($('#mcode').val());
             $('#branch_name_display').text(branchName);
             $('#check_amount').text($('#amount').val());
             $('#payee_name').text($('#payeename').val());
             });*/
    
    
              function round_off(mystring) {
                //my = mystring.substring(0, 3);
                //document.getElementById("member_code").value = my;
//alert(mystring);
                mystring = mystring.replace(/\./g, '');
                mystring = mystring.substring(0, 6);

                mystring1 = mystring.substring(0, 3);
                //document.getElementById("member_code").value = mystring1;
                mystring2 = mystring.substring(3, 5);
                mystring3 = mystring.substring(5, 6);

                mystring3 = "" + mystring1 + "." + mystring2 + "" + "." + mystring3;
//alert(mystring2);
                if (mystring != "" && mystring.length > 3) {
                    document.getElementById("member_code").value = mystring3;
                }

            }
            
            function getComboA(selectObject) {

                var branchName = $('#sel_branch').find(":selected").text();
                $('.source_branch_name').val(branchName);
            }
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
                
                var name = $.trim($('#spouse').val());
                if (name === '') {
                    alert('Spouse/Father In Law Name is empty.');
                    return false;
                }
                $('#s_name').text($('#spouse').val());
                
                var name = $.trim($('#member_code').val());
                    if (name.length > 8 || name.length < 3) {
                        alert('Please Enter the Member Code as (123.02.0) or Center Code as (123)!');
                        return false;
                    }
                    $('#m_code').text($('#member_code').val());

                /*var name = $.trim($('#member_code').val());
                if (name.length > 8) {
                    alert('Member code cannot contain more or less than 8 characters and should be in 000.00.0 format!');
                    return false;
                }
                $('#m_code').text($('#member_code').val());*/




                $('#branch_name_display').text(branchName);


                var name = $.trim($('#amount').val());
                if (name === '') {
                    alert('Please Enter the Amount you want to Deposit');
                    return false;
                }
                if (name > 1000000) {
                    alert('You can only Deposit Upto 1000000');
                    return false;
                }
                 if ( isNaN(name)) {
                 alert('please enter number in Amount Field');
                 return false;
                 }
                $('#amounts').text($('#amount').val());

            });

            //$(document).ready(function(){	 
            //var frmdeposit = $("#frmdeposit");
            //frmdeposit.bootstrapValidator()
            //.on('success.form.bv', function(e) {
            // e.preventDefault();
            $('#submit').click(function () {
                toastr.success('submitting');
                var frmdeposit = $("#frmdeposit");
                var formData = new FormData(frmdeposit[0]);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    url: "insert_depositer_details.php",
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
                            alert(json.message);
                            window.location = "total_deposit_history.php";
                            //alert(json.message);
                            //location.reload();
                            //toastr.success(json.message);
                            // $("#frmdeposit")[0].reset();
                        }

                    }
                });
            });

        </script>
    </body>
</html>
