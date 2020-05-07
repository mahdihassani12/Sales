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
                        <h4><?php echo e(trans('file.Group Permission')); ?></h4>
                    </div>
                    <?php echo Form::open(['route' => 'role.setPermission', 'method' => 'post']); ?>

                    <div class="card-body">
                    	<input type="hidden" name="role_id" value="<?php echo e($ezpos_role_data->id); ?>" />
						<div class="table-responsive">
						    <table class="table table-bordered table-hover table-striped reports-table">
						        <thead>
						        <tr>
						            <th colspan="5" class="text-center"><?php echo e($ezpos_role_data->name); ?> <?php echo e(trans('file.Group Permission')); ?></th>
						        </tr>
						        <tr>
						            <th rowspan="2" class="text-center"><?php echo e(trans('file.module_name')); ?>                                    </th>
						            <th colspan="4" class="text-center"><?php echo e(trans('file.Permissions')); ?>&nbsp;&nbsp; <input type="checkbox" id="select_all" class="checkbox"></th>
						        </tr>
						        <tr>
						            <th class="text-center"><?php echo e(trans('file.View')); ?></th>
						            <th class="text-center"><?php echo e(trans('file.add')); ?></th>
						            <th class="text-center"><?php echo e(trans('file.edit')); ?></th>
						            <th class="text-center"><?php echo e(trans('file.delete')); ?></th>
						        </tr>
						        </thead>
						        <tbody>
						        <tr>
						            <td><?php echo e(trans('file.product')); ?></td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("products-index", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="products-index" checked />
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="products-index" />
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("products-add", $all_permission)): ?>
						               	<input type="checkbox" value="1" class="checkbox" name="products-add" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="products-add">
						                <?php endif; ?>
						                </div>

						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("products-edit", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="products-edit" checked />
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="products-edit" />
						                <?php endif; ?>
						                </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("products-delete", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="products-delete" checked />
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="products-delete" />
						                <?php endif; ?>
						                </div>
						            </td>
						        </tr>

                                 <tr>
						            <td><?php echo e(trans('file.category')); ?></td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("category-index", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="category-index" checked />
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="category-index" />
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("category-add", $all_permission)): ?>
						               	<input type="checkbox" value="1" class="checkbox" name="category-add" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="category-add">
						                <?php endif; ?>
						                </div>

						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("category-edit", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="category-edit" checked />
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="category-edit" />
						                <?php endif; ?>
						                </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("category-delete", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="category-delete" checked />
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="category-delete" />
						                <?php endif; ?>
						                </div>
						            </td>
						        </tr>

						                                     
							   
							  <tr>
						            <td><?php echo e(trans('file.Sale')); ?>/<?php echo e(trans('file.orders')); ?></td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("sales-index", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="sales-index" checked />
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="sales-index">
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("sales-add", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="sales-add" checked />
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="sales-add">
						                <?php endif; ?>
						            	</div>
										<?php echo e(trans('file.send')); ?>

						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("sales-edit", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="sales-edit" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="sales-edit">
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("sales-delete", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="sales-delete" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="sales-delete">
						                <?php endif; ?>
						            	</div>
						            </td>
						        </tr>
 
						       
						        <tr>
						            <td><?php echo e(trans('file.Transfer')); ?></td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("transfers-index", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="transfers-index" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="transfers-index">
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("transfers-add", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="transfers-add" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="transfers-add">
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("transfers-edit", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="transfers-edit" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="transfers-edit">
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("transfers-delete", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="transfers-delete" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="transfers-delete">
						                <?php endif; ?>
						            	</div>
						            </td>
						        </tr>

						        <tr>
						            <td><?php echo e(trans('file.User')); ?></td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("users-index", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="users-index" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="users-index">
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("users-add", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="users-add" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="users-add">
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("users-edit", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="users-edit" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="users-edit">
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("users-delete", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="users-delete" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="users-delete">
						                <?php endif; ?>
						            	</div>
						            </td>
						        </tr>
						       
							     <tr>
						            <td><?php echo e(trans('file.Roles')); ?></td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("role-index", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="role-index" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="role-index">
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("role-add", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="role-add" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="role-add">
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("role-edit", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="role-edit" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="role-edit">
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("role-delete", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="role-delete" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="role-delete">
						                <?php endif; ?>
						            	</div>
						            </td>
						        </tr>
						       
                                <tr>
						            <td><?php echo e(trans('file.Adjustment')); ?></td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("adjustment-index", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="adjustment-index" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="adjustment-index">
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
										<?php echo e(trans('file.in_store')); ?>

										<?php if(in_array("adjustment-in", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="adjustment-in" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="adjustment-in">
						                <?php endif; ?>
						            	</div>
										
										 <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
                                         <?php echo e(trans('file.out_store')); ?>						               
									   <?php if(in_array("adjustment-out", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="adjustment-out" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="adjustment-out">
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("adjusment-edit", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="adjusment-edit" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="adjusment-edit">
						                <?php endif; ?>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                <?php if(in_array("adjustment-delete", $all_permission)): ?>
						                <input type="checkbox" value="1" class="checkbox" name="adjustment-delete" checked>
						                <?php else: ?>
						                <input type="checkbox" value="1" class="checkbox" name="adjustment-delete">
						                <?php endif; ?>
						            	</div>
						            </td>
						        </tr>
						       
							 							  
							     
							   <tr>
						            <td><?php echo e(trans('file.Report')); ?></td>
						            <td colspan="5">
						            	<span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	<?php if(in_array("product-price", $all_permission)): ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="product-price" checked>
					                    	<?php else: ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="product-price">
					                    	<?php endif; ?>
						                    </div>
						                    <label for="profit-loss" class="padding05"><?php echo e(trans('file.price')); ?> &nbsp;&nbsp;</label>
						                </span>
						               
										<span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	<?php if(in_array("item_count_store", $all_permission)): ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="item_count_store" checked>
					                    	<?php else: ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="item_count_store">
					                    	<?php endif; ?>
						                    </div>
						                    <label for="item_count_store" class="padding05"><?php echo e(trans('file.item_count_store')); ?> &nbsp;&nbsp;</label>
						                </span>
						               
						                <span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	<?php if(in_array("item_movement", $all_permission)): ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="item_movement" checked>
					                    	<?php else: ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="item_movement">
					                    	<?php endif; ?>
						                    </div>
						                    <label for="product-qty-alert" class="padding05"><?php echo e(trans('file.item_movement')); ?>  &nbsp;&nbsp;</label>
						                </span>
						                
										<span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	<?php if(in_array("product-qty-alert", $all_permission)): ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="product-qty-alert" checked>
					                    	<?php else: ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="product-qty-alert">
					                    	<?php endif; ?>
						                    </div>
						                    <label for="product-qty-alert" class="padding05"><?php echo e(trans('file.product')); ?> <?php echo e(trans('file.Quantity')); ?> <?php echo e(trans('file.Alert')); ?> &nbsp;&nbsp;</label>
						                </span>
						             
									 </td>
						        </tr>
						       
  							   
								<tr>
						            <td><?php echo e(trans('file.settings')); ?></td>
						            <td colspan="5">
						            	<span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	<?php if(in_array("general_setting", $all_permission)): ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="general_setting" checked>
					                    	<?php else: ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="general_setting">
					                    	<?php endif; ?>
						                    </div>
						                    <label for="general_setting" class="padding05"><?php echo e(trans('file.General Setting')); ?> &nbsp;&nbsp;</label>
						                </span>
						                <span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	<?php if(in_array("store_setting", $all_permission)): ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="store_setting" checked>
					                    	<?php else: ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="store_setting">
					                    	<?php endif; ?>
						                    </div>
						                    <label for="mail_setting" class="padding05"><?php echo e(trans('file.store_setting')); ?> &nbsp;&nbsp;</label>
						                </span>
						                <span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	<?php if(in_array("pos_setting", $all_permission)): ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="pos_setting" checked>
					                    	<?php else: ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="pos_setting">
					                    	<?php endif; ?>
						                    </div>
						                    <label for="pos_setting" class="padding05"><?php echo e(trans('file.POS Setting')); ?> &nbsp;&nbsp;</label>
						                </span>
						            </td>
						        </tr>
						        
								<tr>
						            <td><?php echo e(trans('file.Permissions')); ?></td>
						            <td colspan="5">
						            	 <span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	<?php if(in_array("permission", $all_permission)): ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="permission" checked>
					                    	<?php else: ?>
					                    	<input type="checkbox" value="1" class="checkbox" name="permission">
					                    	<?php endif; ?>
						                    </div>
						                    <label for="pos_setting" class="padding05"><?php echo e(trans('file.Permissions')); ?> &nbsp;&nbsp;</label>
						                </span>
						            </td>
						        </tr>
						        
								</tbody>
						    </table>
						</div>
						<div class="form-group">
	                        <input type="submit" value="<?php echo e(trans('file.submit')); ?>" class="btn btn-primary">
	                    </div>
                    </div>
                    <?php echo Form::close(); ?>

                </div>
            
                
			</div>
        </div>
    </div>
</section>

<script type="text/javascript">

	$("ul#setting").siblings('a').attr('aria-expanded','true');
    $("ul#setting").addClass("show");
    $("ul#setting li").eq(0).addClass("active");

	$("#select_all").on( "change", function() {
	    if ($(this).is(':checked')) {
	        $("tbody input[type='checkbox']").prop('checked', true);
	    } 
	    else {
	        $("tbody input[type='checkbox']").prop('checked', false);
	    }
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>