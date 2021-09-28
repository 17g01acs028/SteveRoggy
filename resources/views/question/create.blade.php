@extends('layouts.dashboard')

@section('content')

@extends('layouts.errors')


<div class="container-fluid">


    {!! Form::open(['route' => 'questions.store']) !!}

            <div class="col-lg-12">
			<div class="row">
				{{-- fields --}}
                @include('question.fields')
                {{-- end fields --}}
                {{-- preview fields --}}
				@include('question.preview')
                {{-- end preview fields --}}
			</div>
		</div>
            <div class="float-right clearfix" style="padding:20px;" >

<input type="submit" name="saveE" class="btn btn-danger" value="Save & Exit" />
<input type="submit" name="saveC" class="btn btn-primary" value="Save & Continue" />

</div>
                    </div>


    {!! Form::close() !!}


</div>




{{-- javascript code start here --}}
<script>
    $(document).ready(function(){

        $('#option').fadeOut();
        $('#number_range').fadeOut();
        $('#text').fadeOut();
 });
    $("#ddr").change(function () {

        if(!$.trim($("#question").val())){
           alert("Please Create Question First?")
        }else{
        if(this.value==="number_range")  {
            $('#option').fadeOut();
            $('#number_range').show();
            $('#text').fadeOut();
        }else if(this.value==="Teaxt_area"){
            $('#option').fadeOut();
            $('#number_range').fadeOut();
            $('#text').show();
        } else if(this.value==="Options"){
            $('#option').show();
            $('#number_range').fadeOut();
            $('#text').fadeOut();
        } }
     });


     count = 1;
    function new_check(){

		// var tbody=$('#table').closest('.row').siblings('table').find('tbody');
		// var count = tbody.find('tr').last().find('.icheck-primary').attr('data-count');

        // console.log(count);
		// 	count++;
		// console.log(count);
		// var opt = '';
		// 	opt +='<td class="pt-1 text-center"><div class="icheck-primary d-inline" data-count = "'+count+'"><input type="checkbox" id="checkboxPrimary'+count+'"><label for="checkboxPrimary'+count+'"> </label></div></td>';
		// 	opt +='<td class="text-center"></td>';
		// 	opt +='<td class="text-center"><a href="javascript:void(0)" onclick="$(this).closest(\'tr\').remove()"><span class="fa fa-times" ></span></a></td>';
		// var tr = $('<tr></tr>')
		// tr.append(opt)
		// tbody.append(tr)
        console.log("in Here");
        $('#table').append('<tr><td><td><div class="text-center row"> <div style="width:40%;"> <input type="text" class="form-control form-control-sm check_inp"  name="label[]" value=""></div> <div style="width:10%;"><label ></label></div><div style="width:40%;"><input type="text" class="form-control form-control-sm check_inp"  name="label[]" value=""></div><div style="width:10%;"><label onclick="$(this).closest(\'tr\').remove()"><i class="fa fa-remove"></label></i></div></div> </td></tr>');
	}

</script>
@endsection
