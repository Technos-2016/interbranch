


<?php
error_reporting(0);
session_start();

include_once 'includes/dbconnect.php';
require_once('admin-page-class.php');
$classObject = new Main_Class();
if (isset($_SESSION['usr_id']) == "") {

    header("Location: login.php");
}

$branch_id = $_SESSION['branch_id'];

function makeRandomPassword() {
    $salt = "abchefghjkmnpqrstuvwxyz0123456789";
    rand((double) microtime() * 1000000);
    $i = 0;
    while ($i <= 7) {
        $num = rand() % 33;
        $tmp = substr($salt, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }
    return $pass;
}

if (isset($_GET['email']) || $_GET['name'] != '' || $_GET['email'] != NULL) {
    $email = $_GET['email'];
    $random_password = makeRandomPassword();
    $db_password = $random_password;
    $pass = md5($db_password);

    $sql = mysqli_query($con, "UPDATE users SET password='$pass' WHERE email='$email'");
    $_GET['password'] = $db_password;
    $classObject->sendMail($_GET['email'], $_GET['name'], $_GET['password']);
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
            <div class="container">
                <h2 class="pull-left">User Information</h2>
                <div style="float:right;text-align:right;">
                    <input type="text" id="txtSearch" placeholder="Enter Code/FirstName/Lastname.." name="txtSearch" maxlength="50" />&nbsp; 
                    <img id="imgSearch" src="images/cancel.png" alt="Cancel Search" title="Cancel Search" style="width:100px;width:25px;height:20px;" />
                </div>
                <table id="tblSearch" class="table table-bordered responsive-table table-condensed table-hover">
                    <thead>
                        <tr>

                            <th>Branch Name</th>
                            <th>Staff Name</th>
                            <th>Staff Code</th>
                            <th>Email</th>
                            <th>Password Status</th>
                            <th>Action</th>
                            <th>Send Password</th>
                            <th>Update Email</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
$result = mysqli_query($con, "Select * From users as us LEFT JOIN branch as br ON (br.branch_id=us.branch_id)Order By id ASC");

while ($row = mysqli_fetch_array($result)) {


    echo "<tr>";

    echo "<td>" . $row['branch_name'] . "</td>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['member_code'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . $row['new_pass'] . "</td>";

    if ($row['user_status'] == 'Deactive') {
        echo "<td><a href='activate.php?userid=$row[id]' class='btn btn-warning'>" . $row['user_status'] . "</a></td>";
        echo "<td width='10%'> <a class='btn btn-sm btn-success' href='manage_users.php?email=$row[email]&&name=$row[name]&&password=$row[password]' onClick='return confirm('Are you sure?');' style='color:#FFF; margin-left:20px; '>Send Mail</a> </td>";
    } else {
        echo "<td><a href='activate.php?userid=$row[id]' class='btn btn-success'>" . $row['user_status'] . "</a></td>";
        echo "<td> <a class='btn btn-sm btn-success' href='manage_users.php?email=$row[email]&&name=$row[name]&&password=$row[password]' onClick='return confirm('Are you sure?');' style='color:#FFF;margin-left:20px;'>Send Mail</a> </td>";
    }

    echo "<td><a class='btn btn-sm btn-info' href='update_profile.php?id=" . $row['id'] . "'  style='color:#FFF; margin-left:20px; '>Update Email</a></td>";

    echo "</tr>";
}
?>
                    </tbody>
                </table>
            </div>

        </div>


        <script language="javascript" type="text/javascript">
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
                jQuery('#imgSearch').hide();

                // reset the search when the cancel image is clicked
                jQuery('#imgSearch').click(function () {
                    resetSearch();
                });

                // cancel the search if the user presses the ESC key
                jQuery('#txtSearch').keyup(function (event) {
                    if (event.keyCode == 27) {
                        resetSearch();
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
                        resetSearch();
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

            function resetSearch() {
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

        <script src="js/bootstrap.min.js"></script>
    </body>
</html>