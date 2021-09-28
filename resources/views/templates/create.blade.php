@extends('layouts.dashboard')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New Message Template</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('templates.index') }}"> Back</a>
        </div>
    </div>
</div>

<div class="row d-flex justify-content-center">
  <div class="col-lg-6 ">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">New Template</h3>
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

      <form role="form" action="{{ route('templates.store') }}" method="POST">
          @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="name">Template Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Template Name">
          </div>
          <div class="form-group">
            <div>
              <a href="#" onclick="insertAtCaret('textareaid','<name>');return false;">Insert Name</a> |
              <a href="#" onclick="insertAtCaret('textareaid','<field_1>');return false;">Insert Field 1</a> |
              <a href="#" onclick="insertAtCaret('textareaid','<field_2>');return false;">Insert Field 2</a> |
              <a href="#" onclick="insertAtCaret('textareaid','<field_3>');return false;">Insert Field 3</a>
            </div>
            <label for="message">Message:</label>
            <textarea class="form-control" cols=50 rows =10 name="message" id="textareaid" placeholder="Enter Message ..."></textarea>
          </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>

</div>

<script type="text/javascript">
$.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
});

    $(function () {
        $('#datetimepicker1').datetimepicker({
          format: 'YYYY-MM-DD HH:mm:ss'
        });
    });

    function insertAtCaret(areaId,text) {
        var txtarea = document.getElementById(areaId);
        var scrollPos = txtarea.scrollTop;
        var strPos = 0;
        var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ?
            "ff" : (document.selection ? "ie" : false ) );
        if (br == "ie") {
            txtarea.focus();
            var range = document.selection.createRange();
            range.moveStart ('character', -txtarea.value.length);
            strPos = range.text.length;
        }
        else if (br == "ff") strPos = txtarea.selectionStart;

        var front = (txtarea.value).substring(0,strPos);
        var back = (txtarea.value).substring(strPos,txtarea.value.length);
        txtarea.value=front+text+back;
        strPos = strPos + text.length;
        if (br == "ie") {
            txtarea.focus();
            var range = document.selection.createRange();
            range.moveStart ('character', -txtarea.value.length);
            range.moveStart ('character', strPos);
            range.moveEnd ('character', 0);
            range.select();
        }
        else if (br == "ff") {
            txtarea.selectionStart = strPos;
            txtarea.selectionEnd = strPos;
            txtarea.focus();
        }
        txtarea.scrollTop = scrollPos;
    }
</script>
@endsection
