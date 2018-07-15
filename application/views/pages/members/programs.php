<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

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
				<a class="btn btn-info btn-sm mr-2" href="<?php echo base_url('members/list'); ?>">Members List View</a>
		  	</div>
		</div>
		<ul class="nav nav-tabs col-md-12 mb-2">
			<?php 
				if ($programs_list) {
					foreach ($programs_list as $id => $program) {
						if ($type === $program) {
							$class = 'text-info active';
						} else {
							$class = 'text-secondary';
						}

						echo '<li class="nav-item"><a class="nav-link ' . $class . '" href="' . base_url('members/programs/' . $id) . '">' . $program . '</a>';
					}
				}
			?>
		</ul>
		<table class="table table-sm table-hover" id="programs-list-contents">
			<thead class="thead">
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Email</th>
					<th>Date Started</th>
					<th>Date Expired</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					foreach ($members as $key => $member) {
						$key += 1;
						echo '<tr>';
						echo '<th scope="row">' . $key . '</th>';
						echo '<td><a class="text-info member-dialog-link" href="' . base_url('members/info/' . $member->id) . '">' . $member->fname . ' ' . $member->mname . ' ' . $member->lname . '</a></td>';
						echo '<td>' . $member->email . '</td>';
						echo '<td>' . $member->date_started . '</td>';
						echo '<td>' . $member->date_expired . '</td>';
					}
				?>
			</tbody>
		</table>
  	</div>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/ProgramList.js"); ?>"></script>