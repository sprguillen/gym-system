$(document).ready(function() {

	$(".freeze-alert").hide();

    $('.move-membership').on('click', function (e) {
        e.preventDefault();
        let newExpiryDate = $('.date_expired_input').val();
        let membershipId = $('.membership_id_val').val();

        console.log('hello', membershipId)
        $.ajax({
            url: '/gym-system/Members_Controller/ajax_update_membership_expiry',
            type: 'POST',
            data: { membershipId, newExpiryDate  },
            success: function (data) {
                data = JSON.parse(data);
        
                if (data) {
                    window.location.reload();
                }
            }
        });

  });

  $('.edit-program-modal').on('click', function (e) {
    let membershipId = $(this).attr('data-membership_id');
    let dateExpired = $(this).attr('data-date_expired');
    let programName = $(this).attr('data-program_name');

    $('.date_expired_input').val(dateExpired);
    $('.membership_id_val').val(membershipId);
    $('.program-name-to-edit').html(programName);
    $('.cancel_membership').attr('href', `/gym-system/members/cancel-membership/${membershipId}`);

  })

	$(".confirm-unfreeze").on('click', function (e) {
		e.preventDefault();
		let id = $(this).attr('data-id');

		$.ajax({
			url: '/gym-system/Members_Controller/ajax_unfreeze_member',
			type: 'POST',
			data: { member_id: id },
			success: function (data) {
				console.log(data)
				data = JSON.parse(data);
				if (data['code'] === 400) {
					$(".freeze-alert").html(data['message']);
					$(".freeze-alert").show();
				} else if (data['code'] === 200) {
					window.location.reload();
				}

			},
			error: function (err) {
				console.log(err)
			}
		});
	});

	$(".freeze-close-modal").on('click', function (e) {
		e.preventDefault();
		$("#purpose").val("");
	})

	$(".freeze-form").on('submit', function (e) {
		e.preventDefault();
		let form = $(e.target).serializeArray();

		let data = {
			purpose: form[0].value
		}

		$.ajax({
			url: '/gym-system/Members_Controller/ajax_freeze_member',
			type: 'POST',
			data: { member_id: form[1].value, freeze_data: data },
			success: function (data) {
				data = JSON.parse(data);
				
				if (data['code'] === 400) {
					$(".freeze-alert").html(data['message']);
					$(".freeze-alert").show();
				} else if (data['code'] === 200) {
					window.location.reload();
				}

			}
		});
	})

	$(".freeze-data").click(function (e) {
		e.preventDefault();
		let id = $(this).attr('data-id');
		let name = $(this).attr('data-name');

		$(".member-name").html(name);
		$("#member-id").val(id);
	})

	$(".edit").click(function(e) {
		e.preventDefault();
		let id = $(this).attr('data-id');
		window.location.href = '/gym-system/members/edit/' + id;
	});

	$(".submit-admin").click(function(e) {
		e.preventDefault();
		window.location.href = '/gym-system/admin/unlock/members';
	});

    $('.enrollment-btn').click(function () {
        var memberId = $(this).data('id');
        if ($('#enroll-program > option').length > 0) {
            $('#enroll-program > option').remove();    
        }
        
        $('#enrollment-modal').attr('data-id', $(this).data('id'));
        console.log($('#enroll-program > option').length);
        if ($('#enroll-program > option').length === 0) {
            $('#enroll-program').ready(function () {
                $.ajax({
                    method: 'GET',
                    url: 'get_program_list_per_member',
                    data: {
                        'member_id': memberId
                    }
                }).done(function (response) {
                    console.log(response);
                    var programData = JSON.parse(response);
                    programData.forEach(function (program) {
                        $('#enroll-program').append('<option value="' + program['id'] + '">' + program['type'] + '</option>'); 
                    });
                });
            });
        }
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
            if (parsedResponse.status) {
                vex.dialog.alert({
                    unsafeMessage: parsedResponse.message,
                    callback: function (value) {
                        $('#enrollment-modal').modal('toggle');
                        location.reload();
                    }
                });
            } else {
            	var errMsg = 'Error: ' + parsedResponse.message;
                vex.dialog.alert({
                    unsafeMessage: errMsg,
                    callback: function (value) {
                        $('#enrollment-modal').modal('toggle');
                        location.reload();
                    }
                });
            }
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
});