<!-- survey id field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Survey ID') !!}
    <p>{{ $survey->id }}</p>
</div>

<!-- title -->
<div class="col-sm-12">
    {!! Form::label('title', 'Title') !!}
    <p>{{ $survey->title }}</p>
</div>

<!--description field -->
<div class="col-sm-12">
    {!! Form::label('description', 'description') !!}
    <p>{{ $survey->description }}</p>
</div>

<!-- user Id field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User ID') !!}
    <p>{{ $survey->user_id }}</p>
</div>

<!-- Start Date Field -->
<div class="col-sm-12">
    {!! Form::label('start_date', 'Start Date:') !!}
    <p>{{ $survey->start_date }}</p>
</div>

<!-- End Date Field -->
<div class="col-sm-12">
    {!! Form::label('end_date', 'End Date:') !!}
    <p>{{ $survey->end_date }}</p>
</div>

{{-- created at field --}}
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At') !!}
    <p>{{ $survey->create_at }}</p>
</div>





























