  <div class="modal-dialog" style="max-width: 483px;">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">   
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> <?php echo e(trans('file.orders')); ?> <?php echo e(trans('file.process')); ?> </h4>
      </div>
      <div class="modal-body">
         <?php echo e(Form::open(['url' => ['request/change_status_to_process'], 'method' => 'POST'] )); ?>

		    <div class="form-group" style='display:none'>
			   <label for="company_shipping"><?php echo e(trans('file.Shipping')); ?> <?php echo e(trans('company')); ?> </label>
			   <select name="company" id="company_shipping" class="form-control">
			      <option value=""><?php echo e(trans('file.select')); ?> <?php echo e(trans('file.company')); ?></option>
				  <?php $__currentLoopData = $company; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
     			  <option value="<?php echo e($comp->company_id); ?>" com_phone="<?php echo e($comp->phone); ?>"><?php echo e($comp->name); ?></option>
			      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			   </select>
			   <input type="hidden" value="<?php echo e($requestId); ?>" name='request_id'>
			</div>
			
			<div class="form-group" style='display:none'>
			   <label for="com_phone"><?php echo e(trans('file.company')); ?> <?php echo e(trans('file.phone')); ?></label>
			   <input type="text" name="com_phone" id='com_phone' class="form-control" value='null'>
			</div>
			
			 <div class="form-group">
			   <label for="from_store"> <?php echo e(trans('file.From')); ?> <?php echo e(trans('file.Store')); ?> </label>
			   <select name="from_store" id="from_store" class="form-control">
			      <option value=""><?php echo e(trans('file.select')); ?> <?php echo e(trans('file.Store')); ?></option>
				  <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
     			  <option value="<?php echo e($store->id); ?>" ><?php echo e($store->name); ?></option>
			      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			   </select>
			   <input type="hidden" value="<?php echo e($requestId); ?>" name='request_id'>
			</div>
             <div class="form-group" style='display:none'>
			   <label for="note"><?php echo e(trans('file.company')); ?> <?php echo e(trans('file.Note')); ?></label>
               <textarea rows="5" class="form-control" name="note" id="note" value='null'></textarea>
			 </div>
           <div class="form-group">
			   <input type="submit" name="submit" class="form-control">
			</div>			
		 <?php echo e(Form::close()); ?>

      </div>
    </div>

  </div>
  
  
  <script>
	  $('#company_shipping').change(function(){
		  var comPhone=$("#company_shipping option:selected").attr('com_phone');
		  $("#com_phone").val(comPhone);
	  });	
	
  </script>