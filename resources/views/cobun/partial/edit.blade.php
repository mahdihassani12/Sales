 {!! Form::open(['url' => 'cobuns/update_cobon', 'method' => 'get', 'class' => ' main_form form-whitout-modal','id'=>'update_coupon_number','enctype'=> 'multipart/form-data']) !!}
 
   <table class="table table-bordered table-hover product-store-list">
                <thead>
                </thead>
                <tbody >
				 <div class="row" style="margin:0px">
				   <div class="col-md-6">
				      <div class="form-group">
					    <label for="cobun_no" style="width:100%"><a href="javascript:void(0)" 
								id="auto_generate_pincode" style="float:left"></a>
								{{trans('file.coupon_number')}} 
						</label>
					    <input type="number" name="cobun_no" id="cobun_no" class="form-control" value="{{$data['coupon']->cobun_number}}">
					  </div>
					  
					   <div class="form-group">
					    <label for="number_of_use">{{trans('file.number_of_use')}}</label>
					    <input type="number" name="number_of_use" id="number_of_use" class="form-control" value="{{$data['coupon']->number_of_use}}">
					     <input type="hidden" name="coupon_id" value="{{$data['coupon']->id}}">
 					   </div>
					  

                        <div class="form-group">
					      <label for="expire_date" >{{trans('file.expire_date')}}</label>
					      <input type="text" name="expire_date" id="expire_date" class="form-control" value="{{$data['coupon']->expire_date}}">
					   </div>
					   
				   </div>
				    <div class="col-md-6">
					
					<div style="display:none">
					  <h3 >{{trans('file.select_category')}}</h3>
					   <div class="row" style="margin-right:0px">
					   <div class="col-md-12 checkbox_container all_categoris_container" >
						   <label for="select_all_category_inser"> {{trans('file.all')}} </label>
						   <input type="checkbox" class="defaul_checkbox"  id="select_all_category_inser">
                           <label class="checkmark_button" for="select_all_category_inser"></label>
						</div><hr>
					 </div>
					</div> 
					 
					  @foreach($data['category'] as $category)
                        <div class="col-md-12 checkbox_container" >
						 <div class="row">
						  <div class="col-md-6"> 
						   <label for="{{$category->id}}"> {{$category->name}} </label>
						   <input type="checkbox" class="defaul_checkbox insert_checkbox" name="selected_category[]" id="{{$category->id}}" value="{{$category->id}}" style="display:none">
                           <label class="checkmark_button" for="{{$category->id}}" style="display:none"></label>
						  </div>
                         <div class="col-md-6" style="margin-top:10px; padding-right:0px">	
                             <?php
							  $cvalue= DB::table('coupon_category')->where('copupon',$data['coupon']->cobun_number)->where('category',$category->id)->get()[0];
							 ?> 						 
						    <input type="number" name="coupon_categories_{{$category->id}}" class="form-control" value="{{$cvalue->value}}">
						 </div> 
                        </div>						 
						</div>						
					  @endforeach
					 </div> 
				   </div>
				   
					
				     <div class="col-md-12">
					      <label style="visibility:hidden">{{trans('file.update')}}</label>
					   	 <input type="submit"  class="btn btn-primary update_coupon_number_btn" value="{{trans('file.update')}}">
					 </div>
				
				  </div> 
                </tbody>
            </table>
  {!! Form::close() !!} 			
		