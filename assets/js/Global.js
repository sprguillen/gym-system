$(document).ready(function () {
	$(".submitAdmin").on('click', function() {
        // window.location.href = '/gym-system/admin/unlock/members';
        var username = $('#admin-mode-user').val();
        var password = $('#admin-mode-pass').val();

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
});