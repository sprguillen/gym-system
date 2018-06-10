$(document).ready(function() {
    var listTableOrig = $('#list-table-contents');

	$('.freeze-alert').hide();
    $('#clear-bttn').hide();
    $('#search-bttn').prop('disabled', true);
    $('#search-text').val(null);
    $('.hidden-by-default').hide();
    $('#enroll-submit').prop('disabled', true);

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
                        $('.hidden-by-default').show();
                        schemeData.forEach(function (data) {
                             $('#payment-length').append('<option value="' + data['id'] + '">' + data['duration'] + '-' + data['price'] + '</option>'); 
                        });
                        $('#enroll-submit').prop('disabled', false);
                    }
                });
            }
        });
    });

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

    $('#search-text').on('keyup', function () {
        if ($('#search-text').val().length > 0) {
             $('#search-bttn').prop('disabled', false);

             $('#clear-bttn').show();
        } else {
            $('#search-bttn').prop('disabled', true);
        }
    });

    $('#clear-bttn').on('click', function () {
        if ($('#search-text').val().length > 0) {
            $('#search-text').val(null);
            $('#search-bttn').prop('disabled', true);
            $(this).hide();

            if ($('#list-table-contents').hasClass('append-table')) {
                $('#list-table-contents').remove();
                $('#list-table').append(listTableOrig);
            }
        } 
    });

    $('#search-bttn').on('click', function () {
        var searchText = $('#search-text').val();
        var pathName = window.location.pathname;

        var pathArry = pathName.split("/");
        var status = pathArry[4];

        $.ajax({
            method: 'GET',
            url: 'get_member_by_name',
            data: {
                name: searchText,
                status: status
            }
        }).done(function (response) {
            var urlFull, duration, classes, isPaid, enrollmentBtnText;
            var enrollmentEle = '';
            var classEle = '';
            var htmlMid = '';
            var freezeEle = '';
            var memberLoginEle = '';
            var baseUrl = window.location.origin + '/gym-system/members/info/';
            response = JSON.parse(response);

            if (response.status) {
                var membersList = response.members;
                var userMode = response.mode;
                if (status !== 'guest') {

                    var htmlTop = "<table class='table table-sm table-hover append-table' id='list-table-contents'>" +
                        "<thead class='thead'>" +
                        "<tr>" +
                        "<th scope='col'>#</th>" +
                        "<th scope='col'>Full Name</th>" +
                        "<th scope='col'>Enrollment Duration</th>" +
                        "<th scope='col'>Programs Enrolled</th>" +
                        "<th scope='col'>Paid?</th>" +
                        "<th scope='col'></th>" +
                        "</tr>" +
                        "</thead>" +
                        "<tbody>";

                    var htmlBot = "</tbody></table>";

                    membersList.forEach(function (member) {
                        var loginUrl = window.location.origin + '/gym-system/members/biometric-login?member_id=' + member['id'];
                        urlFull = baseUrl + member['id'];
                        duration = member['duration'].replace(',', '<br>');
                        isPaid = member['isPaid'].replace(',', '<br>');

                        if (userMode === 'staff') {
                            if (status === 'inactive') {
                                classes = member['classes'].replace(',', '<br>');
                                classEle = "<td>" + classes + "</td>";
                            }
                        } else {
                            if (status === 'active') {
                                var programsEnrolled = member['programs_enrolled'];
                                programsEnrolled.forEach(function (program) {
                                    classEle += "<a href='#' class='text-info edit-program-modal' data-date_expired='" +
                                        program['date_expired'] + "' data-toggle='modal' data-target='#program-modal' " +
                                        "data-program_name='" + program['type'] + "' data-membership_id='" + program['membership_id'] +
                                        "' title='Edit this program'>" + program['type'] + "</a><br/>";
                                });

                                freezeEle = "<button type='button' data-id='" + member['id'] + "' data-name='" + member['name'] +
                                    "' data-toggle='modal' data-target='#freezeMember' class='btn btn-sm btn-outline-primary " +
                                    "freeze-data'>Freeze</button>";
                            } else if (status === 'frozen') {
                                freezeEle = "<button type='button' data-id='" + member['id'] + "' data-name='" + member['name'] +
                                    "' data-toggle='modal' data-target='#unfreeze-member' class='btn btn-sm btn-outline-primary " +
                                    "freeze-data'>Unfreeze</button>";
                            }
                        }

                        if (status !== 'frozen') {
                            if (status === 'active') {
                                enrollmentBtnText = 'Add a program';
                                memberLoginEle = "<a href='" + loginUrl + 
                                    "' class='btn btn-danger btn-sm enrollment-btn'>Member Login</a>"
                            } else if (status === 'inactive' && 'displayRenewButton' in member) {
                                enrollmentBtnText = 'Renew';
                            } else if (status === 'inactive' && !('displayRenewButton' in member)) {
                                enrollmentBtnText = 'Enroll a program';
                            }
                            enrollmentEle = "<button type='button' class='btn btn-danger btn-sm enrollment-btn' " +
                                "data-toggle='modal' data-target='#enrollment-modal' data-id='" + member['id'] + "'>" + 
                                enrollmentBtnText + "</button>"; 
                        }

                        htmlMid += "<tr><th scope='row'>" + member['id'] + "</th>" +
                            "<td><a class='text-info member-dialog-link' href='" + urlFull + "'>" + member['name'] + "</a></td>" +
                            "<td>" + duration + "</td>" +
                            "<td>" + classEle + "</td>" +
                            "<td>" + isPaid + "</td>" +
                            "<td>" + enrollmentEle + " " + memberLoginEle + " " + freezeEle + "</td></tr>";

                    });

                    $('#list-table-contents').remove();
                    $('#list-table').append(htmlTop + htmlMid + htmlBot);
                } else {
                    var htmlTop = "<table class='table table-sm table-hover' id='list-table-contents-guest'>" +
                        "<thead class='thead'>" +
                        "<tr>" +
                        "<th scope='col'>#</th>" +
                        "<th scope='col'>Full Name</th>" +
                        "<th scope='col'>Date Enrolled</th>" +
                        "<th scope='col'>Program Enrolled</th>" +
                        "<th scope='col'></th>" +
                        "</tr>" +
                        "</thead>" +
                        "<tbody>";

                    var htmlBot = "</tbody></table>";

                    membersList.forEach(function (member) {
                        htmlMid = "<tr><th scope='row'>" + member['id'] + "</th>" +
                            "<td>" + member['name'] + "</td>" +
                            "<td>" + member['duration'] + "</td>" +
                            "<td>" + member['classes'] + "</td>" +
                            "<td><button type='button' class='btn btn-outline-danger btn-sm register-bttn' data-id='" + member['id'] + "'>Register as member</button></td></tr>";
                    });

                    $('#list-table-contents-guest').remove();
                    $('#list-table').append(htmlTop + htmlMid + htmlBot);
                }
                                
            } else {
                vex.dialog.alert({
                    message: response.message
                });
            }
        });
    });
});