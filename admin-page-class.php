<?php

error_reporting(0);

include_once 'includes/dbconnect.php';
date_default_timezone_set('Etc/UTC');
require_once 'PHPMailer/class.phpmailer.php';
require_once 'PHPMailer/PHPMailerAutoload.php';

class Main_Class {

    //put your code here
    // constructor
    function __construct() {
        
    }

    // destructor
    function __destruct() {
        
    }

    public function getPassdeatils() {
        $list = array();
        $getQuery = "SELECT id,name,email,password FROM users";

        $getResultQuery = mysqli_query($getQuery, $con);
        while ($resultRow = mysqli_fetch_array($getResultQuery)) {

            $getdata['id'] = $resultRow['id'];
            $getdata['name'] = $resultRow['name'];
            $getdata['email'] = $resultRow['email'];
            $getdata['password'] = decryptIt($resultRow['password']);

            array_push($list, $getdata);
        }
        return $list;
    }

    public function makeRandomPassword() {
        $salt = "abchefghjkmnpqrstuvwxyz0123456789";
        rand((double) microtime() * 1000000);
        $i = 0;
        while ($i <= 7) {
            $num = rand() % 33;
            $tmp = substr($salt, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
        return $pass;
    }

    public function Token($EmailID, $pass) {

        $to = $EmailID;

        // subject
        $subject = 'ABBS Password Information';
        // message
        $message1 = '<!DOCTYPE html><html><head></head><body style="font-family:Calibri; font-size:14px; width:600px;background:#ffffff;"><div style="padding:5px 10px 0px 10px;width:100%;float:left;color:black;"><div style="width:100%;float:left;background:#fde3c2;border-radius:0.3em 0.3em 0 0;"><img src="http://110.34.13.19:81/abbs/images/logo.png" style="padding-top:10px;padding-bottom:10px;"></div>
								   <div style="width:100%;padding:5px 10px 0px 10px;float:left;color:black; background-color:#ffffff;">
						<table>
							
							<tr>
								<td>
									<h4><b>Email ID :</b></h4></td>
								<td>' . $EmailID . '</td>
							</tr>
							<tr>
								<td>
									<h4><b>Password :</b></h4></td>
								<td>' . $pass . '</td>
							</tr>
							</table>
							<div style="width:100%;padding:5px 10px 0px 10px;float:left;color:black; background-color:#ffffff;">
<p style="text-align:left;font-family:Calibri;color:black;">
Thanks & Regards,<br />
<b>ABBS Portal</b>,<br />
<b>Contact No:- 9802714703</b>.
</p>
</div>
<div style="width:100%;float:left;background:#fde3c2;border-radius: 0 0 0.3em 0.3em;">
<p style="text-align:center;font-family: Open Sans Condensed, sans-serif;color:black;padding-left:15px">

<br>

</p>
</div>
									
					</div>
				</body>
			</html>';

        $mail = new PHPMailer();

        $mail->isSMTP();

        //$mail->SMTPDebug = 3;
        //$mail->Debugoutput = 'html';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'TLS';
        $mail->SMTPAuth = true;

        $mail->Username = 'saasjobs2013@gmail.com';
        $mail->Password = 'Welcome@2016';
        $mail->From = 'saasjobs2013@gmail.com';
        $mail->FromName = 'ABBS Portal';
        $mail->Subject = 'Password Information';
        $mail->Body = $message1;
        $mail->IsHTML(true);
        $mail->AddAddress($to);

        $mailsent = $mail->Send();
        if ($mailsent) {

            echo "<script type='text/javascript'>alert('Token has been email to you successfully - Please check your email');window.location='token.php';</script>";
        } else {

            echo "<script type='text/javascript'>alert('Mail sending fail! Please try again');window.location='logout.php';</script>";
        }
    }

    /*
      | -------------------------------------------------------------------
      |  This method is used to send password information to user.
      | -------------------------------------------------------------------
     */

    public function sendMail($EmailID, $name, $pass) {

        $to = $EmailID;


        // subject
        $subject = 'ABBS Password Information';
        // message
        $message1 = '<!DOCTYPE html><html><head></head><body style="font-family:Calibri; font-size:14px; width:600px;background:#ffffff;"><div style="padding:5px 10px 0px 10px;width:100%;float:left;color:black;"><div style="width:100%;float:left;background:#fde3c2;border-radius:0.3em 0.3em 0 0;"><img src="http://110.34.13.19:81/abbs/images/logo.png" style="padding-top:10px;padding-bottom:10px;"></div>
								   <div style="width:100%;padding:5px 10px 0px 10px;float:left;color:black; background-color:#ffffff;">
						<table>
							<tr>
								<td>
									<h4><b>Staff Name :</b></h4></td>
								<td>' . $name . '</td>
							</tr>
							<tr>
								<td>
									<h4><b>Email ID :</b></h4></td>
								<td>' . $EmailID . '</td>
							</tr>
							<tr>
								<td>
									<h4><b>Password :</b></h4></td>
								<td>' . $pass . '</td>
							</tr>
							</table>
							<div style="width:100%;padding:5px 10px 0px 10px;float:left;color:black; background-color:#ffffff;">
<p style="text-align:left;font-family:Calibri;color:black;">
Thanks & Regards,<br />
<b>ABBS Portal</b>,<br />
<b>Contact No:- 9802714703</b>.
</p>
</div>
<div style="width:100%;float:left;background:#fde3c2;border-radius: 0 0 0.3em 0.3em;">
<p style="text-align:center;font-family: Open Sans Condensed, sans-serif;color:black;padding-left:15px">

<br>

</p>
</div>
									
					</div>
				</body>
			</html>';

        $email = new PHPMailer();

        $email->isSMTP();

        //$email->SMTPDebug = 3;
        //$email->Debugoutput = 'html';
        $email->Host = 'smtp.gmail.com';
        $email->Port = 587;
        $email->SMTPSecure = 'TLS';
        $email->SMTPAuth = true;

        $email->Username = 'saasjobs2013@gmail.com';
        $email->Password = 'Welcome@2016';

        $email->From = 'saasjobs2013@gmail.com';
        $email->FromName = 'ABBS Portal';
        $email->Subject = 'Password Information';
        $email->Body = $message1;
        $email->IsHTML(true);
        $email->AddAddress($to);

        $mailsent = $email->Send();

        if ($mailsent) {

            echo "<script type='text/javascript'>
									alert('Password has been successfully send to their respective email');window.location='manage_users.php';
								  </script>";
        } else {

            echo "<script type='text/javascript'>
									alert('Mail sending fail! Please try again');window.location='manage_users.php';
								  </script>";
        }
    }

}

?>