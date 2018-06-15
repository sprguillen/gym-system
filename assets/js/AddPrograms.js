$(document).ready(function () {

  let ratesArr = []

  function displayButton () {
      let len = $('#program-name').val().length
      let isDisabled = (len < 5 || len > 50) || (ratesArr.length === 0)

      $('#add-pricing').attr('disabled', isDisabled)
  }

  $('input[name="duration"]').on('click', function (e) {
      
      if ($(this).is(':checked')) {
          ratesArr.push($(this).val())
      } else {
          let index = ratesArr.indexOf($(this).val())

          if (index >= 0) {
              ratesArr.splice(index, 1)
          }
      }

      displayButton()
  })

  $('#program-name').on('keyup', function (e) {
      e.preventDefault()

      displayButton()
  })

  $('#add-pricing').on('click', function (e) {
      e.preventDefault()
      $('#alert-msg').addClass('d-none')  

      $.ajax({
          method: 'POST',
          url: '/gym-system/Programs_Controller/ajax_check_if_program_exists',
          data: { 
              program_name: $('#program-name').val()
          }
      }).done(function (response) {
          response = JSON.parse(response)
          
          if (response) {
              $('#alert-msg').removeClass('d-none')   
          } else {
              console.log('here')
              $('#title-pricing').removeClass('d-none')
              $('#form-btn').removeClass('d-none')

              $('.pricing-input').html('')
              $('#program-name').attr('disabled', true)
              $('#add-pricing').attr('disabled', true)

              ratesArr.forEach(function (item, index) {
                  let itemName = item.replace(/ /g, '_').toLowerCase()

                  let inputHtml = `<label for="rate-type" class="rate-type mt-3">${item}</label>
                                  <input type="number" class="form-control" placeholder="Enter price" name="price_month[${index}]" required>`

                                  $('.pricing-input').append(inputHtml)
              })
          }
      })
  })

  $('#program-add-submit').on('click', function (e) {
      e.preventDefault()

      let programName = $('#program-name').val()
      let rates = {}

      ratesArr.forEach(function (item, index) {
          let name = `input[name="price_month[${index}]"]`
          
          let tempRate = {
              [item]: $(name).val()
          }

          rates = {...rates, ...tempRate}
      })

      $.ajax({
          method: 'POST',
          url: '/gym-system/Programs_Controller/ajax_add_program',
          data: { 
              program_name: programName,
              rates: JSON.stringify(rates)
          }
      }).done(function (response) {
          response = JSON.parse(response)
          
          if (response) {
              window.location.href = '/gym-system/programs'
          }
          
      })
  })

})