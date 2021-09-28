@extends('layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Clients with the Sender ID</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('senders.index') }}"> Back</a>
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
                    <h3 class="card-title">Showing Clients that are using the Sender ID </h3>
                  </div>
              </div>
           </div>
           <div class="card-body">
             <table class="table table-bordered data-table">
                  <thead>
                      <tr>
                          <th width="5%">No</th>
                          <th>Client Name</th>
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
    var Pref_id="<?php echo ($clientSender->id); ?>";
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('client_senders.index') }}" +'/' + Pref_id,
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},

            {data: 'clientName', name: 'clientName'},
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
    var Sender_id="<?php echo id($sender->id); ?>";
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
         var Pref_id = data
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
                            sender: Sender_id,
                            row: Pref_id
                          },
                          url: "{{ route('detach_client') }}",
                          type: "POST",
                          dataType: 'json',
                          success: function (data) {
                            table.draw();
                            Swal.fire(
                              'Detached!',
                              'Client has been detached from sender.',
                              'success'
                            )
                          },
                          error: function (data) {
                            console.log('Errorr:', data);
                            Swal.fire(
                              'Failed!',
                              'Client has not been detached from sender.',
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
