$(document).ready(function (e) {

    var form = $("#registration_form").show();
    $("#recapture").hide();
    $('#webcam-validation-error').hide();
    $('#fingerprint-validation-error').hide();

    form.steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "fade",
        onStepChanging: function (event, currentIndex, newIndex) {
            if (currentIndex > newIndex) {
                return true;
            }

            if (newIndex === 2) {
                if (!$('input[name="img"').val()) {
                    $('#webcam-validation-error').show();
                    return false;
                }
            }

            form.validate().settings.ignore = ':disabled, :hidden';
            return form.valid();
        },
        onFinishing: function (event, currentIndex) {
            form.validate().settings.ignore = ':disabled';
            
            var hasFingerPrintData = $('#has-fingerprint-data').val();
            if (hasFingerPrintData === "0") {
                $('#fingerprint-validation-error').show();
                return false;
            }

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
                    img: $('input[name="img"]').val(),
                    ename: $('input[name="ename"]').val(),
                    relationship: $('input[name="relationship"]').val(),
                    econtact: $('input[name="econtact"]').val()
                }
            }).done(function (response) {
                response = JSON.parse(response);
                if (response['status'] === true) {
                    vex.dialog.alert({
                        message: response['message'],
                        callback: function (value) {
                            if (value) window.location.replace(response['redirect']);
                        }
                    });
                } else {
                    var errorMsg = response['error'].join('<br/>');
                    vex.dialog.alert({
                        unsafeMessage: errorMsg,
                        callback: function (value) {
                            if (value) window.location.replace(response['redirect']);
                        }
                    });
                }
            });
        }
    }).validate({
        errorPlacement: function errorPlacement (error, element) {
            element.before(error);
        },
        rules: {
            fname: {
                required: true,
                minlength: 2
            },
            mname: {
                required: true,
                minlength: 2
            },
            lname: {
                required: true,
                minlength: 2
            },
            weight: {
                required: true,
                number: true
            },
            height: {
                required: true,
                number: true
            },
            email: {
                required: true,
                email: true
            },
            birthdate: {
                required: true,
                date: true
            },
            gender: {
                required: true
            },
            cellnumber: {
                required: true,
                digits: true
            },
            ename: {
                required: true,
                minlength: 8
            },
            econtact: {
                required: true,
                digits: true
            },
            relationship: {
                required: true
            }
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

    $('.member-dialog-link').on('click', function () {
        var memberId = $(this).data('id');
        $.ajax({
            method: 'GET',
            url: 'get_member_details',
            data: {
                id: memberId
            }
        }).done(function (response) {
            var memberData = JSON.parse(response);

            $('#member-detail-fname').val(memberData['fname']);
            $('#member-detail-mname').val(memberData['mname']);
            $('#member-detail-lname').val(memberData['lname']);
            $('#member-detail-address').val(memberData['address']);
            $('#member-detail-birth').val(memberData['date_of_birth']);
            $('#member-detail-gender').val(memberData['gender']);
            $('#member-detail-weight').val(memberData['weight']);
            $('#member-detail-height').val(memberData['height']);
            $('#member-detail-contact').val(memberData['contact']);
            $('#member-detail-email').val(memberData['email']);
        });
    });
        
    if ($('#has-fingerprint-data').length > 0) {
        $('#has-fingerprint-data').ready(function () {
            setInterval(function () {
                $.ajax({
                    method: "GET",
                    url: "get_fingerprint_data"
                }).done(function (response) {
                    if (response) {
                        $('#has-fingerprint-data').val(1);
                    } else {
                        $('#has-fingerprint-data').val(0);
                    }
                })
            }, 1000)
        });
    }
});