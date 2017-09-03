<?php
error_reporting(0);
session_start();

include_once 'includes/dbconnect.php';

if (isset($_SESSION['usr_id']) == "") {

    header("Location: login.php");
}

$branch_id = $_SESSION['branch_id'];
$branch_name = "SELECT branch_name from branch where branch_id = '$branch_id '";
$result = $con->query($branch_name);
$branchName = $result->fetch_all(MYSQLI_ASSOC);
$_SESSION['branch_name'] = $branchName[0]['branch_name'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Admin Panel</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
       
        <script src="js/jquery.min.js"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
        <!-- Custom CSS -->
        <link href="css/heroic-features.css" rel="stylesheet">

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
                        <li><a href="manage_users.php" >Manage Users</a></li>
                        <li><a href="message.php" >Post Message</a></li>
                        <li><a href="admin_history.php" >History</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" ><?php if (isset($_SESSION['usr_id'])) { ?> Welcome <?php echo $_SESSION['usr_name']; ?><span class="caret"></span></a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="change-headquarter-pass.php">Change Password
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

        <div class="container">
            <header class="text-center"><h4>Welcome To ABBS Control Administrator</h4></header>
            <hr>
            <div class="row">
                <form   action="insert_admin_message.php" method="post" name="frmadmin" id="frmadmin" role="form">

                    <div class="form-group">
                        <div class="col-sm-3">
                            <label for="Admin Message">Enter Message</label>
                        </div>
                        <div class="col-sm-5" >
                            <textarea  rows="5" name="message" id="message" class="form-control " required></textarea>
                        </div>

                    </div>
                    <div class="form-group" style="margin-top: 20px;">
                        <div class="col-sm-4" style="margin-top: 20px;">
                            <button type="submit"   id="submit" class="form-control btn btn-success" >Submit Message</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>

        <script>
        /*$('#submit').click(function () {
                
                var frmadmin = $("#frmadmin");
                var formData = new FormData(frmadmin[0]);
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    contentType: false,
                    cache: false,
                    processData: false,
                    url: "insert_admin_message.php",
                    data: formData,
                    error: function (xhr, status) {
                        alert(status);
                    },
                    success: function (json) {
                       alert(json.message);
                       //window.location = "admin_history.php";
                       location.reload(true);
                       
                        
                            
                        }

                    });
                });*/
        
        </script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>

