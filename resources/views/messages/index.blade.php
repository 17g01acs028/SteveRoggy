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
           <div class="row">
             <!-- left section for filtering -->
             <div class="col-md-4 col-sm-12">
               <!--  -->
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
               <form class="form" action="{{route('stepM1_postReport')}}" method="POST">
                @csrf
                 <!-- start date row -->
                 <div class="row">
                   <div class="col-md-3 col-sm-3">
                     <label for="">Start Date</label>
                   </div>
                    <div class="col-md-9 col-sm-9 input-group date" id="datetimepicker1" data-target-input="nearest">
                      <input type="text" name="startDate" class="form-control datetimepicker-input" data-target="#datetimepicker1"/>
                      <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                   </div>
                   <!-- end Date -->
                   <div class="row mt-2">
                     <div class="col-md-3 col-sm-3">
                       <label for="">End Date</label>
                     </div>
                     <div class="col-md-9 col-sm-9 input-group date" id="datetimepicker2" data-target-input="nearest">
                      <input type="text" name="endDate" class="form-control datetimepicker-input" data-target="#datetimepicker2"/>
                      <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                     </div>
                     <div class="m-2 row mx-auto">
                       <div class="form-check col-6">
                        <input type="checkbox" name="checkbox" class="form-check-input" id="downloadSettings">
                        <label class="form-check-label" for="exampleCheck1">Disable date range</label>
                      </div>
                     </div>
                     <label for="">Filter By?</label>
                     <select class="mt-1 form-control" name="filterBy" id="selectChanger">
                         <option value="1" selected>All</option>
                         <option value="2">PhoneNumber</option>
                         <option value="3">Status</option>
                         <option value="4">Source</option>
                     </select>
                     <div class="visibilityToggler mt-2">
                      <label id="tableDynamicName">assertion allowed</label>
                      <input type="text" name="filterValue" value="" class="form-control">
                     </div>
                     <button class="btn btn-info col-5 pull-left mt-2">Submit</button>
               </form>

             </div>
             <!-- right section for printable table -->
             <div class="col-md-8 col-sm-12">
               <button type="button" name="button" class="btn btn-primary" id="initPdfMaker">Download Pdf</button>
               <button class="btn btn-info" onclick="exportTableToExcel('reportingTable', 'synqAfrica')">Export to Excel</button>
               <a href="" id="dlink" style="display: none"></a>
               <div class="" id="bypassme">

               </div>
               <div class="" id="pdfRenderer">
              <label>History for selected statement period</label>
              
            
 <table class="table">
    <tr class="bg-dark">
      <th>#</th>
      <td>Details</td>
    </tr>
    <tr>
      <th>Total messages sent</th>
      <td>{{ $allMess }}</td>
    </tr>
    <tr > 
      <th>Statement period</th>
      <td>{{ $startDate }} - {{ $endDate }}</td>
    </tr>
    <tr >
      <th>Total amount in Kshs</th>
      <td>{{ $cost }}</td>
    </tr>
 </table>

 <div style="position: absolute; top:-1000em">
  <table style="visibility: collapse" id="reportingTable">
  
    <tr>
      <th>serial</th>
      <th>Source</th>
      <th>Dest</th>
      <th>Status</th>
      <th>Cost</th>
      <th>User</th>
      <th>Created at</th>
    </tr>
    @foreach($messagez as $data)
    <tr>
      <td >{{ $i++ }}</td>
      <td>{{ $data->source }}</td>
      <td>{{ $data->dest }}</td>
      <td>{{ $data->status }}</td>
      <td>{{ $data->cost }}</td>
      <td>{{ $data->user->username }}</td>
      <td>{{ $data->created_at }}</td>
    </tr>
    @endforeach
</table>
 </div>

</div>
 


               
               <!-- end of pdf live area -->
             </div>
           </div>

           <div class="row">
             <div class="col-12 mx-auto">
              <table class="table tabled-stripped" id="mytable">
                <thead>
                  <tr>
                    <th scope="col">serial</th>
                    <th>Source</th>
                    <th>Dest</th>
                    <th>Status</th>
                    <th>Cost</th>
                    <th>User</th>
                    <th>Created at</th>
                  </tr>
                </thead>
                <tbody>
                  @for ($i = 0; $i < count($messagez); $i++)
                  <tr>
                    <th scope="row">{{ $i+1 }}</th>
                    <td>{{ $messagez[$i]->source }}</td>
                    <td>{{ $messagez[$i]->dest }}</td>
                    <td>{{ $messagez[$i]->status }}</td>
                    <td>{{ $messagez[$i]->cost }}</td>
                    <td>{{ $messagez[$i]->user->username }}</td>
                    <td>{{ $messagez[$i]->created_at }}</td>
                  </tr>
                  @endfor
                </tbody>
                 </table>
                
                
                               
                               <!-- end of pdf live area -->
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
 var exportTableToExcel = (tableID, filename = '')=>{
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

$(function () {
$.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
});


$(document).ready(()=>{


 

$('#mytable').DataTable({searching: false});
$('.visibilityToggler').hide()
var label = '';
const isContainerVisible = false;
$('#selectChanger').change(()=>{
  var selected = $('#selectChanger').find(":selected").val();

  switch (+selected) {
    case 1:
      $('.visibilityToggler').hide()
      break;
      case 2:
      $('.visibilityToggler').show();
      label = 'Provide the valid PhoneNumber you wish to filter By'
      break;
      case 3:
      $('.visibilityToggler').show();
      label = 'Provide the status to to filter By (check table for example)'
      break;
      case 4:
      $('.visibilityToggler').show();
      label = 'Provide the source short code'
      break;
    default:

  }
$('#tableDynamicName').html(label)

})


// PDF CREATOR FUNCTION
  $("#initPdfMaker").click(() => {
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

// exportTableToExcel() {
//   var uri = 'data:application/vnd.ms-excel;base64,';
//             var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head></head><body><table>{table}</table></body></html>'; 
//             var base64 = function(s) {
//                 return window.btoa(unescape(encodeURIComponent(s)))
//                   , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
//                   , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }
//                   return function (table, name) {
//                       if (!table.nodeType) table = document.getElementById(table)
//                       var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }
//                       document.getElementById("dlink").href = uri + base64(format(template, ctx));
//                       document.getElementById("dlink").download = `synqPortal-${new Date().getTime()}.xlsx`;
//                       document.getElementById("dlink").click();
//                   }
//               })()

// }




})


});
</script>
@endsection
