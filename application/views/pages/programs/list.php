<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="position-relative overflow-hidden px-5 list-page-body">
    <div class="col-md-12 mb-2"> 
        <small>
            <?php
                foreach ($breadcrumbs as $index => $route) {
                    foreach ($route as $name => $url) {
                        echo '<a class="mt-0 text-muted" href="' . base_url($url) . '"> ' . $name . '</a> / ';
                    }
                }
            ?>
        </small>
        <h3 class="text-danger">Programs</h3>
        <hr/>
    </div>

    <div class="col-md-12">
        <div class="float-right mb-4">
            <div class="input-group">
                <a class="btn btn-success btn-sm mr-2" href="<?php echo base_url('programs/add'); ?>"><i class="fa fa-plus"></i> New</a>
                <input type="text" class="form-control form-control-sm" placeholder="Search for programs..." aria-label="Search for programs..." aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary btn-sm" type="button"><i class="fa fa-search"></i> Search</button>
                </div>
            </div>
        </div>

        <table class="table table-sm table-hover">
            <thead class="thead">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Program</th>
                <th scope="col">Duration</th>
                <th scope="col">Rates</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($programs as $key => $value): ?>
                <tr>
                    <th scope="col"><?php echo ($key+1); ?></th>
                    <td><?php echo $value->type; ?></td>
                    <td>
                    <?php
                      foreach ($value->price as $p) {
                          echo $p->duration . '<br/>';
                      }
                    ?>
                    </td>
                    <td>
                    <?php
                      foreach ($value->price as $p) {
                          echo 'PHP ' . number_format($p->price, 2) . '<br/>';
                      }
                    ?>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger add-pricing" data-programId="<?php echo $value->id ?>" data-toggle="modal" data-target="#addProgramPricing" <?php echo (count($duration) <= count($value->price))? 'disabled': '' ?>>Add pricing</button>
                        <button type="button" class="btn btn-sm btn-danger edit-program-info" data-programId="<?php echo $value->id ?>" data-toggle="modal" data-target="#editProgramInfo">Edit</button>
                        <!-- <button type="button" class="btn btn-sm btn-outline-primary delete-program" data-programId="<?php echo $value->id ?>">Delete</button> -->
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addProgramPricing" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Program Rate</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" name="programId" value="">
          <div class="form-group">
            <label class="font-weight-bold">Pricing Duration</label>
            <div class="form-group duration-pricing"></div>
          </div>
          <label class="font-weight-bold">Enter amount</label>
          <input type="number" class="form-control" name="amount" required>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger add-rate">Add rate</button>
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editProgramInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Program</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" name="programId" value="">
          <div class="form-group">
            <label class="font-weight-bold">Program name</label>
            <input type="email" class="form-control program-name" id="email" placeholder="Enter program name" required>
          </div>
          <label class="font-weight-bold">Pricing Rates</label>
          <div class="form-group duration-input"></div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger update-program">Update</button>
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript" src="<?php echo base_url("assets/js/UpdatePrograms.js"); ?>"></script>