@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Schedule</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('schedules.index') }}"> Back</a>
            </div>
        </div>
    </div>
<div class="row d-flex justify-content-center">
  <div class="col-lg-8 ">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Update Schedule</h3>
      </div>
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

    <form action="{{ route('schedules.update',$schedule->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
          <div class="form-group">
            <label for="source">Source</label>
            <input type="text" name="source" class="form-control" id="source" placeholder="Enter Source Address"
            value = "{{ $schedule->source ? : old('source') }}">
          </div>
          <div class="form-group">
            <label for="text">Message</label>
            <input type="text" name="text" class="form-control" id="text" placeholder="Enter Message"
            value = "{{ $schedule->text ? : old('text') }}">
          </div>
          <div class="form-group">
            <label>Select to use Message Template</label>
            <select class="form-control select2" style="width: 100%;" name="tmp", id="tmp">
              <option></option>
              @foreach ($templates as $tl)
              <option value="{{$tl->message}}">{{ $tl->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <div>
              <a href="#" onclick="insertAtCaret('textareaid','<name>');return false;">Insert Name</a> |
              <a href="#" onclick="insertAtCaret('textareaid','<field_1>');return false;">Insert Field 1</a> |
              <a href="#" onclick="insertAtCaret('textareaid','<field_2>');return false;">Insert Field 2</a> |
              <a href="#" onclick="insertAtCaret('textareaid','<field_3>');return false;">Insert Field 3</a>
            </div>
            <label for="text">Text Message:</label>
            <textarea class="form-control" cols=50 rows =10 name="text" id="textareaid" placeholder="Enter Message ..."></textarea>
          </div>
          <div class="form-group">
            <label for="send_time">Send At:</label>
            <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                <input type="text" name="send_time" class="form-control datetimepicker-input" data-target="#datetimepicker1"
                value = "{{ $schedule->send_time ? : old('send_time') }}">
                <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
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

    $('#tmp').change(function(){
      var txt = $('#tmp').val();
      $('#textareaid').val('');
      // console.log($(this).val());
      $('#textareaid').val(txt);
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
