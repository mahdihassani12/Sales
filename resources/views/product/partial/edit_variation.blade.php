{!! Form::open(['url' => 'variations/update_variation', 'method' => 'post', 'class' => ' main_form form-whitout-modal','id'=>'add_suggest','enctype'=> 'multipart/form-data']) !!}
		 <div class="row">
		  <div class="form-group col-sm-6">
		     <label for="variation_name" class="label">{{trans('file.variation_name')}}</label> 
		     <input type="text" class="form-control" name="variation_name" id="variation_name" value="<?php echo explode('-',$ezpos_product_variation->name)[1];?>">
		  </div>
		  <div class="form-group col-sm-6">
		     <label for="variation_photo" class="label">{{trans('file.Image')}}</label> 
		     <input type="file" class="form-control" name="variation_photo" id="variation_photo">
		     <input type="hidden" value="{{$ezpos_product_variation->image}}" name="variation_image">
		     <input type="hidden" value="{{$ezpos_product_variation->id}}" name="selected_variation_id">
		  </div>
		  <div class="form-group col-sm-6">
		     <label for="variation_product" class="label">{{trans('file.product')}}</label> 
		     <select class="form-control selectpicker" id="variation_product" name="variation_product" data-live-search="true" data-live-search-style="begins" title="Select Product..."> 
			   @foreach($products as $product)
                 <option value="{{$product->id}}" <?php if($ezpos_product_variation->product_id==$product->id){echo "selected";}?>>{{$product->name}}</option>			   
 			   @endforeach
			 </select>
		  </div>
		  <div class="form-group col-sm-6">
		     <label for="variation_price" class="label">{{trans('file.Price')}}</label> 
		     <input type="number" class="form-control" name="variation_price" id="variation_price" value="{{$ezpos_product_variation->price}}">
		  </div>
		  <div class="form-group col-sm-6">
		     <label for="variation_alert" class="label">{{trans('file.alert_quantity')}}</label> 
		     <input type="number" class="form-control" name="variation_alert" id="variation_alert" value="{{$ezpos_product_variation->alert_quantity}}">
		  </div>
		  <div class="form-group col-sm-6">
		     <label  class="label" style='visibility:hidden'>{{trans('file.alert_quantity')}}</label> 
		     <input type="submit" class="btn btn-success btn-block" value="{{trans('file.update')}}">
		  </div>
		  </div> 
		  {!! Form::close(); !!}

		  
<script>
	 $('.selectpicker').selectpicker({
	  style: 'btn-link',
  });
</script>			