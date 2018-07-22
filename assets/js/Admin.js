$(document).ready(function () {
    $('#user-recapture').hide();
    $('#user-upload-success').hide();
	$('.user_reg_submit_btn').prop("disabled", true);

	setInterval(function () {
        $.ajax({
            method: "GET",
            url: "get_fingerprint_data"
        }).done(function (response) {
            if (response) {
                $('.user_reg_submit_btn').prop("disabled", false);
            }
        });

        if ($('input[name="user_img"]').val()) {
            $('#user-upload-photo').hide();
            $('#user-upload-success').show();
        }
    }, 1000)

    if ($('#user-registration-cam').length) {
        var registrationCamClone = $('#user-registration-cam').clone();
        Webcam.set({
            width: 320,
            height: 240,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        Webcam.attach("#user-registration-cam");

        $('#user-take-snapshot').on('click', function () {
            Webcam.snap(function (data_uri) {
                $('#user-registration-cam').replaceWith('<img id="user-snapshot-img" src="' + data_uri + '">');
                $('#user-recapture').show();
                $('input[name="user_img"]').val(data_uri);
            });
        });

        $('#user-recapture').on('click', function () {
            $('#user-snapshot-img').replaceWith(registrationCamClone);
            Webcam.attach("#user-registration-cam");
        });
    }
});