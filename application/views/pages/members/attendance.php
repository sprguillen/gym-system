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

<div class="position-relative overflow-hidden px-5">

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
		<h3 class="text-danger"> <?php echo ucfirst($name); ?></h3>
		<hr/>
	</div>
  
	<div class="col-md-12">
		<h5 class="my-0 text-center font-weight-bold"><?php echo $view_header; ?></h5>
		<hr/>

		<div class="float-right">
			<div class="input-group mb-3">
				<div class="btn-group" role="group" aria-label="Basic example">
					<a class="btn <?php echo ($view_type === 'monthly')? 'btn-success': 'btn-outline-success'; ?> btn-sm mr-2" href="<?php echo base_url('members/attendance/monthly'); ?>"><i class="fa fa-calendar"></i> Monthly</a>
					<a class="btn <?php echo ($view_type === 'weekly')? 'btn-warning': 'btn-outline-warning'; ?> btn-sm mr-2" href="<?php echo base_url('members/attendance/weekly'); ?>"><i class="fa fa-calendar-alt"></i> Weekly</a>
					<a class="btn <?php echo ($view_type === 'daily')? 'btn-info': 'btn-outline-info'; ?> btn-sm mr-2" href="<?php echo base_url('members/attendance/daily'); ?>"><i class="fa fa-clock"></i> Daily</a>
				</div>
				<span class="mr-2"></span>
				<input type="date" id="date-filter" class="form-control form-control-sm" value="<?php echo date('Y-m-d', time()); ?>" aria-label="Search for members..." aria-describedby="basic-addon2">
				<div class="input-group-append">
					<button class="btn btn-outline-primary btn-sm" type="button" id="date-filter-btn"><i class="fa fa-search"></i> Select a date</button>
				</div>
			</div>
		</div>
		<div id="attendance-table">
			<table class="table table-sm table-hover" id="attendance-default-table">
				<thead class="thead">
					<tr>
						<th scope="col">Member ID</th>
						<th scope="col">Full Name</th>
						<th scope="col">Program</th>
						<th scope="col">Logged In</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($members as $row): ?>
					<tr>
						<th><?php echo $row->id; ?></th>
						<td><?php echo $row->first_name . ' ' . $row->middle_name . ' ' . $row->last_name; ?></td>
						<td><?php echo $row->program_type; ?></td>
						<td><?php echo $row->logged_in; ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
  
</div>

<div class="modal fade" id="enrollProgram" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
		  <label for="exampleFormControlSelect1">Select a program</label>
		  <select class="form-control" id="exampleFormControlSelect1">
			<option>Weight Training</option>
			<option>Yoga</option>
			<option>Zumba</option>
			<option>Boxing</option>
			<option>Functional Fitness</option>
		  </select>
		</div>
		<div class="form-group">
		  <label for="exampleFormControlSelect1">Select a coach</label>
		  <select class="form-control" id="exampleFormControlSelect1">
			<option>Antoni</option>
			<option>Tan</option>
			<option>Karamo</option>
			<option>Jonathan</option>
			<option>Bobby</option>
		  </select>
		</div>
		<div class="form-group">
		  <label for="exampleFormControlSelect1">Payment Scheme</label>
		  <select class="form-control" id="exampleFormControlSelect1">
			<option>1 month</option>
			<option>3 months</option>
			<option>6 months</option>
			<option>1 year</option>
		  </select>
		</div>
		<div class="form-group">
		  <label for="exampleFormControlSelect1">Payment Status</label>
		  <select class="form-control" id="exampleFormControlSelect1">
			<option>Paid in full</option>
			<option>Partially paid</option>
			<option>Not paid</option>
		  </select>
		</div>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-danger">Submit</button>
		<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
	  </div>
	</div>
  </div>
</div>

<div class="modal fade" id="adminModeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title text-danger" id="exampleModalLabel">Enter Administrator Mode</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-body">
		<div class="form-group">
		  <label for="username">Email username</label>
		  <input type="email" class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter username">
		</div>
		<div class="form-group">
		  <label for="password">Enter password</label>
		  <input type="password" class="form-control" id="password" aria-describedby="emailHelp" placeholder="Enter password">
		</div>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-danger submitAdmin">Submit</button>
		<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
	  </div>
	</div>
  </div>
</div>

<script type="text/javascript" src="<?php echo base_url("assets/js/Attendance.js"); ?>"></script>
