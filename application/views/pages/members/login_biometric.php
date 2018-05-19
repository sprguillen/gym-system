<div class="position-relative overflow-hidden p-md-5">
    <div class="row ">
        <div class="card mx-auto">
            <div class="card-body text-center">
                <h3 class="text-danger">BIOMETRIC LOGIN</h3>
                <hr>
                <h3 class="text-center mb-3">Please place your finger on the biometric scanner.</h3>
                <img src="<?php echo base_url('assets/images/face.svg'); ?>" alt="..." class="img-thumbnail w-50 mx-auto d-block">
                <a href="finspot:FingerspotVer;<?php echo $api_ver_url ?>" class='btn btn-xs btn-success'>Press to open fingerprint scanner API</a>
            <div>
            <div id="verification-result">
            </div>
            <a href="<?php echo base_url('members/list') ?>" class="btn-link">Go Back</a>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/MemberLogin.js"); ?>"></script>