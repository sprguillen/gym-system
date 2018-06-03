<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3">
  	<div class="col-md-12 mb-2"> 
    	<small>
		    <?php
		      	foreach ($breadcrumbs as $index => $route) {
		        	foreach ($route as $name => $url) {
		          		echo '<a class="mt-0 text-muted" href="' . base_url($url) . '"> ' . $name . '</a> / ';
		        	}
		      	}
		    ?>
    	</small>
	    <h3 class="text-danger"> <?php echo $name; ?></h3>
	    <hr/>
  	</div>
	<div class="modal fade" id="registration-dialog" role="dialog">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h4 class="modal-title">Take a picture</h4>
	                <button type="button" class="close" data-dismiss="modal">&times;</button>
	            </div>
	            <div class="modal-body">
	                <center>
	                    <div id="registration-cam"></div>
	                    <div class="modal-button-container">
	                        <button class="btn btn-primary" id="take-snapshot">Capture</button>
	                        <button class="btn btn-primary" id="recapture">Re-capture</button>
	                    </div>
	                    <input type="hidden" name="img"  >
	                </center>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	            </div>
	        </div>
	    </div>
	</div>
  	<div class="col-md-8 p-lg-8 mx-auto my-5">
    	<form id="registration_form" action="Members_Controller/process_registration" method="post">
    		<h3>Profile</h3>
    		<section>
	      		<div id="profile-container" class="card">
	        		<div class="card-body">
	          			<h2 class="text-dark text-center">1. Profile</h2>
	          			<h5 class="text-muted text-center">Join the pursuit of health and wellness.</h5>
	          			<hr/>
	          			<div class="row">
	              			<div class="col-md-12 mb-3">
	                  			<h6 class="text-info">
	                      			<i class="fa fa-plus-square"></i>
	                      			Personal Information
	                  			</h6>
	              			</div>
	          			</div>

		          		<div class="row mb-2">
		              		<div class="col-md-4">
		                  		<div class="form-group">
		                      		<label class="text-dark" for="fname-text">First</label>
		                      		<?php $guest_data = $this->session->flashdata('guest_data') ?>
		                  			<?php if ($guest_data) { ?>
		                      			<input type="text" class="form-control" id="fname-text" name="fname" value="<?php echo $guest_data->fname ?>"  >
		                      		<?php } else { ?>
		                          		<input type="text" class="form-control" id="fname-text" name="fname" value=""  >
		                      		<?php } ?>
		                  		</div>
		              		</div>
		              		<div class="col-md-4">
		                  		<div class="form-group">
		                      		<label class="text-dark" for="mname-text">Middle</label>
		                      		<?php if ($guest_data) { ?>
		                          		<input type="text" class="form-control" id="mname-text" name="mname" value="<?php echo $guest_data->mname ?>"  >
		                      		<?php } else { ?>
		                          		<input type="text" class="form-control" id="mname-text" name="mname"  >
		                      		<?php } ?>
		                  		</div>
		              		</div>
		              		<div class="col-md-4">
		                  		<div class="form-group">
		                      		<label class="text-dark" for="lname-text">Last</label>
		                      		<?php if ($guest_data) { ?>
		                          		<input type="text" class="form-control" id="lname-text" name="lname" value="<?php echo $guest_data->lname ?>"  >
		                      		<?php } else { ?>
		                          		<input type="text" class="form-control" id="lname-text" name="lname"  >
		                      		<?php } ?>
		                  		</div>
		              		</div>

		              		<div class="col-md-12">
		                  		<div class="form-group">
		                      		<label class="text-dark" for="address-text">Address</label>
		                      		<textarea class="form-control" id="address-text" rows="3" name="address"  ></textarea>
		                  		</div>
		              		</div>

		              		<div class="col-md-3">
		                  		<div class="form-group">
		                      		<label class="text-dark" for="birth-date">Date of birth</label>
		                      		<input type="date" class="form-control" id="birthdate" name="birthdate"  >
		                  		</div>
		              		</div>
		              		<div class="col-md-3">
		                  		<div class="form-group">
		                      		<label class="text-dark" for="gender-input">Gender</label>
		                      		<?php if ($guest_data) { ?>
			                          	<select class="form-control" id="gender-input" name="gender"  >
			                              	<?php echo "<option selected value='" . $guest_data->gender . "'>" . $guest_data->gender . "</option>" ?>
			                          	</select>
		                      		<?php } else { ?>
		                          		<select class="form-control" id="gender-input" name="gender"  >
		                              		<option selected disabled>Select gender</option>
		                              		<option value="female">Female</option>
		                              		<option value="male">Male</option>
		                          		</select>
		                      		<?php } ?>
		                  		</div>
		              		</div>
		              		<div class="col-md-3">
		                  		<div class="form-group">
			                      	<label class="text-dark" for="weight-number">Weight (in kgs)</label>
			                      	<input type="number" class="form-control" id="weight-number" name="weight"  >
		                  		</div>
		              		</div>
		              		<div class="col-md-3">
		                  		<div class="form-group">
		                      		<label class="text-dark" for="height-number">Height (in cm)</label>
		                      		<input type="number" class="form-control" id="height-number" name="height"  >
		                  		</div>
		              		</div>

		              		<div class="col-md-6">
		                  		<div class="form-group">
		                      		<label class="text-dark" for="number-text">Phone number</label>
		                      		<input type="text" class="form-control" id="number-text" name="cellnumber"  >
		                  		</div>
		              		</div>
		              		<div class="col-md-6">
		                  		<div class="form-group">
		                      		<label class="text-dark" for="email-input">E-mail address</label>
		                      		<?php if ($guest_data) { ?>
		                          		<input type="email" class="form-control" id="email-input" name="email" aria-describedby="emailHelp" value="<?php echo $guest_data->email ?>" >
		                      		<?php } else { ?>
		                          		<input type="email" class="form-control" id="email-input" name="email" aria-describedby="emailHelp"  >
		                      		<?php } ?>
		                  		</div>
		              		</div>

		              		<div class="col-md-12 mb-3 mt-2">
		                  		<h6 class="text-info">
		                    		<i class="fa fa-user"></i>
		                    		Emergency Contact
		                  		</h6>
		              		</div>

			              	<div class="col-md-4">
			                  	<div class="form-group">
			                      	<label class="text-dark" for="emergency-name">Full Name</label>
			                      	<input type="text" class="form-control" id="emergency-name" name="ename"  >
			                  	</div>
			              	</div>
		              		<div class="col-md-4">
		                  		<div class="form-group">
		                      		<label class="text-dark" for="relationship-text">Relationship</label>
		                      		<input type="text" class="form-control" id="relationship-text" name="relationship"  >
		                  		</div>
		              		</div>
		              		<div class="col-md-4">
		                  		<div class="form-group">
		                      		<label class="text-dark" for="tel-input">Phone number</label>
		                      		<input type="tel" class="form-control" id="tel-input" name="econtact"  >
		                  		</div>
		              		</div>
		            	</div>
	        		</div>
	      		</div>
			</section>
			<h3>Picture Taking</h3>
			<section>
		      	<div id="camera-container" class="card">
			        <div class="card-body">
			          	<h2 class="text-dark text-center">2. Facial Recognition</h2>
			          	<h5 class="text-muted text-center">Join the pursuit of health and wellness.</h5>
			          	<hr/>
			          	<div class="row">
			            	<div class="col-md-4">
			                	<div class="card">
			                    	<img class="card-img-top w-50 mx-auto" src="<?php echo base_url('assets/images/face.png'); ?>" alt="">
			                    	<div class="card-body">
			                        	<h5 class="card-title text-dark">Take A Picture</h5>
			                        	<p class="card-text">Please standby and let our camera take a picture of you.</p>
			                        	<a data-toggle="modal" href="#registration-dialog" class="btn btn-outline-danger btn-block" id="upload-photo">
			                        		Upload Photo
			                        	</a>
			                        	<p class="error" id="webcam-validation-error">Please take a picture to go to the next step.</p>
			                    	</div>
			                	</div>
			            	</div>
			          	</div>
			        </div>
		    	</div>
			</section>	
			<h3>Fingerprint</h3>
			<section>
				<div id="bio-container" class="card">
					<div class="card-body">
						<h2 class="text-dark text-center">3. Fingerprint Recognition</h2>
						<h5 class="text-muted text-center">Join the pursuit of health and wellness.</h5>
						<hr/>
						<div class="row">
							<div class="col-md-4">
			                	<div class="card">
			                    	<img class="card-img-top w-25 mx-auto" src="<?php echo base_url('assets/images/thumb.png'); ?>" alt="">
			                    	<div class="card-body">
			                        	<h5 class="card-title text-dark">Biometrics</h5>
			                        	<p class="card-text">Please place your fingerprint on the machine to scan.</p>
			                        	<a href="finspot:FingerspotReg;<?php echo $api_reg_url ?>" class="btn btn-outline-danger btn-block" id="scan-btn" >Scan fingerprint</a>
			                        	<input type="hidden" id="has-fingerprint-data" >
			                        	<p class="error" id="fingerprint-validation-error">Please take a picture to go to the next step.</p>
			                    	</div>
			                	</div>
			            	</div>
						</div>
					</div>
				</div>
			</section>
    	</form>
  	</div>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/Register.js"); ?>"></script>