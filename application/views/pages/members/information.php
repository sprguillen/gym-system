<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

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
                    <a id="attendance" class="nav-link text-secondary" href="#">Biometrics</a>
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


    <div class="row">
        <div class="col-md-2">
            <div class="card card-body">
                <img class="img-fluid" src="<?php echo base_url('assets/images/person.jpeg'); ?>" alt=""/>
                
            </div>
        </div>

        <div class="col-md-10">
            <h5 class="text-info">Personal Information</h5>
            <table class="table table-bordered mb-4">
                <tbody>
                    <tr>
                        <th scope="row">Full Name</th>
                        <td><?php echo $member->fname . " " . $member->mname . " " . $member->lname; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Address</th>
                        <td><?php echo $member->address; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Date of birth</th>
                        <td><?php echo date('M d Y', strtotime($member->date_of_birth)); ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Gender</th>
                        <td><?php echo $member->gender ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Weight</th>
                        <td><?php echo $member->weight ?> kgs</td>
                    </tr>
                    <tr>
                        <th scope="row">Height</th>
                        <td><?php echo $member->height ?> cm</td>
                    </tr>
                    <tr>
                        <th scope="row">Phone number</th>
                        <td><?php echo $member->contact ?></td>
                    </tr>
                    <tr>
                        <th scope="row">E-mail address</th>
                        <td><?php echo $member->email ?></td>
                    </tr>
                    <tr>
                        <th scope="row">In case of emergency</th>
                        <td>
                            <strong>Carmelita Cantoneros</strong> <br/>
                            Mother <br/>
                            Banana Beach, Apokon, Tagum City 8100 <br/>
                            0915 123 8712
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript" charset="utf-8" async defer>
    $(document).ready(function (e) {
        $('#profile').addClass('text-info active');
    })
</script>
