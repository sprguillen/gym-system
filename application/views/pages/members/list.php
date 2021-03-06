<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="modal fade" id="member-detail-dialog" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <h4 class="modal-title">View Member Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
				<label class="text-dark font-weight-bold col-md-4">First Name:</label>
              	<input type="text" class="col-md-6" id="member-detail-fname">
              	<label class="text-dark font-weight-bold col-md-4">Middle Name:</label>
              	<input type="text" class="col-md-6" id="member-detail-mname">
              	<label class="text-dark font-weight-bold col-md-4">Last Name:</label>
              	<input type="text" class="col-md-6" id="member-detail-lname">
              	<label class="text-dark font-weight-bold col-md-4 align-top">Address:</label>
              	<textarea class="col-md-6" id="member-detail-address"></textarea>
              	<label class="text-dark font-weight-bold col-md-4">Date of birth:</label>
              	<input type="text" class="col-md-6" id="member-detail-birth">
              	<label class="text-dark font-weight-bold col-md-4">Gender:</label>
              	<input type="text" class="col-md-6" id="member-detail-gender">
              	<label class="text-dark font-weight-bold col-md-4">Weight (kg):</label>
              	<input type="text" class="col-md-6" id="member-detail-weight">
              	<label class="text-dark font-weight-bold col-md-4">Height (cm):</label>
              	<input type="text" class="col-md-6" id="member-detail-height">
              	<label class="text-dark font-weight-bold col-md-4">Contact:</label>
              	<input type="text" class="col-md-6" id="member-detail-contact">
              	<label class="text-dark font-weight-bold col-md-4">Email:</label>
              	<input type="text" class="col-md-6" id="member-detail-email">
            </div>
		</div>
	</div>
</div>

<div class="position-relative overflow-hidden px-5 list-page-body">

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
		<h3 class="text-danger"> <?php echo ucfirst(strtolower($type)); ?> Members</h3>
		<hr/>
  	</div>
  
  	<div class="col-md-12">
  		<div class="float-right">
	  		<div class="input-group">
				<a class="btn btn-success btn-sm mr-2" href="<?php echo base_url('members/register'); ?>"><i class="fa fa-plus"></i> New</a>
				<a class="btn btn-info btn-sm mr-2" href="<?php echo base_url('members/programs'); ?>">Programs View</a>
		  	</div>
		</div>
		<ul class="nav nav-tabs col-md-12 mb-2">
			<li class="nav-item">
				<a class="nav-link <?php echo (strtolower($type) === 'active' || strtolower($type) === NULL)? 'text-info active': 'text-secondary'; ?>" href="<?php echo base_url('members/list/active'); ?>">Active</a>
		  	</li>
		  	<li class="nav-item">
				<a class="nav-link <?php echo (strtolower($type) === 'inactive')? 'text-info active': 'text-secondary'; ?>" href="<?php echo base_url('members/list/inactive'); ?>">Inactive</a>
		  	</li>
		  	<li class="nav-item">
				<a class="nav-link <?php echo (strtolower($type) === 'frozen')? 'text-info active': 'text-secondary'; ?>" href="<?php echo base_url('members/list/frozen'); ?>">Frozen</a>
		  	</li>
		  	<li class="nav-item">
				<a class="nav-link <?php echo (strtolower($type) === 'guest')? 'text-info active': 'text-secondary'; ?>" href="<?php echo base_url('members/list/guest'); ?>">Guest</a>
		  	</li>
		</ul>
		
		<?php if ($this->session->userdata('logged_in')['account_type'] === 'Admin'): ?>
			<div class="float-right mb-2">
				<div class="input-group">	  	
					<?php if ($user_mode === 'staff'): ?>
						<a class="text-info btn-sm mr-2" data-toggle="modal" data-target="#adminModeModal" href="#"><i class="fa fa-lock"></i> Staff Mode</a>
				  	<?php endif; ?>
				  	<?php if ($user_mode === 'admin'): ?>
						<a class="text-danger btn-sm mr-2" href="<?php echo base_url('admin/lock/members'); ?>"><i class="fa fa-lock-open"></i> Admin Mode</a>
				  	<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
		<div id="list-table">
			<?php if (strtolower($type) !== 'guest'): ?>
			  	<table class="table table-sm table-hover" id="list-table-contents" data-total-count="<?php echo $total_count ?>">
					<thead class="thead">
					  	<tr>
							<th scope="col">#</th>
							<th scope="col">Full Name</th>
							<th scope="col">Enrollment Duration</th>
							<th scope="col">Programs Enrolled</th>
							<th scope="col">Paid?</th>
							<th scope="col"></th>
					  	</tr>
					</thead>
					<tbody>
				  		<?php foreach ($members as $key => $value): ?>
				  			<tr>
								<th scope="row"><?php echo $key+1; ?></th>
								<td><a class="text-info member-dialog-link" href="<?php echo base_url('members/info/' . $value['id']); ?>"><?php echo $value['name']; ?></a></td>
								<td>
									<?php
										if (strtolower($type) === 'active') {
											foreach ($value['programs_enrolled'] as $enrolled) {
												echo $enrolled['date_started'] . ' - ' . $enrolled['date_expired'] . '<br/>';

											}
										} else {
											if (isset($value['duration'])) {
												$duration = str_replace(",", "<br>", $value['duration']);
											}

											echo $duration;
										}

									?>
								</td>
								<td>
									<?php
										if ($user_mode === 'staff' || strtolower($type) === 'inactive' || strtolower($type) === 'frozen') {

											$classes = "";

											if (isset($value['classes'])) {
												$classes = str_replace(",", "<br>", $value['classes']);
											}

											echo $classes;
										} else if ($user_mode === 'admin') {
											foreach ($value['programs_enrolled'] as $enrolled) {
												echo '<a href="#" class="text-info edit-program-modal" data-program_id="' . $enrolled['id'] . '" data-date_expired="' . $enrolled['date_expired'] . '" data-toggle="modal" data-target="#program-modal" data-program_name="' . $enrolled['type'] . '" data-membership_id="' . $enrolled['membership_id'] . '" title="Edit this program">' . $enrolled['type'] . '</a> <br/>';
											}
										}
									?>
								</td>
								<td>
									<?php
										$isPaid = "";

										if (isset($value['isPaid'])) {
											$isPaid = str_replace(",", "<br>", $value['isPaid']);
										}

										echo $isPaid;
									?>
								</td>
								<td>
						  		<?php
						  			$bttn_text = 'Add a program';
						  			$enroll_link = false;
						  			$bio_url = $api_ver_url . $value['id'];
						  			if (strtolower($type) !== 'frozen') {
						  				if (strtolower($type) === 'inactive' && array_key_exists('displayRenewButton', $value)) {
						  					echo '<button type="button" class="btn btn-danger btn-sm renew-btn" data-toggle="modal" data-target="#renewal-modal" data-id="' . $value['id'] . '">Renew</button> ';
						  				}

						  				if (strtolower($type) === 'active') {
						  					$enroll_link = true;
						  				} else if (strtolower($type) === 'inactive' && !array_key_exists('displayRenewButton', $value)) {
						  					$bttn_text = 'Enroll a program';
						  				}

						  				echo '<button type="button" class="btn btn-danger btn-sm enrollment-btn" data-toggle="modal" data-target="#enrollment-modal" data-id="' . $value['id'] . '">' . $bttn_text . '</button> ';

						  				if ($enroll_link) {
						  					echo '<a data-id="' . $value['id'] . '" data-href="' . $bio_url . '" class="btn btn-sm btn-danger login-bttn">Member Login</a>';
						  				}
						  			}
						  		?>
				  				<?php if ($user_mode === 'admin'): ?>
									<?php if (strtolower($type) === 'active'): ?>
										<button type="button" data-id="<?php echo $value['id']; ?>" data-name="<?php echo $value['name']; ?>" data-toggle="modal" data-target="#freezeMember" class="btn btn-sm btn-outline-primary freeze-data">Freeze</button>
									<?php endif; ?>
									<?php if (strtolower($type) === 'frozen'): ?>
										<button type="button" data-id="<?php echo $value['id']; ?>" data-name="<?php echo $value['name']; ?>" data-toggle="modal" data-target="#unfreeze-member" class="btn btn-sm btn-outline-primary freeze-data unfreeze-bttn">Unfreeze</button>
									<?php endif; ?>
				  				<?php endif; ?>
								</td>
				  			</tr>
				  		<?php endforeach; ?>
					</tbody>
			 	 </table>
			<?php endif; ?>

			<?php if (strtolower($type) === 'guest'): ?>
			  	<table class="table table-sm table-hover" id="list-table-contents-guest">
					<thead class="thead">
				  		<tr>
							<th scope="col">#</th>
							<th scope="col">Full Name</th>
							<th scope="col">Last Session Date</th>
							<th scope="col">Program Enrolled</th>
							<th scope="col"></th>
				  		</tr>
					</thead>
					<tbody>
				  		<?php foreach ($guests as $key => $value): ?>
				  			<tr>
								<th scope="row"><?php echo $key+1; ?></th>
								<td><?php echo $value['name']; ?></td>
								<td><?php echo $value['duration']; ?></td>
								<td><?php echo $value['classes']; ?></td>
								<td>
						  			<button type="button" class="btn btn-outline-danger btn-sm register-bttn" data-id="<?php echo $value['id'] ?>">Register as member</button>
								</td>
				  			</tr>
				  		<?php endforeach; ?>
					</tbody>
			  	</table>
			<?php endif; ?>
		</div>
		<div id="page-nav"></div>
	</div>
  
</div>

<div class="modal fade" id="program-modal" tabindex="-1" role="dialog" aria-labelledby="editProgram" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
	  		<div class="modal-header">
				<h5 class="modal-title text-danger" id="deactivateFreeze"><span class="program-name-to-edit"></span> Advance Payment</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  			<span aria-hidden="true">&times;</span>
				</button>
	  		</div>
	  		<div class="modal-body">
	  			<label for="extension-field">Duration and Price: </label>
				<select class="form-control" id="extension-field"></select>
				<input type="hidden" name="membership_id" class="membership_id_val">
				<br>or  <a href="#" class="text-danger cancel_membership"> cancel this membership</a>.
	  		</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger move-membership">Confirm</button>
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
  	</div>
</div>

<div class="modal fade" id="unfreeze-member" tabindex="-1" role="dialog" aria-labelledby="deactivateFreeze" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
	  		<div class="modal-header">
				<h5 class="modal-title text-danger" id="deactivateFreeze">Unfreeze a Member</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  			<span aria-hidden="true">&times;</span>
				</button>
	  		</div>
	  		<div class="modal-body">
				<p>By unfreezing <span class="text-danger member-name"></span>, his/her active memberships will be restored.</p>
	  		</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger confirm-unfreeze" data-id="<?php echo $value['id']; ?>">Confirm</button>
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
  	</div>
</div>

<div class="modal fade" id="enrollment-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
	  		<div class="modal-header">
				<h5 class="modal-title text-danger" id="exampleModalLabel">Enroll a Program</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  			<span aria-hidden="true">&times;</span>
				</button>
	  		</div>
	  		<div class="modal-body">
				<div class="form-group">
		  			<label for="enroll-program">Programs</label>
		  			<select class="form-control" id="enroll-program"></select>
				</div>
				<div class="form-group" id="payment-form">
			  		<label for="payment-length" class="hidden-by-default">Duration and Price</label>
		  			<select class="form-control" id="payment-length">
		  			</select>
		  			<br/>
		  			<input type="checkbox" id="old-member-check" />Old Member?
		  			<br/>
		  			<div id="date-form">
		  				<label for="old-member-date">Date Started</label>
		  				<input class="form-control" type="date" id="old-member-date" />
		  			</div>
				</div>
	  		</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" id="enroll-submit">Submit</button>
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
  	</div>
</div>

<div class="modal fade" id="renewal-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
	  		<div class="modal-header">
				<h5 class="modal-title text-danger" id="exampleModalLabel">Renew a Program</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  			<span aria-hidden="true">&times;</span>
				</button>
	  		</div>
	  		<div class="modal-body">
				<div class="form-group">
		  			<label for="enroll-program-renew">Programs</label>
		  			<select class="form-control" id="enroll-program-renew"></select>
				</div>
				<div class="form-group" id="payment-renew-form">
			  		<label for="payment-length" class="hidden-by-default">Duration and Price</label>
		  			<select class="form-control" id="payment-length-renew">
		  			</select>
				</div>
	  		</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" id="renew-submit">Submit</button>
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
  	</div>
</div>

<div class="modal fade" id="freezeMember" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-danger" id="exampleModalLabel">Freeze Member</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="freeze-form">		
				<div class="modal-body">
					<p>Are you sure you want to freeze membership of <span class="text-danger member-name"></span>? This action <strong>cannot</strong> be undone.</p>
					<div class="alert alert-warning freeze-alert"></div>
					<div class="form-group">
						<label for="username">Reason:</label>
						<textarea class="form-control" rows="4" id="purpose" name="purpose" placeholder="Specify reason for freezing. Approval may be subjected to discussion by the gym manager." required></textarea>
						<input type="hidden" id="member-id" name="memberId" value="">
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-danger" value="Submit">
					<button type="button" class="btn btn-outline-secondary freeze-close-modal" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="adminModeModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-danger">Enter Administrator Mode</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="username">Email username</label>
					<input type="email" class="form-control" id="list-admin-mode-user" aria-describedby="emailHelp" placeholder="Enter username">
				</div>
				<div class="form-group">
					<label for="password">Enter password</label>
					<input type="password" class="form-control" id="list-admin-mode-password" aria-describedby="emailHelp" placeholder="Enter password">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger submit-admin">Submit</button>
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/List.js"); ?>"></script>
