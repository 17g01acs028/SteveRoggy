@extends('layouts.dashboard')


@section('content')

<body class="bg-dark">
 <div class="container">
   <div class="row">
     <div class="col-md-12">
       <div class="card mt-5">
         <div class="card-header">
            <div class="col-md-12">
                <h4 class="card-title">
                  Delivery Status
                </h4>
            </div>
         </div>
         <div class="card-body">
           <div id="pie_chart" >
           </div>
        </div>

       </div>

       <div class="card mt-5">
         <div class="card-header">
            <div class="col-md-12">
                <h4 class="card-title">
                  Sent Messages
                </h4>
            </div>
         </div>
         <div class="card-body">
           <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Client Name</th>
                        <th>User</th>
                        <th>Source</th>
                        <th>Dest</th>
                        <th>Status</th>
                        <th>Cost</th>
                        <th>Created at</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

       </div>

     </div>
   </div>
 </div>
</body>
<script type="text/javascript">

  $(function () {

    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });

    var analytics = <?php echo $status; ?>;
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable(analytics);
      var options = {
        title : 'Percentage of Delivery Status'
      };
      var chart = new google.visualization.PieChart(document.getElementById('pie_chart'));
      chart.draw(data, options);
    }


    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('messages.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
            {data: 'client', name: 'client.clientName'},
            {data: 'user', name: 'user.username'},
            {data: 'source', name: 'source'},
            {data: 'dest', name: 'dest'},
            {data: 'status', name: 'status'},
            {data: 'cost', name: 'cost'},
            {
               data: 'created_at',
               type: 'num',
               render: {
                  _: 'display',
                  sort: 'timestamp'
               }
            },
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });


   $('body').on('click', '.showItem', function () {
     var Pref_id = $(this).data('id');
       $.ajax({
         data: {
           idee: Pref_id
         },
         url: "{{ route('pass_id') }}",
         type: "POST",
         dataType: 'json',
         success: function (data) {
            // console.log('Succ:', data);
            window.location = "{{ route('messages.index') }}" +'/' + data ;
         },
         error: function (data) {
           console.log('Errorr:', data);

         }
     });

  });

  });
</script>
@endsection
