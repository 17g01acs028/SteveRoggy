@extends('layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Template</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('templates.index') }}"> Back</a>
            </div>
        </div>
    </div>


<div class="row d-flex justify-content-center">
  <div class="col-lg-8">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Showing Message Template</h3>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="name">Name:</label>
            {{ $template->name }}
        </div>
        <div class="form-group">
          <label for="message">Template Message:</label>
            {{ $template->message }}
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <a href="{{ route('templates.index') }}/{{ id($template->id) }}/edit" class="btn btn-primary" role="button" aria-pressed="true">Update</a>
      </div>
    </div>
  </div>
</div>
@endsection
