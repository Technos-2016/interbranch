<?php

error_reporting(0);
$postdata = $_POST;
session_start();
include_once 'includes/dbconnect.php';
$name = $_SESSION['usr_name'];
$branch_id = $_SESSION['branch_id'];
$response = '';
if (empty($postdata)) {
    /* $sql="SELECT DATE_FORMAT(date, '%d-%b-%y') AS displaydate,md.member_id as memberId,md.*,trn.*,br.* from transaction_notification trn 
      LEFT JOIN member_detail as md ON (md.member_id=trn.member_id)
      LEFT JOIN branch as br ON (br.branch_id=trn.branch_id)
      where trn.branch_id='$branch_id'  ORDER BY date DESC"; */
//$sql="SELECT DISTINCT trn.member_id,  FROM transaction_notification  as trn  LEFT JOIN member_detail as md ON (trn.member_id = md.member_id)ORDER BY trn.member_id DESC"; 
    $sql = "SELECT *
FROM member_detail md
LEFT JOIN transaction_notification trn ON (trn.member_id = md.member_id)
LEFT JOIN branch as br ON (br.branch_id=trn.branch_id)
GROUP BY md.member_id ORDER BY date desc";
    $result = mysqli_query($con, $sql);
    $branchnotificationcount = sizeof($result);

    if ($branchnotificationcount > 0) {

        $response .='<table class="table table-bordered table-condensed table-striped table-responsive"><tr>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Date</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">From Branch</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">To Branch</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Member Name</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Member/Center Code</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Cheque Number</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Cheque Amount</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Bearer Name</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Status</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Remaining Balance</th></tr>';
        // $i = 1;
        while ($row = mysqli_fetch_array($result)) {

            if ($row['source_branch'] != $row['destination_branch']) {
                $to_branch = $row['source_branch'];
                $branch_name = "SELECT branch_name from branch where branch_id = '$to_branch'";
                $res = $con->query($branch_name);
                $branchName = $res->fetch_all(MYSQLI_ASSOC);
                $destination_branch = $branchName[0]["branch_name"];
            } else {
                $row['branch_name'];
            }


            if ($row['deposite_type'] == 'Pending') {

                $response = $response . "<tr class='info' style='font-weight:bold;font-size:12px;'>" . "<td class='notification-subject'>" . $row["date"] . "</td>" . "<td class='notification-subject'>" . $destination_branch . "</td>" . "<td class='notification-subject'>" . $row["branch_name"] . "</td>";

                $response = $response . "<td class='notification-subject'>" . $row["member_name"] . "</td>" . "<td class='notification-subject'>" . $row["member_code"] . "</td>" ."<td class='notification-subject'>" . $row["member_check_number"] . "</td>" ."<td class='notification-subject'>" . $row["amount"] . "</td>" . "<td class='notification-subject'>" . $row["payee_name"] . "</td>" . "<td class='notification-subject'>" . $row["deposite_type"] . "</td>" . "<td class='notification-subject'>".$row['balance_amount']."</td>" . "</tr>";
            } //$i++;
            else {
                $response = $response . "<tr >" . "<td class='notification-subject'>" . $row["date"] . "</td>" . "<td class='notification-subject'>" . $destination_branch . "</td>" . "<td class='notification-subject'>" . $row["branch_name"] . "</td>";

                $response = $response . "<td class='notification-subject'>" . $row["member_name"] . "</td>" . "<td class='notification-subject'>" . $row["member_code"] . "</td>" . "<td class='notification-subject'>" . $row["member_check_number"] . "</td>"."<td class='notification-subject'>" . $row["amount"] . "</td>" . "<td class='notification-subject'>" . $row["payee_name"] . "</td>" . "<td class='notification-subject'>" . $row["deposite_type"] . "</td>" . "<td class='notification-subject'>".$row['balance_amount']."</td>" . "</tr>";
            }
        }
    }
    $response = $response . '</table>';
    if (!empty($response)) {
        print $response;
    } else {
        echo "No Record Found";
    }
}
else {
    $branchnotificationcountsearch = '0';
    $branchStatus = $postdata['branchStatus'];
    $branchId = $postdata['branchName'];

    //$sqlsearch="SELECT * FROM `member_detail` md LEFT JOIN `branch` br ON md.branch_id=br.branch_id  where member_name='$name' AND is_branch_read = '$branchStatus' AND md.branch_id='$branchId'"; 
    //$sqlsearch = "SELECT * FROM `member_detail` md LEFT JOIN `branch` br ON md.branch_id=br.branch_id  where branch_id IN ($branchStatus','$branchId') order by date desc";

    $sqlsearch = "SELECT * FROM member_detail md
            LEFT JOIN transaction_notification trn ON (trn.member_id = md.member_id)
            LEFT JOIN branch as br ON (br.branch_id=trn.branch_id)
            WHERE date BETWEEN '$branchStatus' AND '$branchId' GROUP BY md.member_id ORDER BY date desc";

    $resultsearch = mysqli_query($con, $sqlsearch);
    $branchnotificationcountsearch = count($resultsearch);
    if ($branchnotificationcountsearch >= 0) {
        $response .='<table class="table table-bordered table-condensed table-striped table-responsive"><tr>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Date</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">From Branch</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">To Branch</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Member Name</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Member/Center Code</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Cheque Number</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Cheque Amount</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Bearer Name</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Status</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Remaining Balance</th></tr>';
        while ($row = mysqli_fetch_array($resultsearch)) {
            
            if ($row['source_branch'] != $row['destination_branch']) {
                $to_branch = $row['source_branch'];
                $branch_name = "SELECT branch_name from branch where branch_id = '$to_branch'";
                $res = $con->query($branch_name);
                $branchName = $res->fetch_all(MYSQLI_ASSOC);
                $destination_branch = $branchName[0]["branch_name"];
            } else {
                $row['branch_name'];
            }
            
            if ($row['deposite_type'] == 'Pending') {

                $response = $response . "<tr class='info' style='font-weight:bold;font-size:12px;'>" . "<td class='notification-subject'>" . $row["date"] . "</td>" . "<td class='notification-subject'>" . $destination_branch . "</td>" . "<td class='notification-subject'>" . $row["branch_name"] . "</td>";

                $response = $response . "<td class='notification-subject'>" . $row["member_name"] . "</td>" . "<td class='notification-subject'>" . $row["member_code"] . "</td>" . "<td class='notification-subject'>" . $row["member_check_number"] . "</td>"."<td class='notification-subject'>" . $row["amount"] . "</td>" . "<td class='notification-subject'>" . $row["member_name"] . "</td>" . "<td class='notification-subject'>" . $row["deposite_type"] . "</td>" ."<td class='notification-subject'>".$row['balance_amount']."</td>" . "</tr>";
            } //$i++;
            else {
                $response = $response . "<tr >" . "<td class='notification-subject'>" . $row["date"] . "</td>" . "<td class='notification-subject'>" . $destination_branch . "</td>" . "<td class='notification-subject'>" . $row["branch_name"] . "</td>";

                $response = $response . "<td class='notification-subject'>" . $row["member_name"] . "</td>" . "<td class='notification-subject'>" . $row["member_code"] . "</td>" . "<td class='notification-subject'>" . $row["member_check_number"] . "</td>"."<td class='notification-subject'>" . $row["amount"] . "</td>" . "<td class='notification-subject'>" . $row["member_name"] . "</td>" . "<td class='notification-subject'>" . $row["deposite_type"] . "</td>" . "<td class='notification-subject'>".$row['balance_amount']."</td>" . "</tr>";
            }
        }
    } else {
        echo "No record found";
    }
    $response = $response . "</table>";
    print $response;
}