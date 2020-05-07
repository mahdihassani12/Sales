<?php echo Form::open(['route' => 'pincode.update', 'method' => 'post', 'files' => true]); ?>

        <div class="modal-body">
             <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><?php echo e(trans('file.pincode_no')); ?> *</label>
                        <input type="number" class="form-control" name="pincode_no" value="<?php echo e($data['pincode']->number); ?>" >
                        <input type="hidden" name="pinid" value="<?php echo e($data['pincode']->id); ?>">
					</div>
                </div>
				  <div class="col-md-6">
                    <div class="form-group">
                        <label><?php echo e(trans('file.amount')); ?> * </label>
                        <input type="number" class="form-control" name="amount" value="<?php echo e($data['pincode']->amount); ?>">
                    </div>
                </div>
				  <div class="col-md-6">
                    <div class="form-group">
                        <label><?php echo e(trans('file.user_owner')); ?> </label>
                        <input type="text" class="form-control" name="user_owner" value="<?php echo e($data['pincode']->user_owner); ?>">
                    </div>
                </div>
				 <div class="col-md-6">
                    <div class="form-group">
                        <label><?php echo e(trans('file.software_name')); ?> </label>
                        <input type="text" class="form-control" name="software_name" value="<?php echo e($data['pincode']->software_name); ?>">
                    </div>
                </div>
				 <div class="col-md-6">
                    <div class="form-group">
                        <label><?php echo e(trans('file.status_done')); ?> </label>
                        <select class="form-control" name="status_done">
						   <option value="1" <?php if($data['pincode']->status_done==1){ echo "selected";} ?>><?php echo e(trans('file.active')); ?></option>
						   <option value="0" <?php if($data['pincode']->status_done==0){ echo "selected";} ?>><?php echo e(trans('file.inactive')); ?></option>
						</select>
                    </div>
                </div>
				 <div class="col-md-6">
                    <div class="form-group">
                        <label><?php echo e(trans('file.status_used')); ?> </label>
                        <select class="form-control" name="status_used">
						   <option value="1" <?php if($data['pincode']->status_used==1){ echo "selected";} ?>><?php echo e(trans('file.active')); ?></option>
						   <option value="0" <?php if($data['pincode']->status_done==0){ echo "selected";} ?>><?php echo e(trans('file.inactive')); ?></option>
						</select>
                    </div>
                </div>
				
				 <div class="col-md-12">
                    <div class="form-group">
                        <label><?php echo e(trans('file.note')); ?> </label>
                        <textarea class="form-control" name="note"><?php echo e($data['pincode']->notes); ?></textarea>
                    </div>
                </div>
           </div>           
            <?php echo e(Form::submit('Submit', ['class' => 'btn btn-primary'])); ?>

        </div>
        <?php echo Form::close(); ?>