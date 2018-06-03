$(document).ready(function (e) {
	$(".edit").click(function(e) {
		e.preventDefault();
		let id = $(this).attr('data-id');
		window.location.href = '/gym-system/members/edit/' + id;
	});

	$('#date-filter-btn').on('click', function () {

		var htmlTop = "<table class='table table-sm table-hover' id='attendance-default-table'>" +
			"<thead class='thead'>" +
				"<tr>" +
					"<th scope='col'>Member ID</th>" +
					"<th scope='col'>Full Name</th>" +
					"<th scope='col'>Program</th>" +
					"<th scope='col'>Logged In</th>" +
				"</tr>" +
			"<thead>" +
			"<tbody>";

		var htmlBot = "</tbody></table>";
		
		$.ajax({
			method: 'GET',
			url: 'get_specific_date_attendance_by_ajax',
			data: {
				date: $('#date-filter').val()
			}
		}).done(function (response) {
			var htmlMid = '';
			var membersList = JSON.parse(response);
			membersList.forEach(function (members) {
				htmlMid += "<tr>" +
						"<th>" + members['id'] + "</th>" +
						"<td>" + members['first_name'] + ' ' + members['middle_name'] + ' ' + members['last_name'] + "</td>" +
						"<td>" + members['program_type'] + "</td>" +
						"<td>" + members['logged_in'] + "</td>" +
					"</tr>";
			});

			$('#attendance-default-table').remove();
			$('#attendance-table').append(htmlTop + htmlMid + htmlBot);
		});
	});
});