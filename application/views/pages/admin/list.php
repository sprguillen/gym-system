<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="position-relative overflow-hidden px-5 list-page-body">
	<div class="col-md-12 mb-2"> 
		<h3 class="text-danger">Users List</h3>
		<hr/>
	</div>
	<div class="col-md-12">
		<div class="float-right">
	  		<div class="input-group">
	  			<a class="btn btn-success btn-sm mr-2" href="<?php echo base_url('users/add'); ?>"><i class="fa fa-plus"></i> New User</a>
	  			<a class="btn btn-secondary btn-sm mr-2" href="<?php echo base_url('dashboard'); ?>">Back</a>
	  		</div>
	  	</div>
	  	<br/>
	  	<br/>
	  	<table class="table table-sm table-hover" id="user-list-table-contents">
  			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Username</th>
					<th scope="col">Fullname</th>
					<th scope="col">Email</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					foreach ($users as $key => $user) {
						$key += 1;
						echo '<tr>';
						echo '<th scope="row">' . $key . '</th>';
						echo '<td><a class="text-info" href="#">' . $user->username . '</a></td>';
						echo '<td>' . $user->fname . ' ' . $user->lname . '</td>';
						echo '<td>' . $user->email . '</td>';
						echo '</tr>';
					}
				?>
			</tbody>
  		</table>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/UserAndProgramList.js"); ?>"></script>