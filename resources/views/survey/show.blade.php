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

        

         <div class="card" style="border-top:4px solid green">
                <div class="row justify-content-center">
                    
                        <div class="col-12 col-md-6">
                        <img src="{{asset('/images/bamboo.jpg')}}" alt="" srcset="" class="img-fluid" >
                        </div>
                        <div class="col-12 col-md-6">
                      <ul class="list-group list-group-flush">
                              <li class="list-group-item">ID: {{ $survey->id }} <br> Name: <span class="text-muted">{{ $survey->name }}</span></li>
                              <li class="list-group-item">Description:  <br><span class="text-muted">{{ $survey->description }}</span> </li>
                              {{-- <li class="list-group-item">client ID: <br> <span class="text-muted">
                            {{ $survey->client_id }}
                            </span></li> --}}
                              <li class="list-group-item">Finish Message: <br><span class="text-muted">
                            {{ $survey->finish_message }}
                            </span></li>
                              <li class="list-group-item">Created At: <br> <span class="text-muted">
                            {{ $survey->created_at }}
                            </span></li>
                        </ul> 
                                    </div>

                </div>
            </div>


@endsection
