@extends('layouts.dashboard')


@section('content')

<body class="bg-dark">
 <div class="container">
   <div class="row">
     <div class="col-md-12">
       <div class="card mt-5">
         <div class="card-header">
            <div class="col-md-12">
                <h4 class="card-title">Users
                  <a class="btn btn-success ml-5" href="{{route('invite_view')}}"> Invite New User</a>
                </h4>
            </div>
         </div>
         <div class="card-body">
           <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Phone Number</th>
                        <th>LowBal Notify</th>
                        <th>Bal Threshold</th>
                        <th>Notify At</th>
                        <th>Client</th>
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


    $('body').on('click', '.custom-switch', function () {
      $(":checkbox").change(function() {
        if($(this).is(":checked")){
            var Alloc_id = this.id;
            // console.log("Checkbox is checked.");
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to activate notification!?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
              }).then((result) => {
                if (result.value) {
                    $.ajax({
                      data: {
                        idee: Alloc_id
                      },
                      url: "{{ route('enable_notfis') }}",
                      type: "POST",
                      dataType: 'json',
                      success: function (data) {
                          console.log('Success:', data);
                          table.draw();
                          Swal.fire(
                            'Approved!',
                            'Notification is enabled.',
                            'success'
                          )
                      },
                      error: function (data) {
                          console.log('Error:', data);
                          Swal.fire(
                            'Failed!',
                            'You are not admin.',
                            'error'
                          )
                      }
                  });

                }
              });

        }
        else if($(this).is(":not(:checked)")){
            // console.log("Checkbox is unchecked.");
            var Alloc_id = this.id;
            // console.log("Checkbox is checked.");
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to disable notification!?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
              }).then((result) => {
                if (result.value) {
                    $.ajax({
                      data: {
                        idee: Alloc_id
                      },
                      url: "{{ route('disable_notfis') }}",
                      type: "POST",
                      dataType: 'json',
                      success: function (data) {
                          console.log('Success:', data);
                          table.draw();
                          Swal.fire(
                            'Deactivated!',
                            'Notification has been disabled.',
                            'success'
                          )
                      },
                      error: function (data) {
                          console.log('Error:', data);
                          Swal.fire(
                            'Failed!',
                            'You do not have rights.',
                            'error'
                          )
                      }
                  });

                }
              });
        }
        table.draw();

      });
    });


    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('users.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'username', name: 'username'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'role', name: 'role'},
            {data: 'phone', name: 'phone'},
            {data: 'flip', name: 'flip', orderable: false, searchable: false},
            {data: 'threshold', name: 'threshold'},
            {data: 'time', name: 'time'},
            {data: 'client', name: 'client.clientName'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('#createNewItem').click(function () {
        $('#saveBtn').val("create-Item");
        $('#User_id').val('');
        $('#ItemForm').trigger("reset");
        $('#modelHeading').html("Create New User");
        $('#ajaxModel').modal('show');
    });

    $('body').on('click', '.editItem', function () {
      var User_id = $(this).data('id');
      $.ajax({
        data: {
          idee: User_id
        },
        url: "{{ route('pass_id') }}",
        type: "POST",
        dataType: 'json',
        success: function (data) {
           // console.log('Succ:', data);
           window.location = "{{ route('users.index') }}" +'/' + data +'/edit';
        },
        error: function (data) {
          console.log('Errorr:', data);

        }
    });

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
            window.location = "{{ route('users.index') }}" +'/' + data ;
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
          url: "{{ route('users.store') }}",
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
               var User_id = data ;
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
                                     url: "{{ route('users.store') }}"+'/'+User_id,
                                     dataType: 'json',
                                     success: function (data) {
                                         table.draw();
                                         Swal.fire(
                                           'Deleted!',
                                           'User has been deleted.',
                                           'success'
                                         )
                                     },
                                     error: function (data) {
                                         console.log('Error:', data);
                                         Swal.fire(
                                           'Failed!',
                                           'User has not been deleted.',
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
