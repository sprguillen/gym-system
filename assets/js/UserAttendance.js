$(document).ready(function () {
	$('#user-fingerprint-bttn').hide();
	$('#user-refresh-bttn').hide();

	$('#user-login-bttn').on('click', function () {
		var username = $('#username-field').val();

		$.ajax({
			method: 'POST',
			url: 'get_username_for_attendance',
			data: {
				username: username
			}
		}).done(function (response) {
			response = JSON.parse(response);
			if (response.status) {
				$('#username-field').prop('disabled', true)
				$('#user-fingerprint-bttn').show();

				var apiUrl = 'finspot:FingerspotVer;' + Base64.encode(response.fingerprint_url);
				$('#user-fingerprint-bttn').attr('href', apiUrl);
			} else {
				vex.dialog.alert({
                    message: response.message
                });
			}
		});

	});

	setInterval(function () {
        $.ajax({
            method: "GET",
            url: "ajax_done_verification"
        }).done(function (response) {
        	response = JSON.parse(response);
            if (response) {
                $('#user-fingerprint-bttn').hide();
                $('#user-refresh-bttn').show();
            }
        })
    }, 1000)

    $('#user-refresh-bttn').on('click', function () {
    	$.ajax({
    		method: 'POST',
    		url: 'clear_done_verification'
    	}).done(function (response) {
    		window.location.reload();
    	});
    });
});