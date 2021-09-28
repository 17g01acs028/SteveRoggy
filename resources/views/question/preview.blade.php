
{{-- ndani ya hii pia nataka nikuwe na inlcudes kama ya options fields description ana hiyo y range --}}


<div class="col-sm-6">
					<b>Preview</b>
					<div class="preview">

						<center><b>Question Description Field.</b></center>
                        {{-- question options --}}
							@include('question.options')


                            {{-- end questions options --}}
						</div>
						</div>
                        {{-- number range --}}
                            @include('question.numberRange')
                            {{-- end number range --}}

                            {{-- text area --}}

								<textarea name="frm_opt" id="text" cols="30" rows="10" class="form-control"  placeholder="Write Something here..."></textarea>
{{-- end text area --}}
					</div>
				</div>
