<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
session_start();

require_once('admin-page-class.php');
$classObject = new Main_Class();

if (isset($_SESSION['usr_id']) != "") {
    header("Location:index.php"); 
    
}


if (isset($_POST['login'])) {


    $mcode = mysqli_real_escape_string($con, $_POST['member_code']);

    $password = mysqli_real_escape_string($con, md5($_POST['password']));

    $result = mysqli_query($con, "SELECT * FROM users WHERE member_code = '" . $mcode . "' and password = '" . $password . "'");

    $data = mysqli_fetch_array($result);

    
    if ($data > 0 AND $data[5] == 'admin') {

        $_SESSION['usr_id'] = $data[0];
        $_SESSION['branch_id'] = $data[1];
        $_SESSION['usr_name'] = $data[2];
        $_SESSION['usr_role'] = $data[5];
        
        echo "<script>alert('Login Successfull');window.location='admin.php'; </script>";
    } else if ($password != $data[4]) {
        $fmsg = "Password Error";
    } else {
        $fmsg = "Login Error";
    }
    
    if ($data > 0 AND $data[5] == 'headquarter' AND $data[9]=='Active') {

        $_SESSION['usr_id'] = $data[0];
        $_SESSION['branch_id'] = $data[1];
        $_SESSION['usr_name'] = $data[2];
        $_SESSION['usr_role'] = $data[5];
       
        
        $random = $classObject->makeRandomPassword();
        $random_password = $random;
        $db_password = md5($random_password);
        echo "<script>alert('Login Successfull'); </script>";
        $classObject->Token($data[8], $db_password);
        $sql = mysqli_query($con, "UPDATE `users` SET token='$db_password' WHERE id='$data[0]'");
       
        
    }
    
    else if ($password != $data[4]) {
        $fmsg = "Password Error";
    }
    
    else {
       $fmsg = "User is not active Please Contact your Administrator at 9802796236";
    }
    
    if ($data > 0 AND $data[5] == 'branch' AND $data[9]=='Active') {

        $_SESSION['usr_id'] = $data[0];
        $_SESSION['branch_id'] = $data[1];
        $_SESSION['usr_name'] = $data[2];
        $_SESSION['usr_role'] = $data[5];
     
        $random = $classObject->makeRandomPassword();
        $random_password = $random;
        $db_password = md5($random_password);
        echo "<script>alert('Login Successfull'); </script>";
        $classObject->Token($data[8], $db_password);
        $sql = mysqli_query($con, "UPDATE `users` SET token='$db_password' WHERE id='$data[0]'");
       
    } else if ($password != $data[4]) {
        $fmsg = "Password Error";
    } 
    else {
        $fmsg = "User is not active Please Contact your Administrator at 9802796236";
    }
    
    
    
    
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>JBS ABBS SYSTEM</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" >
        <script src="js/jquery.js" type="text/javascript"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
    </head>
    <body>

        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <!-- add header -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" >JBS ABBS</a>
                </div>
                <!-- menu items -->
                <div class="collapse navbar-collapse" id="navbar1">
                    <ul class="nav navbar-nav navbar-right">
                        <!--<li class="active"><a href="login.php">Login</a></li>
                        <li><a href="register.php">Sign Up</a></li>-->
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
<?php if (isset($fmsg)) { ?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?> </div><?php } ?>       
            <div class="row">
                <div class="col-md-4 col-md-offset-4 well">
                    <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform">
                        <fieldset>
                            <legend>Login</legend>

                            <div class="form-group">
                                <label for="name">Staff Code</label>
                                <input type="text" name="member_code" placeholder="Staff Code" required class="form-control" />
                            </div>

                            <div class="form-group">
                                <label for="name">Password</label>
                                <input type="password" name="password" placeholder="Your Branch ID" required class="form-control" />
                            </div>

                            <div class="form-group">
                                <input type="submit"  name="login" class="btn btn-lg btn-primary btn-block" value="Login"/>
                            </div>
                        </fieldset>
                    </form>

                </div>
            </div>

        </div>


        <script src="js/bootstrap.min.js"></script>
    </body>
</html>