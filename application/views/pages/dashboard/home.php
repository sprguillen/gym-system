<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="position-relative overflow-hidden p-md-5 bg-light">
  <h3 class="text-dark"><?php echo $page; ?></h3>
  <hr/>

  <div class="row">
    <div class="col-sm-4">
      <div class="card text-center">
        <div class="card-body">
          <h2 class="card-title font-weight-bold text-dark">42 Members</h2>
          <hr/>
          <a href="<?php echo base_url('members/register'); ?>" class="btn btn-danger btn-block"><i class="fa fa-plus fa-xs"></i> Register a new member</a>
          <a href="<?php echo base_url('members') ?>" class="btn btn-outline-danger btn-block"><i class="fa fa-users fa-xs"></i> View all members</a>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="card text-center">
         <div class="card-body">
          <h2 class="card-title font-weight-bold text-dark">6 Programs</h2>
          <hr/>
          <a href="#" class="btn btn-danger btn-block"><i class="fa fa-plus fa-xs"></i> Assign a member to a program</a>
          <a href="#" class="btn btn-outline-danger btn-block"><i class="fa fa-basketball-ball fa-xs"></i> View all programs</a>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="card text-center">
         <div class="card-body">
          <h2 class="card-title font-weight-bold text-dark">9 Coaches</h2>
          <hr/>
          <a href="#" class="btn btn-outline-danger btn-block"><i class="fa fa-bowling-ball fa-xs"></i> View all coaches</a>
          <a href="#" class="btn btn-outline-danger btn-block"><i class="fa fa-calendar-alt fa-xs"></i> View all schedules</a>
        </div>
      </div>
    </div>
  </div>
</div>