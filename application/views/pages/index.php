<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 bg-light hero-image">
	<div class="col-md-4 p-lg-4 my-5">
		<div class="card">
			<div class="card-body">
				<h4 class="text-dark text-center">Log in to your account.</h4>
				<hr/>
				<form name="login-input" action="Home_controller/login_user_process">
					<div class="form-group">
						<label for="user_input">Username</label>
						<input type="text" class="form-control" id="user_input" aria-describedby="emailHelp" placeholder="Enter username">
					</div>
					<div class="form-group">
						<label for="pass_input">Password</label>
						<input type="password" class="form-control" id="pass_input" placeholder="Password">
					</div>
					<!-- <button type="button" class="btn btn-danger btn-block">Log in</button> -->
					<input type="submit" class="btn btn-danger btn-block" value="Log in">
				</form>
				<?php
					echo "<h5 class='text-danger text-center'>" . validation_errors() . "</h5>";
				?>
			</div>
		</div>
	</div>
</div>
