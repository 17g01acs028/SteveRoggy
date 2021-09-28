@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Contact</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('contacts.index') }}"> Back</a>
            </div>
        </div>
    </div>
<div class="row d-flex justify-content-center">
  <div class="col-lg-8 ">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Update Contact</h3>
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

    <form action="{{ route('contacts.update',$contact->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
          <div class="form-group">
            <label for="phonenumber">Phone Number</label>
            <input type="text" name="phonenumber" class="form-control" id="phonenumber" placeholder="Enter Phone Number"
            value = "{{ $contact->phonenumber ? : old('phonenumber') }}">
          </div>
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name"
            value = "{{ $contact->name ? : old('name') }}">
          </div>
          <div class="form-group">
            <label for="field_1">Field 1 Detail (optional)</label>
            <input type="text" name="field_1" class="form-control" id="field_1" placeholder="Enter Field 1 Detail"
            value = "{{ $contact->field_1 ? : old('field_1') }}">
          </div>
          <div class="form-group">
            <label for="field_2">Field 2 Detail (optional)</label>
            <input type="text" name="field_2" class="form-control" id="field_2" placeholder="Enter Field 2 Detail"
            value = "{{ $contact->field_2 ? : old('field_2') }}">
          </div>
          <div class="form-group">
            <label for="field_3">Field 3 Detail (optional)</label>
            <input type="text" name="field_3" class="form-control" id="field_3" placeholder="Enter Field 3 Detail"
            value = "{{ $contact->field_3 ? : old('field_3') }}">
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
