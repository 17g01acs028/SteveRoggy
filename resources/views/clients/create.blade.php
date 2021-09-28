@extends('layouts.dashboard')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create New Client</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('clients.index') }}"> Back</a>
        </div>
    </div>
</div>

<div class="row d-flex justify-content-center">
  <div class="col-lg-8 ">

    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">New Client</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
        </div>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      @if ($errors->any())
          <div class="alert alert-danger">
              <strong>Whoops!</strong> There were some problems with your input.<br><br>
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
      <div class="card-body">
        <form role="form" action="{{ route('clients.store') }}" method="POST">
            @csrf
        <div class="row">

          <div class="col-md-6">
            <div class="form-group">
              <label for="clientName">Client Name</label>
              <input type="text" name="clientName" class="form-control" id="clientName" placeholder="Enter Client Name">
            </div>
            <div class="form-group">
              <label for="clientAddress">Address</label>
              <input type="text" name="clientAddress" class="form-control" id="clientAddress" placeholder="Client's Address">
            </div>
            <div class="form-group">
              <label for="mobileNo">Mobile Number</label>
              <input type="text" name="mobileNo" class="form-control" id="mobileNo" placeholder="Enter Client Name">
            </div>
            <div class="form-group">
              <label for="company_email">Company Email</label>
              <input type="text" name="company_email" class="form-control" id="company_email" placeholder="Enter Company Email">
            </div>
            <div class="form-group">
              <label for="accType">Account Type</label>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="accType" id="exampleRadios1" value="1" checked>
                <label class="form-check-label" for="exampleRadios1">
                  Pre-Paid
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="accType" id="exampleRadios2" value="0">
                <label class="form-check-label" for="exampleRadios2">
                  Post-Paid
                </label>
              </div>
            </div>
            <div class="form-group">
              <label for="accBalance">Account Balance</label>
              <input readonly type="number" name="accBalance" class="form-control" id="accBalance" placeholder="Account Balance">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="accLimit">Account Limit</label>
              <input type="text" name="accLimit" class="form-control" id="accLimit" placeholder="Enter Account Limit">
            </div>
            <div class="form-group">
              <label for="httpDlrUrl">Dlr Report Url</label>
              <input type="text" name="httpDlrUrl" class="form-control" id="httpDlrUrl" placeholder="Enter Client Name">
            </div>
            <div class="form-group">
              <label for="dlrHttpMethod">HTTP Method</label>
              <input type="text" name="dlrHttpMethod" class="form-control" id="dlrHttpMethod" placeholder="Enter Client Name">
            </div>
            <div class="form-group">
              <label for="accStatus">Account Status</label>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="accStatus" id="exampleRadios1" value="1" checked>
                <label class="form-check-label" for="exampleRadios1">
                  Active
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="accStatus" id="exampleRadios2" value="0">
                <label class="form-check-label" for="exampleRadios2">
                  Inactive
                </label>
              </div>
            </div>

          </div>
        </div>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>

    </div>
    <!-- /.card -->
  </div>

</div>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });
  })
</script>
@endsection
