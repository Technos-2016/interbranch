


<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

include_once 'includes/dbconnect.php';

if (isset($_SESSION['usr_id']) == "") {

    header("Location: login.php");
}

$branch_id = $_SESSION['branch_id'];
$response = '';



//$login_users = mysqli_query($con, "SELECT * from users where live_status = '1'");
$login_users = mysqli_query($con, "SELECT * from users where live_status = '1'");

$count = mysqli_num_rows($login_users);
if ($count > 0) {



    $response = $response . "<table border='1px solid grey' class='table table-striped table-condensed responsive-table table-bodered'>" . "<tr>"  . "<th>Branch Name" . "</th>" . "<th>Staff Name" . "</th>"   . "</tr>";
    while ($row = mysqli_fetch_array($login_users)) {

        
            $branch_name = "SELECT branch_name from branch  WHERE  branch_id=".$row['branch_id']."  ";
            $result = $con->query($branch_name);
            $branchName = $result->fetch_all(MYSQLI_ASSOC);
            $branch_live = $branchName[0]['branch_name'];
        
            

        if ($row['live_status'] == '1') {
           
            
            $response = $response  . "<td class='notification-subject'>"."<img class='img-rounded' src='images/profile.png' width='10px;' style='background-color:#123;'/>&nbsp;" . $branch_live. "</td>" . "<td class='notification-subject'>" . $row['name']."&nbsp;(".$row['member_code'].")" . "</td>". "</tr>";
        } else {
            echo "No online";
        }
    }
    $response = $response . "</table>";
    if (!empty($response)) {
        print $response;
    }
}
?>
