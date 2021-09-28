@extends('layouts.dashboard')


@section('content')

<body class="bg-dark">
 <div class="container">
   <div class="row">
     <div class="col-md-12">
       <div class="card mt-5">
         <div class="card-header">
            <div class="col-md-12">
                <h4 class="card-title">Invited Users
                </h4>
            </div>
         </div>
         <div class="card-body">
           <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Company Name</th>
                        <th>Token</th>
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

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('invites.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
            {data: 'username', name: 'username'},
            {data: 'email', name: 'email'},
            {data: 'client', name: 'client.clientName'},
            {data: 'token', name: 'token'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('body').on('click', '.deleteItem', function () {

        var Invite_id = $(this).data("id");
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
                              url: "{{ route('invites.index') }}"+'/'+Invite_id,
                              success: function (data) {
                                  table.draw();
                                  Swal.fire(
                                    'Deleted!',
                                    'Invite has been deleted.',
                                    'success'
                                  )
                              },
                              error: function (data) {
                                  console.log('Error:', data);
                                  Swal.fire(
                                    'Failed!',
                                    'Invite has not been deleted.',
                                    'error'
                                  )
                              }
                          });

                        }
                      });

    });

  });
</script>
@endsection
