$(document).ready(function() {
    var listTableOrig = $('#list-table-contents');

	$('.freeze-alert').hide();
    $('#clear-bttn').hide();
    $('#search-bttn').prop('disabled', true);
    $('#search-text').val(null);

    $('#list-table-contents').DataTable();
    $('#list-table-contents-guest').DataTable();

    $('.move-membership').on('click', function (e) {
        e.preventDefault();
        let programPriceId = $('#extension-field').val();
        let membershipId = $('.membership_id_val').val();
        vex.dialog.confirm({
            message: 'Are you sure?',
            callback: function (value) {
                if (value) {
                    $.ajax({
                        url: '/gym-system/Members_Controller/ajax_update_membership_expiry',
                        type: 'POST',
                        data: { membershipId, programPriceId },
                        success: function (data) {
                            data = JSON.parse(data);
                            vex.dialog.alert({
                                message: data.message,
                                callback: function (value) {
                                    if (data.status) {
                                        location.reload();
                                    }
                                }
                            });  
                        }
                    });
                }
            }
        });
        

    });

    $('.edit-program-modal').on('click', function (e) {
        let membershipId = $(this).attr('data-membership_id');
        let dateExpired = $(this).attr('data-date_expired');
        let programName = $(this).attr('data-program_name');
        let programId = $(this).attr('data-program_id');

        $.ajax({
            method: 'GET',
            url: 'get_program_payment_by_program_id',
            data: {
                'program_id': programId
            }
        }).done(function (response) {
            var schemeData = JSON.parse(response);

            if (schemeData) {
                $('#extension-field > option').remove();
                schemeData.forEach(function (data) {
                     $('#extension-field').append('<option value="' + data['id'] + '">' + data['duration'] + '-' + data['price'] + '</option>'); 
                });
            }
        });
        // $('.date_expired_input').val(dateExpired);
        $('.membership_id_val').val(membershipId);
        $('.program-name-to-edit').html(programName);
        // $('.cancel_membership').attr('href', `/gym-system/members/cancel-membership/${membershipId}`);

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

	$(document).on('click', '.freeze-data', function (e) {
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
		var username = $('#list-admin-mode-user').val();
        var password = $('#list-admin-mode-password').val();

        if (username && password) {
            $.ajax({
                method: 'POST',
                url: '/gym-system/admin/unlock/members',
                data: {
                    'username': username,
                    'password': password
                }
            }).done(function (response) {
                response = JSON.parse(response);
                if (response.status) {
                    vex.dialog.alert({
                        message: 'Successfully entered admin mode!',
                        callback: function (value) {
                            location.reload();
                        }
                    });
                } else {
                    vex.dialog.alert(response.message);
                }
            });
        } else {
            vex.dialog.alert('Please fill up username and/or password');
        }
	});

    $(document).on('click', '.enrollment-btn', function () {
        $('#payment-form').hide();
        $('#enroll-submit').prop('disabled', true);
        var memberId = $(this).data('id');

        if ($('#enroll-program > option').length > 0) {
            $('#enroll-program > option').remove();    
        }
        
        $('#enrollment-modal').attr('data-id', $(this).data('id'));
        if ($('#enroll-program > option').length === 0) {
            $('#enroll-program').ready(function () {
                $.ajax({
                    method: 'GET',
                    url: 'get_program_list_per_member',
                    data: {
                        'member_id': memberId
                    }
                }).done(function (response) {
                    var programData = JSON.parse(response);
                    $('#enroll-program').append('<option disabled selected value>Select a program </option>');
                    programData.forEach(function (program) {
                        $('#enroll-program').append('<option value="' + program['id'] + '">' + program['type'] + '</option>'); 
                    });
                });
            });
        }

        $('#enroll-program').on('change', function () {
            if ($(this).val()) {
                $.ajax({
                    method: 'GET',
                    url: 'get_program_payment_by_program_id',
                    data: {
                        'program_id': $(this).val()
                    }
                }).done(function (response) {
                    var schemeData = JSON.parse(response);

                    if (schemeData) {
                        $('#payment-length > option').remove();
                        $('#payment-form').show();
                        schemeData.forEach(function (data) {
                             $('#payment-length').append('<option value="' + data['id'] + '">' + data['duration'] + '-' + data['price'] + '</option>'); 
                        });
                        $('#enroll-submit').prop('disabled', false);
                    }
                });
            }
        });
    });

    $(document).on('click', '.renew-btn', function () {
        $('#payment-renew-form').hide();
        $('#renew-submit').prop('disabled', true);
        var memberId = $(this).data('id');

        if ($('#enroll-program-renew > option').length > 0) {
            $('#enroll-program-renew > option').remove();    
        }

        $('#renewal-modal').attr('data-id', $(this).data('id'));
        if ($('#enroll-program-renew > option').length === 0) {
            $('#enroll-program-renew').ready(function () {
                $.ajax({
                    method: 'GET',
                    url: 'get_expired_program_list_per_member',
                    data: {
                        'member_id': memberId
                    }
                }).done(function (response) {
                    var programData = JSON.parse(response);
                    $('#enroll-program-renew').append('<option disabled selected value>Select an existing program </option>');
                    programData.forEach(function (program) {
                        $('#enroll-program-renew').append('<option value="' + program['membership_id'] + '-' + program['program_id'] + '">' + program['type'] + '</option>'); 
                    });
                });
            });
        }

        $('#enroll-program-renew').on('change', function () {
            if ($(this).val()) {
                var programId = $(this).val().split('-')[1];
                $.ajax({
                    method: 'GET',
                    url: 'get_program_payment_by_program_id',
                    data: {
                        'program_id': programId
                    }
                }).done(function (response) {
                    var schemeData = JSON.parse(response);

                    if (schemeData) {
                        $('#payment-length-renew > option').remove();
                        $('#payment-renew-form').show();
                        schemeData.forEach(function (data) {
                             $('#payment-length-renew').append('<option value="' + data['id'] + '">' + data['duration'] + '-' + data['price'] + '</option>'); 
                        });
                        $('#renew-submit').prop('disabled', false);
                    }
                });
            }
        });
    })

    $('#enroll-submit').on('click', function () {
        var memberId = $('#enrollment-modal').attr('data-id');
        $.ajax({
            method: 'POST',
            url: 'process_enrollment',
            data: {
                'member_id': memberId,
                'program_id': $('#enroll-program').val(),
                'program_price_id': $('#payment-length').val()
            }
        }).done(function (response) {
            var parsedResponse = JSON.parse(response);
            if (parsedResponse.status) {
                vex.dialog.alert({
                    message: parsedResponse.message,
                    callback: function (value) {
                        $('#enrollment-modal').modal('toggle');
                        location.reload();
                    }
                });
            } else {
            	var errMsg = 'Error: ' + parsedResponse.message;
                vex.dialog.alert({
                    message: errMsg,
                    callback: function (value) {
                        $('#enrollment-modal').modal('toggle');
                        location.reload();
                    }
                });
            }
        });
    });

    $('#renew-submit').on('click', function () {
        var memberId = $('#renewal-modal').attr('data-id');
        var membershipId = $('#enroll-program-renew').val().split('-')[0];
        $.ajax({
            method: 'POST',
            url: 'process_renewal',
            data: {
                'member_id': memberId,
                'membership_id': membershipId,
                'program_price_id': $('#payment-length-renew').val()
            }
        }).done(function (response) {
            var parsedResponse = JSON.parse(response);
            if (parsedResponse.status) {
                vex.dialog.alert({
                    message: parsedResponse.message,
                    callback: function (value) {
                        $('#enrollment-modal').modal('toggle');
                        location.reload();
                    }
                });
            } else {
                var errMsg = 'Error: ' + parsedResponse.message;
                vex.dialog.alert({
                    message: errMsg,
                    callback: function (value) {
                        $('#enrollment-modal').modal('toggle');
                        location.reload();
                    }
                });
            }
        });
    });

    $(document).on('click', '.register-bttn', function () {
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

    $(document).on('click', '.login-bttn', function () {
        var memberId = $(this).data('id');
        var fingerprintUrl = $(this).data('href');
        var apiUrl = 'finspot:FingerspotVer;';

        $.ajax({
            method: 'GET',
            url: '/gym-system/Members_Controller/ajax_get_membership_logs',
            data: {
                'member_id': memberId
            }
        }).done(function (response) {
            response = JSON.parse(response);
            var programs = '';
            var programSelectOpenTag = '<select name="membershipId">';
            var programSelectClosingTag = '</select>';

            response.forEach(function (program) {
                programs += '<option value="' + program['id'] + '">' + program['type'] + '</option>';
            });

            vex.dialog.open({
                message: 'Pick your program:',
                input: [
                    programSelectOpenTag,
                    programs,
                    programSelectClosingTag
                ].join(''),
                buttons: [
                    $.extend({}, vex.dialog.buttons.YES, {text: 'Login'}),
                    $.extend({}, vex.dialog.buttons.NO, {text: 'Back'})
                ],
                callback: function (data) {
                    if (data) {
                        fingerprintUrl += '&membership_id=' + data['membershipId'];
                        var encodedString = Base64.encode(fingerprintUrl);
                        window.open(apiUrl + encodedString, "_self");
                    }
                }
            });
        });
    });
});