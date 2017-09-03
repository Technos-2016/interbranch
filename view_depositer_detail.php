<?php
include_once 'includes/dbconnect.php';
$postdata = $_POST;
$destination_branch_id = $postdata['deposit_id'];
$branch_id = $postdata['branch_id']; 
$response='';
$sql="SELECT DATE_FORMAT(date, '%d-%b-%y') AS displaydate,ds.id as depostitorId,ds.*,trn.*,br.* from deposit as ds JOIN transaction_notification_depositor as trn ON (trn.member_id=ds.id) JOIN branch as br ON (br.branch_id=trn.branch_id) where trn.branch_id='$branch_id'"; 
$result=mysqli_query($con, $sql);
$branchnotificationcount = sizeof($result); 
if($branchnotificationcount > 0){
	$response .='<table class="table"><tr><th class="col-md-1 col-sm-1 col-xs-1 hero-feature ">S.No</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Date</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Branch Code</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Branch Name</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Member Code</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Amount</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Bearer Name</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Status</th><th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Action</th></tr>';
							$i = 1;
						while($row=mysqli_fetch_array($result)) {
							$response = $response ."<tr>"."<td class='notification-subject'>". $i . "</td>" . "<td class='notification-subject'>".$row["displaydate"]. "</td>"."<td class='notification-subject'>". $row["_code"]."</td>"."<td class='notification-subject'>". $row["branch_name"] . "</td>"."<td class='notification-subject'>". $row["member_code"] . "</td>"."<td class='notification-subject'>". $row["amount"] . "</td>"."<td class='notification-subject'>". $row["depositor"] . "</td>"."<td class='notification-subject'>------</td>"."<td class='notification-subject'><button type='button' onClick=checkstatusApprove('" . $row['depostitorId']. "','" . $row['branch_id']. "'); class='btn btn-info'>View</button>"."</td>"."</tr>";
							
						$i++;} 
						}
$response = $response .'</table>';
print $response;
?>


