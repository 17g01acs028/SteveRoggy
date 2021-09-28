<!DOCTYPE html>
<html>
<head>
    <title>Laravel 7 Ajax CRUD tutorial using Datatable</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.17/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.17/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>
<body class="bg-dark">
 <div class="container">
   <div class="row">
     <div class="col-md-12">
       <div class="card mt-5">
         <div class="card-header">
            <div class="col-md-12">
                <h4 class="card-title">Laravel 7 Ajax CRUD tutorial using Datatable - nicesnippets.com
                  <a class="btn btn-success ml-5" href="javascript:void(0)" id="createNewItem"> Create New Item</a>
                </h4>
            </div>
         </div>
         <div class="card-body">
           <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Client Name</th>
                        <th>Address</th>
                        <th>Phone Number</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="ajaxModel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modelHeading"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="ItemForm" name="ItemForm" class="form-horizontal">
                           <input type="hidden" name="id" id="Client_id">
                            <div class="form-group">
                                <label for="clientName" class="col-sm-2 control-label">Client Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="name" name="clientName" placeholder="Enter Name" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Client Address</label>
                                <div class="col-sm-12">
                                    <textarea id="address" name="clientAddress" required="" placeholder="Enter client address" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Phone Number</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="phoneNumber" name="mobileNo" placeholder="Enter Phone Number" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Account Type</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="accType" name="accType" placeholder="Enter Account Type" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Account Balance</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="accBalance" name="accBalance" placeholder="Account Balance" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Account Status</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="accStatus" name="accStatus" placeholder="Account Status" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Dlr URL</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="httpDlrUrl" name="httpDlrUrl" placeholder="HTTP Account Dlr" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">HTTP Dlr Method</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="dlrHttpMethod" name="dlrHttpMethod" placeholder="HTTP Method" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="col-sm-offset-2 col-sm-10">
                             <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                             </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('clients.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'clientName', name: 'clientName'},
            {data: 'clientAddress', name: 'clientAddress'},
            {data: 'mobileNo', name: 'mobileNo'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('#createNewItem').click(function () {
        $('#saveBtn').val("create-Item");
        $('#Client_id').val('');
        $('#ItemForm').trigger("reset");
        $('#modelHeading').html("Create New Item");
        $('#ajaxModel').modal('show');
    });

    $('body').on('click', '.editItem', function () {
      var Client_id = $(this).data('id');
      $.get("{{ route('clients.index') }}" +'/' + Client_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Item");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#Client_id').val(data.id);
          $('#name').val(data.clientName);
          $('#address').val(data.clientAddress);
          $('#phoneNumber').val(data.mobileNo);
          $('#accType').val(data.accType);
          $('#accBalance').val(data.accBalance);
          $('#accStatus').val(data.accStatus);
          $('#httpDlrUrl').val(data.httpDlrUrl);
          $('#dlrHttpMethod').val(data.dlrHttpMethod);
      })
   });

    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');

        $.ajax({
          data: $('#ItemForm').serialize(),
          url: "{{ route('clients.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {

              $('#ItemForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();

          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });

    $('body').on('click', '.deleteItem', function () {

        var Client_id = $(this).data("id");
        var res = confirm("Are You sure want to delete !");
        if (res) {
          $.ajax({
              type: "DELETE",
              url: "{{ route('clients.store') }}"+'/'+Client_id,
              success: function (data) {
                  table.draw();
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
        }

    });

  });
</script>
</html>
