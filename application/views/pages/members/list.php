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
    <?php echo ucfirst($type); ?> Members
  </h3>
  <hr/>
  <div class="row mb-4">
    <ul class="nav nav-pills float-right">
      <li class="nav-item">
        <a class="nav-link <?php echo ($type === 'active' || $type === NULL)? 'text-white bg-danger': 'text-danger'; ?>" href="<?php echo base_url('members/list/active'); ?>">Active</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo ($type === 'inactive')? 'text-white bg-danger': 'text-danger'; ?>" href="<?php echo base_url('members/list/inactive'); ?>">Inactive</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo ($type === 'frozen')? 'text-white bg-danger': 'text-danger'; ?>" href="<?php echo base_url('members/list/frozen'); ?>">Frozen</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo ($type === 'guest')? 'text-white bg-danger': 'text-danger'; ?>" href="<?php echo base_url('members/list/guest'); ?>">Guest</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <?php if ($type !== 'guest'): ?>
      <table class="table table-sm table-hover">
        <thead class="thead">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Full Name</th>
            <th scope="col">Payment Scheme</th>
            <th scope="col">Enrollment Duration</th>
            <th scope="col">Programs Enrolled</th>
            <th scope="col">Paid?</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($sampleUsers as $key => $value): ?>
          <tr>
            <th scope="row"><?php echo $key+1; ?></th>
            <td><a class="text-danger" href="#"><?php echo $value['name']; ?></a></td>
            <td><?php echo $value['scheme']; ?></td>
            <td><?php echo $value['duration']; ?></td>
            <td><?php echo $value['classes']; ?></td>
            <td><?php echo ($value['isPaid'])? 'Yes': 'No'; ?></td>
            <td>
              <!-- <button type="button" class="btn btn-primary">Freeze</button> -->
             <!--  <button type="button" data-id="<?php echo $value['id']; ?>" class="btn btn-info edit">Edit</button> -->
              <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#exampleModal">Enroll a program</button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>

    <?php if ($type === 'guest'): ?>
      <table class="table table-sm table-hover">
        <thead class="thead">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Full Name</th>
            <th scope="col">Date Enrolled</th>
            <th scope="col">Program Enrolled</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($sampleUsers as $key => $value): ?>
          <tr>
            <th scope="row"><?php echo $key+1; ?></th>
            <td><?php echo $value['name']; ?></td>
            <td><?php echo $value['duration']; ?></td>
            <td><?php echo $value['classes']; ?></td>
            <td>
              <!-- <button type="button" class="btn btn-primary">Freeze</button> -->
             <!--  <button type="button" data-id="<?php echo $value['id']; ?>" class="btn btn-info edit">Edit</button> -->
              <button type="button" class="btn btn-outline-danger register">Register as member</button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
    <div class="btn-group float-right d-flex" role="group" aria-label="Basic example">
      <button type="button" class="btn btn-outline-danger w-100">Prev</button>
      <button type="button" class="btn btn-danger w-100">Next</button>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger" id="exampleModalLabel">Enroll a Program</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="exampleFormControlSelect1">Select a program</label>
          <select class="form-control" id="exampleFormControlSelect1">
            <option>Weight Training</option>
            <option>Yoga</option>
            <option>Zumba</option>
            <option>Boxing</option>
            <option>Functional Fitness</option>
          </select>
        </div>
        <div class="form-group">
          <label for="exampleFormControlSelect1">Select a coach</label>
          <select class="form-control" id="exampleFormControlSelect1">
            <option>Antoni</option>
            <option>Tan</option>
            <option>Karamo</option>
            <option>Jonathan</option>
            <option>Bobby</option>
          </select>
        </div>
        <div class="form-group">
          <label for="exampleFormControlSelect1">Payment Scheme</label>
          <select class="form-control" id="exampleFormControlSelect1">
            <option>1 month</option>
            <option>3 months</option>
            <option>6 months</option>
            <option>1 year</option>
          </select>
        </div>
        <div class="form-group">
          <label for="exampleFormControlSelect1">Payment Status</label>
          <select class="form-control" id="exampleFormControlSelect1">
            <option>Paid in full</option>
            <option>Partially paid</option>
            <option>Not paid</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger">Submit</button>
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" charset="utf-8" async defer>
  $(document).ready(function() {
    $(".register").click(function(e) {
      e.preventDefault();
      window.location.href = '/gym-system/members/register';
    });
  });
</script>
