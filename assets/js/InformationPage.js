
    function displayInputName () {        
        $('#input_name').show();
        $('#form_name').hide();
    }

    function displayInputAddress () {        
        $('#input_address').show();
        $('#form_address').hide();
    }

    function displayInputBirth () {
        $('#input_birth').show();
        $('#form_birth').hide();
    }

    function displayInputGender () {
        $('#input_gender').show();
        $('#form_gender').hide();
    }

    function displayInputWeight () {
        $('#input_weight').show();
        $('#form_weight').hide();
    }

    function displayInputHeight () {
        $('#input_height').show();
        $('#form_height').hide();
    }

    function displayInputContact () {
        $('#input_contact').show();
        $('#form_contact').hide();
    }

    function displayInputEmail () {
        $('#input_email').show();
        $('#form_email').hide();
    }

    $(document).ready(function () {
        $('#profile').addClass('text-info active');
        displayInputName();
        displayInputAddress();
        displayInputBirth();
        displayInputGender();
        displayInputWeight();
        displayInputHeight();
        displayInputContact();
        displayInputEmail();

        $('#input_name').on('click', function (e) {
            e.preventDefault(); 

            let value = $(this).attr('data-value');
            $('#input_name').hide();
            $('#form_name').show();
        });

        $('#input_address').on('click', function (e) {
            e.preventDefault(); 

            $('#input_address').hide();
            $('#form_address').show();
        });

        $('#input_birth').on('click', function (e) {
            e.preventDefault(); 

            $('#input_birth').hide();
            $('#form_birth').show();
        });

        $('#input_gender').on('click', function (e) {
            e.preventDefault(); 

            $('#input_gender').hide();
            $('#form_gender').show();
        });

        $('#input_weight').on('click', function (e) {
            e.preventDefault(); 

            $('#input_weight').hide();
            $('#form_weight').show();
        });

        $('#input_height').on('click', function (e) {
            e.preventDefault(); 

            $('#input_height').hide();
            $('#form_height').show();
        });

        $('#input_contact').on('click', function (e) {
            e.preventDefault(); 

            $('#input_contact').hide();
            $('#form_contact').show();
        });

        $('#input_email').on('click', function (e) {
            e.preventDefault(); 

            $('#input_email').hide();
            $('#form_email').show();
        });

        $('#input_name_cancel').on('click', function (e) {
            e.preventDefault();
            displayInputName();
        });

        $('#input_address_cancel').on('click', function (e) {
            e.preventDefault();
            displayInputAddress();
        });

        $('#input_birth_cancel').on('click', function (e) {
            e.preventDefault();
            displayInputBirth();
        });

        $('#input_gender_cancel').on('click', function (e) {
            e.preventDefault();
            displayInputGender();
        });

        $('#input_weight_cancel').on('click', function (e) {
            e.preventDefault();
            displayInputWeight();
        });

        $('#input_height_cancel').on('click', function (e) {
            e.preventDefault();
            displayInputHeight();
        });

        $('#input_contact_cancel').on('click', function (e) {
            e.preventDefault();
            displayInputContact();
        });

        $('#input_email_cancel').on('click', function (e) {
            e.preventDefault();
            displayInputEmail();
        });
    })