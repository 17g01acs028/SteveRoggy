@extends('layouts.dashboard')


@section('content')

<body class="bg-dark">
 <div class="container">
   <div class="row">
     <div class="col-md-12">
       <div class="card mt-5">
         <div class="card-header">
            <div class="col-md-12">
                <h4 class="card-title">SMS Platform
                  <!-- <a class="btn btn-success ml-5" href="javascript:void(0)" id="createNewItem"> Create New Client</a> -->
                </h4>
            </div>
         </div>
         <div class="card-body">
           <div class="p-2 mb-1">
             <button class="btn btn-primary" onclick="exportToPdf()">Export to Pdf</button>
             <button class="btn btn-info" onclick="exportTableToExcel('reportingTable', 'synqAfrica')">Export to Excel</button>
           </div>
           <div class="" id="pdfRenderer">
            <label>Clients' Accounts Details</label>

           <div style="position: absolute; top:-1000em; visibility:collapse" >
             <table id="reportingTable">
              <tr>
                <th width="5%">No</th>
                <th>Client Name</th>
                <th>Account Limit</th>
                <th>Account Balance</th>
            </tr>
            @for ($i = 0; $i < count($clientz); $i++)
                  <tr>
                    <th scope="row">{{ $i+1 }}</th>
                    <td>{{ $clientz[$i]->clientName }}</td>
                    <td>{{ $clientz[$i]->accLimit }}</td>
                    <td>{{ $clientz[$i]->accBalance }}</td>
                  </tr>
                  @endfor
             </table>
          </div>
        </div>
           <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Created by</th>
                        <th>Approved/Disabled by</th>
                        <th>Client Name</th>
                        <th>Account Status</th>
                        <th>Account Limit</th>
                        <th>Company Email</th>
                        <th>Account Type</th>
                        <th>Account Balance</th>
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
                                    <input type="text" class="form-control" id="name" name="clientName" placeholder="Enter Name" value="" maxlength="50" required="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Client Address</label>
                                <div class="col-sm-12">
                                    <textarea id="address" name="clientAddress" required="true" placeholder="Enter client address" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Phone Number</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="phoneNumber" name="mobileNo" placeholder="Enter Phone Number" value="" maxlength="50" required="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Account Type</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="accType" name="accType" placeholder="Enter Account Type" value="" maxlength="50" required="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Account Balance</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="accBalance" name="accBalance" placeholder="Account Balance" value="" maxlength="50" required="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Account Status</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="accStatus" name="accStatus" placeholder="Account Status" value="" maxlength="50" required="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Dlr URL</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="httpDlrUrl" name="httpDlrUrl" placeholder="HTTP Account Dlr" value="" maxlength="50" required="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">HTTP Dlr Method</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="dlrHttpMethod" name="dlrHttpMethod" placeholder="HTTP Method" value="" maxlength="50" required="true">
                                </div>
                            </div>
                            <div class="col-sm-offset-2 col-sm-10">
                             <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                             </button>
                            </div>
                        </form>
                        <div class="alert alert-danger" style="display:none"></div>
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
// excel sheet maker
var exportTableToExcel = (tableID, filename)=>{
  var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?`synqAccounts-${new Date().getTime()}`+'.xls':`synqAccounts-${new Date().getTime()}.xls`;
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}
//excel sheet maker

// pdf maker
var exportToPdf = ()=>{
  var pdf = new jsPDF({
      orientation: "l",
      unit: "pt",
      format: "a4",
    });

    // page Dimensions
    const pageDimensions = {
      height: 595.28,
      width: 841.89,
    };
    const pageMargin = 50;
    const liveArea = {
      width: pageDimensions.width - pageMargin,
      height: pageDimensions.height - pageMargin,
    };
    source = $("#pdfRenderer")[0];

    specialElementHandlers = {
      // element with id of "bypass" - jQuery style selector
      "#bypassme": function (element, renderer) {
        // true = "handled elsewhere, bypass text extraction"
        return true;
      },
    };
    margins = {
      top: 60,
      bottom: 60,
      left: 40,
      width: liveArea.width,
    };
    // all coords and widths are in jsPDF instance's declared units
    // 'inches' in this case

    pdf.setFont("times", "italic");
    pdf.setFontSize(10);

    //pdf.addImage("./avater_synq.jpg", "JPEG", 10, 78, 12, 15);
    pdf.fromHTML(
      source, // HTML string or DOM elem ref.
      margins.left, // x coord
      margins.top,
      {
        // y coord
        width: margins.width, // max width of content on PDF
        elementHandlers: specialElementHandlers,
      },
      function () {
        // dispose: object with X, Y of the last line add to the PDF
        //          this allow the insertion of new lines after html
        //upper most title
      },
      {
        top: pageMargin,
        bottom: pageMargin,
      }
    );
    pdf.save(`synqAfricaAccounts-${makeid(5)}.pdf`);
}
// end of pdf maker




function makeid(length) {
  var result = "";
  var characters =
    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  var charactersLength = characters.length;
  for (var i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }
  return result;
}


  $(function () {

    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });

    function makeid(length) {
  var result = "";
  var characters =
    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  var charactersLength = characters.length;
  for (var i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }
  return result;
}


    $('body').on('click', '.custom-switch', function () {
      $(":checkbox").change(function() {
        if($(this).is(":checked")){
            var Alloc_id = this.id;
            // console.log("Checkbox is checked.");
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to activate the account!?",
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
                      url: "{{ route('approve_client') }}",
                      type: "POST",
                      dataType: 'json',
                      success: function (data) {
                          console.log('Success:', data);
                          table.draw();
                          Swal.fire(
                            'Approved!',
                            'Account creation has been approved.',
                            'success'
                          )
                      },
                      error: function (data) {
                          console.log('Error:', data);
                          Swal.fire(
                            'Approval Failed!',
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
                text: "You want to deactivate the account!?",
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
                      url: "{{ route('dissapprove_client') }}",
                      type: "POST",
                      dataType: 'json',
                      success: function (data) {
                          console.log('Success:', data);
                          table.draw();
                          Swal.fire(
                            'Deactivated!',
                            'Account has been deactivated.',
                            'success'
                          )
                      },
                      error: function (data) {
                          console.log('Error:', data);
                          Swal.fire(
                            'Deactivation Failed!',
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
        ajax: "{{ route('clients.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'user', name: 'user'},
            {data: 'admin', name: 'admin'},
            {data: 'clientName', name: 'clientName'},
            {data: 'flip', name: 'flip', orderable: false, searchable: false},
            {data: 'accLimit', name: 'accLimit'},
            {data: 'company_email', name: 'company_email'},
            {data: 'accType', name: 'accType'},
            {data: 'accBalance', name: 'accBalance'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
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
