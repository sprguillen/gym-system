<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 bg-light hero-image">
  <div class="col-md-4 p-lg-4 my-5">
    <div class="card">
      <div class="card-body">
        <h4 class="text-dark text-center">Log in to your account.</h4>
        <hr/>
        <form>
        <div class="form-group">
          <label for="exampleInputEmail1">Email address</label>
          <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>
        <button type="button" class="btn btn-danger btn-block">Log in</button>
        <a href="<?php echo base_url('register') ?>" class="btn btn-sm btn-outline-muted btn-block">Register a new user</a>
      </form>
      </div>
    </div>
  </div>
</div>