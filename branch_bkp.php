<?php
session_start();
$user_id = $_SESSION['usr_id'];
include_once 'includes/dbconnect.php';

$sql="SELECT * from branch";
$branches=mysqli_query($con, $sql);
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

<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<!-- add header -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php"></a>
		</div>
		<!-- menu items -->
		<div class="collapse navbar-collapse" id="navbar1">
			<ul class="nav navbar-nav navbar-right">
                <li><a href="branch_notification.php" >Notificationbranch</a><span class="countnotification"></span></li>
				<li><a href="branch_to_branch_notification.php" >NotificationHQ</a><span class="countnotificationotherbranch"></span></li>
				<?php if (isset($_SESSION['usr_id'])) { ?>
				<li><p class="navbar-text">Welcome<?php echo $_SESSION['usr_name'];?> </p></li>
				<li><a href="logout.php">Log Out</a></li>
				<?php  } else {?><li class="active"><a href="login.php">Login</a></li> <?php }?>
			</ul>
		</div>
	</div>
</nav>

<div class="container">
	

	<legend>Branch</legend>
		        <?php if(isset($_SESSION['message'])){//echo $_SESSION['message'];
} ?>
<div class="row">
       <form action=""  method="post" name="frmBranch" id="frmBranch" class="" enctype="multipart/form-data">
          <div class="col-sm-3 col-md-12 col-lg-3 col-xs-3">
            <div class="form-group">
              <label class="">Member Name : 
                <em class="required">*
                </em>
              </label>
              <div class="em-form">
                <span>
                  <i class="fa fa-building" aria-hidden="true">
                  </i>
                </span>
                <input class="form-control" id="mname" maxlength="30" name="mname" placeholder="Member Name" required data-bv-notempty-message="Please enter member name" title="Member Name" type="text" />
              </div>
            </div>
            <div class="form-group">
              <label class="">Member Code:
			  <em class="required">*
                </em>
              </label>
              <div class="em-form">
                <span>
                  <i class="fa fa-globe" aria-hidden="true">
                  </i>
                </span>
                <input class="form-control" id="mcode" maxlength="30" name="mcode" placeholder="Member Code" required data-bv-notempty-message="Please enter Member Code" data-bv-regexp="true" data-bv-regexp-regexp="^\s*-?[0-9]{1,100}\s*$" data-bv-regexp-message="Please enter  only numbers." title="Member Code" type="text" />
				<input  type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>"/>
              </div>
            </div>
			<div class="form-group">
				<label for="branch" class="field prepend-icon">Headquarter Branch <em class="required">*</em>
				<select id="sel_branch" name="sel_branch" class="gui-input" required data-bv-notempty-message="Please select branch.">
					<option value="">Select Branch</option>
						<?php foreach($branches as $branch){
						echo '<option value="'.$branch['branch_id'].'">'.$branch['branch_name'].'</option>';
						}?>
				</select>
				</label>
			</div>
          </div>
          <div class="col-sm-6 col-md-12 col-lg-6 col-xs-6">
           <!-- <div class="form-group">
              <div class="col-sm-4">
                <div class="booth">
                  <video id="video" width="275" height="200">
                  </video>
                  <a href="#" id="capture" class="booth-capture-button">Take Snap
                  </a>
                  <!--<input type="button" value="Configure..." onClick="configure()">
                </div>
              </div>
              <div class="col-sm-4">
                <canvas id="canvas" width="275" height="250">
                </canvas>
                <img id="photo" src="" />
                <!-- <button id="clear"  class="booth-capture-button" >Clear Image</button>
<button class="booth-capture-button" onclick="UploadPic();return false;">Upload to Server</button>
              </div>		
            </div>-->
	<div class="form-group">
		Member Profile Image:<br>
		<div class="radio">
			<label><input type="radio" name="photo" value="capture">Capture Photo</label>
		</div>
		<div class="radio">
			<label><input type="radio" name="photo" value="choose">Choose File</label>
		</div>
		<div id="webcamimagePreview"></div>
		<div class="choosepart">
			<label>
				*Format. jpg / .jpeg / png / gif 
			</label>
			<input name="new_student_profile_images" id="new_student_profile_images" class="form-control  validate[checkFileType[jpg|JPG|jpeg|JPEG|gif|GIF|png|PNG]] __web-inspector-hide-shortcut__" style="width: 35%;" type="file">
		</div>
		<div class="capturepart">
			<div id="my_camera"></div><br>
			<div id="pre_take_buttons">
				<input type=button value="Capture Photo" onClick="preview_snapshot()" class="btn btn-success">
			</div>
			<div id="post_take_buttons" style="display:none">
				<input type=button value="&lt; Take Another" onClick="cancel_preview()" class="btn btn-success">
				<input type=button value="Save Photo &gt;" onClick="save_photo()" style="font-weight:bold;" class="btn btn-success">
			</div>				
		</div>
		<br>
			<input type="hidden" name="capture_image" class="capture_image" value="">
			<div id="results">
				
			</div>
	        </div>
			   <div class="form-group">
			   <div class="col-sm-10 col-md-10 col-lg-10 col-xs-10">
              <label class="">Check Iamge 
                <em class="required">*
                </em>
              </label>
			  
              <div class="em-form"> 
			  <div id="imagePreview"></div>
                <input class="form-control" id="uploadFile"  name="mcheckimage" placeholder="Member Check Number" required data-bv-notempty-message="Please enter check image" title="Member Check Image" type="file" />
              </div>
			  </div>
            </div>
          </div>
		
          <div class="col-sm-3 col-md-12 col-lg-3 col-xs-3">
            <div class="form-group">
              <label class="">Check Number : 
                <em class="required">*
                </em>
              </label>
              <div class="em-form"> 
                <span>
                  <i class="fa fa-globe" aria-hidden="true">
                  </i>
                </span>
                <input class="form-control" id="mcheckno" maxlength="30" name="mcheckno" placeholder="Member Check Number" required data-bv-notempty-message="Please enter Check Number" data-bv-regexp="true" data-bv-regexp-regexp="^\s*-?[0-9]{1,100}\s*$" data-bv-regexp-message="Please enter  only numbers." title="Member Check Number" type="text" />
              </div>
            </div>
            <div class="form-group">
              <label class="">Amount : 
                <em class="required">*
                </em>
              </label>
              <div class="em-form"> 
                <span>
                  <i class="fa fa-globe" aria-hidden="true">
                  </i>
                </span>
                <input class="form-control" id="amount" maxlength="30" name="amount" placeholder="Amount" required data-bv-notempty-message="Please enter amount" data-bv-regexp="true" data-bv-regexp-regexp="^\s*-?[0-9]{1,100}\s*$" data-bv-regexp-message="Please enter  only numbers." title="Payee Name" type="text" />
              </div>
            </div>
            <div class="form-group">
              <label class="">Payee name : 
                <em class="required">*
                </em>
              </label>
              <div class="em-form"> 
                <span>
                  <i class="fa fa-globe" aria-hidden="true">
                  </i>
                </span>
                <input class="form-control" id="payeename" maxlength="30" name="payeename" placeholder="Payee Name" required data-bv-notempty-message="Please enter payee name" title="Payee Name" type="text" />
              </div>
            </div>
          </div>
		  <div class="row">
          <div class="form-group">
            <label class="">
            </label>
            <div class="cr_btn_half pull-right">
              <button type="submit" id="headquarterDetail" class="btn-4 hvr-bounce-to-top waves-effect" value="Save Changes" style="margin:right 40px !important;">Save Changes
              </button>
            </div>
			 <div class="cr_btn_half pull-left ">
               <button class="btn-4 hvr-bounce-to-top waves-effect second-eff" value="Cancel" id="previewBtn" data-toggle="modal" data-target="#confirm-submit" type="button">Preview</button>
            </div>
          </div>
		  </div>
        </form>
        <span class="text-danger">
          <?php if (isset($errormsg)) { echo $errormsg; } ?>
        </span>
        <div class="row">
          <!--<div class="col-md-4 col-md-offset-4 text-center">	
New User? <a href="register.php">Sign Up Here</a>
</div>-->
        </div>
	<div class="row">
		<!--<div class="col-md-4 col-md-offset-4 text-center">	
		New User? <a href="register.php">Sign Up Here</a>
		</div>-->
	</div>
</div>
<div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-body">
                Check Information

                <!-- We display the details entered by the user here -->
                <table class="table">
                    <tr>
                        <th>Member Name</th>
                        <td id="member_name"></td>
                    </tr>
                    <tr>
                        <th>Member Code</th>
                        <td id="member_code"></td>
                    </tr>
					<tr>
                        <th>Branch Name</th>
                        <td id="branch_name_display"></td>
                    </tr>
					<tr>
                        <th>Amount</th>
                        <td id="check_amount"></td>
                    </tr>
					<tr>
                        <th>Payee Name</th>
                        <td id="payee_name"></td>
                    </tr>
                </table>

            </div>
           <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           </div>
    </div>
</div>
<?php include_once ('includes/footer.php');?>
<script>
$('#previewBtn').click(function() {
     /* when the button in the form, display the entered values in the modal */
	 var branchName = $('#sel_branch').find(":selected").text();
	 $('#member_name').text($('#mname').val());
         $('#member_code').text($('#mcode').val());
	 $('#branch_name_display').text(branchName);
	 $('#check_amount').text($('#amount').val());
	 $('#payee_name').text($('#payeename').val());
});

$(document).ready(
            function() {
                setInterval(function() {
                    $.ajax({
                        url: 'view_branch_count.php' ,
                        cache: false,
                        success: function(data)
                        {
						 $('.countnotification').html(data);
                        },
						});
                }, 1000);
            });
$(document).ready(
            function() {
                setInterval(function() {
                    $.ajax({
                        url: 'show_branch_count_other_branch.php' ,
                        cache: false,
                        success: function(data)
                        {
						// alert(data);	
						 $('.countnotificationotherbranch').html(data);
                        },

                    });
                }, 1000);
            });			

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
			Webcam.snap( function(data_uri) {
				
				//fnSaveImagetoFile(data_uri);
				
				// display results in page
				document.getElementById('results').innerHTML = 
					'<img  width="100" height="100" src="'+data_uri+'"/>';
					$('.capture_image').val(data_uri);
				
				// swap buttons back
				document.getElementById('pre_take_buttons').style.display = '';
				document.getElementById('post_take_buttons').style.display = 'none';
			} );
		}
		
		function fnSaveImagetoFile(data_uri)
		{
			$.ajax({ 
				type: "POST",
				url: "http://themeridianschool.co.in/wcam/upload.php",
				data: 'datauri='+data_uri,
				cache: false,
				dataType:"json",
				success: function(data)
				{
					alert('done');
				}
			});
		}
		$(document).ready(function () {	
			$('.choosepart').hide();
			$('.capturepart').hide();		
			$('input[type=radio][name=photo]').on('change', function()  {
				var photo_val = $(this).val();
				if(photo_val == 'capture')
				{
					Webcam.set({
						width: 250,
						height: 200,
						image_format: 'jpeg',
						jpeg_quality: 90
					});
					Webcam.attach( '#my_camera' );
					$('.choosepart').hide();
					$('.capturepart').show();					
				}
				else
				{
					$('.choosepart').show();
					$('.capturepart').hide();	
				}
			});	
			

		});
$(function() {
    $("#uploadFile").on("change", function()
    {
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
 
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
 
            reader.onloadend = function(){ // set image data as background of div
                $("#imagePreview").css("background-image", "url("+this.result+")");
            }
        }
    });
});
$(function() {
    $("#new_student_profile_images").on("change", function()
    {
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
 
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
 
            reader.onloadend = function(){ // set image data as background of div
                $("#webcamimagePreview").css("background-image", "url("+this.result+")");
            }
        }
    });
});

</script>
</body>
</html>

