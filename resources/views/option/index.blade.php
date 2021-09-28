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


<body class="bg-dark">
 <div class="container">
   <div class="row">
     <div class="col-md-12">

     </div>
   </div>
 </div>



 <div class="card">
    <div class="p-0 card-body">
        @include('survey.table')
        <div class="modal fade" id="surveyAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title" id="exampleModalLabel">Survey</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        {!! Form::open(['route' => 'survey.store']) !!}

                        @include('survey.fields')
                    </div>
                    <div class="modal-footer">
                        {!! Form::submit('Save', ['class' => 'btn btn-primary rounded-pill mx-2']) !!}
                        <a href="{{ route('survey.index') }}" class="btn btn-default rounded-pill">Cancel</a>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix float-right card-footer">
            <div class="float-right">

            </div>
        </div>
    </div>

</div>

</body>
@endsection
