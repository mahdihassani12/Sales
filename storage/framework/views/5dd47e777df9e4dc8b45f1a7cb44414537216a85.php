 <?php $__env->startSection('content'); ?>

<?php if($errors->has('name')): ?>
<div class="alert alert-danger alert-dismissible text-center">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e($errors->first('name')); ?></div>
<?php endif; ?>
<?php if(session()->has('message')): ?>
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>

<section>
    <div class="container-fluid">
	  <?php if(in_array("role-add", $all_permission)): ?>
        <a href="#" data-toggle="modal" data-target="#createModal" class="btn btn-info"><i class="fa fa-plus"></i> <?php echo e(trans('file.add')); ?> <?php echo e(trans('file.Role')); ?> </a>
      <?php endif; ?>
	</div>
    <div class="table-responsive">
        <table id="role-table" class="table table-hover">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.name')); ?></th>
                    <th><?php echo e(trans('file.Description')); ?></th>
                    <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $ezpos_role_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($key); ?></td>
                    <td><?php echo e($role->name); ?></td>
                    <td><?php echo e($role->description); ?></td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo e(trans('file.action')); ?>

                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                               <?php if(in_array("role-edit", $all_permission)): ?>                               
							   <li>
                                    <button type="button" data-id="<?php echo e($role->id); ?>" class="open-EditroleDialog btn btn-link" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i> <?php echo e(trans('file.edit')); ?>

                                    </button>
                                </li>
								<?php endif; ?>
								<?php if(in_array("role-delete", $all_permission)): ?>
                                <li class="divider"></li>
                                <?php echo e(Form::open(['route' => ['role.destroy', $role->id], 'method' => 'DELETE'] )); ?>

                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> <?php echo e(trans('file.delete')); ?></button>
                                </li>
                                <?php echo e(Form::close()); ?>

								<?php endif; ?>
								<?php if(in_array("permission", $all_permission)): ?>
                                <li>
                                    <a href="<?php echo e(route('role.permission', ['id' => $role->id])); ?>" class="btn btn-link"><i class="fa fa-unlock-alt"></i> <?php echo e(trans('file.Change Permission')); ?></a>
                                </li>
								<?php endif; ?>
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</section>

<div id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <?php echo Form::open(['route' => 'role.store', 'method' => 'post']); ?>

            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.add')); ?> <?php echo e(trans('file.Role')); ?></h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
                <form>
                    <div class="form-group">
                    <label><strong><?php echo e(trans('file.name')); ?> *</strong></label>
                    <?php echo e(Form::text('name',null,array('required' => 'required', 'class' => 'form-control'))); ?>

                    </div>
                    <div class="form-group">
                        <label><strong><?php echo e(trans('file.Description')); ?></strong></label>
                        <?php echo e(Form::textarea('description',null,array('rows'=> 5, 'class' => 'form-control'))); ?>

                    </div>
                    <input type="hidden" name="is_active" value="1">
                    <input type="hidden" name="guard_name" value="web">
                    <input type="submit" value="<?php echo e(trans('file.submit')); ?>" class="btn btn-primary">
            	</form>
        	</div>
        <?php echo e(Form::close()); ?>

    	</div>
	</div>
</div>

<div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
	<div role="document" class="modal-dialog">
		  <div class="modal-content">
		    <?php echo Form::open(['route' => ['role.update',1], 'method' => 'put']); ?>

		    <div class="modal-header">
		      <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.update')); ?> <?php echo e(trans('file.Role')); ?></h5>
		      <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
		    </div>
		    <div class="modal-body">
		      <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
		        <form>
		            <input type="hidden" name="role_id">
		            <div class="form-group">
		                <label><strong><?php echo e(trans('file.name')); ?> *</strong></label>
		                <?php echo e(Form::text('name',null,array('required' => 'required', 'class' => 'form-control'))); ?>

		            </div>
		            <div class="form-group">
		                <label><strong><?php echo e(trans('file.Description')); ?></strong></label>
		                <?php echo e(Form::textarea('description',null,array('rows'=> 5, 'class' => 'form-control'))); ?>

		            </div>
		            <input type="submit" value="<?php echo e(trans('file.submit')); ?>" class="btn btn-primary">
		        </form>
		    </div>
		    <?php echo e(Form::close()); ?>

		  </div>
	</div>
</div>

<script type="text/javascript">

    $("ul#setting").siblings('a').attr('aria-expanded','true');
    $("ul#setting").addClass("show");
    $("ul#setting li").eq(0).addClass("active");

	 function confirmDelete() {
        if (confirm("Are you sure want to delete?")) {
            return true;
        }
        return false;
    }

    $(document).ready(function() {
    $('.open-EditroleDialog').on('click', function() {
        var url = "role/"
        var id = $(this).data('id').toString();
        url = url.concat(id).concat("/edit");

        $.get(url, function(data) {
            $("input[name='name']").val(data['name']);
            $("textarea[name='description']").val(data['description']);
            $("input[name='role_id']").val(data['id']);
        });
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#role-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 3]
            },
            {
                'checkboxes': {
                   'selectRow': true
                },
                'targets': 0
            }
        ],
        'select': { style: 'multi',  selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'pdf',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'colvis',
                columns: ':gt(0)'
            },
        ],
    } );
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>