

<?php
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
    <table id="tblPayment" class="table table-striped table-condensed responsive-table">

        <thead>
            <tr>

                <th>Date</th>
                <th>From Branch</th>
                <th>To Branch</th>
                <th>Member Name</th>
                <th>Member/Center Code</th>
                
                <th>Cheque Number</th>
                <th>Cheque Amount</th>
                <th>Bearer Name</th>
                 <th>Remaining Balance</th>
                <th>Status</th>
            </tr>
        </thead>

        <?php
        $status = "Approved";
        //$query1 = "SELECT * FROM member_detail as ds  LEFT JOIN transaction_notification as trn ON (trn.member_id = ds.member_id) WHERE trn.source_branch='$branch_id' ORDER BY date DESC";
        $query1 = "SELECT *
                                FROM transaction_notification trn
                                LEFT JOIN member_detail md ON (md.member_id = trn.member_id)
                                LEFT JOIN branch as br ON (br.branch_id = trn.branch_id) WHERE trn.source_branch='$branch_id' AND trn.deposite_type='$status'
                                GROUP BY md.member_id ORDER BY deposite_type ASC";
        $result1 = mysqli_query($con, $query1);
        while ($row1 = mysqli_fetch_array($result1)) {
            ?>

            <tbody>
                <tr>

                    <td><?php echo $row1['date']; ?></td>

                     <?php
                if ($row1['source_branch'] != $row1['destination_branch']) {
                    $to_branch = $row1['source_branch'];
                    $branch_name = "SELECT branch_name from branch where branch_id = '$to_branch'";
                    $result = $con->query($branch_name);
                    $branchName = $result->fetch_all(MYSQLI_ASSOC);
                    echo "<td>" . $branchName[0]['branch_name'] . "</td>";
                } else {
                    echo "<td>" . $row1['branch_name'] . "</td>";
                }
                ?>
                 <td><?php echo $row1['branch_name']; ?></td>
                    <td><?php echo $row1['member_name']; ?></td>
                    <td><?php echo $row1['member_code']; ?></td>
                   
                    <td><?php echo $row1['member_check_number']; ?></td>
                     <td><?php echo $row1['amount']; ?></td>
                    <td><?php echo $row1['payee_name']; ?></td>
                     <td><?php echo $row1['balance_amount']; ?></td>
                    <td style="color:Green;font-weight:bold;"><?php echo $row1['deposite_type']; ?></td>
                </tr>
            </tbody>
        <?php }
        ?>
    </table>

<?php } else if ($radio == "Rejected") {
    ?>
    <table id="tblPayment" class="table table-condensed table-striped responsive-table">
        <thead>
            <tr>

                <th>Date</th>
                <th>From Branch</th>
                <th>To Branch</th>
                <th>Member Name</th>
                <th>Member/Center Code</th>
                <th>Cheque Number</th>
                <th>Cheque Amount</th>
                <th>Bearer Name</th>
                <th>Balance Amount</th>
                <th>Status</th>
                <th>Reason</th>

            </tr>
        </thead>
        <?php
        $status = "Rejected";

        //$query1 = "SELECT * FROM member_detail as ds  LEFT JOIN transaction_notification as trn ON (trn.member_id = ds.member_id) WHERE trn.source_branch='$branch_id' ORDER BY date DESC";
        $query1 = "SELECT *
                                FROM transaction_notification trn
                                LEFT JOIN member_detail md ON (md.member_id = trn.member_id)
                                LEFT JOIN branch as br ON (br.branch_id = trn.branch_id) WHERE trn.source_branch='$branch_id' AND trn.deposite_type='$status'
                                GROUP BY md.member_id ORDER BY deposite_type ASC";

        $result1 = mysqli_query($con, $query1);
        while ($row1 = mysqli_fetch_array($result1)) {
            ?><tbody>
                <tr>

                    <td><?php echo $row1['date']; ?></td>
                <?php
                if ($row1['source_branch'] != $row1['destination_branch']) {
                    $to_branch = $row1['source_branch'];
                    $branch_name = "SELECT branch_name from branch where branch_id = '$to_branch'";
                    $result = $con->query($branch_name);
                    $branchName = $result->fetch_all(MYSQLI_ASSOC);
                    echo "<td>" . $branchName[0]['branch_name'] . "</td>";
                } else {
                    echo "<td>" . $row1['branch_name'] . "</td>";
                }
                ?>
                 <td><?php echo $row1['branch_name']; ?></td>
                    <td><?php echo $row1['member_name']; ?></td>
                    <td><?php echo $row1['member_code']; ?></td>
                    <td><?php echo $row1['member_check_number']; ?></td>
                    <td><?php echo $row1['amount']; ?></td>
                    <td><?php echo $row1['payee_name']; ?></td>
                     <td><?php echo $row1['balance_amount']; ?></td>
                    <td style="color:red;font-weight:bold;"><?php echo $row1['deposite_type']; ?></td>
                    <td><?php echo $row1['comment']; ?></td>
                </tr>
            </tbody>
        <?php } ?>
    </table>

<?php } else {
    ?>  

    <table id="tblPayment" class="table table-condensed table-striped responsive-table">
        <thead>

        <th>Date</th>
        <th>From Branch</th>
        <th>To Branch</th>
        <th>Member Name</th>
        <th>Member/Center Code</th>
        <th>Cheque Number</th>
        <th>Cheque Amount</th>
        <th>Bearer Name</th>
        <th>Remaining Balance</th>
        <th>Status</th>
    </thead>
    <?php
    //$query1 = "SELECT * FROM member_detail as ds  LEFT JOIN transaction_notification as trn ON (trn.member_id = ds.member_id) WHERE trn.source_branch='$branch_id' ORDER BY date DESC";
    $query1 = "SELECT *
                                FROM transaction_notification trn
                                LEFT JOIN member_detail md ON (md.member_id = trn.member_id)
                                LEFT JOIN branch as br ON (br.branch_id = trn.branch_id) WHERE trn.source_branch='$branch_id'
                                GROUP BY md.member_id ORDER BY deposite_type ASC";

    $result1 = mysqli_query($con, $query1);
    while ($row1 = mysqli_fetch_array($result1)) {
        ?><tbody>
            <tr>

                <td><?php echo $row1['date']; ?></td>

                <?php
                if ($row1['source_branch'] != $row1['destination_branch']) {
                    $to_branch = $row1['source_branch'];
                    $branch_name = "SELECT branch_name from branch where branch_id = '$to_branch'";
                    $result = $con->query($branch_name);
                    $branchName = $result->fetch_all(MYSQLI_ASSOC);
                    echo "<td>" . $branchName[0]['branch_name'] . "</td>";
                } else {
                    echo "<td>" . $row1['branch_name'] . "</td>";
                }
                ?>
                 <td><?php echo $row1['branch_name']; ?></td>
                <td><?php echo $row1['member_name']; ?></td>
                <td><?php echo $row1['member_code']; ?></td>
                <td><?php echo $row1['member_check_number']; ?></td>
                <td><?php echo $row1['amount']; ?></td>
                <td><?php echo $row1['payee_name']; ?></td>
                 <td><?php echo $row1['balance_amount']; ?></td>
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

<?php }
?>