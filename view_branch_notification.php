<?php
session_start();
include_once 'includes/dbconnect.php';
$name = $_SESSION['usr_name'];
$branch_id = $_SESSION['branch_id'];
$response = '';
$sql="SELECT DATE_FORMAT(date, '%d-%b-%y') AS displaydate,md.member_id as memberId,md.*,trn.*,br.* from transaction_notification trn 
LEFT JOIN member_detail as md ON (md.member_id=trn.member_id) 
LEFT JOIN branch as br ON (br.branch_id=trn.branch_id)
where trn.branch_id='$branch_id' AND is_check_submitted ='2' AND is_notification_read != '2' ORDER BY date DESC"; 
$result = mysqli_query($con, $sql);
$branchnotificationcount = sizeof($result);
if ($branchnotificationcount > 0) {
   
    $response .='<table class="table table-bordered table-condensed table-striped table-responsive"><tr>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Date</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Branch Code</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Branch Name</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Member/Center Code</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Amount</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Bearer Name</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Status</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Action</th></tr>';
   // $i = 1;
    while ($row = mysqli_fetch_array($result)) {
        if($row['deposite_type']=='Pending'){
        
        $response = $response ."<tr class='info' style='font-weight:bold;font-size:12px;' >"."<td class='notification-subject'>" . $row["displaydate"] . "</td>" . "<td class='notification-subject' width=10%>" . $row["branch_code"] . "</td>"; 
		
		$response = $response ."<td class='notification-subject'>" . $row["branch_name"] . "</td>" . "<td class='notification-subject'>" . $row["member_code"] . "</td>" . "<td class='notification-subject'>" . $row["amount"] . "</td>" . "<td class='notification-subject'>" . $row["member_name"] . "</td>" . "<td class='notification-subject'>" . $row["deposite_type"] . "</td>"."<td class='View Detail'><a class='btn btn-sm btn-primary'  href='view_member_detail.php?transactionId=".$row['transaction_id']."&memberId=".$row['member_id']."&branchId=".$row['branch_id']."'>View Detail</a></td>" . "</tr>";

        } //$i++;
        else{
            $response = $response ."<tr >"."<td class='notification-subject' width=10%>" . $row["displaydate"] . "</td>" . "<td class='notification-subject'>" . $row["branch_code"] . "</td>"; 
		
		$response = $response ."<td class='notification-subject'>" . $row["branch_name"] . "</td>" . "<td class='notification-subject'>" . $row["member_code"] . "</td>" . "<td class='notification-subject'>" . $row["amount"] . "</td>" . "<td class='notification-subject'>" . $row["member_name"] . "</td>" . "<td class='notification-subject'>" . $row["deposite_type"] . "</td>"."<td class='View Detail'><a class='btn btn-sm btn-primary'  href='view_member_detail.php?transactionId=".$row['transaction_id']."&memberId=".$row['member_id']."&branchId=".$row['branch_id']."'>View Detail</a></td>" . "</tr>";

        }
    }
}
$response = $response . '</table>';
print $response;
