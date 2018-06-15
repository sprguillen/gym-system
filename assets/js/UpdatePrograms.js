$(document).ready(function () {
    let priceDurations = {}
    
    $('.add-rate').on('click', function (e) {
      let programId = $('input[name="programId"]').val()
      
      let duration = $('select[name="pricing_duration"] :selected').val()
      let amount = $('input[name="amount"]').val()
      
      $.ajax({
            method: 'POST',
            url: `/gym-system/Programs_Controller/add_program_rate`,
            data: {
              duration, amount,
              program_id: programId
            }
        }).done(function (response) {
            response = JSON.parse(response)
            
            if (response) {
              window.location.reload()
            }
        })


    })


    $('.add-pricing').on('click', function (e) {
      e.preventDefault()
      
      let programId = $(this).attr('data-programId')
      $('input[name="programId"]').val(programId)

      $.ajax({
            method: 'GET',
            url: `/gym-system/Programs_Controller/ajax_get_program_by_id/${programId}`,
            data: {}
        }).done(function (response) {
            response = JSON.parse(response)
            
            let programInfo = response['program_info'][0]
            let durationTypes = response['duration']

            priceDurations = {}
            programInfo['price'].forEach(function (item) {
              let temp = {[item.duration]: item.price}
              let index = durationTypes.indexOf(item.duration)
              
              if (index >= 0) {
                durationTypes.splice(index, 1)
              }

              priceDurations = {...priceDurations, ...temp}
            })


            let html = '<select class="form-control" name="pricing_duration">'
            durationTypes.forEach(function (item) {
              html += `<option value="${item}">${item}</option>`
            })

            html += '</select>'

            $('.duration-pricing').html(html)
            console.log(durationTypes)
        })
    })

    $('.update-program').on('click', function (e) {
      e.preventDefault()

      let programId = $('input[name="programId"]').val()
      let newName = $('.program-name').val()

      let rates = []

      Object.entries(priceDurations).forEach((key, value) => {
        let price = $(`input[name="price_month['${key[0]}']"]`).val()
        let newRate = { [key[0]]: price }
        
        rates.push(newRate)
      })

      $.ajax({
            method: 'POST',
            url: `/gym-system/Programs_Controller/ajax_update_program`,
            data: {
              rates: JSON.stringify(rates),
              program_name: newName,
              program_id: programId
            }
        }).done(function (response) {
            response = JSON.parse(response)
            
            if (response) {
              window.location.reload()
            }
        })


    })

    $('.edit-program-info').on('click', function (e) {
      e.preventDefault()
      let programId = $(this).attr('data-programId')

      $.ajax({
            method: 'GET',
            url: `/gym-system/Programs_Controller/ajax_get_program_by_id/${programId}`,
            data: {}
        }).done(function (response) {
            response = JSON.parse(response)
            
            let programInfo = response['program_info'][0]
            let durationTypes = response['duration']

            priceDurations = {}
            programInfo['price'].forEach(function (item) {
              let temp = {[item.duration]: item.price}

              priceDurations = {...priceDurations, ...temp}
            })

            $('input[name="programId"]').val(programId)

            let html = ''
            programInfo['price'].forEach(function (item) {
              html += `<label>${item.duration}</label>`
              html += `<input type="text" class="form-control mb-2" name="price_month['${item.duration}']" placeholder="Enter amount" value="${item.price}">`
            })
            
            $('.duration-input').html(html)

            $('.program-name').val(programInfo.type)
        })
    })

})