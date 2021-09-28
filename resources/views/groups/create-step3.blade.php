@extends('layouts.dashboard')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Send Bulk SMS</h2>
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
        <h3 class="card-title">New Campaign</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
        </div>
      </div>
      <!-- /.card-header -->

      <div class="card-body">

          <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link {{ request()->is('tabG1') ? 'active' : null }}" style="border:1px solid #ccc" id="pills-home-tab" href="{{ url('tabG1') }}" role="tab" aria-controls="pills-home" aria-selected="true">Send Now</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('tabG2') ? 'active' : null }}" style="border:1px solid #ccc" id="pills-profile-tab" href="{{ url('tabG2') }}" role="tab" aria-controls="pills-profile" aria-selected="false">Schedule</a>
            </li>
          </ul>
          <hr>
          <div class="tab-content" style="margin-top:16px;" id="pills-tabContent">
            <div class="tab-pane {{ request()->is('tabG1') ? 'active' : null }}" id="{{ url('tabG1') }}" role="tabpanel" aria-labelledby="pills-home-tab">
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
                  <form id="Step1Form" name="Step1Form" role="form" action="{{route('stepG1_post')}}" method="POST">
                    @csrf
                      <div class="form-group">
                        <label for="source">From:</label>
                        <select class="form-control select2" style="width: 100%;" name="source", id="source">
                          <option></option>
                          @foreach ($senders as $cl)
                          <option value="{{$cl->name}}" >{{ $cl->name }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="group_id">Select Group</label>
                        <select class="form-control select2" style="width: 100%;" name="group_id", id="group_id">
                          <option></option>
                          @foreach ($groups as $cl)
                          <option value="{{$cl->id}}" >{{ $cl->name }}</option>
                          @endforeach
                        </select>
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
                        <label for="text">Message:</label>
                        <textarea class="form-control" rows =3 name="text" id="textareaid" placeholder="Enter Message ..."></textarea>
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
                     <a class="btn btn-default btn-lg" href="{{ url('tabG2') }}" role="button">Schedule</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="tab-pane {{ request()->is('tabG2') ? 'active' : null }}" id="{{ url('tabG2') }}" role="tabpanel" aria-labelledby="pills-profile-tab">
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
                  <form role="form" action="{{route('stepG2_post')}}" method="POST">
                      @csrf
                    <div class="form-group">
                      <label for="source">From:</label>
                      <select class="form-control select2" style="width: 100%;" name="source", id="source1">
                        <option></option>
                        @foreach ($senders as $cl)
                        <option value="{{$cl->name}}" >{{ $cl->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="group_id">Select Group:</label>
                      <select class="form-control select2" style="width: 100%;" name="group_id", id="group_id1">
                        <option></option>
                        @foreach ($groups as $cl)
                        <option value="{{$cl->id}}" >{{ $cl->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Select to use Message Template</label>
                      <select class="form-control select2" style="width: 100%;" name="tmp1", id="tmp1">
                        <option></option>
                        @foreach ($templates as $tl)
                        <option value="{{$tl->message}}">{{ $tl->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <div>
                        <a href="#" onclick="insertAtCaret('textareaid1','<name>');return false;">Insert Name</a> |
                        <a href="#" onclick="insertAtCaret('textareaid1','<field_1>');return false;">Insert Field 1</a> |
                        <a href="#" onclick="insertAtCaret('textareaid1','<field_2>');return false;">Insert Field 2</a> |
                        <a href="#" onclick="insertAtCaret('textareaid1','<field_3>');return false;">Insert Field 3</a>
                      </div>
                      <label for="text">Message:</label>
                      <textarea class="form-control" rows =3 name="text" id="textareaid1" placeholder="Enter Message ..."></textarea>
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
                    <div align="center">
                      <a class="btn btn-default btn-lg" href="{{ url('tabG1') }}" role="button">Send Now</a>
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

    $('#tmp1').change(function(){
      var txt = $('#tmp1').val();
      $('#textareaid1').val('');
      // console.log($(this).val());
      $('#textareaid1').val(txt);
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
