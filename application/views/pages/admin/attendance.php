<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="position-relative overflow-hidden px-5 list-page-body">
	<div class="col-md-12 mb-2"> 
		<h3 class="text-danger"></h3>
		<hr/>
	</div>
	<div class="col-md-12">
		<div class="float-right">
	  		<div class="input-group">
	  			<a class="btn btn-secondary btn-sm mr-2" href="<?php echo base_url('dashboard'); ?>">Back</a>
	  		</div>
	  	</div>
	  	<br/>
	  	<br/>
	  	<table class="table table-sm table-hover" id="user-list-table-contents">
  			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Attendance</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					foreach ($attendance as $key => $att) {
						$key += 1;
						$date_time_attendance = DateTime::createFromFormat(MYSQL_DATE_TIME_FORMAT, $att->attendance);
						echo '<tr>';
						echo '<th scope="row">' . $key . '</th>';
						echo '<td>' . date_format($date_time_attendance, "F d, Y H:i:s") . '</td>';
						echo '</tr>';
					}
				?>
			</tbody>
  		</table>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/UserAndProgramList.js"); ?>"></script>