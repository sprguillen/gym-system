<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="position-relative overflow-hidden p-md-5">
	<h3 class="text-dark"><?php echo $page; ?></h3>
	<hr/>

	<div class="row">
		<div class="col-sm-4">
			<div class="card text-center">
				<div class="card-body">
					<h2 class="card-title font-weight-bold text-dark"><?php echo $membersCount ?> Members</h2>
					<hr/>
					<a href="<?php echo base_url('members/register'); ?>" class="btn btn-danger btn-block"><i class="fa fa-plus fa-xs"></i> Register a new member</a>
					<a href="<?php echo base_url('members/list') ?>" class="btn btn-outline-danger btn-block"><i class="fa fa-users fa-xs"></i> View all members</a>
					<a href="<?php echo base_url('members/attendance') ?>" class="btn btn-outline-danger btn-block"><i class="fa fa-calendar fa-xs"></i> View member attendance</a>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
      		<div class="card text-center">
         		<div class="card-body">
					<h2 class="card-title font-weight-bold text-dark">9 Guests</h2>
					<hr/>
					<a href="<?php echo base_url('guests/register'); ?>" class="btn btn-danger btn-block"><i class="fa fa-plus fa-xs"></i> Register a guest</a>
					<a href="<?php echo base_url('members/list/guest'); ?>" class="btn btn-outline-danger btn-block"><i class="fa fa-calendar-alt fa-xs"></i> View all guests</a>
        		</div>
      		</div>
    	</div>
	</div>
</div>