
@csrf
<!-- CLIENT ID-->
<div class="form-group col-sm-12">
    {!! Form::text('title',"client ID: ". Auth::user()->client_id . "  -  ".Auth::user()->name , ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'disabled'=>'disabled']) !!}
</div>


<!-- name -->
<div class="form-group col-sm-12">
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'placeholder'=>'Name']) !!}
</div>

{{-- Description field --}}
<div class="form-group col-sm-12">
    {!! Form::textArea('description', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'placeholder'=>'Survey Description']) !!}
</div>

<!-- finish_message -->
<div class="form-group col-sm-12">
    {!! Form::text('finish_message', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'placeholder'=>'finish_message']) !!}
</div>

{{-- session lifespan --}}
<div class="rangeContainer form-group">
    <input type="range" min=".5" max="4.5" valueAsNumber=".1" class="rangeContainer__slider" id="myRange" name="session_lifespan">
    <p>Hours: <span id="demo"></span></p>
  </div>
