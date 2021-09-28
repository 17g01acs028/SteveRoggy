
@csrf
<!-- title field-->
<div class="form-group col-sm-12">
    {{--{!! Form::label('department_name', 'Department Name:') !!}--}}
    {!! Form::text('title', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'placeholder'=>'Title']) !!}
</div>


{{-- Description field --}}
<div class="form-group col-sm-12">
    {{--{!! Form::label('department_description', 'Department Description:') !!}--}}
    {!! Form::textArea('description', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'placeholder'=>'Survey Description']) !!}
</div>

<!-- Date start field -->
<div class="form-group col-sm-12">
    {{--{!! Form::label('department_name', 'Department Name:') !!}--}}
    {!! Form::text('user_id', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'placeholder'=>'user_id']) !!}
</div>

<!-- start date -->
<div class="form-group col-sm-12">
    {{--{!! Form::label('department_code', 'Department Code:') !!}--}}
    <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
        <input type="text" name="start_date" class="form-control datetimepicker-input" data-target="#datetimepicker1" placeholder="Date Start"/>
        <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>
    </div>
</div>


<!-- date end -->
<div class="form-group col-sm-12">
<div class="input-group date" id="datetimepicker2" data-target-input="nearest">
    <input type="text" name="end_date" class="form-control datetimepicker-input" data-target="#datetimepicker2" placeholder="Date End"/>
    <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
    </div>
</div>
</div>
