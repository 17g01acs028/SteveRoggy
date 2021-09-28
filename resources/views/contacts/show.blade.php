@extends('layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Contact</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('contacts.index') }}"> Back</a>
            </div>
        </div>
    </div>


<div class="row d-flex justify-content-center">
  <div class="col-lg-8">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Showing Contact </h3>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="phonenumber">Phone Number:</label>
            {{ $contact->phonenumber }}
        </div>
        <div class="form-group">
          <label for="name">Name:</label>
            {{ $contact->name }}
        </div>
        <div class="form-group">
          <label for="field_1">Field 1:</label>
            {{ $contact->field_1 }}
        </div>
        <div class="form-group">
          <label for="field_2">Field 2:</label>
            {{ $contact->field_2 }}
        </div>
        <div class="form-group">
          <label for="field_3">Field 3:</label>
            {{ $contact->field_3 }}
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <a href="{{ route('contacts.index') }}/{{ id($contact->id) }}/edit" class="btn btn-primary" role="button" aria-pressed="true">Update</a>
      </div>
    </div>
  </div>
</div>
@endsection
