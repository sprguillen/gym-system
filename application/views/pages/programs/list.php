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
                <input type="text" class="form-control form-control-sm" placeholder="Search for members..." aria-label="Search for members..." aria-describedby="basic-addon2">
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
                <th scope="col">Rates</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($programs as $key => $value): ?>
                <tr>
                    <th scope="col"><?php echo ($key+1); ?></th>
                    <td><?php echo $value->type; ?></td>
                    <td></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-primary freeze-data">Edit</button>

                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>