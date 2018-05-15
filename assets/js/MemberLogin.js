$(document).ready(function (e) {
	var refreshIntervalId = setInterval(function () {
		$.ajax({
            method: "GET",
            url: "get_verification_data"
        }).done(function (response) {
        	if (response) {
        		response = JSON.parse(response);
	            var hasInactiveProgram = false;
	            var memberships = response['memberships'];
	            if (memberships.length > 0) {
	            	memberships.forEach(function (membership) {
	            		console.log(membership);
	            		if (membership['inactive']) {
	            			if (membership['status'] === 'Inactive') {
	            				hasInactiveProgram = true;
		            			$('#verification-result').append("Your membership for the following program: " +
		            				membership['program'] + " has been expired since " + membership['expiration'] + "<br/>");
	            			} else if (membership['status'] === 'Frozen') {
	            				$('#verification-result').append("Your membership has been frozen, please approach staff to unfreeze your account. <br/>");
	            			}
	            		} else {
	            			$('#verification-result').append("Your membership is active! Logged in at " + response['login_time'] + "<br/>");
	            		}
	            	});
	            }

	            if (hasInactiveProgram) {
	            	$('#verification-result').addClass('alert alert-warning mt-4');
	            } else {
	            	$('#verification-result').addClass('alert alert-success mt-4');
	            }
        		
        		clearInterval(refreshIntervalId);
        	}
        })
	}, 1000);
});