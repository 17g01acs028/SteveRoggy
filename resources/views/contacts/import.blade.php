@extends('layouts.dashboard')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Importing contacts</h2>
        </div>
        <div class="pull-right">
        </div>
    </div>
</div>

<div class="row d-flex justify-content-center">
  <div class="col-lg-8 ">
    <div class="card card-primary">

      <div class="card-header">
        <h3 class="card-title">Import CSV File</h3>
      </div>

      <div class="card-body">
          <form class="form-horizontal" method="POST" action="{{ route('import_parse') }}" enctype="multipart/form-data">
              {{ csrf_field() }}
            <div class="row">
              <div class="col-md-6">
                <div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
                    <label for="csv_file" class="control-label">CSV file to import</label>
                    <input id="csv_file" type="file" class="form-control" name="csv_file" required>

                    @if ($errors->has('csv_file'))
                        <span class="help-block">
                        <strong>{{ $errors->first('csv_file') }}</strong>
                    </span>
                    @endif
                </div>
                (Leave blank if adding to an existing group)
                <label for="name">Add to New Group</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Enter Group Name">
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
              </div>
              <div class="col-md-6">
                <h4><strong>NOTE:</strong></h4>
                <p>The file should be a CSV file</p>
                <p>The file should NOT have a TITLES row</p>
                <p>First Column should be the phone numbers</p>
                <p>Second column should be the names</p>
              </div>
            </div>



              <div class="form-group">
                  <div class="col-md-8 col-md-offset-4">
                      <button type="submit" class="btn btn-primary">
                          Parse CSV
                      </button>
                  </div>
              </div>
          </form>
      </div>
  </div>

  </div>

</div>


@endsection
