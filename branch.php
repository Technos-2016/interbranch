<?php
session_start();
$user_id = $_SESSION['usr_id'];
include_once 'includes/dbconnect.php';

$sql = "SELECT * from branch";
$branches = mysqli_query($con, $sql);
$branchnotificationcount = sizeof($branches);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Branch</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" >
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
    </head>
    <body>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php" sytle="">JBS ABBS DEPOSIT</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">

                        <li class="text-center" style="margin-right:220px;margin-top:15px;color:#FFF;font-weight:bold;"><?php echo strtoupper($_SESSION['branch_name']); ?></li>
                        <li><a href="index.php" >Home</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" ><?php if (isset($_SESSION['usr_id'])) { ?> Welcome <?php echo $_SESSION['usr_name']; ?><span class="caret"></span></a>

                                <ul class="dropdown-menu">

                                    <li>
                                        <a href="logout.php">Log Out
                                        </a>
                                    </li>
                                <?php } else { ?>
                                    <li class="active">
                                        <a href="login.php">Login
                                        </a>
                                    </li> 


                                <?php } ?>

                                <!--<li><a href="register.php">Sign Up</a></li>-->
                            </ul>
                        </li>



                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>
        <div class="container" style="margin-top:100px;">

            <header >
                <h1 class="text-center">Please Fill in the Credentials Correctly to Deposit Cheque
                </h1>
            </header>
            <hr>

            <?php
            if (isset($_SESSION['message'])) {//echo $_SESSION['message'];
            }
            ?>

            <div class="row" >
                <form action=""  method="post" name="frmBranch" id="frmBranch" class="" enctype="multipart/form-data">

                    <div class="col-md-6 pull-left form-group em-form">
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label for="Depositor Name">Bearer Name
                                </label>
                            </div>
                            <div class="col-sm-6 ">

                                <input class="form-control " placeholder="Please Enter Bearer Name" id="payeename"  name="payeename" placeholder="Payee Name" required data-bv-notempty-message="Please enter payee name" title="Payee Name" type="text"  />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-4">
                                <br/> 
                                <label for="Member Name">Member Name
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <br/>
                                <input class="form-control" placeholder="Please Enter Member Name" id="mname" maxlength="30" name="mname" placeholder="Member Name" required data-bv-notempty-message="Please enter member name" title="Member Name" type="text" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <br/>
                                <label for="Member Code">Member/Center Code 
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <br/>
                                <input class="form-control"  id="mcode" maxlength="8" name="mcode" placeholder="Please Enter Member (123.12.2) / Center Code(123)" required data-bv-notempty-message="Please enter in the given format 000.00.0" data-bv-regexp="true" data-bv-regexp-regexp="^\s*-?[0-9].{1,100}.\s*$" data-bv-regexp-message="Please enter  in the given format 000.00.0" title="Please Enter Member (123.12.2) / Center Code(123)" type="text"  onkeyup="round_off(this.value)"/>
                                <input  type="hidden"  name="user_id" id="user_id" value="<?php echo $user_id; ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <br/> 
                                <label for="Branch" class="field prepend-icon" >Branch Name
                                    <em class="required">*
                                    </em>
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <br/>
                                <select id="sel_branch" name="sel_branch" class="form-control" required data-bv-notempty-message="Please select branch.">
                                    <option value="">Select Branch</option>
                                    <?php
                                    foreach ($branches as $branch) {
                                        echo '<option value="' . $branch['branch_id'] . '">' . "(" . $branch['branch_code'] . ") &nbsp;" . $branch['branch_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>	

                        <div class="form-group">
                            <div class="col-sm-4"> 
                                <br/>
                                <label for="Amount">Amount
                                </label>
                            </div>
                            <div class="col-sm-6"> 
                                <br/>
                                <input class="form-control" placeholder="Please Enter Cheque Amount" id="amount" maxlength="7" name="amount"  required data-bv-notempty-message="Please enter amount" data-bv-regexp="true" data-bv-regexp-regexp="^\s*-?[0-9]{1,100}\s*$" data-bv-regexp-message="Please enter  only numbers." title="Please Enter Cheque Amount" type="text" />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-4"> 
                                <br/>
                                <label for="Cheque">Cheque No
                                </label>
                            </div>
                            <div class="col-sm-6"> 
                                <br/>
                                <input class="form-control" id="mcheckno" maxlength="7" name="mcheckno" placeholder="Please Enter Cheque Number" required data-bv-notempty-message="Please enter Cheque Number" data-bv-regexp="true" data-bv-regexp-regexp="^\s*-?[0-9]{1,100}\s*$" data-bv-regexp-message="Please enter  only numbers." title="Please Enter Member Cheque Number" type="text" />
                            </div>
                        </div>



                    </div>


                    <div class="col-md-6 pull-right">

                        <!-- <div class="form-group">
 
 
 
                             <div class="col-sm-6"> 
                                 <input type="button"  class="btn btn-sm btn-info" name="photo" value="capture Image" /><br/>
 
 
                                 <div class="capturepart">
                                     <div id="my_camera"></div>
                                     <br/>
                                     <div id="pre_take_buttons">
                                         <input type="button" value="Capture Photo" onClick="preview_snapshot()" class="btn btn-success">
                                     </div>
                                     <div id="post_take_buttons" style="display:none">
                                         <input type="button" value="&lt; Take Another" onClick="cancel_preview()" class="btn btn-success">
                                         <input type="button" value="Save Photo &gt;" onClick="save_photo()" style="font-weight:bold;" class="btn btn-success">
 
                                     </div>		
                                 </div>	
 
                             </div>
                             <div class="col-sm-6" >
                                 <input type="hidden" name="capture_image" class="capture_image " value="" >
                                 <div id="results" style="margin-top:30px;"></div>
                             </div>
 
 
                         </div>-->

                        <div class="form-group">

                            <div class="col-sm-12">
                                <input type="hidden" >
                                <img  id="image" class="img-rounded"  src="" style="padding:10px;width:100%;" />
                            </div>
                            <div class="col-sm-12"> 
                                <br/>
                                <label for="Cheque Image">Upload Cheque
                                </label>

                                <br/>
                                <input class="btn btn-info" id="mcheckimage"  onchange="readURL(this);" name="mcheckimage" placeholder="Member Cheque Number" required data-bv-notempty-message="Please enter chequeimage" title="Member Cheque Image" style="width: 80%; height:10%" type="file" />
                            </div>



                        </div>
                    </div>

                    <div class="row col-md-12">
                        <div class="form-group">
                            <div class="col-md-6">
                                <button class="btn btn-lg btn-warning pull-left btn-block" value="Cancel" id="previewBtn" data-toggle="modal" data-target="#confirm-submit" type="button" style="margin:right 40px !important; margin-top:13px;">Preview</button>
                            </div>   

                            <div class="col-md-6">
                                <button type="submit" id="headquarterDetail" class="btn btn-lg btn-success pull-right btn-block" value="Save Changes" style="margin:right 40px !important; margin-top:13px;">Submit Cheque</button>
                            </div>

                        </div>
                    </div>

                    <div class="row">




                    </div>

                </form>
                <span class="text-danger">
                    <?php
                    if (isset($errormsg)) {
                        echo $errormsg;
                    }
                    ?>
                </span>

            </div>
        </div>
        <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-body">
                        <h4>Are you sure you want to submit the following details?</h4>

                        <!-- We display the details entered by the user here -->
                        <table class="table">
                            <tr>
                                <th>Payee Name</th>
                                <td id="payee_name"></td>
                            </tr>
                            <tr>
                                <th>Member Name</th>
                                <td id="member_name"></td>
                            </tr>
                            <tr>
                                <th>Member/Center Code</th>
                                <td id="member_code"></td>
                            </tr>
                            <tr>
                                <th>Branch Name</th>
                                <td id="branch_name_display"></td>
                            </tr>
                            <tr>
                                <th>Cheque Number</th>
                                <td id="check_number"></td>
                            </tr>
                            <tr>
                                <th>Amount</th>
                                <td id="check_amount"></td>
                            </tr>
                            
                        </table>

                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>



                    </div>
                </div>
            </div>
        </div>
        <?php include_once ('includes/footer.php'); ?>
        <script>

            function round_off(mystring) {
                //my = mystring.substring(0, 3);
                //document.getElementById("member_code").value = my;
//alert(mystring);
                mystring = mystring.replace(/\./g, '');
                mystring = mystring.substring(0, 6);

                mystring1 = mystring.substring(0, 3);
                //document.getElementById("member_code").value = mystring1;
                mystring2 = mystring.substring(3, 5);
                mystring3 = mystring.substring(5, 6);

                mystring3 = "" + mystring1 + "." + mystring2 + "" + "." + mystring3;
//alert(mystring2);
                if (mystring != "" && mystring.length > 3) {
                    document.getElementById("mcode").value = mystring3;
                }

            }




            $('#previewBtn').click(function () {
                /* when the button in the form, display the entered values in the modal */
                var branchName = $('#sel_branch').find(":selected").text();
                 $('#payee_name').text($('#payeename').val());
                $('#member_name').text($('#mname').val());
                //$('#member_code').text($('#mcode').val());
                
                var name = $.trim($('#mcode').val());
                if( name === ""){
                    alert('Member/Center Code is Empty');
                    return false;
                }
                if (name.length > 8 || name.length < 3  ) {
                    alert('Please Enter Either Center Code (123) or Member Code (123.12.1) in the given format!');
                    return false;
                }
                $('#member_code').text($('#mcode').val());


                $('#branch_name_display').text(branchName);
                
                var name = $.trim($('#amount').val());
                if (name === "") {
                    alert('Please Enter the Amount From Cheque');
                    return false;
                }
                if (name > 1000000) {
                    alert('You can only Deposit Upto 1000000');
                    return false;
                }
                if (isNaN(name)) {
                    alert('please enter number in Amount Field');
                    return false;
                }
                $('#check_amount').text($('#amount').val());

                var name = $.trim($('#mcheckno').val());
                if (name.length > 7 || name.length < 7) {
                    alert('Cheque Number cannot contain more or less than 7 characters !');
                    return false;
                }

                $('#check_number').text($('#mcheckno').val());

                //$('#check_amount').text($('#amount').val());

               
            });

            /*$(document).ready(
             function () {
             setInterval(function () {
             $.ajax({
             url: 'view_branch_count.php',
             cache: false,
             success: function (data)
             {
             $('.countnotification').html(data);
             },
             });
             }, 1000);
             });
             
             $(document).ready(
             function () {
             setInterval(function () {
             $.ajax({
             url: 'show_branch_count_other_branch.php',
             cache: false,
             success: function (data)
             {
             // alert(data);	
             $('.countnotificationotherbranch').html(data);
             },
             });
             }, 1000);
             });*/

        </script>
        <script type="text/javascript">
            function preview_snapshot() {
                // freeze camera so user can preview pic
                Webcam.freeze();

                // swap button sets
                document.getElementById('pre_take_buttons').style.display = 'none';
                document.getElementById('post_take_buttons').style.display = '';
            }

            function cancel_preview() {
                // cancel preview freeze and return to live camera feed
                Webcam.unfreeze();

                // swap buttons back
                document.getElementById('pre_take_buttons').style.display = '';
                document.getElementById('post_take_buttons').style.display = 'none';
            }

            function save_photo() {
                // actually snap photo (from preview freeze) and display it
                Webcam.snap(function (data_uri) {

                    //fnSaveImagetoFile(data_uri);

                    // display results in page
                    document.getElementById('results').innerHTML =
                            '<img  width="150" height="150" class="img-rounded" src="' + data_uri + '"/>';
                    $('.capture_image').val(data_uri);
                    $('.capturepart').hide();

                    // swap buttons back
                    document.getElementById('pre_take_buttons').style.display = '';
                    document.getElementById('post_take_buttons').style.display = 'none';
                });
            }

            /* function fnSaveImagetoFile(data_uri)
             {
             $.ajax({
             type: "POST",
             url: "http://themeridianschool.co.in/wcam/upload.php",
             data: 'datauri=' + data_uri,
             cache: false,
             dataType: "json",
             success: function (data)
             {
             alert('done');
             }
             });
             }*/
            $(document).ready(function () {
                //$('.choosepart').hide();
                $('.capturepart').hide();
                $('input[type=button][name=photo]').on('click', function () {
                    var photo_val = $(this).val();
                    if (photo_val == 'capture Image')
                    {
                        Webcam.set({
                            width: 250,
                            height: 200,
                            image_format: 'jpeg',
                            jpeg_quality: 90
                        });
                        Webcam.attach('#my_camera');
                        //$('.choosepart').hide();
                        $('.capturepart').show();
                    } else
                    {
                        //$('.choosepart').show();
                        $('.capturepart').hide();
                    }
                });


            });
            /*  $(function () {
             $("#uploadFile").on("change", function ()
             {
             var files = !!this.files ? this.files : [];
             if (!files.length || !window.FileReader)
             return; // no file selected, or no FileReader support
             
             if (/^image/.test(files[0].type)) { // only image file
             var reader = new FileReader(); // instance of the FileReader
             reader.readAsDataURL(files[0]); // read the local file
             
             reader.onloadend = function () { // set image data as background of div
             $("#imagePreview").css("background-image", "url(" + this.result + ")");
             }
             }
             });
             });
             $(function () {
             $("#new_student_profile_images").on("change", function ()
             {
             var files = !!this.files ? this.files : [];
             if (!files.length || !window.FileReader)
             return; // no file selected, or no FileReader support
             
             if (/^image/.test(files[0].type)) { // only image file
             var reader = new FileReader(); // instance of the FileReader
             reader.readAsDataURL(files[0]); // read the local file
             
             reader.onloadend = function () { // set image data as background of div
             $("#webcamimagePreview").css("background-image", "url(" + this.result + ")");
             }
             }
             });
             });*/


            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#image').attr('src', e.target.result);

                    }
                    reader.readAsDataURL(input.files[0]);
                }

            }

        </script>
    </body>
</html>

