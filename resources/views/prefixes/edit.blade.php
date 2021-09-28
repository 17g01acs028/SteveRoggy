@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Number Prefix Details</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('prefixes.index') }}"> Back</a>
            </div>
        </div>
    </div>
<div class="row d-flex justify-content-center">
  <div class="col-lg-8 ">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Update Prefix Details</h3>
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

    <form action="{{ route('prefixes.update',$prefix->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
          <div class="form-group">
            <label for="network_id">Network Name</label>
            <select class="form-control select2" style="width: 100%;" name="network_id", id="network_id">
              @foreach ($networks as $cl)
              <option value="{{$cl->id}}" {{ $prefix->network_id == $cl->id ? 'selected' : old('network_id') }} >{{ $cl->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="prefix">Prefix</label>
            <input type="number" name="prefix" class="form-control" id="prefix" placeholder="Prefix"
            value = "{{ $prefix->prefix ? : old('prefix') }}">
          </div>
          <div class="form-group">
            <label for="prefix_length">Prefix Length</label>
            <input type="number" name="prefix_length" class="form-control" id="prefix_length" placeholder="Prefix Length"
            value = "{{ $prefix->prefix_length ? : old('prefix_length') }}">
          </div>
          <div class="form-group">
            <label for="number_length">Prefix</label>
            <input type="number" name="number_length" class="form-control" id="number_length" placeholder="Number Length"
            value = "{{ $prefix->number_length ? : old('number_length') }}">
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


@endsection
