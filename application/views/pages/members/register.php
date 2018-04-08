<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal fade" id="dialog-form" role="dialog">
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
                    <input type="hidden" name="img">
                </center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3">

    <?php
        foreach ($breadcrumbs as $index => $route) {

            foreach ($route as $name => $url) {
                echo '<a class="mt-0" href="' . base_url($url) . '">' . $name . '</a>';
            }

            if ($index < (count($breadcrumbs) - 1)) {
                echo ' &middot ';
            }
        }
    ?>

    <h3 class="text-dark">
        Register
    </h3>
    <hr/>
    <div class="col-md-8 p-lg-8 mx-auto my-5">
        <form id="registration_form" action="Members_Controller/process_registration" method="post">
            <h3>Profile</h3>
            <fieldset>
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-dark text-center">Register</h2>
                        <h5 class="text-muted text-center">Join the pursuit of health and wellness.</h5>
                        <hr/>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <a href="#peronsalInfo" class="text-info">
                                    <i class="fa fa-user-md"></i>
                                    Personal Information
                                </a>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-dark" for="fname-text">First</label>
                                    <input type="text" class="form-control" id="fname-text" placeholder="Juan" name="fname">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-dark" for="mname-text">Middle</label>
                                    <input type="text" class="form-control" id="mname-text" placeholder="Antonio" name="mname">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-dark" for="lname-text">Last</label>
                                    <input type="text" class="form-control" id="lname-text" placeholder="Saluminag" name="lname">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-dark" for="address-text">Address</label>
                                    <textarea class="form-control" id="address-text" placeholder="Door 4 Frontier St., Garden Heights, Sasa, Davao City" rows="3" name="address"></textarea>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="text-dark" for="birth-date">Date of birth</label>
                                    <input type="date" class="form-control" id="birthdate" name="birthdate">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="text-dark" for="gender-input">Gender</label>
                                    <select class="form-control" id="gender-input" name="gender">
                                        <option></option>
                                        <option value="female">Female</option>
                                        <option value="male">Male</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="text-dark" for="weight-number">Weight (in kgs)</label>
                                    <input type="number" class="form-control" id="weight-number" placeholder="58" name="weight">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="text-dark" for="height-number">Height (in cm)</label>
                                    <input type="number" class="form-control" id="height-number" placeholder="136" name="height">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark" for="number-text">Phone number</label>
                                    <input type="text" class="form-control" id="number-text" placeholder="+639168912341" name="cellnumber">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark" for="email-input">E-mail address</label>
                                    <input type="email" class="form-control" id="email-input" name="email" aria-describedby="emailHelp" placeholder="paz.saluminag@gmail.com">
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <a href="#peronsalInfo" class="text-info">
                                    <i class="fa fa-user-md"></i>
                                    Emergency Contact
                                </a>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-dark" for="emergency-name">Contact Full Name</label>
                                    <input type="text" class="form-control" id="emergency-name" placeholder="Jenny Amorsolo" name="ename">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-dark" for="relationship-text">Relationship</label>
                                    <input type="text" class="form-control" id="relationship-text" placeholder="Wife" name="relationship">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-dark" for="tel-input">Phone number</label>
                                    <input type="tel" class="form-control" id="tel-input" placeholder="+639123812352" name="econtact">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>


            <h3>Identification</h3>
            <fieldset>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <a href="#peronsalInfo" class="text-info">
                                    <i class="fa fa-medkit"></i>
                                    Biometrics and Identification
                                </a>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <img class="card-img-top w-25 mx-auto" src="<?php echo base_url('assets/images/thumb.png'); ?>" alt="">
                                    <div class="card-body">
                                        <h5 class="card-title text-dark">Biometrics</h5>
                                        <p class="card-text">Please place your fingerprint on the machine to scan.</p>
                                        <a href="#" class="btn btn-outline-danger btn-block" >Scan fingerprint</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <img class="card-img-top w-50 mx-auto" src="<?php echo base_url('assets/images/face.png'); ?>" alt="">
                                    <div class="card-body">
                                        <h5 class="card-title text-dark">Take A Picture</h5>
                                        <p class="card-text">Please standby and let our camera take a picture of you.</p>
                                        <a data-toggle="modal" href="#dialog-form" class="btn btn-outline-danger btn-block" id="upload-photo">Upload Photo</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
