@extends('layouts.dashboard')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <a class="float-right btn btn-success"
                    href="{{ route('questions.create') }}">
                     <i class="fa fa-plus"> new Question</i>
                 </a>
                </div>
                <div class="col-sm-6">
                    <a class="float-right btn btn-default"
                       href="{{ route('survey.index') }}">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </section>
<div class="px-3 row ">
    <div class="mr-10 col-12 col-md-4">
        <div class="card w=-100 mr-10" style="border-top:4px solid green">
            <ul class="list-group list-group-flush">
              <li class="list-group-item">ID: {{ $survey->id }} <br> Title:  <span class="text-muted">{{ $survey->title }}</span></li>
              <li class="list-group-item">Description <br><span class="text-muted">{{ $survey->description }}</span> </li>
              <li class="list-group-item">Start Date <span class="text-muted">
            {{ $survey->start_date }}
            </span></li>
              <li class="list-group-item">End Date <span class="text-muted">
            {{ $survey->end_date }}
            </span></li>
              <li class="list-group-item">Created At: <br> <span class="text-muted">
            {{ $survey->created_at }}
            </span></li>
            </ul>
            <div class="card-footer">
              Card footer
            </div>
          </div>

    </div>
</div>

@endsection
