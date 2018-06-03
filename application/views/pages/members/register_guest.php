<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3">
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
        <h3 class="text-danger"> <?php echo $name; ?></h3>
        <hr/>
    </div>
    <div class="col-md-12">
        <div class="alert alert-danger" role="alert" id="guest-error-messages">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <small id="append-message">
            </small>
        </div>
    </div>
    <div class="col-md-7 p-lg-8 mx-auto my-5">
        <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="guest-fname">First name</label>
              <input type="text" class="form-control" id="guest-fname" placeholder="First name" value="" name="fname">
            </div>
            <div class="col-md-4 mb-3">
              <label for="guest-mname">Middle name</label>
              <input type="text" class="form-control" id="guest-mname" placeholder="MIddle name" value="" name="mname">
            </div>
            <div class="col-md-4 mb-3">
              <label for="guest-lname">Last name</label>
              <input type="text" class="form-control" id="guest-lname" placeholder="Last name" value="" name="lname">
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="guest-gender">Gender</label>
                <select id="guest-gender" name="" class="form-control" name="gender">
                    <option value="female">Female</option>
                    <option value="male">Male</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="guest-email">E-mail address</label>
                <input type="email" class="form-control" id="guest-email" placeholder="E-mail address" value="" name="email">
            </div>
            <div class="col-md-6 mb-3">
                <label for="guest-program">Program</label>
                <select class="form-control" id="guest-program" name="program_id"></select>
            </div>
        </div>
        <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-outline-danger w-25 float-right">Cancel</a>
        <button id="guest-submit" class="btn btn-danger w-25 float-right mr-3">Submit</button>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/RegisterGuest.js"); ?>"></script>