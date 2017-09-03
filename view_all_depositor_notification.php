<?php

session_start();
include_once 'includes/dbconnect.php';
$name = $_SESSION['usr_name'];
//$source_branch_id = $_SESSION['branch_id'];
$branch_id = $_SESSION['branch_id'];
$response = '';
$sql = "SELECT DATE_FORMAT(date, '%d-%b-%y') AS displaydate,ds.id as depostitorId,ds.*,trn.*,br.* from deposit as ds JOIN transaction_notification_depositor as trn ON (trn.member_id=ds.id) JOIN branch as br ON (br.branch_id=trn.branch_id) where trn.branch_id='$branch_id' ORDER BY date DESC"; 
$result = mysqli_query($con, $sql);
$branchnotificationcount = sizeof($result);
if ($branchnotificationcount > 0) {
    $response .='<table class="table table-bordered table-condensed table-striped"><tr>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Date</th>
                            <!--<th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Branch Code</th>-->
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">From Branch</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">To Branch</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Member/Center Code</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Member Name</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Amount</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Depositor Name</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Status</th></tr>';
    $i = 1;
    while ($row = mysqli_fetch_array($result)) {

        
        
        $response = $response . "<tr>"  . "<td class='notification-subject' width=9%>" . $row["displaydate"] . "</td>" . "<td class='notification-subject' width=20%>" . $row["source_branch_name"] . "</td>";
		if($row['branch_id']!=$row['source_branch_id']){
		
		
        $response = $response . "<td class='branch_notification'>". $row['branch_name']. "</td>";
		}
		else{
			$response = $response . "<td class='branch_notification'>".$row['source_branch_name']."</td>";
		}
		
   		$response .= "<td class='notification-subject' width=10%>" . $row["member_code"] . "</td>" ."<td class='notification-subject' width=18%>" . $row["member_name"] . "</td>". "<td class='notification-subject'>" . $row["amount"] . "</td>" . "<td class='notification-subject' width=18%>" . $row["depositor"] . "</td>" . "<td class='notification-subject'>".$row["deposite_type"] . "</td>" . "</tr>";
        
        
        
        $i++;
    }
}
$response = $response . '</table>';
print $response;
