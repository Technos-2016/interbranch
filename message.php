
<?php
session_start();

include_once 'includes/dbconnect.php';

if (isset($_SESSION['usr_id']) == "") {

    header("Location: login.php");
}

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
            <header >
                <h1 class="text-center">Welcome To ABBS SYSTEM</h1>
            </header>
            <hr>
            <h2 class="pull-left">Message From Administrator</h2>
            <table id="tblSearch" class="table table-bordered responsive-table table-condensed table-hover">
                    <thead>
                        <tr>

                           
                            <th>Date</th>
                            <th>Message</th>
                            <th>Is_Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = mysqli_query($con, "Select * From admin Order By id ASC");
                     
                        while ($row = mysqli_fetch_array($result)) {
                            

                            echo "<tr>";

                            echo "<td>" . $row['date'] . "</td>";
                            echo "<td>" . $row['message'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            
                           
                            if ($row['status'] == 'Deactive') {
                                echo "<td><a href='activate_message.php?userid=$row[id]' class='btn btn-warning'>" . $row['status'] . "</a></td>";
                                 } else {
                                echo "<td><a href='activate_message.php?userid=$row[id]' class='btn btn-success'>" . $row['status'] . "</a></td>";
                                 
                            }

                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>

            
        </div>

        <script src="js/bootstrap.min.js"></script>
    </body>
</html>

