@extends('layouts.dashboard')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>New Notification Message</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('notfis.index') }}"> Back</a>
        </div>
    </div>
</div>

<div class="row d-flex justify-content-center">
  <div class="col-lg-8 ">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">New Message</h3>
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

      <form role="form" action="{{ route('notfis.store') }}" method="POST">
          @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="client">Select Client Name</label>
            <select class="form-control select2" style="width: 100%;" name="client", id="client">
              <option></option>
              @foreach ($clients as $cl)
              <option value="{{$cl->id}}" >{{ $cl->clientName }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="user">Select Client User</label>
            <select class="form-control select2" style="width: 100%;" name="user", id="user">
              <option></option>
              @foreach ($users as $cl)
              <option value="{{$cl->id}}" >{{ $cl->username }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="type">Select Message Type</label>
            <select class="form-control select2" style="width: 100%;" name="type", id="type">
              <option></option>
              @foreach ($type as $cl)
              <option value="{{$cl}}" >{{ $cl }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="sender">Select SenderId</label>
            <select class="form-control select2" style="width: 100%;" name="sender", id="sender">
              <option></option>
              @foreach ($senders as $cl)
              <option value="{{$cl->name}}" >{{ $cl->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <div>
              <a href="#" onclick="insertAtCaret('textareaid','<name>');return false;">Insert Name</a> |
              <a href="#" onclick="insertAtCaret('textareaid','<amount>');return false;">Insert Amount</a> |
              @role('super-admin|admin|manager')
              <a href="#" onclick="insertAtCaret('textareaid','<balance>');return false;">Client's credit balance</a> |
              <a href="#" onclick="insertAtCaret('textareaid','<threshold>');return false;">Threshold set on user's account</a>
              @endrole
            </div>
            <label for="message">Notification Message:</label>
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
