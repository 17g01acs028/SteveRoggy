@extends('layouts.dashboard')

@section('content')
@if ($errors -> any())
<div class="alert alert-danger">
    <span>Please make sure you Fill every Field before Saving. And Correct the Below Errors.</span>
	@foreach ($errors -> all() as $err)
	<li>{{$err}}</li>
		
	@endforeach
</div>
@endif
<form action="" method="post"> 
	@csrf
<div class="container-fluid">
	
		<div class="col-lg-12">
			<div class="row">
				<div class="col-sm-6 border-right">
					
						<div class="form-group">
							<label for="" class="control-label">Question</label>
							<textarea name="question" id="question" cols="30" rows="4" class="form-control">{{old('question')}}</textarea>
						</div>
						<div class="form-group">
							<label for="" class="control-label">Question Answer Type</label>
							<select name="type" id="ddr" class="custom-select custom-select-sm">
							
								<option value="" disabled="" selected="">Please Select here</option>
							

								<option value="number_range" {{ old('type') == "number_range" ? 'selected' : '' }}>Number Range</option>
								<option value="Teaxt_area" {{ old('type') == "Teaxt_area" ? 'selected' : '' }} >Text Area</option>
								<option value="Options" {{ old('type') == "Options" ? 'selected' : '' }}  >Options</option>
							</select>
						</div>
						
				</div>
				<div class="col-sm-6">
					<b>Preview</b>
					<div class="preview">
						
						<center><b>Question Answer Field.</b></center>
					
							<div class="callout callout-info" id="option"> 
								
							
						      <table width="100%" class="table" id="table"  >
						      	<colgroup>
						      		<col width="10%">
						      		<col width="80%">
						      		<col width="10%">
						      	</colgroup>
						      	<thead>
							      	<tr class="">
								      	<th class="text-center"></th>

								      	<th class="text-center">
								      		
								      	</th>
								      	<th class="text-center"></th>
							     	</tr>
						     	</thead>
						     	<tbody>
						     		
						     		<tr class="">
								      	<td class="text-center">
								      		<div class="icheck-primary d-inline" data-count = '1'>
									        	
									        	
									        </div>
								      	</td>
                                          <td class="col-sm-12 " >
                                            <div class="row">
                                                <div style="width:40%;"><label >Answer Type</label> </div>
                                                <div style="width:10%;"><label ></label></div>
                                                <div style="width:40%;"><label >Answer Value</label></div>
                                             </div>
                                            <div class="row text-center">
                                                <div style="width:40%;"> <input type="text" class="form-control form-control-sm check_inp"  name="labelO1[]" value=""></div>
                                                <div style="width:10%;"><label ></label></div>
                                                <div style="width:40%;"><input type="text" class="form-control form-control-sm check_inp"  name="labelO2[]" value=""></div>
                                             </div>
                                         
                                        </td>
								      	
								      	<td class="text-center"></td>
							     	</tr>
						     	
                                   
						     	</tbody>
						      </table>
						      <div class="row">
						      <div class="col-sm-12 text-center">
						      	<button class="btn btn-sm btn-flat btn-default" type="button" onclick="new_check()"></i> <i class="fa fa-plus"></i> Add</button><br><br>
                                  
                                  
                            </div> 
						      </div>
						    </div>
                            <div class="callout callout-info" id="number_range" >
							
                                <table width="100%" class="table">
                                    <colgroup>
                                        <col width="10%">
                                        <col width="80%">
                                        <col width="10%">
                                    </colgroup>
                                    <thead>
                                        <tr class="">
                                            <th class="text-center"></th>
  
                                            <th class="text-center">
                                               
                                            </th>
                                            <th class="text-center"></th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                       
                                       <tr class="">
                                            <td class="text-center">
                                                <div class="icheck-primary d-inline" data-count = ''>
                                                  
                                                  
                                              </div>
                                            </td>
  
                                            <td class="col-sm-12 " >
                                                <div class="row">
                                                    <div style="width:40%;"><label >Start</label> </div>
                                                    <div style="width:20%;"><label ></label></div>
                                                    <div style="width:40%;"><label >End</label></div>
                                                 </div>
                                                <div class="row text-center">
                                                    <div style="width:40%;"> <input type="text" class="form-control form-control-sm check_inp"  name="label1[]" value=""></div>
                                                    <div style="width:20%;"><label >TO</label></div>
                                                    <div style="width:40%;"><input type="text" class="form-control form-control-sm check_inp"  name="label1[]" value=""></div>
                                                 </div>
                                              
                                            </td>
                                            <td class="text-center"></td>
                                       </tr>
                                   
                                     
                                   </tbody>
                                </table>
                               
                              </div>
						    </div>
							


						
								<textarea name="frm_opt" id="text" cols="30" rows="10" class="form-control"  placeholder="Write Something here..."></textarea>
						
					</div>
				</div>
			</div>
		</div>




<div class="float-right"  width:100%;" style="padding:20px;" >
<button type="submit"  name="saveE" class="btn btn-danger" style="padding:10px;" >save and exit</button>
 <button type="submit" name="saveC" class="btn btn-primary" style="padding:10px;" >Save and Continue</button> 

</div>
</form>
@endsection


