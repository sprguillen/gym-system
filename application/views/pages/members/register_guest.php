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
    <div class="col-md-7 p-lg-8 mx-auto my-5">
        <form method="POST" action="<?php echo base_url('Admin_Controller/add_user'); ?>">
            <div class="form-row">
                <div class="col-md-4 mb-3">
                  <label for="validationCustom01">First name</label>
                  <input type="text" class="form-control" id="validationCustom01" placeholder="First name" value="" required>
                </div>
                <div class="col-md-4 mb-3">
                  <label for="validationCustom02">Middle name</label>
                  <input type="text" class="form-control" id="validationCustom02" placeholder="MIddle name" value="" required>
                </div>
                <div class="col-md-4 mb-3">
                  <label for="validationCustom02">Last name</label>
                  <input type="text" class="form-control" id="validationCustom02" placeholder="Last name" value="" required>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="exampleInputEmail1">Gender</label>
                    <select name="" class="form-control">
                        <option value="female">Female</option>
                        <option value="male">Male</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationCustom02">E-mail address</label>
                  <input type="text" class="form-control" id="validationCustom02" placeholder="E-mail address" value="">
                </div>
            </div>
            <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-outline-danger w-25 float-right">Cancel</a>
            <button type="submit" class="btn btn-danger w-25 float-right mr-3">Submit</button>
        </form>
    </div>
</div>
