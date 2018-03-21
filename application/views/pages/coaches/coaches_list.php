<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

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
    Health Coaches
  </h3>
  <hr/>
  <div class="row mx-auto p-lg-8 my-5">
    <div class="card mr-3 my-3 mx-auto card-width">
      <img class="card-img-top fixed-height" src="<?php echo site_url('assets/images/coaches/Selection_005.png'); ?>" alt="Card image cap">
      <div class="card-body">
       <h5 class="card-title text-info font-weight-bold">Manuel Sarda</h5>
        <p class="card-text font-italic"><small>Boxing, Kickboxing, Wushu</small></p>
        <p class="card-text"><button type="button" class="btn btn-outline-danger btn-block" data-toggle="modal" data-target="#exampleModal">View schedule</button></p>
      </div>
    </div>
    <div class="card mr-3 my-3 mx-auto card-width">
      <img class="card-img-top fixed-height" src="<?php echo site_url('assets/images/coaches/Selection_004.png'); ?>" alt="Card image cap">
      <div class="card-body">
       <h5 class="card-title text-info font-weight-bold">Dan Eric Azuri</h5>
        <p class="card-text font-italic"><small>Weight Training, Functional Fitness</small></p>
        <p class="card-text"><button type="button" class="btn btn-outline-danger btn-block" data-toggle="modal" data-target="#exampleModal">View schedule</button></p>
      </div>
    </div>
    <div class="card mr-3 my-3 mx-auto card-width">
      <img class="card-img-top fixed-height" src="<?php echo site_url('assets/images/coaches/Selection_006.png'); ?>" alt="Card image cap">
      <div class="card-body">
       <h5 class="card-title text-info font-weight-bold">Cory San Antonio</h5>
        <p class="card-text font-italic"><small>Zumba, Aerobics</small></p>
        <p class="card-text"><button type="button" class="btn btn-outline-danger btn-block">View schedule</button></p>
      </div>
    </div>
    <div class="card mr-3 my-3 mx-auto card-width">
      <img class="card-img-top fixed-height" src="<?php echo site_url('assets/images/coaches/Selection_001.png'); ?>" alt="Card image cap">
      <div class="card-body">
       <h5 class="card-title text-info font-weight-bold">Susana Tsang</h5>
        <p class="card-text font-italic"><small>Functional Fitness, Yoga, Cycling</small></p>
        <p class="card-text"><button type="button" class="btn btn-outline-danger btn-block" data-toggle="modal" data-target="#exampleModal">View schedule</button></p>
      </div>
    </div>
    <div class="card mr-3 my-3 mx-auto card-width">
      <img class="card-img-top fixed-height" src="<?php echo site_url('assets/images/coaches/Selection_002.png'); ?>" alt="Card image cap">
      <div class="card-body">
       <h5 class="card-title text-info font-weight-bold">Linette Ang</h5>
        <p class="card-text font-italic"><small>Functional Fitness, Wushu, Cardiovascular</small></p>
        <p class="card-text"><button type="button" class="btn btn-outline-danger btn-block" data-toggle="modal" data-target="#exampleModal">View schedule</button></p>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-info"><i class="far fa-calendar"></i> Daily Schedule - Manuel Sarda</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-sm table-bordered table-hover">
          <thead class="thead-light">
            <tr class="text-center">
              <th scope="col">Schedule</th>
              <th scope="col">Mon</th>
              <th scope="col">Tue</th>
              <th scope="col">Wed</th>
              <th scope="col">Thu</th>
              <th scope="col">Fri</th>
              <th scope="col">Sat</th>
            </tr>
          </thead>
          <tbody>
            <tr class="text-center">
              <th scope="row">6AM - 9AM</th>
              <td>Boxing</td>
              <td>Boxing</td>
              <td>Kickboxing</td>
              <td>Kickboxing</td>
              <td>Wushu</td>
              <td>Wushu</td>
            </tr>
            <tr class="text-center">
              <th scope="row">9AM - 12PM</th>
              <td>Boxing</td>
              <td>Boxing</td>
              <td>Kickboxing</td>
              <td>Kickboxing</td>
              <td>Wushu</td>
              <td>Wushu</td>
            </tr>
            <tr class="text-center">
              <th scope="row">1PM - 4PM</th>
              <td>Boxing</td>
              <td>Boxing</td>
              <td>Kickboxing</td>
              <td>Kickboxing</td>
              <td>Wushu</td>
              <td>Wushu</td>
            </tr>
            <tr class="text-center">
              <th scope="row">4PM - 7PM</th>
              <td>Boxing</td>
              <td>Boxing</td>
              <td>Kickboxing</td>
              <td>Kickboxing</td>
              <td>Wushu</td>
              <td>Wushu</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger">Enroll a student</button>
        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>