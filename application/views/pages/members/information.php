<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal fade" id="edit-img-dialog" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Take a picture</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <center>
                    <div id="registration-cam-edit"></div>
                    <div class="modal-button-container">
                        <button class="btn btn-primary" id="take-snapshot-edit">Capture</button>
                        <button class="btn btn-primary" id="recapture-edit">Re-capture</button>
                        <button class="btn btn-success" id="submit-img-edit">Done</button>
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
<div class="position-relative overflow-hidden px-5">
    <div class="row">
        <div class="col-md-12"> 
            <small>
                <?php
                    foreach ($breadcrumbs as $index => $route) {
                        foreach ($route as $name => $url) {
                            echo '<a class="mt-0 text-muted" href="' . base_url($url) . '"> ' . $name . '</a> / ';
                        }
                    }
                ?>
            </small>
            <h3 class="text-danger"> <?php echo ucfirst($name); ?></h3>
            <hr/>
        </div>
        
        <div class="col-md-12">
            <div class="float-right">
                <div class="input-group">
                    <?php if ($user_mode === 'staff'): ?>
                        <a class="text-info btn-sm mr-2" data-toggle="modal" data-target="#adminModeModal" href="#"><i class="fa fa-lock"></i> Staff Mode</a>
                    <?php endif; ?>
                    <?php if ($user_mode === 'admin'): ?>
                        <a class="text-danger btn-sm mr-2" href="<?php echo base_url('admin/lock/members'); ?>"><i class="fa fa-lock-open"></i> Admin Mode</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a id="profile" class="nav-link" href="#">Profile</a>
                </li>
                <li class="nav-item">
                    <a id="biometrics" class="nav-link text-secondary" href="#">Biometrics</a>
                </li>
                <li class="nav-item">
                    <a id="attendance" class="nav-link text-secondary" href="#">Attendance</a>
                </li>
                <li class="nav-item">
                    <a id="logs" class="nav-link text-secondary" href="#">Membership Logs</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="row logs-section">
        <div class="col-md-12">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Program</th>
                        <th scope="col">Date Enrolled</th>
                        <th scope="col">Date Expired</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody class="logs-table">
                </tbody>
            </table>
        </div>
    </div>

    <div class="row attendance-section">
        <div class="col-md-12">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Date</th>
                        <th scope="col">Program Attended</th>
                    </tr>
                </thead>
                <tbody class="attendance-table">
                </tbody>
            </table>
        </div>
    </div>

    <div class="row profile-section">
        <div class="col-md-2">
            <div class="card card-body">
                <img class="img-fluid" src="<?php echo $member->img ?>" alt=""/>
            </div>
            <?php if ($user_mode === 'admin'): ?>
            <a data-toggle="modal" href="#edit-img-dialog" class="btn btn-outline-danger btn-block" id="upload-photo-edit">
                Upload Photo
            </a>
            <?php endif; ?>
        </div>

        <div class="col-md-10">
            <h5 class="text-info">Personal Information</h5>
            <table class="table table-bordered mb-4">
                <tbody>
                    <tr>
                        <th scope="row" width="30%">Full Name</th>
                        <td>
                            <a href="javascript:void(0);" class="text-dark" id="<?php echo ($user_mode === 'admin')? 'input_name': ''; ?>" data-value="<?php echo $member->fname . " " . $member->mname . " " . $member->lname; ?>">
                                <u class="dotted-underline"><?php echo $member->fname . " " . $member->mname . " " . $member->lname; ?></u>
                            </a>

                            <div class="input-group w-50" id="form_name">
                                <input class="form-control form-control-sm" type="text" id="edit_fname" value="<?php echo $member->fname; ?>">
                                <input class="form-control form-control-sm" type="text" id="edit_mname" value="<?php echo $member->mname; ?>">
                                <input class="form-control form-control-sm" type="text" id="edit_lname" value="<?php echo $member->lname; ?>">
                                <div class="input-group-append">
                                    <button type="button" id="input_name_ok" class="btn btn-outline-danger btn-sm"><i class="fa fa-check"></i></button>
                                    <button type="button" id="input_name_cancel" class="btn btn-outline-dark btn-sm"><i class="fa fa-times-circle"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="30%">Address</th>
                        <td>
                            <a href="javascript:void(0);" class="text-dark" id="<?php echo ($user_mode === 'admin')? 'input_address': ''; ?>" data-value="<?php echo $member->address; ?>">
                                <u class="dotted-underline"><?php echo $member->address; ?></u>
                            </a>

                            <div class="input-group w-50" id="form_address">

                                <textarea class="form-control" rows="4" name="address" id="edit_address"><?php echo $member->address; ?> </textarea>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-danger btn-sm" id="input_address_ok"><i class="fa fa-check"></i></button>
                                    <button type="button" id="input_address_cancel" class="btn btn-outline-dark btn-sm"><i class="fa fa-times-circle"></i></button>
                                </div>
                            </div>

                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="30%">Date of birth</th>
                        <td>
                            <a href="javascript:void(0);" class="text-dark" id="<?php echo ($user_mode === 'admin')? 'input_birth': ''; ?>" data-value="<?php echo date('M d Y', strtotime($member->date_of_birth)); ?>">
                                <u class="dotted-underline"><?php echo date('M d Y', strtotime($member->date_of_birth)); ?></u>
                            </a>

                            <div class="input-group w-50" id="form_birth">
                                <input class="form-control form-control-sm" type="date" id="edit_birth" value="<?php echo date('Y-m-d', strtotime($member->date_of_birth)); ?>">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-danger btn-sm" id="input_birth_ok"><i class="fa fa-check"></i></button>
                                    <button type="button" id="input_birth_cancel" class="btn btn-outline-dark btn-sm"><i class="fa fa-times-circle"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="30%">Gender</th>
                        <td>
                            <a href="javascript:void(0);" class="text-dark" id="<?php echo ($user_mode === 'admin')? 'input_gender': ''; ?>" data-value="<?php echo $member->gender; ?>">
                                <u class="dotted-underline"><?php echo $member->gender; ?></u>
                            </a>

                            <div class="input-group w-50" id="form_gender">
                                <select class="form-control w-50" name="gender" id="edit_gender">
                                    <option selected="<?php echo ($member->gender === 'Female'); ?>" value="Female">Female</option>
                                    <option selected="<?php echo ($member->gender === 'Male'); ?>" value="Male">Male</option>
                                </select>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-danger btn-sm" id="input_gender_ok"><i class="fa fa-check"></i></button>
                                    <button type="button" id="input_gender_cancel" class="btn btn-outline-dark btn-sm"><i class="fa fa-times-circle"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="30%">Weight</th>
                        <td>
                            <a href="javascript:void(0);" class="text-dark" id="<?php echo ($user_mode === 'admin')? 'input_weight': ''; ?>" data-value="<?php echo $member->weight ?>">
                                <u class="dotted-underline"><?php echo $member->weight; ?> kgs</u>
                            </a>

                            <div class="input-group w-50" id="form_weight">
                                <input class="form-control form-control-sm" type="text" id="edit_weight" name="fullname" value="<?php echo $member->weight ?>">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-danger btn-sm" id="input_weight_ok"><i class="fa fa-check"></i></button>
                                    <button type="button" id="input_weight_cancel" class="btn btn-outline-dark btn-sm"><i class="fa fa-times-circle"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="30%">Height</th>
                        <td>
                            <a href="javascript:void(0);" class="text-dark" id="<?php echo ($user_mode === 'admin')? 'input_height': ''; ?>" data-value="<?php echo $member->height  ?>">
                                <u class="dotted-underline"><?php echo $member->height ; ?> cm</u>
                            </a>

                            <div class="input-group w-50" id="form_height">
                                <input class="form-control form-control-sm" type="text" id="edit_height" name="fullname" value="<?php echo $member->height  ?>">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-danger btn-sm" id="input_height_ok"><i class="fa fa-check"></i></button>
                                    <button type="button" id="input_height_cancel" class="btn btn-outline-dark btn-sm"><i class="fa fa-times-circle"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="30%">Phone number</th>
                        <td>
                            <a href="javascript:void(0);" class="text-dark" id="<?php echo ($user_mode === 'admin')? 'input_contact': ''; ?>" data-value="<?php echo $member->contact; ?>">
                                <u class="dotted-underline"><?php echo $member->contact; ?></u>
                            </a>

                            <div class="input-group w-50" id="form_contact">
                                <input class="form-control form-control-sm" type="text" id="edit_contact" name="fullname" value="<?php echo $member->contact; ?>">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-danger btn-sm" id="input_contact_ok"><i class="fa fa-check"></i></button>
                                    <button type="button" id="input_contact_cancel" class="btn btn-outline-dark btn-sm"><i class="fa fa-times-circle"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="30%">E-mail address</th>
                        <td>
                            <a href="javascript:void(0);" class="text-dark" id="<?php echo ($user_mode === 'admin')? 'input_email': ''; ?>" data-value="<?php echo $member->email; ?>">
                                <u class="dotted-underline"><?php echo $member->email; ?></u>
                            </a>

                            <div class="input-group w-50" id="form_email">
                                <input class="form-control form-control-sm" type="text" id="edit_email" name="fullname" value="<?php echo $member->email; ?>">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-danger btn-sm" id="input_email_ok"><i class="fa fa-check"></i></button>
                                    <button type="button" id="input_email_cancel" class="btn btn-outline-dark btn-sm"><i class="fa fa-times-circle"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="30%">In case of emergency</th>
                        <td>

                            <!-- 
                            IN CASE OF EMERGENCY - ADD DETAILS HERE

                            <a href="javascript:void(0);" class="text-dark" id="input_email" data-value="<?php echo $member->email; ?>">
                                <u class="dotted-underline"><?php echo $member->email; ?></u>
                            </a>

                            <div class="input-group w-25" id="form_email">
                                <input class="form-control form-control-sm" type="text" id="input_email_field" name="fullname" value="<?php echo $member->email; ?>">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-danger btn-sm"><i class="fa fa-check"></i></button>
                                    <button type="button" id="input_email_cancel" class="btn btn-outline-dark btn-sm"><i class="fa fa-times-circle"></i></button>
                                </div>
                            </div> -->

                            <strong><?php echo $member->ec_fullname ?></strong> <br/>
                            <?php echo $member->ec_relationship ?> <br/>
                            <?php echo $member->ec_contact ?>
                        </td>
                    </tr>
                </tbody>
            </table>
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
<script type="text/javascript" src="<?php echo base_url("assets/js/Information.js"); ?>"></script>