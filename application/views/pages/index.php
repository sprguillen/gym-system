<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 bg-light hero-image">
	<div class="col-md-4 p-lg-4 my-5">
		<div class="card">
			<div class="card-body">
				<h4 class="text-dark text-center">Log in to your account.</h4>
				<hr/>

				<?php if (validation_errors() || $this->session->flashdata('error')): ?>
				<div class="alert alert-danger" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
					<?php
						echo "<small>";
						echo validation_errors();
						echo $this->session->flashdata('error')['message'];
						echo "</small>";
					?>
				</div>
				<?php endif; ?>
	
				<form name="login-input" action="Home_Controller/login_user_process" method="POST">
					<div class="form-group">
						<label for="user_input">Username</label>
						<input type="text" class="form-control" name="user_input" aria-describedby="emailHelp" placeholder="Enter username" required>
					</div>
					<div class="form-group">
						<label for="pass_input">Password</label>
						<input type="password" class="form-control" name="pass_input" placeholder="Password" required>
					</div>
					<!-- <button type="button" class="btn btn-danger btn-block">Log in</button> -->
					<input type="submit" class="btn btn-danger btn-block" value="Log in">
				</form>
			</div>
		</div>
	</div>
</div>
