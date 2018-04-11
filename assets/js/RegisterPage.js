$(document).ready(function (e) {
  $('#identification').hide();

  $('#next').on('click', function (e) {
    e.preventDefault();
    $('#profile').fadeOut(200);
    $('#identification').show();
    $('#profile_tab').removeClass('bg-danger text-white');
    $('#identification_tab').removeClass('text-danger');
    $('#identification_tab').addClass('bg-danger text-white');
    $('#profile_tab').addClass('text-danger');
  })
  
  $('#prev').on('click', function (e) {
    e.preventDefault();
    $('#identification').fadeOut(200);
    $('#profile').show();
    $('#identification_tab').removeClass('bg-danger text-white');
    $('#profile_tab').removeClass('text-danger');
    $('#profile_tab').addClass('bg-danger text-white');
    $('#identification_tab').addClass('text-danger');
  })

});