@extends('layouts.dashboard')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>New Client</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('route_maps.index') }}"> Back</a>
        </div>
    </div>
</div>

<div class="row d-flex justify-content-center">
  <div class="col-lg-8 ">

    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">New Client</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
        </div>
      </div>
      <!-- /.card-header -->

      <div class="card-body">

          <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link {{ request()->is('tab1') ? 'active' : null }}" style="border:1px solid #ccc" id="pills-home-tab" href="{{ url('tab1') }}" role="tab" aria-controls="pills-home" aria-selected="true">Add Client</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('tab2') ? 'active' : null }}" style="border:1px solid #ccc" id="pills-profile-tab" href="{{ url('tab2') }}" role="tab" aria-controls="pills-profile" aria-selected="false">Add Routes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('tab3') ? 'active' : null }}" style="border:1px solid #ccc" id="pills-contact-tab" href="{{ url('tab3') }}" role="tab" aria-controls="pills-contact" aria-selected="false">Add Users</a>
            </li>
          </ul>
          <hr>
          <div class="tab-content" style="margin-top:16px;" id="pills-tabContent">
            <div class="tab-pane {{ request()->is('tab1') ? 'active' : null }}" id="{{ url('tab1') }}" role="tabpanel" aria-labelledby="pills-home-tab">
              <div class="panel panel-default">
                <div class="panel-heading">
                  KYC information
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
                  <form id="Step1Form" name="Step1Form" role="form" action="{{route('step1_post')}}" method="POST">
                    @csrf
                    <div class="row">
                      <div class="col-lg-6">

                        <div class="form-group">
                          <label for="clientName">Client Name</label>
                          <input type="text" value="{{ session()->get('client.clientName') }}" name="clientName" class="form-control" id="clientName" placeholder="Enter Client Name">
                        </div>
                        <div class="form-group">
                          <label for="clientAddress">Address</label>
                          <input type="text" value="{{ session()->get('client.clientAddress') }}" name="clientAddress" class="form-control" id="clientAddress" placeholder="Client's Address">
                        </div>
                        <div class="form-group">
                          <label for="mobileNo">Mobile Number</label>
                          <input type="text" value="{{ session()->get('client.mobileNo') }}" name="mobileNo" class="form-control" id="mobileNo" placeholder="Enter Client Name">
                        </div>
                        <div class="form-group">
                          <label for="company_email">Company Email</label>
                          <input type="text" value="{{ session()->get('client.company_email') }}" name="company_email" class="form-control" id="company_email" placeholder="Enter Company Email">
                        </div>
                        <div class="form-group">
                          <label for="accType">Account Type</label>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="accType" id="exampleRadios5" value="1"
                            @if (session()->get('client.accType') != null && $client->accType == 1 ) checked @endif >
                            <label class="form-check-label" for="exampleRadios5">
                              Pre-Paid
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="accType" id="exampleRadios6" value="0"
                            @if (session()->get('client.accType') != null && $client->accType == 0  ) checked @endif >
                            <label class="form-check-label" for="exampleRadios6">
                              Post-Paid
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="accLimit">Account Limit</label>
                          <input type="text" value="{{ session()->get('client.accLimit') }}" name="accLimit" class="form-control" id="accLimit" placeholder="Enter Account Limit">
                        </div>
                        <div class="form-group">
                          <label for="httpDlrUrl">Dlr Report Url</label>
                          <input type="text" value="{{ session()->get('client.httpDlrUrl') }}" name="httpDlrUrl" class="form-control" id="httpDlrUrl" placeholder="Enter Deliver Reports URL">
                        </div>
                        <!-- <div class="form-group">
                          <label for="dlrHttpMethod">HTTP Method</label>
                          <input type="text" value="{{ session()->get('client.dlrHttpMethod') }}" name="dlrHttpMethod" class="form-control" id="dlrHttpMethod" placeholder="Enter Client Name">
                        </div> -->
                        <div class="form-group">
                          <label for="dlrHttpMethod">HTTP Method</label>
                          <select class="form-control select2" style="width: 100%;" name="dlrHttpMethod", id="dlrHttpMethod">
                            <option></option>
                            @foreach ($dlrMethods as $cl)
                            <option value="{{$cl}}" {{ session()->get('client.dlrHttpMethod') ? 'selected' : old('dlrHttpMethod') }} >{{ $cl }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="accBalance">Account Balance</label>
                          <input readonly type="number" class="form-control" placeholder="Account Balance">
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
            <div class="tab-pane {{ request()->is('tab2') ? 'active' : null }}" id="{{ url('tab2') }}" role="tabpanel" aria-labelledby="pills-profile-tab">
              <div class="panel panel-default">
                <div class="panel-heading">
                  Add Network Routes to Client
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
                  <form role="form" action="{{route('step2_post')}}" method="POST">
                      @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="client_id">Client Name</label>
                          <select class="form-control select2" style="width: 100%;" name="client_id", id="client_id">
                            <option></option>
                            @foreach ($clients as $cl)
                            <option value="{{$cl->id}}" {{ (session()->get('client.clientName') == $cl->clientName ? 'selected' :"") }} >{{ $cl->clientName }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="network_id">Network Name</label>
                          <select class="form-control select2" style="width: 100%;" name="network_id", id="network_id">
                            <option></option>
                            @foreach ($networks as $cl)
                            <option value="{{$cl->id}}" >{{ $cl->name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="route_id">Route Name</label>
                          <select class="form-control select2" style="width: 100%;" name="route_id", id="route_id">
                            <option></option>
                            @foreach ($routes as $cl)
                            <option value="{{$cl->id}}" >{{ $cl->name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="price">Price per SMS</label>
                          <input type="text" name="price" class="form-control" id="price" placeholder="Enter Price per SMS">
                        </div>
                        <div align="center">
                          <a class="btn btn-default btn-lg" href="{{ url('tab1') }}" role="button">Previous</a>
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
            <div class="tab-pane {{ request()->is('tab3') ? 'active' : null }}" id="{{ url('tab3') }}" role="tabpanel" aria-labelledby="pills-contact-tab">
              <div class="panel panel-default">
                <div class="panel-heading">
                  Invite Client Users
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
                  <form method="post" action="{{route('step3_post')}}">
                      @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Email address</label>
                          <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                          <label for="username">Username</label>
                          <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                        </div>
                        <div class="form-group">
                          <label for="client_id">Client Name</label>
                          <select class="form-control select2" style="width: 100%;" name="client_id", id="client_id1">
                            <option></option>
                            @foreach ($clients as $cl)
                            <option value="{{$cl->id}}" {{ session()->get('client.clientName') == $cl->clientName ? 'selected' : old('id') }} >{{ $cl->clientName }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div align="center">
                         <a class="btn btn-default btn-lg" href="{{ url('tab2') }}" role="button">Previous</a>
                         <button type="submit" name="btn_contact_details" id="btn_contact_details" class="btn btn-success btn-lg">Register</button>
                        </div>
                      </div>
                      <div class="col-md-6">
                        full column list
                      </div>
                    </div>
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





<script>

</script>

@endsection
