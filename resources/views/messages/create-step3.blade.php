@extends('layouts.dashboard')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Send SMS</h2>
        </div>
        <div class="pull-right">
        </div>
    </div>
</div>

<div class="row d-flex justify-content-center">
  <div class="col-md-6 ">

    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">New Message</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
        </div>
      </div>
      <!-- /.card-header -->

      <div class="card-body">

          <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link {{ request()->is('tabM1') ? 'active' : null }}" style="border:1px solid #ccc" id="pills-home-tab" href="{{ url('tabM1') }}" role="tab" aria-controls="pills-home" aria-selected="true">Send Now</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('tabM2') ? 'active' : null }}" style="border:1px solid #ccc" id="pills-profile-tab" href="{{ url('tabM2') }}" role="tab" aria-controls="pills-profile" aria-selected="false">Schedule</a>
            </li>
          </ul>
          <hr>
          <div class="tab-content" style="margin-top:16px;" id="pills-tabContent">
            <div class="tab-pane {{ request()->is('tabM1') ? 'active' : null }}" id="{{ url('tabM1') }}" role="tabpanel" aria-labelledby="pills-home-tab">
              <div class="panel panel-default">
                <div class="panel-heading">
                  Send Now
                </div>
                <div class="panel-body">
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
                  <form id="Step1Form" name="Step1Form" role="form" action="{{route('stepM1_post')}}" method="POST">
                    @csrf
                      <div class="form-group">
                        <label for="source">From:</label>
                        <select class="form-control select2" style="width: 100%;" name="source" id="source">
                          <option></option>
                          @foreach ($senders as $cl)
                          <option value="{{$cl->name}}" >{{ $cl->name }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="dest">Phone Number: <small>(you can enter multiple phone numbers, seperated by space eg 254712345678 254713246587)</small></label>
                        <input type="text" name="dest" class="form-control" id="#dest" placeholder="Enter Mobile Number">
                      </div>
                      <div class="form-group">
                        <label for="text">Text Message:</label>
                        <textarea class="form-control" rows="3" name="text" id="text" placeholder="Enter Message ..."></textarea>
                        <div id="count">
                          <div float="left">
                            <span id="current_count">0</span>
                            <span id="maximum_count">/ 160</span> <b>Characters</b>
                          </div>
                          <div float="right">
                            <span id="message_parts">0</span> <b>Message Parts</b>
                          </div>

                        </div>
                      </div>
                    <div align="center">
                     <button type="submit" name="btn_login_details" id="btn_login_details" class="btn btn-info btn-lg">Send</button>
                     <a class="btn btn-default btn-lg" href="{{ url('tabM2') }}" role="button">Schedule</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="tab-pane {{ request()->is('tabM2') ? 'active' : null }}" id="{{ url('tabM2') }}" role="tabpanel" aria-labelledby="pills-profile-tab">
              <div class="panel panel-default">
                <div class="panel-heading">
                  Schedule Message
                </div>
                <div class="panel-body">
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
                  <form role="form" action="{{route('stepM2_post')}}" method="POST">
                      @csrf
                    <div class="form-group">
                      <label for="source">From:</label>
                      <select class="form-control select2" style="width: 100%;" name="source" id="source1">
                        <option></option>
                        @foreach ($senders as $cl)
                            <option value="{{$cl->name}}" >{{ $cl->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="phonenumber">Phone Number: <small>(you can enter multiple phone numbers, seperated by space eg 254712345678 254713246587)</small></label>
                      <input type="text" name="phonenumber" class="form-control" id="phonenumber" placeholder="Enter Phone Number">
                    </div>
                    <div class="form-group">
                      <label>Select to use Message Template:</label>
                      <select class="form-control select2" style="width: 100%;" name="tmp" id="tmp">
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
                      <textarea class="form-control" rows =3 name="text" id="textareaid" placeholder="Enter Message ..."></textarea>
                      <div id="count1">
                          <div float="left">
                            <span id="current_count1">0</span>
                            <span id="maximum_count1">/ 160</span> <b>Characters</b>
                          </div>
                          <div float="right">
                            <span id="message_parts1">0</span> <b>Message Parts</b>
                          </div>

                      </div>

                    </div>
                    <div class="form-group">
                      <label for="send_time">Send At:</label>
                      <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                          <input type="text" name="send_time" class="form-control datetimepicker-input" data-target="#datetimepicker1"/>
                          <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                      </div>
                    </div>
                    <div>
                      <a class="btn btn-default btn-lg" href="{{ url('tabM1') }}" role="button">Send Now</a>
                     <button type="submit" name="btn_personal_details" id="btn_personal_details" class="btn btn-info btn-lg">Schedule</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

          </div>

      </div>
      <div class="card-footer">
      </div>
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

// $("#dest").tagsinput('items');
// console.log("loaded");

$('textarea').keyup(function() {
    var characterCount = $(this).val().length,
        parts = Math.ceil(characterCount/160),
        current_count = $('#current_count'),
        maximum_count = $('#maximum_count'),
        message_parts = $('#message_parts'),
        count = $('#count');
        current_count.text(characterCount);
        message_parts.text(parts);
});

$('textarea').keyup(function() {
    var characterCount = $(this).val().length,
        parts = Math.ceil(characterCount/160),
        current_count = $('#current_count1'),
        maximum_count = $('#maximum_count1'),
        message_parts = $('#message_parts1'),
        count = $('#count1');
        current_count.text(characterCount);
        message_parts.text(parts);
});

    $('#tmp').change(function(){
      var txt = $('#tmp').val();
      $('#textareaid').val('');
      // console.log($(this).val());
      $('#textareaid').val(txt);
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
