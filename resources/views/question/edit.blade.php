@extends('layouts.dashboard')

@section('content')

@if($errors ->any())

<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>
            {{ $error }}
        </li>
        @endforeach
    </ul>
</div>
@endif
    <section class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1>Edit Surveys</h1>

                    
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

    <div class="px-3 content">


        <div class="card">

            {!! Form::model($survey, ['route' => ['survey.update', $survey->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('survey.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('survey.index') }}" class="btn btn-default">Cancel</a>
            </div>

           {!! Form::close() !!}

        </div>
    </div>
@endsection
