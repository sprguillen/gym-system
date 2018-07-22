<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 bg-light hero-image">
	<div class="col-md-4 p-lg-4 my-5">
		<div class="card">
			<div class="card-body align-middle">
				<h4 class="text-dark text-center">Attendance Login</h4>
				<hr/>
				<div class="form-group">
					<label for="user_input">Username</label>
					<input type="text" class="form-control" id="username-field" aria-describedby="emailHelp" placeholder="Enter username" required>
				</div>
				<!-- <button type="button" class="btn btn-danger btn-block">Log in</button> -->
				<button class="btn btn-danger btn-block" id="user-login-bttn">Login</button>
				<a href="#" class="btn btn-info btn-block" id="user-fingerprint-bttn">Enter fingerprint to finish</a>
				<button class="btn btn-primary btn-block" id="user-refresh-bttn">Next User</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/UserAttendance.js"); ?>"></script>