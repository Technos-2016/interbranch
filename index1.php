<?php
error_reporting(0);

session_start();

if (!isset($_SESSION['usr_id']) & empty($_SESSION['usr_id'])) {
    header('location: login.php');
}
include_once 'includes/dbconnect.php';


$userid = $_SESSION['usr_id'];
?>
<!DOCTYPE html>
<html lang="en">
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
                    <a class="navbar-brand"  sytle="">JBS ABBS SYSTEM</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">



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

        <div class="container" style="margin-top:50px;">
            <header>
                <h2 class="text-center"> Welcome To ABBS</h2>
                <hr>
            </header>
            
            <a href="<?php if($role=='headquarter'){ header("Location:headquarter.php;");} else{header("Location:index.php;");}?>" class="btn btn-lg btn-success" >DEPOSITE/PAYMENT</a>
            <a href="<?php if($role=='headquarter'){ header("Location:headquarter.php;");} else{header("Location:index.php;");}?>" class="btn btn-lg btn-success" >REMITTANCE</a>
        </div>
        <script src="js/bootstrap.min.js"></script>  
    </body>

</html>