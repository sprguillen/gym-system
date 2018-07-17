<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="position-relative overflow-hidden px-5 list-page-body">
    <div class="col-md-12 mb-2"> 
        <small class="breadcrumbs">
            <?php
                foreach ($breadcrumbs as $index => $route) {
                    foreach ($route as $name => $url) {
                        echo '<a class="mt-0 text-muted" href="' . base_url($url) . '"> ' . $name . '</a> / ';
                    }
                }
            ?>
        </small>
        <h3 class="text-danger"><span id="month-name"></span>  Income Report</h3>
        <hr/>
    </div>

    <div class="col-md-12">
        <div class="reports-selection"> 
          <div class="float-left mb-4 mr-2">
              <select name="view_type" class="form-control">
                  <option value="table" selected>Table view</option>
                  <option value="chart">Chart view</option>
              </select>
          </div>
          <div class="float-left mb-4 mr-2">
              <select name="date_view" class="form-control">
                  <option value="monthly" selected>Monthly</option>
                  <option value="weekly">Weekly</option>
              </select>
          </div>
          <div class="float-right mb-4 mr-2">
              <button type="button" class="btn btn-info print-function"><i class="fa fa-print"></i> Print</button>
          </div>
          <div class="float-left mb-4">
              <select name="month" class="form-control">
                  <option value="<?php echo date('Y') . '-' ?>01" <?php echo (date('m') === '01')? 'selected': '' ?>>January</option>
                  <option value="<?php echo date('Y') . '-' ?>02" <?php echo (date('m') === '02')? 'selected': '' ?>>February</option>
                  <option value="<?php echo date('Y') . '-' ?>03" <?php echo (date('m') === '03')? 'selected': '' ?>>March</option>
                  <option value="<?php echo date('Y') . '-' ?>04" <?php echo (date('m') === '04')? 'selected': '' ?>>April</option>
                  <option value="<?php echo date('Y') . '-' ?>05" <?php echo (date('m') === '05')? 'selected': '' ?>>May</option>
                  <option value="<?php echo date('Y') . '-' ?>06" <?php echo (date('m') === '06')? 'selected': '' ?>>June</option>
                  <option value="<?php echo date('Y') . '-' ?>07" <?php echo (date('m') === '07')? 'selected': '' ?>>July</option>
                  <option value="<?php echo date('Y') . '-' ?>08" <?php echo (date('m') === '08')? 'selected': '' ?>>August</option>
                  <option value="<?php echo date('Y') . '-' ?>09" <?php echo (date('m') === '09')? 'selected': '' ?>>September</option>
                  <option value="<?php echo date('Y') . '-' ?>10" <?php echo (date('m') === '10')? 'selected': '' ?>>October</option>
                  <option value="<?php echo date('Y') . '-' ?>11" <?php echo (date('m') === '11')? 'selected': '' ?>>November</option>
                  <option value="<?php echo date('Y') . '-' ?>12" <?php echo (date('m') === '12')? 'selected': '' ?>>December</option>
              </select>
          </div>
        </div>

        <table class="table table-sm table-hover tbl-view">
            <thead class="thead">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Name</th>
                <th scope="col">Program</th>
                <th scope="col">Amount</th>
            </tr>
            </thead>
            <tbody id="reports-table">
               <!--  <?php $count = 0; ?>
                <?php foreach ($results as $r): ?>
               <tr>
                   <th><?php echo ++$count; ?></th>
                   <td><?php echo $r->payment_date_time; ?></td>
                   <td><?php echo $r->fname . ' ' . $r->lname; ?></td>
                   <td><?php echo $r->type; ?></td>
                   <td><?php echo 'P ' . number_format($r->price, 2); ?></td>
               </tr>
               <?php endforeach; ?> -->
            </tbody>
        </table>

        <table class="table table-sm table-hover tbl-weekly-view d-none">
            <thead class="thead">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Name</th>
                <th scope="col">Program</th>
                <th scope="col">Total Amount</th>
            </tr>
            </thead>
            <tbody id="reports-weekly-table">
               <!--  <?php $count = 0; ?>
                <?php foreach ($results as $r): ?>
               <tr>
                   <th><?php echo ++$count; ?></th>
                   <td><?php echo $r->payment_date_time; ?></td>
                   <td><?php echo $r->fname . ' ' . $r->lname; ?></td>
                   <td><?php echo $r->type; ?></td>
                   <td><?php echo 'P ' . number_format($r->price, 2); ?></td>
               </tr>
               <?php endforeach; ?> -->
            </tbody>
        </table>
    
        <div class="btn-group float-right tbl-view prev-next" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-sm btn-outline-danger">Prev</button>
            <button type="button" class="btn btn-sm btn-danger">Next</button>
        </div>
    </div>
</div>

<div class="position-relative overflow-hidden px-5 list-page-body chart-div">
    <div class="col-md-12 chart-view d-none"></div>
</div>

<script type="text/javascript" src="<?php echo base_url("assets/js/Reports.js"); ?>"></script>