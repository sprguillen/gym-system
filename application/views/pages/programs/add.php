<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3">
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
        <h3 class="text-danger">New Program</h3>
        <hr/>
    </div>

    <div class="col-md-6 p-lg-8 mx-auto my-5">
        <div class="form-group">
            <label for="program-name">Program name</label>
            <input type="text" class="form-control" id="program-name" placeholder="Enter program name" name="program_name">
        </div>


        <div class="form-row">
            <div class="col-md-2 mb-3">
                <div class="custom-control custom-checkbox my-1">
                    Enter rates for:
                </div>
            </div>

            <?php foreach ($duration as $d): ?>
            <div class="col-md-2 mb-3">
                <div class="my-1 mr-sm-2">
                    <input type="checkbox" name="duration" value="<?php echo $d ?>">
                    <label><?php echo $d; ?></label>
                </div>
            </div>
            <?php endforeach; ?>

            <div class="col-md-12 mb-3">
                <button type="button" id="add-pricing" class="btn btn-outline-danger float-right" disabled><i class="fa fa-plus fa-xs"></i> Add pricing</button>
            </div>
        </div>

        <h6 id="title-pricing">Pricing rates</h6>
        <div class="form-group pricing-input"></div>

        <div class="form-group" id="form-btn">
            <a href="<?php echo base_url('programs'); ?>" class="btn btn-outline-danger w-25 float-right">Cancel</a>
            <button id="guest-submit" class="btn btn-danger w-25 float-right mr-3">Submit</button>
        </div>
    </div>
</div>

<script type="text/javascript" charset="utf-8" async defer>
    $(document).ready(function () {

        $('#title-pricing').hide()
        $('#form-btn').hide()

        let ratesArr = []

        function displayButton () {
            let len = $('#program-name').val().length
            let isDisabled = (len < 5 || len > 50) || (ratesArr.length === 0)

            $('#add-pricing').attr('disabled', isDisabled)
        }

        $('input[name="duration"]').on('click', function (e) {
            
            if ($(this).is(':checked')) {
                ratesArr.push($(this).val())
            } else {
                let index = ratesArr.indexOf($(this).val())

                if (index >= 0) {
                    ratesArr.splice(index, 1)
                }
            }

            displayButton()
        })

        $('#program-name').on('keyup', function (e) {
            e.preventDefault()

            displayButton()
        })

        $('#add-pricing').on('click', function (e) {
            e.preventDefault()

            $('#title-pricing').show()
            $('#form-btn').show()
            
            $('.pricing-input').html('')
            $('#program-name').attr('disabled', true);

            ratesArr.forEach(function (item) {
                let itemName = item.replace(/ /g, '_').toLowerCase()

                let inputHtml = `<label for="rate-type" class="rate-type mt-3">${item}</label>
                                     <input type="number" class="form-control" placeholder="Enter price" name="${itemName}">`

                $('.pricing-input').append(inputHtml)
            })
        })

    })

</script>