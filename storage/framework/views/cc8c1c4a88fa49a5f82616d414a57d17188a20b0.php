 <?php echo Form::open(['url' => 'cobuns/update_cobon', 'method' => 'get', 'class' => ' main_form form-whitout-modal','id'=>'update_coupon_number','enctype'=> 'multipart/form-data']); ?>

 
   <table class="table table-bordered table-hover product-store-list">
                <thead>
                </thead>
                <tbody >
				 <div class="row" style="margin:0px">
				   <div class="col-md-6">
				      <div class="form-group">
					    <label for="cobun_no" style="width:100%"><a href="javascript:void(0)" 
								id="auto_generate_pincode" style="float:left"></a>
								<?php echo e(trans('file.coupon_number')); ?> 
						</label>
					    <input type="number" name="cobun_no" id="cobun_no" class="form-control" value="<?php echo e($data['coupon']->cobun_number); ?>">
					  </div>
					  
					   <div class="form-group">
					    <label for="number_of_use"><?php echo e(trans('file.number_of_use')); ?></label>
					    <input type="number" name="number_of_use" id="number_of_use" class="form-control" value="<?php echo e($data['coupon']->number_of_use); ?>">
					     <input type="hidden" name="coupon_id" value="<?php echo e($data['coupon']->id); ?>">
 					   </div>
					  

                        <div class="form-group">
					      <label for="expire_date" ><?php echo e(trans('file.expire_date')); ?></label>
					      <input type="text" name="expire_date" id="expire_date" class="form-control" value="<?php echo e($data['coupon']->expire_date); ?>">
					   </div>
					   
				   </div>
				    <div class="col-md-6">
					
					<div style="display:none">
					  <h3 ><?php echo e(trans('file.select_category')); ?></h3>
					   <div class="row" style="margin-right:0px">
					   <div class="col-md-12 checkbox_container all_categoris_container" >
						   <label for="select_all_category_inser"> <?php echo e(trans('file.all')); ?> </label>
						   <input type="checkbox" class="defaul_checkbox"  id="select_all_category_inser">
                           <label class="checkmark_button" for="select_all_category_inser"></label>
						</div><hr>
					 </div>
					</div> 
					 
					  <?php $__currentLoopData = $data['category']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-12 checkbox_container" >
						 <div class="row">
						  <div class="col-md-6"> 
						   <label for="<?php echo e($category->id); ?>"> <?php echo e($category->name); ?> </label>
						   <input type="checkbox" class="defaul_checkbox insert_checkbox" name="selected_category[]" id="<?php echo e($category->id); ?>" value="<?php echo e($category->id); ?>" style="display:none">
                           <label class="checkmark_button" for="<?php echo e($category->id); ?>" style="display:none"></label>
						  </div>
                         <div class="col-md-6" style="margin-top:10px; padding-right:0px">	
                             <?php
							  $cvalue= DB::table('coupon_category')->where('copupon',$data['coupon']->cobun_number)->where('category',$category->id)->get()[0];
							 ?> 						 
						    <input type="number" name="coupon_categories_<?php echo e($category->id); ?>" class="form-control" value="<?php echo e($cvalue->value); ?>">
						 </div> 
                        </div>						 
						</div>						
					  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					 </div> 
				   </div>
				   
					
				     <div class="col-md-12">
					      <label style="visibility:hidden"><?php echo e(trans('file.update')); ?></label>
					   	 <input type="submit"  class="btn btn-primary update_coupon_number_btn" value="<?php echo e(trans('file.update')); ?>">
					 </div>
				
				  </div> 
                </tbody>
            </table>
  <?php echo Form::close(); ?> 			
		