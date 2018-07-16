<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="position-relative overflow-hidden px-5 list-page-body">
    <div class="col-md-12 mb-2"> 
        <small class="breadcrumbs">
            <?php
                foreach ($breadcrumbs as $index => $route) {
                    foreach ($route as $name => $url) {
                        echo '<a class="mt-0 text-muted" href="' . base_url($url) . '"> ' . $name . '</a> / ';
                    }
                }
            ?>
        </small>
        <h3 class="text-danger"><span id="month-name"></span>  Income Report</h3>
        <hr/>
    </div>

    <div class="col-md-12">
        <div class="reports-selection"> 
          <div class="float-left mb-4 mr-2">
              <select name="view_type" class="form-control">
                  <option value="table" selected>Table view</option>
                  <option value="chart">Chart view</option>
              </select>
          </div>
          <div class="float-left mb-4 mr-2">
              <select name="date_view" class="form-control">
                  <option value="monthly" selected>Monthly</option>
                  <option value="weekly">Weekly</option>
              </select>
          </div>
          <div class="float-right mb-4 mr-2">
              <button type="button" class="btn btn-info print-function"><i class="fa fa-print"></i> Print</button>
          </div>
          <div class="float-left mb-4">
              <select name="month" class="form-control">
                  <option value="<?php echo date('Y') . '-' ?>01" <?php echo (date('m') === '01')? 'selected': '' ?>>January</option>
                  <option value="<?php echo date('Y') . '-' ?>02" <?php echo (date('m') === '02')? 'selected': '' ?>>February</option>
                  <option value="<?php echo date('Y') . '-' ?>03" <?php echo (date('m') === '03')? 'selected': '' ?>>March</option>
                  <option value="<?php echo date('Y') . '-' ?>04" <?php echo (date('m') === '04')? 'selected': '' ?>>April</option>
                  <option value="<?php echo date('Y') . '-' ?>05" <?php echo (date('m') === '05')? 'selected': '' ?>>May</option>
                  <option value="<?php echo date('Y') . '-' ?>06" <?php echo (date('m') === '06')? 'selected': '' ?>>June</option>
                  <option value="<?php echo date('Y') . '-' ?>07" <?php echo (date('m') === '07')? 'selected': '' ?>>July</option>
                  <option value="<?php echo date('Y') . '-' ?>08" <?php echo (date('m') === '08')? 'selected': '' ?>>August</option>
                  <option value="<?php echo date('Y') . '-' ?>09" <?php echo (date('m') === '09')? 'selected': '' ?>>September</option>
                  <option value="<?php echo date('Y') . '-' ?>10" <?php echo (date('m') === '10')? 'selected': '' ?>>October</option>
                  <option value="<?php echo date('Y') . '-' ?>11" <?php echo (date('m') === '11')? 'selected': '' ?>>November</option>
                  <option value="<?php echo date('Y') . '-' ?>12" <?php echo (date('m') === '12')? 'selected': '' ?>>December</option>
              </select>
          </div>
        </div>

        <table class="table table-sm table-hover tbl-view">
            <thead class="thead">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Name</th>
                <th scope="col">Program</th>
                <th scope="col">Amount</th>
            </tr>
            </thead>
            <tbody id="reports-table">
               <!--  <?php $count = 0; ?>
                <?php foreach ($results as $r): ?>
               <tr>
                   <th><?php echo ++$count; ?></th>
                   <td><?php echo $r->payment_date_time; ?></td>
                   <td><?php echo $r->fname . ' ' . $r->lname; ?></td>
                   <td><?php echo $r->type; ?></td>
                   <td><?php echo 'P ' . number_format($r->price, 2); ?></td>
               </tr>
               <?php endforeach; ?> -->
            </tbody>
        </table>

        <table class="table table-sm table-hover tbl-weekly-view d-none">
            <thead class="thead">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Name</th>
                <th scope="col">Program</th>
                <th scope="col">Total Amount</th>
            </tr>
            </thead>
            <tbody id="reports-weekly-table">
               <!--  <?php $count = 0; ?>
                <?php foreach ($results as $r): ?>
               <tr>
                   <th><?php echo ++$count; ?></th>
                   <td><?php echo $r->payment_date_time; ?></td>
                   <td><?php echo $r->fname . ' ' . $r->lname; ?></td>
                   <td><?php echo $r->type; ?></td>
                   <td><?php echo 'P ' . number_format($r->price, 2); ?></td>
               </tr>
               <?php endforeach; ?> -->
            </tbody>
        </table>
    
        <div class="btn-group float-right tbl-view prev-next" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-sm btn-outline-danger">Prev</button>
            <button type="button" class="btn btn-sm btn-danger">Next</button>
        </div>
    </div>
</div>

<div class="position-relative overflow-hidden px-5 list-page-body chart-div">
    <div class="col-md-12 chart-view d-none"></div>
</div>

<script type="text/javascript">

    let viewType = $('select[name="view_type"] :selected').val()
    let dateView = $('select[name="date_view"] :selected').val()
    let month = $('select[name="month"]').val()
    let html = ''

    function showReportsBarChart(data, displayType) {

      let totalPrice = 0
      labelX = []

      $('tbl-weekly-view').addClass('d-none')
      $('tbl-view').addClass('d-none')

      if (displayType === 'monthly') {
        labelX = [...Array(32).keys()]
        labelX.splice(0, 1)

        let valuesY = []

        labelX.forEach(function(item) {
          valuesY[item] = 0
        })

        data['result'].forEach(function (item) {
          let day = parseInt(item['payment_date_time'].split(' ')[0].split('-')[2]) - 1
          valuesY[day] += parseInt(item['price'])

          totalPrice += parseInt(item['price'])  
        })


        new Chartist.Bar('.chart-view', {
          labels: labelX,
          series: [
            valuesY
          ]
        }, {
          stackBars: false,
          axisY: {
            labelInterpolationFnc: function(value) {
              return value;
            }
          }
        }).on('draw', function(data) {
          if(data.type === 'bar') {
            data.element.attr({
              style: 'stroke-width: 30px'
            })
          }
        })
      } else if (displayType === 'yearly') {
        labelX = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
      } else if (displayType === 'weekly') {
        data = JSON.parse(data)
        console.log(data)

        labelX = [] 
        valuesY = []

        data['week'].forEach(function (item, i) {
          labelX[i] = `${item['sun']} - ${item['sat']}`

          if (data['result'] !== undefined && data['result'][i] !== null) {
            valuesY[i] = 0
            data['result'][i].forEach(function (member, count) {
              valuesY[i] += parseInt(member['price'])
            })
          } else {
            valuesY[i] = 0
          }
        })
        
         new Chartist.Bar('.chart-view', {
            labels: labelX,
            series: [
              valuesY
            ]
          }, {
            stackBars: false,
            axisY: {
              labelInterpolationFnc: function(value) {
                return value;
              }
            }
          }).on('draw', function(data) {
            if(data.type === 'bar') {
              data.element.attr({
                style: 'stroke-width: 30px'
              })
            }
          })
      }
    }


    function getReportsByMonth (month = '', display = 'table') {
      $.ajax({
        method: 'POST',
        url: '/gym-system/Reports_Controller/ajax_get_reports_by_month',
        data: { 
          month: (month === '')? '': month
        }
      }).done(function (response) {
        response = JSON.parse(response)
        html  = ''

        if (display === 'table') {

          $('#month-name').html(response['month'])

          response['result'].forEach(function (item, i) {
            html += '<tr>'
            html += `<th>${i+1}</th>`
            html += `<td>${item.payment_date_time.split(' ')[0]}</td>`
            html += `<td>${item.fname} ${item.mname} ${item.lname}</td>`
            html += `<td>${item.type}</td>`
            html += `<td>P ${item.price}</td>`
            html += '</tr>'
          })

          $('#reports-table').html(html)
        } else {
          showReportsBarChart(response, 'monthly')
        }

        $('select[name=""]')
      })
    }

    function getReportsByWeek (selectedDate = '', display = 'table') {
      $.ajax({
        method: 'POST',
        url: '/gym-system/Reports_Controller/ajax_get_reports_by_week',
        data: { selected_date: selectedDate }
      }).done(function (response) {
        if (response !== '') {
          let tblresults = JSON.parse(response)
          html = ''

          if (display === 'table') {
            tblresults['week'].forEach(function (item, i) {
              html += '<tr>'
              html += `<th>${i+1}</th>`
              html += `<td>${item['sun']} to ${item['sat']}</td>`

              if (tblresults['result'] !== undefined) {
                tblresults['result'].forEach(function (result, weeknum) {
                  if (i === weeknum) {
                    if (result !== null) {
                      let amt = 0
                      html += `<td>`
                      result.forEach(function (members, i) {
                        html += `${members['fname']} ${members['mname']} ${members['lname']}<br/>`
                        amt += parseInt(members['price'])
                      })
                      html += `</td>`

                      html += `<td>`
                      result.forEach(function (members, i) {
                        html += `${members['type']} <br/>`
                      })
                      html += `</td>`
                      
                      html += `<td>`
                      html += `${(amt !== 0)? `P ${amt}`: ''}`
                      html += `</td>`
                    }
                  }
                })
              }
              html += '</tr>'
            })

            $('#reports-weekly-table').html(html)
          } else {
            showReportsBarChart(response, 'weekly')
          }
        }
      })
    }

    $(document).ready(function () {

        getReportsByMonth()

        $('select[name="view_type"]').on('change', function (e) {
          viewType = $('select[name="view_type"] :selected').val()
          month = $('select[name="month"]').val()

          if (viewType === 'chart') {
            $('.tbl-weekly-view').addClass('d-none')
            $('.tbl-view').addClass('d-none')
            $('.chart-view').removeClass('d-none')
            getReportsByMonth(month, 'chart')
          } else {
            $('.chart-view').addClass('d-none')
            $('.tbl-view').removeClass('d-none')
          }
        })


        if (viewType === 'table' && dateView === 'monthly') {
          $('.tbl-view').addClass('d-none')
          $('.tbl-weekly-view').addClass('d-none')
          getReportsByMonth()
        }

        if (viewType === 'chart' && dateView === 'monthly') {
          $('.tbl-view').addClass('d-none')
          $('.tbl-weekly-view').addClass('d-none')
          getReportsByMonth()
        }

        $('select[name="month"]').on('change', function (e) {
          e.preventDefault()

          if (dateView === 'monthly') {
            month = $('select[name="month"]').val()
            $('.tbl-view').removeClass('d-none')
            $('.tbl-weekly-view').addClass('d-none')
            getReportsByMonth(month, viewType)
          }

          if (dateView === 'weekly') {
            $('.tbl-view').addClass('d-none')
            if (viewType === 'chart') {
              $('.tbl-weekly-view').addClass('d-none')
              getReportsByWeek($('select[name="month"]').val(), viewType)
            } else {
              $('.tbl-weekly-view').removeClass('d-none')
              getReportsByWeek($('select[name="month"]').val(), viewType)
            }
          }

        })

        $('select[name="date_view"]').on('change', function (e) {
            e.preventDefault()

            dateView = $('select[name="date_view"] :selected').val()

            if (dateView === 'monthly' && viewType === 'table') {
              $('.tbl-view').removeClass('d-none')
              $('.tbl-weekly-view').addClass('d-none')
              getReportsByMonth($('select[name="month"]').val(), viewType)
            }

            if (dateView === 'monthly' && viewType === 'chart') {
              $('.tbl-view').addClass('d-none')
              $('.tbl-weekly-view').addClass('d-none')
              getReportsByMonth($('select[name="month"]').val(), viewType)
            }

            if (dateView === 'weekly' && viewType === 'table') {
              $('.tbl-weekly-view').removeClass('d-none')
              $('.tbl-view').addClass('d-none')
              getReportsByWeek($('select[name="month"]').val(), viewType)
            }

            if (dateView === 'weekly' && viewType === 'chart') {
              getReportsByWeek($('select[name="month"]').val(), viewType)
            }

        })

        $('.print-function').on('click', function (e) {
          e.preventDefault()

            $('.tbl-view').addClass('mt-5')

            $('.prev-next').addClass('d-none')
            $('.reports-selection').addClass('d-none')
            $('.breadcrumbs').addClass('d-none')
            $('header').addClass('d-none')
            $('footer').addClass('d-none')

            $(this).parents('table').last().removeClass('d-none')
          
            window.print() 
              
            $('.tbl-view').removeClass('mt-5')
            $('.reports-selection').removeClass('d-none')
            $('.breadcrumbs').removeClass('d-none')
            $('header').removeClass('d-none')
            $('footer').removeClass('d-none')

            if (viewType === 'table') {
              $('.prev-next').removeClass('d-none')
            }
        })
    })

</script>