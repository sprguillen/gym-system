$(document).ready(function (e) {
	$(".edit").click(function(e) {
		e.preventDefault();
		let id = $(this).attr('data-id');
		window.location.href = '/gym-system/members/edit/' + id;
	});

	$('#attendance-default-table').DataTable();
});