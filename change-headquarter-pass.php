<?php
error_reporting(0);
/* session_start();
  require_once('../connect.php');
  if(!isset($_SESSION['username']) & empty($_SESSION['username'])){
  header('location: ..\login.php');
  } */

session_start();

if (!isset($_SESSION['usr_id']) & empty($_SESSION['usr_id'])) {
    header('location: login.php');
}
include_once 'includes/dbconnect.php';
$branch_id = $_SESSION['branch_id'];
$userid = $_SESSION['usr_id'];

if (isset($_POST) & !empty($_POST)) {
    $cpass = md5($_POST['cpass']);
    $newpass = md5($_POST['newpass']);
    $newpass1 = md5($_POST['newpass1']);

    $passsql = "SELECT * FROM `users` WHERE id='$userid'";
    $passres = mysqli_query($con, $passsql);
    $passr = mysqli_fetch_assoc($passres);

    if ($cpass == $passr['password']) {
        if ($newpass == $newpass1) {
            $passusql = "UPDATE `users` SET password='$newpass', new_pass='false' WHERE id='$userid'";
            $passures = mysqli_query($con, $passusql);
            if ($passures) {
                
               echo "<script>alert('Password Updated Successfully please login again with New Password');window.location='logout.php'; </script>";
               //echo "<script type='text/javascript'> window.location('login.php','$message');</script>";
            }
        }
    } else {
        //$message = "Current Password Does Not Matched";
        //echo "<script type='text/javascript'>alert('$message');</script>";
        echo "<script>alert('current Password Does Not Match Please try again..'); </script>";
               
           
    }
}
?>

<html>
    <head>
        <title>JBS ABBS PORTAL - Change Password</title>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>ABBS SYSTEM - Jeevan Bikas Samaj</title>
        <!-- Bootstrap Core CSS -->
        <script src="js/jquery.js" type="text/javascript"></script>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="css/heroic-features.css" rel="stylesheet">
        
        
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

    <body >
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
                    <a class="navbar-brand"  sytle="">JBS ABBS DEPOSIT</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">

                        <li class="text-center" style="margin-right:220px;margin-top:15px;color:#FFF;font-weight:bold;"><?php echo strtoupper($_SESSION['branch_name']); ?></li>
                     
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

        <div class="container" style="margin-top:100px;">
            
            <header class="text-center"><h4>Please Change your Password for secure transaction</h4></header>
                        <hr>
            <div class="col-sm-12">
<?php
$sql = "SELECT * FROM `users` WHERE id='$userid'";
$res = mysqli_query($con, $sql);
$r = mysqli_fetch_assoc($res);
?>
                <div class="panel panel-default">
                    <div class="panel-heading"><h4>Change Password</h4></div>
                    <div class="panel-body">

                        <div class="col-sm-6 col-centered">



                            <form method="post" class="form-horizontal">

                                <div class="form-group">
                                    <label for="input1" class="col-sm-4 control-label">Current Password</label>
                                    <div class="col-sm-8">
                                        <input type="password" name="cpass" class="form-control" placeholder="Current Password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="input1" class="col-sm-4 control-label">New Password</label>
                                    <div class="col-sm-8">
                                        <input type="password" name="newpass" class="form-control" placeholder="New Password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="input1" class="col-sm-4 control-label">Repeat Again</label>
                                    <div class="col-sm-8">
                                        <input type="password" name="newpass1" class="form-control" placeholder="Repeat New Password" required>
                                    </div>
                                </div>

                                <input type="submit" class="btn btn-primary col-md-3 col-md-offset-9" value="Update">
                            </form> 
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>

            </div>
        </div>
    </div>
</div>
<script src="js/bootstrap.min.js"></script>
</body>
</html>