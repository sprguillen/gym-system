$(function () {
    var form = $("#registration_form").show();
    $("#recapture").hide();

    form.steps({
        headerTag: "h3",
        bodyTag: "fieldset",
        transitionEffect: "slideLeft",
        onStepChanging: function (event, currentIndex, newIndex) {
            if (currentIndex > newIndex) {
                return true;
            }
            form.validate().settings.ignore = ':disabled, :hidden';
            return form.valid();
        },
        onFinishing: function (event, currentIndex) {
            form.validate().settings.ignore = ':disabled';
            return form.valid();
        },
        onFinished: function (event, currentIndex) {
            $.ajax({
                method: "POST",
                url: "process_member_register",
                data: {
                    fname: $('input[name="fname"]').val(),
                    mname: $('input[name="mname"]').val(),
                    lname: $('input[name="lname"]').val(),
                    address: $('textarea[name="address"]').val(),
                    birthdate: $('input[name="birthdate"]').val(),
                    gender: $('select[name="gender"]').val(),
                    weight: $('input[name="weight"]').val(),
                    height: $('input[name="height"]').val(),
                    cellnumber: $('input[name="cellnumber"]').val(),
                    email: $('input[name="email"]').val(),
                    ename: $('input[name="ename"]').val(),
                    relationship: $('input[name="relationship"]').val(),
                    econtact: $('input[name="econtact"]').val()
                }
            }).done(function (response) {

            });
        }
    }).validate({
        errorPlacement: function errorPlacement (error, element) {
            element.before(error);
        },
        rules: {
            // fname: {
            //     required: true,
            //     minlength: 2
            // },
            // mname: {
            //     required: true,
            //     minlength: 2
            // },
            // lname: {
            //     required: true,
            //     minlength: 2
            // },
            // weight: {
            //     required: true,
            //     number: true
            // },
            // height: {
            //     required: true,
            //     number: true
            // },
            // email: {
            //     required: true,
            //     email: true
            // },
            // birthdate: {
            //     required: true,
            //     date: true
            // },
            // gender: {
            //     required: true
            // },
            // cellnumber: {
            //     required: true,
            //     digits: true
            // },
            // ename: {
            //     required: true,
            //     minlength: 8
            // },
            // econtact: {
            //     required: true,
            //     digits: true
            // },
            // relationship: {
            //     required: true
            // }
        }
    });

    if ($('#registration-cam').length) {
        var registrationCamClone = $('#registration-cam').clone();
        Webcam.set({
            width: 320,
            height: 240,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        Webcam.attach("#registration-cam");

        $('#take-snapshot').on('click', function () {
            Webcam.snap(function (data_uri) {
                $('#registration-cam').replaceWith('<img id="snapshot-img" src="' + data_uri + '">');
                $('#recapture').show();
                $('input[name="img"]').val(data_uri);
            });
        });

        $('#recapture').on('click', function () {
            $('#snapshot-img').replaceWith(registrationCamClone);
            Webcam.attach("#registration-cam");
        });
    }


});
