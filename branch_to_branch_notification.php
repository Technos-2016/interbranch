<?php
session_start();
include_once 'includes/dbconnect.php';
$requestedUri = explode('/', $_SERVER['REQUEST_URI']);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Headquarter Notification</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" >
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
                    <a class="navbar-brand" href="index.php"></a>
                </div>
                <!-- menu items -->
                <div class="collapse navbar-collapse" id="navbar1">
                    <ul class="nav navbar-nav navbar-right">
                        <?php
                        if ($requestedUri['2'] == 'headquarter_notification.php') {
                            echo "<li><p><a href='headquarter.php'><p class='navbar-text'>Go back</p></a></li>";
                        }
                        if (isset($_SESSION['usr_id'])) {
                            ?>
                            <li><p class="navbar-text">Signed in as <?php echo $_SESSION['usr_name']; ?> </p></li>
                            <li><a href="logout.php">Log Out</a></li>
                        <?php } else { ?><li class="active"><a href="login.php">Login</a></li> <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="row">

                <div id="notification-latest"></div>

            </div>
            <div class="row">
                <!--<div class="col-md-4 col-md-offset-4 text-center">	
                New User? <a href="register.php">Sign Up Here</a>
                </div>-->
            </div>
        </div>
        <?php include_once ('includes/footer.php'); ?>

        <script type="text/javascript">

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
            function details(id)
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
            }
        </script>
    </body>
</html>

