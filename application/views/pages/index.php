<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<a class="py-2" href="#">

<header>
    <nav class="site-header sticky-top py-2">
    <div class="container d-flex flex-column flex-md-row justify-content-between">
      <a class="py-3 d-none d-md-inline-block font-weight-bold" href="#">
        <img class="header-icon" src="<?php echo base_url('assets/images/fitness.png'); ?>">
        Gym Master
      </a>
      <a class="py-3 d-none pr-4 d-md-inline-block" href="#">Membership</a>
      <a class="py-3 d-none pr-4 d-md-inline-block" href="#">Pricing</a>
      <a class="py-3 d-none pr-4 d-md-inline-block" href="#">Schedules</a>
      <a class="py-3 d-none pr-4 d-md-inline-block" href="#">Classes</a>
      <a class="py-3 d-none pr-4 d-md-inline-block" href="#">Contact</a>
    </div>
  </nav>
</header>

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
        <button type="button" class="btn btn-outline-danger btn-block">Register as a new user</button>
      </form>
      </div>
    </div>
  </div>
</div>