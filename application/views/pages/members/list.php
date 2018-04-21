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
		<h3 class="text-danger"> <?php echo ucfirst($type); ?> Members</h3>
		<hr/>
  	</div>
  
  	<div class="col-md-12">
		<div class="float-right">
	  		<div class="input-group">
				<a class="btn btn-success btn-sm mr-2" href="<?php echo base_url('members/register'); ?>"><i class="fa fa-plus"></i> New</a>
				<input type="text" class="form-control form-control-sm" placeholder="Search for members..." aria-label="Search for members..." aria-describedby="basic-addon2">
				<div class="input-group-append">
		  			<button class="btn btn-outline-primary btn-sm" type="button"><i class="fa fa-search"></i> Search</button>
				</div>
		  	</div>
		</div>


		<ul class="nav nav-tabs col-md-12 mb-2">
		  	<li class="nav-item">
				<a class="nav-link <?php echo ($type === 'active' || $type === NULL)? 'text-info active': 'text-secondary'; ?>" href="<?php echo base_url('members/list/active'); ?>">Active</a>
		  	</li>
		  	<li class="nav-item">
				<a class="nav-link <?php echo ($type === 'inactive')? 'text-info active': 'text-secondary'; ?>" href="<?php echo base_url('members/list/inactive'); ?>">Inactive</a>
		  	</li>
		  	<li class="nav-item">
				<a class="nav-link <?php echo ($type === 'frozen')? 'text-info active': 'text-secondary'; ?>" href="<?php echo base_url('members/list/frozen'); ?>">Frozen</a>
		  	</li>
		  	<li class="nav-item">
				<a class="nav-link <?php echo ($type === 'guest')? 'text-info active': 'text-secondary'; ?>" href="<?php echo base_url('members/list/guest'); ?>">Guest</a>
		  	</li>
		</ul>
	
		<div class="float-right mb-2">
		  	
			<div class="input-group">	  	
				<?php if ($user_mode === 'staff'): ?>
					<a class="text-info btn-sm mr-2" data-toggle="modal" data-target="#adminModeModal" href="#"><i class="fa fa-lock"></i> Staff Mode</a>
			  	<?php endif; ?>
			  	<?php if ($user_mode === 'admin'): ?>
					<a class="text-danger btn-sm mr-2" href="<?php echo base_url('admin/lock/members'); ?>"><i class="fa fa-lock-open"></i> Admin Mode</a>
			  	<?php endif; ?>

			  	<select class="form-control form-control-sm ml-2" id="filter-dropdown">
					<option selected disabled>Filter by program</option>
					<option value="Weight Training">Weight Training</option>
					<option value="Boxing">Boxing</option>
					<option value="Yoga">Yoga</option>
					<option value="Zumba">Zumba</option>
				</select>
			</div>
		</div>

		<?php if ($type !== 'guest'): ?>
		  	<table class="table table-sm table-hover">
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
			  			<tr class="filter-program" data-program="<?php echo $value['classes'] ?>">
							<th scope="row"><?php echo $key+1; ?></th>
							<td><a class="text-info member-dialog-link" data-toggle="modal" href="#member-detail-dialog" data-id="<?php echo $value['id'] ?>"><?php echo $value['name']; ?></a></td>
							<td><?php echo $value['duration']; ?></td>
							<td><?php echo $value['classes']; ?></td>
							<td><?php echo $value['isPaid']; ?></td>
							<td>
				  			<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#enrollProgram">Enroll</button>
				  				<?php if ($user_mode === 'admin'): ?>
									<button type="button" data-id="<?php echo $value['id']; ?>" class="btn btn-sm btn-info edit">Edit</button>
									<button type="button" data-id="<?php echo $value['id']; ?>" data-toggle="modal" data-target="#freezeMember" class="btn btn-sm btn-outline-primary">Freeze</button>
				  				<?php endif; ?>
							</td>
			  			</tr>
			  		<?php endforeach; ?>
				</tbody>
		 	 </table>
		<?php endif; ?>

		<?php if ($type === 'guest'): ?>
		  	<table class="table table-sm table-hover">
				<thead class="thead">
			  		<tr>
						<th scope="col">#</th>
						<th scope="col">Full Name</th>
						<th scope="col">Date Enrolled</th>
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
					 		<!-- <button type="button" class="btn btn-primary">Freeze</button> -->
					 		<!--  <button type="button" data-id="<?php echo $value['id']; ?>" class="btn btn-info edit">Edit</button> -->
					  			<button type="button" class="btn btn-outline-danger btn-sm register-bttn" data-id="<?php echo $value['id'] ?>">Register as member</button>
							</td>
			  			</tr>
			  		<?php endforeach; ?>
				</tbody>
		  	</table>
		<?php endif; ?>

		<div class="btn-group float-right" role="group" aria-label="Basic example">
			  <button type="button" class="btn btn-sm btn-outline-danger">Prev</button>
			  <button type="button" class="btn btn-sm btn-danger">Next</button>
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

<div class="modal fade" id="freezeMember" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title text-danger" id="exampleModalLabel">Freeze Member</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-body">
		<p>Are you sure you want to freeze membership of Simon Guillen? This action <strong>cannot</strong> be undone.</p>

		<div class="form-group">
		  <label for="username">Freeze until:</label>
		  <input type="date" class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter username">
		</div>
		<p class="text-warning">You can only freeze membership until October 17, 2018.</p>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-danger submitAdmin">Submit</button>
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

<script type="text/javascript" charset="utf-8" async defer>
  $(document).ready(function() {
	$(".edit").click(function(e) {
	  e.preventDefault();
	  let id = $(this).attr('data-id');
	  window.location.href = '/gym-system/members/edit/' + id;
	});

	$(".submitAdmin").click(function(e) {
	  e.preventDefault();
	  window.location.href = '/gym-system/admin/unlock/members';
	});
  });
</script>
