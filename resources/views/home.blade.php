@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-md-12">

        <!-- Small boxes (Stat box) -->
        <div class="row mt-3">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $contactsCount }}</h3>

                <p>Total Contacts</p>
                <br>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{route('contacts.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $totalCount }}</h3>

                <p>SMS Total</p>
                <br>
              </div>
              <div class="icon">
                <i class="fa fa-envelope"></i>
              </div>
              <a href="{{route('messages.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $successCount }}</h3>

                <p>SMS Delivered</p>
                <br>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{route('messages.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ Auth::user()->client->accBalance }}</h3>

                <p>KES <br> Credit Balance</p>
              </div>
              <div class="icon">
                <i class="fa fa-money" aria-hidden="true"></i>
              </div>
              <a href="{{route('balances.create')}}" class="small-box-footer">Top up <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->

        <div class="row">
        {{ csrf_field() }}
            <div class="col-md-12">
                <div class="card mt-0">
                    <div class="card-header">
                      <div class="col-md-12">
                        <h2 class="card-title">

                          <div class="row">
                            <div class="float-left">
                              <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                              </div>
                            </div>
                            <div id="loader" class="spinner-border ml-5" role="status">
                              <span class="sr-only">Loading...</span>
                            </div>
                            <!-- <div class="float-right" style="padding: 5px 10px">
                              <button type="button" name="filter" id="filter" class="btn btn-info btn-sm">Filter</button>
                              <button type="button" name="refresh" id="refresh" class="btn btn-warning btn-sm">Refresh</button>
                            </div> -->
                          </div>

                        </h2>
                      </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                              <div class="panel panel-default">
                              <div class="panel-heading">Statistics</div>
                                <div class="panel-body">
                                  <canvas id="canvas" ></canvas>
                                </div>
                            </div>
                            </div>

                            <div class="col-md-6">

                            </div>

                        </div>
                    </div>

                </div>
            </div>

            
         </div>

    </div>
  </div>
</div>


 <!-- javascript -->
 
<script>
var _token = $('input[name="_token"]').val();


var options =  {
                    // elements: {
                    //     rectangle: {
                    //         borderWidth: 2,
                    //         borderColor: '#c1c1c1',
                    //         borderSkipped: 'bottom'
                    //     }
                    // },
                    responsive: true,
                    title: {
                      display: true,
                      position: "top",
                      text: "Delivery Status",
                      fontSize: 10,
                      fontColor: "#111"
                    },
                    legend: {
                      display: true,
                      position: "left",
                      labels: {
                        fontColor: "#333",
                        fontSize: 8
                      }
                    }
                };



$(function() {

var start = moment().subtract(29, 'days');
var end = moment();

function cb(start, end) {
    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    // console.log('st:', start);
    // console.log('end:', end);
    start = moment(start).format('Y-MM-DD HH:mm:ss');
    end = moment(end).format('Y-MM-DD HH:mm:ss');
    // console.log('st:', start);
    // console.log('end:', end);
    fetch_data(start,end);
}

$('#reportrange').daterangepicker({
    startDate: start,
    endDate: end,
    ranges: {
       'Today': [moment(), moment()],
       'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
       'Last 7 Days': [moment().subtract(6, 'days'), moment()],
       'Last 30 Days': [moment().subtract(29, 'days'), moment()],
       'This Month': [moment().startOf('month'), moment().endOf('month')],
       'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
}, cb);

cb(start, end);

function fetch_data(start, end)
{
    $.ajax({
      url: "{{ route('daterange') }}",
      type: "POST",
      data: {startDate: start, endDate: end, _token:_token},
      dataType: 'json',
      beforeSend: function () {
          $('#loader').addClass('spinner-border')
      },
      success: function (data) {
            // console.log('Successs:', data);
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myBar = new Chart(ctx, {
                type: 'pie',
                data: {
                      labels: data.label,
                      datasets: [{
                          label: 'Delivery Status',
                          data: data.data,
                          backgroundColor: [
                                "#DEB887",
                                "#A9A9A9",
                                "#DC143C",
                                "#4af515",
                                "#F4A460",
                                "#2E8B57",
                                "#1D7A46",
                                "#edfc15",
                                "#1569f5",
                              ],
                              borderColor: [
                                "#CDA776",
                                "#989898",
                                "#CB252B",
                                "#edfc15",
                                "#b27a4a",
                                "#1D7A46",
                                "#F4A460",
                                "#a9b22f",
                                "#204583",
                              ],
                              borderWidth: [1, 1, 1, 1, 1,1,1, 1, 1]
                          
                      }]
                  },
                options: options
            });
            $('#loader').removeClass('spinner-border')

          },
      error: function (data) {
        console.log('Errorr:', data);
        $('#loader').removeClass('spinner-border')
      }
    });
}


});



</script>


@endsection
