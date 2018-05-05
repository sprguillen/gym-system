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

function returnMemberIDFromUrl() {
    return this.location.href.substr(this.location.href.lastIndexOf('/') + 1);
}

$(document).ready(function (e) {

    $(".submitAdmin").click(function(e) {
        e.preventDefault();
        window.location.href = '/gym-system/admin/unlock/members';
    });

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

    $('#input_name_ok').on('click', function (e) {
        var memberId = returnMemberIDFromUrl();
        $.ajax({
            method: 'POST',
            url: 'update_member_details',
            data: {
                id: memberId,
                fname: $('#edit_fname').val(),
                mname: $('#edit_mname').val(),
                lname: $('#edit_lname').val()
            }
        }).done(function () {
            location.reload();
        });
    });

    $('#input_address_ok').on('click', function (e) {
        var memberId = returnMemberIDFromUrl();
        $.ajax({
            method: 'POST',
            url: 'update_member_details',
            data: {
                id: memberId,
                address: $('#edit_address').val()
            }
        }).done(function () {
            location.reload();
        });
    });

    $('#input_birth_ok').on('click', function (e) {
        var memberId = returnMemberIDFromUrl();
        $.ajax({
            method: 'POST',
            url: 'update_member_details',
            data: {
                id: memberId,
                date_of_birth: $('#edit_birth').val()
            }
        }).done(function () {
            location.reload();
        });
    });

    $('#input_gender_ok').on('click', function (e) {
        var memberId = returnMemberIDFromUrl();
        $.ajax({
            method: 'POST',
            url: 'update_member_details',
            data: {
                id: memberId,
                gender: $('#edit_gender').val()
            }
        }).done(function () {
            location.reload();
        });
    });

    $('#input_weight_ok').on('click', function (e) {
        var memberId = returnMemberIDFromUrl();
        $.ajax({
            method: 'POST',
            url: 'update_member_details',
            data: {
                id: memberId,
                weight: $('#edit_weight').val()
            }
        }).done(function () {
            location.reload();
        });
    });

    $('#input_height_ok').on('click', function (e) {
        var memberId = returnMemberIDFromUrl();
        $.ajax({
            method: 'POST',
            url: 'update_member_details',
            data: {
                id: memberId,
                height: $('#edit_height').val()
            }
        }).done(function () {
            location.reload();
        });
    });

    $('#input_contact_ok').on('click', function (e) {
        var memberId = returnMemberIDFromUrl();
        $.ajax({
            method: 'POST',
            url: 'update_member_details',
            data: {
                id: memberId,
                contact: $('#edit_contact').val()
            }
        }).done(function () {
            location.reload();
        });
    });

    $('#input_email_ok').on('click', function (e) {
        var memberId = returnMemberIDFromUrl();
        $.ajax({
            method: 'POST',
            url: 'update_member_details',
            data: {
                id: memberId,
                email: $('#edit_email').val()
            }
        }).done(function () {
            location.reload();
        });
    });

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

        $('.register-bttn').on('click', function () {
            var memberId = $(this).data('id');
            
            $.ajax({
                method: 'GET',
                url: 'get_details_via_ajax',
                data: {
                    id: memberId
                }
            }).done(function (response) {
                window.location.replace('register');
            });
        });

        if ($('#enroll-program').length > 0) {
            $('#enroll-program').ready(function () {
                $.ajax({
                    method: 'GET',
                    url: 'get_program_list',
                }).done(function (response) {
                    var programData = JSON.parse(response);
                    programData.forEach(function (program) {
                        $('#enroll-program').append('<option value="' + program['id'] + '">' + program['type'] + '</option>'); 
                    });
                });
            });
        }
        

        $('.enrollment-btn').click(function () {
            $('#enrollment-modal').attr('data-id', $(this).data('id'));
        });

        $('#enroll-submit').click(function () {
            var memberId = $('#enrollment-modal').attr('data-id');
            $.ajax({
                method: 'POST',
                url: 'process_enrollment',
                data: {
                    'member_id': memberId,
                    'program_id': $('#enroll-program').val(),
                    'payment_length': $('#payment-length').val()
                }
            }).done(function (response) {
                var parsedResponse = JSON.parse(response);
                alert(parsedResponse.message);
                $('#enrollment-modal').modal('toggle');
                location.reload();
            });
        });

        if ($('#scan-btn').length > 0) {
            $('#scan-btn').ready(function () {
                 $.ajax({
                    method: 'GET',
                    url: 'get_member_count'
                 }).done(function (response) {
                    if (response) {
                        var urlRegister = window.location.href + "/register_fingerprint?member_id=" + response;
                        var encodedUrl = Base64.encode(urlRegister);
                        var href = 'finspot:FingerspotReg;' + encodedUrl;
                        $('#scan-btn').attr('href', href);
                    }
                 });
            });
        }
    });
});