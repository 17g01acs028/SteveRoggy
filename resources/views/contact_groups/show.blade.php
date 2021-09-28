@extends('layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Group Contacts</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('groups.index') }}"> Back</a>
            </div>
        </div>
    </div>

  <body class="bg-dark">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
         <div class="card mt-5">
           <div class="card-header">
              <div class="col-md-12">
                  <!-- <h4 class="card-title">My Contacts
                    <a class="btn btn-success ml-5" href="{{route('contacts.create')}}">Add New Contact</a>
                  </h4> -->
                  <div class="card-header">
                    <h3 class="card-title">Showing Contacts belonging to the Group </h3>
                  </div>
              </div>
           </div>
           <div class="card-body">
             <table class="table table-bordered data-table">
                  <thead>
                      <tr>
                          <th width="5%">No</th>
                          <th>Phone Number</th>
                          <th>Name</th>
                          <th>Field 1</th>
                          <th>Field 2</th>
                          <th>Field 3</th>
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
    var Pref_id="<?php echo ($contactGroup->id); ?>";
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('contact_groups.index') }}" +'/' + Pref_id,
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},

            {data: 'phonenumber', name: 'phonenumber'},
            {data: 'name', name: 'name'},
            {data: 'field_1', name: 'field_1'},
            {data: 'field_2', name: 'field_2'},
            {data: 'field_3', name: 'field_3'},
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


  $('body').on('click', '.deleteItem', function () {
    var Group_id="<?php echo id($group->id); ?>";
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
             var Pref_id = data ;
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
                                 data: {
                                   group: Group_id,
                                   row: Pref_id
                                 },
                                 url: "{{ route('detach_contact') }}",
                                 type: "POST",
                                 dataType: 'json',
                                 success: function (data) {
                                       table.draw();
                                       Swal.fire(
                                         'Detached!',
                                         'Contact has been remove from group.',
                                         'success'
                                       )
                                   },
                                   error: function (data) {
                                       console.log('Error:', data);
                                       Swal.fire(
                                         'Failed!',
                                         'Contact has not been remove from group.',
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
