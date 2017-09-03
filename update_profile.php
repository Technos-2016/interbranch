<?php
error_reporting(0);
session_start();
if (!isset($_SESSION['usr_id'])) {
    header('Location:login.php');
}

include_once 'includes/dbconnect.php';

$userid = $_GET['id'];

$result = mysqli_query($con, "Select * From users WHERE id=$userid");
while ($row = mysqli_fetch_array($result)){ 
    $curr_status = $row['email'];
}
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

                    <form   action="?php echo htmlentities($_SERVER['PHP_SELF']); ?" method="POST">

                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="Update Email">Enter Your Updated Email</label>
                            </div>
                            <div class="col-sm-5" >
                                <input  type='text' name="email" id="email" class="form-control" placeholder="<?php echo $curr_status; ?>" required>
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id'], ENT_QUOTES | ENT_HTML5); ?>">
                            </div>

                        </div>
                        <div class="form-group" style="margin-top: 20px;">
                            <div class="col-sm-4">
                                <button type="submit" name="update"   class="form-control btn btn-success" >UPDATE</button>
                            </div>
                        </div>
                    </form>

 
            </div>

        </div>


<?php
if (isset($_POST['update'])) {
    $id=$_POST['id'];
    $mail = $_POST['email'];
    $sql = mysqli_query($con, "UPDATE  users SET email='$mail' WHERE id='$id'");
    if ($sql) {
        echo '<script>alert("Your Email is successfully updated..");window.location="manage_users.php";</script>';
    } else {
        echo '<script>alert("Error while updating email..");window.location="manage_users.php";</script>';
    }
}
?>


        <script src="js/bootstrap.min.js"></script>
    </body>
</html>

