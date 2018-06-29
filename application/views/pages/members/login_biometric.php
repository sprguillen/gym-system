<div class="position-relative overflow-hidden p-md-5">
    <div class="row ">
        <div class="card mx-auto">
            <div class="card-body text-center">
                <h1 class="text-danger">WELCOME <?php echo $first_name . ' ' . $middle_name . ' ' . $last_name ?></h3>
                <h2><?php echo $login_time_display ?></h2>
                <hr>
                <img src="<?php echo $member_img_url ?>" alt="..." class="img-thumbnail w-50 mx-auto d-block">
            <div>
            <?php
                foreach($memberships as $membership) {
                    if ($membership['status'] === 'Active') {
                        echo "<h3 class='text-success'>Your membership for " . $membership['program'] . " is still active.</h1>";
                    }

                    if ($membership['status'] === 'Inactive') {
                        echo "<h3 class='text-danger'>Your membership for " . $membership['program'] . " was inactive since " . $membership['expiration'] . ".</h1>";
                    }

                    if ($membership['status'] === 'Frozen') {
                        echo "<h3 class='text-primary'>Your membership for " . $membership['program'] . " has been frozen, please unfreeze and repeat login process again.</h1>";
                    }
                }
            ?>
        </div>
    </div>
</div>
