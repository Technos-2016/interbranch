

<?php
error_reporting(0);
session_start();
if (isset($_SESSION['usr_id']) == "") {
    header("Location: login.php");
}
include_once 'includes/dbconnect.php';
$uid = $_SESSION['usr_id'];
$branch_id = $_SESSION['branch_id'];



//$mname=$_POST['mname'];
$radio = $_POST['radio'];
//if($mname!=''){

if ($radio == "Approved") {
    ?> 
    <table id="tblSearch" class="table table-striped table-condensed">

        <thead>
            <tr>

                <th>Date</th>
                <th>From Branch</th>
                <th>To Branch</th>
                <th>Spouse/Father-IN-Law</th>
                <th>Member Name</th>
                <th>Member/Center Code</th>
                <th>Amount</th>
                <th>Depositor Name</th>
                <th>Status</th>
            </tr>
        </thead>

        <?php
        $status = "Approved";
        //$query1 = "SELECT * FROM deposit as ds LEFT JOIN transaction_notification_depositor as trn ON (trn.member_id = ds.id) WHERE branch_id='$branch_id' AND deposite_type='$status' ORDER BY date DESC";
        $query1="SELECT * FROM deposit as ds LEFT JOIN transaction_notification_depositor as trn ON (trn.member_id = ds.id) WHERE  deposite_type='$status'  ORDER BY date desc"; 

        $result1 = mysqli_query($con, $query1);
        while ($row1 = mysqli_fetch_array($result1)) {
            ?>

            <tbody>
                <tr>

                    <td><?php echo $row1['date']; ?></td>
                    <td><?php echo $row1['source_branch_name']; ?></td>
                    <?php
                    if ($row1['branch_id'] != $row1['source_branch_id']) {
                        $to_branch = $row1['branch_id'];
                        $branch_name = "SELECT branch_name from branch where branch_id = '$to_branch'";
                        $result = $con->query($branch_name);
                        $branchName = $result->fetch_all(MYSQLI_ASSOC);
                        echo "<td>" . $branchName[0]['branch_name'] . "</td>";
                    } else {
                       echo "<td>" .$row1['source_branch_name']. "</td>";
                    }
                    ?>
                    <td><?php echo $row1['spouse']; ?></td>
                    <td><?php echo $row1['member_name']; ?></td>
                    <td><?php echo $row1['member_code']; ?></td>
                    <td><?php echo $row1['amount']; ?></td>
                    <td><?php echo $row1['depositor']; ?></td>
                    <td style="color:Green;font-weight:bold;"><?php echo $row1['deposite_type']; ?></td>
                </tr>
            </tbody>
        <?php }
    ?>
    </table>


        <?php
        
    } else if ($radio == "Rejected") {
        ?>
    <table id="tblSearch" class="table table-condensed table-striped responsive-table">
        <thead>
            <tr>

                <th>Date</th>
                <th>From Branch</th>
                <th>To Branch</th>
                 <th>Spouse/Father-In-Law</th>
                <th>Member Name</th>
                <th>Member/Center Code</th>
                <th>Amount</th>
                <th>Depositor Name</th>
                <th>Status</th>
                <th>Reason</th>

            </tr>
        </thead>
    <?php
    $status = "Rejected";

    $query1="SELECT * FROM deposit as ds LEFT JOIN transaction_notification_depositor as trn ON (trn.member_id = ds.id) WHERE deposite_type='$status' ORDER BY deposite_type ASC"; 

    $result1 = mysqli_query($con, $query1);
    while ($row1 = mysqli_fetch_array($result1)) {
        ?><tbody>
                <tr>

                    <td><?php echo $row1['date']; ?></td>
                    <td><?php echo $row1['source_branch_name']; ?></td>
            <?php
            if ($row1['branch_id'] != $row1['source_branch_id']) {
                $to_branch = $row1['branch_id'];
                $branch_name = "SELECT branch_name from branch where branch_id = '$to_branch'";
                $result = $con->query($branch_name);
                $branchName = $result->fetch_all(MYSQLI_ASSOC);
                echo "<td>" . $branchName[0]['branch_name'] . "</td>";
            } else {
                echo "<td>" .$row1['source_branch_name']. "</td>";
            }
            ?>
                     <td><?php echo $row1['spouse']; ?></td>
                    <td><?php echo $row1['member_name']; ?></td>
                    <td><?php echo $row1['member_code']; ?></td>
                    <td><?php echo $row1['amount']; ?></td>
                    <td><?php echo $row1['depositor']; ?></td>
                    <td style="color:red;font-weight:bold;"><?php echo $row1['deposite_type']; ?></td>
                    <td><?php echo $row1['comment']; ?></td>
                </tr>
            </tbody>
    <?php } ?>
    </table>

    <?php
    header("Content-Type:application/xls");
    header("Content-Deposition:attachment, filename:Rejected.xls");
} else {
    ?>  

    <table id="tblSearch" class="table table-condensed table-striped responsive-table">
        <thead>

        <th>Date</th>
        <th>From Branch</th>
        <th>To Branch</th>
        <th>Spouse/Father-IN-Law</th>
        <th>Member Name</th>
        <th>Member/Center Code</th>
        <th>Amount</th>
        <th>Depositor Name</th>
        <th>Status</th>
    </thead>
    <?php
    $query1="SELECT * FROM deposit as ds LEFT JOIN transaction_notification_depositor as trn ON (trn.member_id = ds.id)  ORDER BY deposite_type ASC"; 

    $result1 = mysqli_query($con, $query1);
    while ($row1 = mysqli_fetch_array($result1)) {
        ?><tbody>
            <tr>

                <td><?php echo $row1['date']; ?></td>
                <td><?php echo $row1['source_branch_name']; ?></td>
        <?php
        if ($row1['branch_id'] != $row1['source_branch_id']) {
            $to_branch = $row1['branch_id'];
            $branch_name = "SELECT branch_name from branch where branch_id = '$to_branch'";
            $result = $con->query($branch_name);
            $branchName = $result->fetch_all(MYSQLI_ASSOC);
            echo "<td>" . $branchName[0]['branch_name'] . "</td>";
        } else {
            echo "<td>" .$row1['source_branch_name']. "</td>";
        }
        ?>
                <td><?php echo $row1['spouse']; ?></td>
                <td><?php echo $row1['member_name']; ?></td>
                <td><?php echo $row1['member_code']; ?></td>
                <td><?php echo $row1['amount']; ?></td>
                <td><?php echo $row1['depositor']; ?></td>



                <?php if ($row1['deposite_type'] == 'Approved') { ?>
                    <td style="color:Green;font-weight:bold;"><?php echo $row1['deposite_type']; ?></td>
        <?php } else if ($row1['deposite_type'] == 'Rejected') { ?><td style="color:red;font-weight:bold;"><?php echo $row1['deposite_type']; ?></td><?php } else {
            ?>
                    <td style="color:#123;font-weight:bold;"><?php echo $row1['deposite_type']; ?></td><?php
        }
        ?>




            <tr>
        </tbody>
                <?php }
            ?>
    </table>

    <?php
    header("Content-Type:application/xls");
    header("Content-Deposition:attachment, filename:All.xls");
}
?>