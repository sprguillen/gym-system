$(document).ready(function () {
	$('#guest-error-messages').hide();
	if ($('#guest-program').length > 0) {
		$('#guest-program').ready(function () {
			$.ajax({
                method: 'GET',
                url: 'get_program_list',
            }).done(function (response) {
                var programData = JSON.parse(response);
                programData.forEach(function (program) {
                    $('#guest-program').append('<option value="' + program['id'] + '">' + program['type'] + '</option>'); 
                });
            });
		});
	}

	$('#guest-submit').on('click', function () {
		$.ajax({
			method: 'POST',
			url: 'registration',
			data: {
				'fname': $('#guest-fname').val(),
				'mname': $('#guest-mname').val(),
				'lname': $('#guest-lname').val(),
				'gender': $('#guest-gender').val(),
				'email': $('#guest-email').val(),
				'program_id': $('#guest-program').val()
			}
		}).done(function (response) {
			response = JSON.parse(response);
			if (response['status']) {
				vex.dialog.alert({
                    message: response['message'],
                    callback: function (value) {
                        window.location.href = '/gym-system/members/list/guest';
                    }
                });
			} else {
				var message = $.parseHTML(response['message']);
				$('#append-message').append(message);
				$('#guest-error-messages').show();
			}
		})
	})
});