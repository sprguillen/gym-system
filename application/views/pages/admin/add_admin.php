<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3">
    <div class="modal fade" id="registration-dialog" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Take a picture</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <center>
                        <div id="registration-cam"></div>
                        <div class="modal-button-container">
                            <button class="btn btn-primary" id="take-snapshot">Capture</button>
                            <button class="btn btn-primary" id="recapture">Re-capture</button>
                        </div>
                        <input type="hidden" name="img"  >
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 p-lg-8 mx-auto my-5">
        <form method="POST" action="<?php echo base_url('admin/add_user'); ?>">
            <?php 
                if (validation_errors()) {
                    echo '<div class="alert alert-danger">';
                    echo validation_errors();
                    echo '</div>';
                }
            ?>
            <?php 
                if ($this->session->flashdata('error')) {
                    echo '<div class="alert alert-danger">';
                    echo $this->session->flashdata('error');
                    echo '</div>';
                }
            ?>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                  <label for="validationCustom01">First name</label>
                  <input type="text" class="form-control" id="validationCustom01" name="first_name" placeholder="First name" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="validationCustom02">Last name</label>
                  <input type="text" class="form-control" id="validationCustom02" name="last_name" placeholder="Last name" required>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="Enter email" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username" aria-describedby="username" placeholder="Enter username" required>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" required>
            </div>
            <div class="form-group">
                <label for="exampleInputConfPassword1">Confirm password</label>
                <input type="password" class="form-control" id="exampleInputConfPassword1" placeholder="Retype password" name="confirm_password" required>
            </div>
            <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-outline-danger w-25 float-right">Cancel</a>
            <button type="submit" class="btn btn-danger w-25 float-right mr-3">Submit</button>
        </form>
    </div>
</div>
