 <?php $__env->startSection('content'); ?>

<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4><?php echo e(trans('file.update')); ?> <?php echo e(trans('file.User')); ?></h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
                        <?php echo Form::open(['route' => ['user.update', $ezpos_user_data->id], 'method' => 'put', 'files' => true]); ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.UserName')); ?> *</strong> </label>
                                        <input type="text" name="name" required class="form-control" value="<?php echo e($ezpos_user_data->name); ?>">
                                        <?php if($errors->has('name')): ?>
                                       <span>
                                           <strong><?php echo e($errors->first('name')); ?></strong>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Change Password')); ?></strong> </label>
                                        <div class="input-group">
                                            <input type="password" name="password" class="form-control">
                                            <div class="input-group-append">
                                                <button id="genbutton" type="button" class="btn btn-default"><?php echo e(trans('file.Generate')); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Email')); ?> *</strong></label>
                                        <input type="email" name="email" placeholder="example@example.com" required class="form-control" value="<?php echo e($ezpos_user_data->email); ?>">
                                        <?php if($errors->has('email')): ?>
                                       <span>
                                           <strong><?php echo e($errors->first('email')); ?></strong>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Phone Number')); ?> *</strong></label>
                                        <input type="text" name="phone" required class="form-control" value="<?php echo e($ezpos_user_data->phone); ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="<?php echo e(trans('file.submit')); ?>" class="btn btn-primary">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Company Name')); ?></strong></label>
                                        <input type="text" name="company_name" class="form-control" value="<?php echo e($ezpos_user_data->company_name); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Role')); ?> *</strong></label>
                                        <input type="hidden" name="role_id_hidden" value="<?php echo e($ezpos_user_data->role_id); ?>">
                                        <select name="role_id" required class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Role...">
                                          <?php $__currentLoopData = $ezpos_role_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <option value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group" id="store-id">
                                        <input type="hidden" name="store_id_hidden" value="<?php echo e($ezpos_user_data->store_id); ?>" />
                                        <label><strong><?php echo e(trans('file.Store')); ?> * 
										   <?php $allstores=explode("-",$ezpos_user_data->store_id);?>
										</strong></label>
                                        <select id="salesman_store_id"   multiple name="store_id[]" required class="selectpicker form-control store-id" data-live-search="true" data-live-search-style="begins" title="Select store...">
                                          <?php $__currentLoopData = $ezpos_store_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <option  <?php for($i=0; $i<count($allstores); $i++): ?> <?php if($store->id==$allstores[$i]): ?> selected <?php endif; ?>  <?php endfor; ?> value="<?php echo e($store->id); ?>"><?php echo e($store->name); ?></option>
										  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <?php if($ezpos_user_data->is_active): ?>
                                        <input class="mt-4" type="checkbox" name="is_active" value="1" checked>
                                        <?php else: ?>
                                        <input class="mt-4" type="checkbox" name="is_active" value="1">
                                        <?php endif; ?>
                                        <label class="mt-4"><strong><?php echo e(trans('file.Active')); ?></strong></label>
                                    </div>
                                </div>                              
                            </div>
                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">

    $("ul#people").siblings('a').attr('aria-expanded','true');
    $("ul#people").addClass("show");
    $('#store-id').hide();
    
    $('.selectpicker').selectpicker({
      style: 'btn-link',
    });

    $('#genbutton').on("click", function(){
      $.get('../genpass', function(data){
        $("input[name='password']").val(data);
      });
    });

    $('select[name=role_id]').val($("input[name='role_id_hidden']").val());
    if($('select[name=role_id]').val() > 2  && $('select[name=role_id]').val() != 8 ){
        $('#store-id').show();
       // $('#salesman_store_id').val($("input[name='store_id_hidden']").val());
    }
    $('.selectpicker').selectpicker('refresh');

    $('select[name="role_id"]').on('change', function() {
       if($(this).val() > 2  && $(this).val()!=8){
            $('#salesman_store_id').prop('required',true);
            $('#store-id').show();
        }
        else{
            $('#salesman_store_id').prop('required',false);
            $('.store-id').val(null);
            $('.selectpicker').selectpicker('refresh');
            $('#store-id').hide();
        }
    });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>