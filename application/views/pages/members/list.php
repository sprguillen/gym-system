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
    Members
  </h3>
  <hr/>
  <div class="row">
    <table class="table table-sm table-hover">
      <thead class="thead-light">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Full Name</th>
          <th scope="col">Payment Scheme</th>
          <th scope="col">Enrollment Duration</th>
          <th scope="col">Classes Enrolled</th>
          <th scope="col">Paid?</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($sampleUsers as $key => $value): ?>
        <tr>
          <th scope="row"><?php echo $key+1; ?></th>
          <td><?php echo $value['name']; ?></td>
          <td><?php echo $value['scheme']; ?></td>
          <td><?php echo $value['duration']; ?></td>
          <td><?php echo $value['classes']; ?></td>
          <td><?php echo ($value['isPaid'])? 'Yes': 'No'; ?></td>
          <td>
            <button type="button" class="btn btn-primary">Freeze</button>
            <button type="button" class="btn btn-warning">View</button>
            <button type="button" class="btn btn-info">Edit</button>
            <button type="button" class="btn btn-danger">Delete</button>
          </td>
        </tr> 
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>