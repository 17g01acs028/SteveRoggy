@extends('layouts.dashboard')


@section('content')

<body class="bg-dark">
 <div class="container">
   <div class="row">
     <div class="col-md-12">
       <div class="card mt-5">
         <div class="card-header">
            <div class="col-md-12">
                <h4 class="card-title">Clients Credit Balance
                </h4>
            </div>
         </div>
         <div class="card-body">
           <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Client Name</th>
                        <th>Account Limit</th>
                        <th>Account Type</th>
                        <th>Account Balance</th>
                        <th>Account Status</th>
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

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('clients_credits') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'clientName', name: 'clientName'},
            {data: 'accLimit', name: 'accLimit'},
            {data: 'accType', name: 'accType'},
            {data: 'accBalance', name: 'accBalance'},
            {data: 'accStatus', name: 'accStatus'},
        ]
    });

    $('#createNewItem').click(function () {
        $('#saveBtn').val("create-Item");
        $('#Client_id').val('');
        $('#ItemForm').trigger("reset");
        $('#modelHeading').html("Create New Client");
        $('#ajaxModel').modal('show');
    });

    $('body').on('click', '.editItem', function () {
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
           var Client_id = data ;
           window.location = "{{ route('clients.index') }}" +'/' + Client_id +'/edit';
        },
        error: function (data) {
          console.log('Errorr:', data);

        }
    });
      $.get("{{ route('clients.index') }}" +'/' + Client_id +'/edit', function (data) {
          window.location = "{{ route('clients.index') }}" +'/' + Client_id +'/edit';
          $('#modelHea').html("Edit Item");
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
          var Client_id = data ;
          window.location = "{{ route('clients.index') }}" +'/' + Client_id;
       },
       error: function (data) {
         console.log('Errorr:', data);

       }
   });

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
            console.log('Errorr:', data);
            if(data.responseText)
          	{
              var errors = $.parseJSON(data.responseText);
          		jQuery('.alert-danger').html('');
          		jQuery.each(errors.errors, function(key, value){
          			jQuery('.alert-danger').show();
          			jQuery('.alert-danger').append('<li>'+value+'</li>');
                console.log('Errorrr:', value);
          		});
          	}
          	else
          	{
          		jQuery('.alert-danger').hide();
          		$('#open').hide();
          		$('#ajaxModel').modal('hide');
          	}
              // $('#ajaxModel').modal('show');
              // console.log('Error:', data);
              // $('#saveBtn').html('Save Changes');
          }
      });
    });


    $('body').on('click', '.deleteItem', function () {

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
               var Client_id = data ;
               var res =   Swal.fire({
                               title: 'Are you sure?',
                               text: "You won't be able to revert this!",
                               icon: 'warning',
                               showCancelButton: true,
                               confirmButtonColor: '#3085d6',
                               cancelButtonColor: '#d33',
                               confirmButtonText: 'Yes, delete it!'
                             }).then((result) => {
                               if (result.value) {
                                 $.ajax({
                                     type: "DELETE",
                                     url: "{{ route('clients.store') }}"+'/'+Client_id,
                                     dataType: 'json',
                                     success: function (data) {
                                         table.draw();
                                         Swal.fire(
                                           'Deleted!',
                                           'Client has been deleted.',
                                           'success'
                                         )
                                     },
                                     error: function (data) {
                                         console.log('Error:', data);
                                         Swal.fire(
                                           'Failed!',
                                           'Client has not been deleted.',
                                           'error'
                                         )
                                     }
                                 });

                               }
                             });
            },
            error: function (data) {
              console.log('Errorr:', data);

            }
        });


    });

  });
</script>
@endsection
