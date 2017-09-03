<?php

session_start();
include_once 'includes/dbconnect.php';
$postdata = $_POST;
$deposite_id = $postdata['deposite_id'];
$branchId = $postdata['branch_id'];
$branch_id = $_SESSION['branch_id'];
$name = $_SESSION['usr_name'];
$branch_id = $_SESSION['branch_id'];
$response = '';
$sql = "SELECT DATE_FORMAT(date, '%d-%b-%y') AS displaydate ,trn.transaction_id as transactionId,ds.*,trn.*,br.* from deposit as ds JOIN transaction_notification_depositor as trn ON (trn.member_id=ds.id) JOIN branch as br ON (br.branch_id=trn.branch_id) where ds.id='$deposite_id'";
$result = mysqli_query($con, $sql);
$branchnotificationcount = sizeof($result);
if ($branchnotificationcount > 0) {
    
    $response .='<table class="table table-bordered table-condensed table-striped"><tr>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Date</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Branch Name</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Member/Center Code</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Member Name</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Amount</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Depositor Name</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Status</th><th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Accept</th><th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Reject</th></tr>';
    //$i = 1;
    while ($row = mysqli_fetch_array($result)) {
        if($row['is_deposited'] == '1'){
       $response = $response . "<tr>" .  "<td class='notification-subject'>" . $row["displaydate"] . "</td>"  . "<td class='notification-subject'>" . $row["branch_name"] . "</td>" . "<td class='notification-subject'>" . $row["member_code"] . "</td>" . "<td class='notification-subject'>" . $row["member_name"] . "</td>". "<td class='notification-subject'>" . $row["amount"] . "</td>" . "<td class='notification-subject'>" . $row["depositor"] . "</td>" . "<td class='notification-subject'>" . $row["deposite_type"] . "</td>" . "<td class='notification-subject'><input type='checkbox' id='check_status_approve' name='check_status_approve' onClick=depositApprove('" . $row['transactionId'] . "','" . $row['branch_id'] . "');></td>" ."<td class='notification-reject'><input type='checkbox' id='deposite_status_reject' name='deposite_status_reject' onClick=depositReject('" . $row['transactionId'] . "','" . $row['branch_id'] . "');></td>" . "</tr>";
        }
       }
      //$i++;
    }

$response = $response . '</table>';
print $response;
?>