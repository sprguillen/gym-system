<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="position-relative overflow-hidden p-md-5">
	<h3 class="text-dark"><?php echo $page; ?></h3>
	<hr/>
  <?php
    $width_class = ($user_type === 'staff')? 'col-sm-6': 'col-sm-4';
  ?>
	<div class="row">
		<div class="<?php echo $width_class; ?>">
			<div class="card text-center">
				<div class="card-body">
					<h2 class="card-title font-weight-bold text-dark">Members</h2>
					<hr/>
					<a href="<?php echo base_url('members/register'); ?>" class="btn btn-danger btn-block"><i class="fa fa-plus fa-xs"></i> Register a member</a>
					<a href="<?php echo base_url('members/list') ?>" class="btn btn-outline-danger btn-block"><i class="fa fa-users fa-xs"></i> View all members</a>
					<a href="<?php echo base_url('members/attendance') ?>" class="btn btn-outline-danger btn-block"><i class="fa fa-calendar fa-xs"></i> View member attendance</a>
				</div>
			</div>
		</div>
    <div class="<?php echo $width_class; ?>">
        <div class="card text-center">
          <div class="card-body">
        <h2 class="card-title font-weight-bold text-dark">Guests</h2>
        <hr/>
        <a href="<?php echo base_url('guests/register'); ?>" class="btn btn-danger btn-block"><i class="fa fa-plus fa-xs"></i> Register a guest</a>
        <a href="<?php echo base_url('members/list/guest'); ?>" class="btn btn-outline-danger btn-block"><i class="fa fa-users fa-xs"></i> View all guests</a>
          </div>
        </div>
    </div>
    <?php if ($user_type === 'admin'): ?>
		<div class="<?php echo $width_class; ?>">
    		<div class="card text-center">
       		<div class="card-body">
				<h2 class="card-title font-weight-bold text-dark">Administrator</h2>
				<hr/>
				<a href="<?php echo base_url('programs/add'); ?>" class="btn btn-danger btn-block"><i class="fa fa-plus fa-xs"></i> Add a program</a>
                <a href="<?php echo base_url('programs'); ?>" class="btn btn-outline-danger btn-block"><i class="fa fa-basketball-ball fa-xs"></i> View all programs</a>
				<a href="<?php echo base_url('reports'); ?>" class="btn btn-outline-danger btn-block"><i class="fa fa-chart-bar fa-xs"></i> View reports</a>
      		</div>
    		</div>
  	</div>
	</div>
  <?php endif; ?>
</div>