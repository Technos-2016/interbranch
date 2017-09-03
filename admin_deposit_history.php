<?php
error_reporting(0);
$postdata = $_POST;
session_start();
include_once 'includes/dbconnect.php';
$name = $_SESSION['usr_name'];
$branch_id = $_SESSION['branch_id'];
$response = '';
if (empty($postdata)){
$sql="SELECT * FROM deposit as ds LEFT JOIN transaction_notification_depositor as trn ON (trn.member_id = ds.id)  ORDER BY deposite_type ASC"; 
$result = mysqli_query($con, $sql);
$branchnotificationcount = sizeof($result);
if ($branchnotificationcount > 0) {
   
    $response = $response.'<table class="table table-bordered table-condensed table-striped table-responsive"><tr>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Date</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">From Branch</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">To Branch</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Spouse/Father-In-Law Name</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Member Name</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Member/Center Code</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Amount</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Depositor</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Status</th>
                      </tr>';
    
     
       
      
   // $i = 1;
    while ($row = mysqli_fetch_array($result)) {
        
        if($row['branch_id']!=$row['source_branch_id']){ 
		$source_branch = $row['branch_id'];
		$branch_name = "SELECT branch_name from branch where branch_id = '$source_branch'"; 
		$res = $con->query($branch_name);
		$branchName = $res->fetch_all(MYSQLI_ASSOC);	
		$destination_branch=$branchName[0]["branch_name"];
		}
                else{
                     $row['source_branch_name'];
                }
        
        
        
        if($row['deposite_type']=='Pending'){
        
        $response = $response ."<tr class='info' style='font-weight:bold;font-size:12px;'>"."<td class='notification-subject'>" . $row["date"] . "</td>" . "<td class='notification-subject'>" . $row["source_branch_name"] . "</td>"; 
		
		$response = $response ."<td class='notification-subject'>" . $destination_branch . "</td>" . "<td class='notification-subject'>" . $row["member_name"] . "</td>" ."<td class='notification-subject'>" . $row["spouse"] . "</td>" ."<td class='notification-subject'>" . $row["member_code"] . "</td>" . "<td class='notification-subject'>" . $row["amount"] . "</td>" . "<td class='notification-subject'>" . $row["member_name"] . "</td>" . "<td class='notification-subject'>" . $row["deposite_type"] . "</td>". "</tr>";

        } //$i++;
        else{
            $response = $response ."<tr >"."<td class='notification-subject'>" . $row["date"] . "</td>" . "<td class='notification-subject'>" . $row["source_branch_name"]. "</td>"; 
		
		$response = $response ."<td class='notification-subject'>" . $destination_branch . "</td>" ."<td class='notification-subject'>" . $row["spouse"] . "</td>" . "<td class='notification-subject'>" . $row["member_name"] . "</td>" . "<td class='notification-subject'>" . $row["member_code"] . "</td>" . "<td class='notification-subject'>" . $row["amount"] . "</td>" . "<td class='notification-subject'>" . $row["member_name"] . "</td>" . "<td class='notification-subject'>" . $row["deposite_type"] . "</td>". "</tr>";

        }
    }
}
$response = $response . '</table>';
if(!empty($response)) {
	print $response;
}

else{
	echo "No Record Found";
}
}
else {
	$branchnotificationcountsearch = '0';
	$branchStatus = $postdata['branchStatus']; 
	$branchId = $postdata['branchName'];
	
	//$sqlsearch="SELECT * FROM `member_detail` md LEFT JOIN `branch` br ON md.branch_id=br.branch_id  where member_name='$name' AND is_branch_read = '$branchStatus' AND md.branch_id='$branchId'"; 
	$sqlsearch="SELECT * FROM deposit as ds LEFT JOIN transaction_notification_depositor as trn ON (trn.member_id = ds.id) WHERE date BETWEEN '$branchStatus' AND '$branchId' ORDER BY date DESC"; 

        
        $resultsearch=mysqli_query($con, $sqlsearch);
	$branchnotificationcountsearch = count($resultsearch); 
	if($branchnotificationcountsearch >= 0){
	 $response .='<table class="table table-bordered table-condensed table-striped table-responsive"><tr>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Date</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">From branch</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">To Branch</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Spouse/Father-In-Law</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Member Code</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Member Name</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Amount</th>
                            <th class="col-md-2 col-sm-2 col-xs-2 hero-feature">Depositor</th>
                            <th class="col-md-1 col-sm-1 col-xs-1 hero-feature">Status</th>
                           </tr>';
        while ($row = mysqli_fetch_array($resultsearch)) {
            if($row['branch_id']!=$row['source_branch_id']){ 
		$source_branch = $row['branch_id'];
		$branch_name = "SELECT branch_name from branch where branch_id = '$source_branch'"; 
		$res = $con->query($branch_name);
		$branchName = $res->fetch_all(MYSQLI_ASSOC);	
		$destination_branch=$branchName[0]["branch_name"];
		}
                 else{
                     $row['source_branch_name'];
                }
            
        if($row['deposite_type']=='Pending'){
        
        $response = $response ."<tr class='info' style='font-weight:bold;font-size:12px;'>"."<td class='notification-subject'>" . $row["date"] . "</td>" . "<td class='notification-subject'>" .$row["source_branch_name"] . "</td>"; 
		
		$response = $response ."<td class='notification-subject'>" . $destination_branch . "</td>" . "<td class='notification-subject'>" . $row["member_code"] . "</td>" . "<td class='notification-subject'>" . $row["spouse"] . "</td>"."<td class='notification-subject'>" . $row["member_name"] . "</td>"."<td class='notification-subject'>" . $row["amount"] . "</td>" . "<td class='notification-subject'>" . $row["depositor"] . "</td>" . "<td class='notification-subject'>" . $row["deposite_type"] . "</td>". "</tr>";

        } //$i++;
        else{
            $response = $response ."<tr >"."<td class='notification-subject'>" . $row["date"] . "</td>" . "<td class='notification-subject'>" . $row["source_branch_name"] . "</td>"; 
		
		$response = $response ."<td class='notification-subject'>" . $destination_branch . "</td>" . "<td class='notification-subject'>" . $row["member_code"] . "</td>" ."<td class='notification-subject'>" . $row["spouse"] . "</td>" ."<td class='notification-subject'>" . $row["member_name"] . "</td>"."<td class='notification-subject'>" . $row["amount"] . "</td>" . "<td class='notification-subject'>" . $row["depositor"] . "</td>" . "<td class='notification-subject'>" . $row["deposite_type"] . "</td>". "</tr>";

        }
    }
}
else {echo "No record found";}
$response = $response ."</table>";
print $response;
}