@extends('layouts.dashboard')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>New Network</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('networks.index') }}"> Back</a>
        </div>
    </div>
</div>

<div class="row d-flex justify-content-center">
  <div class="col-lg-8 ">

    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">New Network</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
        </div>
      </div>
      <!-- /.card-header -->

      <div class="card-body">

          <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link {{ request()->is('tabN1') ? 'active' : null }}" style="border:1px solid #ccc" id="pills-home-tab" href="{{ url('tabN1') }}" role="tab" aria-controls="pills-home" aria-selected="true">Add Network</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('tabN2') ? 'active' : null }}" style="border:1px solid #ccc" id="pills-profile-tab" href="{{ url('tabN2') }}" role="tab" aria-controls="pills-profile" aria-selected="false">Add Prefix</a>
            </li>
          </ul>
          <hr>
          <div class="tab-content" style="margin-top:16px;" id="pills-tabContent">
            <div class="tab-pane {{ request()->is('tabN1') ? 'active' : null }}" id="{{ url('tabN1') }}" role="tabpanel" aria-labelledby="pills-home-tab">
              <div class="panel panel-default">
                <div class="panel-heading">
                  Network Name
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
                  <form id="Step1Form" name="Step1Form" role="form" action="{{route('stepN1_post')}}" method="POST">
                    @csrf
                    <div class="row">
                      <div class="col-lg-6">

                        <div class="form-group">
                          <label for="name">Network Name</label>
                          <input type="text" value="{{ session()->get('network.name') }}" name="name" class="form-control" id="name" placeholder="Enter Network Name">
                        </div>
                      </div>
                    </div>
                    <div align="center">
                     <button type="submit" name="btn_login_details" id="btn_login_details" class="btn btn-info btn-lg">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="tab-pane {{ request()->is('tabN2') ? 'active' : null }}" id="{{ url('tabN2') }}" role="tabpanel" aria-labelledby="pills-profile-tab">
              <div class="panel panel-default">
                <div class="panel-heading">
                  Add Number Prefix
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
                  <form role="form" action="{{route('stepN2_post')}}" method="POST">
                      @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="network_id">Network Name</label>
                          <select class="form-control select2" style="width: 100%;" name="network_id", id="network_id">
                            <option></option>
                            @foreach ($networks as $cl)
                            <option value="{{$cl->id}}" {{ session()->get('network.name') == $cl->name ? 'selected' :"" }} >{{ $cl->name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="prefix">Prefix</label>
                          <input type="number" name="prefix" class="form-control" id="prefix" placeholder="Enter Phone Number Prefix">
                        </div>
                        <div class="form-group">
                          <label for="prefix_length">Prefix Length</label>
                          <input type="number" name="prefix_length" class="form-control" id="prefix_length" placeholder="Enter Prefix Length">
                        </div>
                        <div class="form-group">
                          <label for="number_length">Phone Number Length</label>
                          <input type="number" name="number_length" class="form-control" id="number_length" placeholder="Enter Phone Number Length">
                        </div>
                        <div align="center">
                          <a class="btn btn-default btn-lg" href="{{ url('tabN1') }}" role="button">Previous</a>
                         <button type="submit" name="btn_personal_details" id="btn_personal_details" class="btn btn-info btn-lg">Next</button>
                        </div>
                      </div>
                      <div class="col-md-6">
                        Full column
                      </div>
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


@endsection
