<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3">
  <h3 class="text-dark"><?php echo $page; ?></h3>
  <hr/>
  <div class="col-md-8 p-lg-8 mx-auto my-5">
    <div class="card">
      <div class="card-body">
        <h2 class="text-dark text-center">Register</h2>
        <h5 class="text-muted text-center">Join the pursuit of health and wellness.</h5>
        <hr/>

        <form>
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
                <label class="text-dark" for="exampleInputEmail1">First name</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Juan">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="text-dark" for="exampleInputEmail1">Middle name</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Antonio">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="text-dark" for="exampleInputEmail1">Last name</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Saluminag">
              </div>
            </div>
            
            <div class="col-md-12">
              <div class="form-group">
                <label class="text-dark" for="exampleInputEmail1">Address</label>
                <textarea class="form-control" placeholder="Door 4 Frontier St., Garden Heights, Sasa, Davao City" rows="3"></textarea>
              </div>
            </div>

            <div class="col-md-3">
             <div class="form-group">
                <label class="text-dark" for="exampleInputEmail1">Date of birth</label>
                <input type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
              </div>
            </div>  
            <div class="col-md-3">
             <div class="form-group">
                <label class="text-dark" for="exampleInputEmail1">Gender</label>
                <select class="form-control">
                  <option value="female">Female</option>
                  <option value="male">Male</option>
                </select>
              </div>
            </div>  
            <div class="col-md-3">
             <div class="form-group">
                <label class="text-dark" for="exampleInputEmail1">Weight (in kgs)</label>
                <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="58">
              </div>
            </div>  
            <div class="col-md-3">
             <div class="form-group">
                <label class="text-dark" for="exampleInputEmail1">Height (in cm)</label>
                <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="136">
              </div>
            </div>          

            <div class="col-md-6">
             <div class="form-group">
                <label class="text-dark" for="exampleInputEmail1">Phone number</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="+639168912341">
              </div>
            </div>  
            <div class="col-md-6">
             <div class="form-group">
                <label class="text-dark" for="exampleInputEmail1">E-mail address</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="paz.saluminag@gmail.com">
              </div>
            </div>  
            
            <div class="col-md-12">
              <div class="form-group">
                <label class="text-dark" for="exampleInputEmail1">Do you take any medications?</label>
                <textarea class="form-control" placeholder="If multiple, separate by comma" rows="3"></textarea>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label class="text-dark" for="exampleInputEmail1">Do you have any allergies?</label>
                <textarea class="form-control" placeholder="If multiple, separate by comma" rows="3"></textarea>
              </div>
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-md-12 mb-3">
              <a href="#peronsalInfo" class="text-info">
                <i class="fa fa-user-md"></i>
                Emergency Contact
              </a>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label class="text-dark" for="exampleInputEmail1">Full name</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Jenny Amorsolo">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="text-dark" for="exampleInputEmail1">Relationship</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Wife">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="text-dark" for="exampleInputEmail1">Phone number</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="+639123812352">
              </div>
            </div>
          </div>

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
                  <h5 class="card-title text-dark">Biometrics</h5>
                  <p class="card-text">Please place your fingerprint on the machine to scan.</p>
                  <a href="#" class="btn btn-outline-danger btn-block">Upload Photo</a>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <button type="button" class="btn btn-danger btn-lg btn-block mb-3">Save profile</button>
                  <button type="button" class="btn btn-outline-danger btn-block btn-lg  ">Cancel</button>
                </div>
              </div>
            </div>
          </div>
        </form>


        
      </div>
    </div>
  </div>
</div>