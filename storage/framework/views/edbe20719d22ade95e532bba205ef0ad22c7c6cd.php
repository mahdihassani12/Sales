 <?php $__env->startSection('content'); ?>

<?php if($errors->has('name')): ?>
<div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e($errors->first('name')); ?></div>
<?php endif; ?>
<?php if(session()->has('message')): ?>
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>

<section>
    <div class="container-fluid">
        <!-- Trigger the modal with a button -->
		<?php if(in_array("category-add", $all_permission)): ?>
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i> <?php echo e(trans('file.add')); ?> <?php echo e(trans('file.category')); ?></button>&nbsp;
        <button class="btn btn-primary" data-toggle="modal" data-target="#importCategory"><i class="fa fa-file"></i> <?php echo e(trans('file.import')); ?> <?php echo e(trans('file.category')); ?></button>
       <?php endif; ?>   
   </div>
    <div class="table-responsive">
        <table id="category-table" class="table table-hover">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.category')); ?></th>
                    <th><?php echo e(trans('file.parent')); ?> <?php echo e(trans('file.category')); ?></th>
                    <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $ezpos_category_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($key); ?></td>
                    <td><?php echo e($category->name); ?></td>
                    <?php
                        $ezpos_parent_category  = DB::table('categories')
                        ->where('id',$category->parent_id)->first();
                    ?>
                    <?php if($ezpos_parent_category): ?>
                        <td><?php echo e($ezpos_parent_category->name); ?></td>
                    <?php else: ?>
                        <td>N/A</td>
                    <?php endif; ?>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo e(trans('file.action')); ?>

                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                <?php if(in_array("category-edit", $all_permission)): ?>
								<li>
                                    <button type="button" data-id="<?php echo e($category->id); ?>" class="open-EditCategoryDialog btn btn-link" data-toggle="modal" data-target="#editModal" ><i class="fa fa-edit"></i>  <?php echo e(trans('file.edit')); ?></button>
                                </li>
								<?php endif; ?>
                                <li class="divider"></li>
								
								<?php if(in_array("category-delete", $all_permission)): ?>
                                <?php echo e(Form::open(['route' => ['category.destroy', $category->id], 'method' => 'DELETE'] )); ?>

                                <li>
                                  <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> <?php echo e(trans('file.delete')); ?></button> 
                                </li>
                                <?php echo e(Form::close()); ?>

								<?php endif; ?>
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</seaction>

<!-- Create Modal -->
<div id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        <?php echo Form::open(['route' => 'category.store', 'method' => 'post']); ?>

        <div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.add')); ?> <?php echo e(trans('file.category')); ?></h5>
          <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
          <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
          <form>
            <div class="form-group">
                <label><strong><?php echo e(trans('file.name')); ?> *</strong></label>
                <?php echo e(Form::text('name',null,array('required' => 'required', 'class' => 'form-control', 'placeholder' => 'Type category name...'))); ?>

            </div>
            <div class="form-group">
                <label><strong><?php echo e(trans('file.parent')); ?> <?php echo e(trans('file.category')); ?></strong></label>
                <?php echo e(Form::select('parent_id', $ezpos_categories, null, ['class' => 'form-control','placeholder' => 'No Parent Category'])); ?>

            </div>                
            <div class="form-group">       
              <input type="submit" value="<?php echo e(trans('file.submit')); ?>" class="btn btn-primary">
            </div>
          </form>
        </div>
        <?php echo e(Form::close()); ?>

      </div>
    </div>
</div>
<!-- Edit Modal -->
<div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog">
    <div class="modal-content">
        <?php echo e(Form::open(['route' => ['category.update', 1], 'method' => 'PUT'] )); ?>

      <div class="modal-header">
        <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.update')); ?> <?php echo e(trans('file.category')); ?></h5>
        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">
        <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
          <div class="form-group">
            <label><strong><?php echo e(trans('file.name')); ?> *</strong></label>
            <?php echo e(Form::text('name',null, array('required' => 'required', 'class' => 'form-control'))); ?>

        </div>
            <input type="hidden" name="category_id">
        <div class="form-group">
            <label><strong><?php echo e(trans('file.parent')); ?> <?php echo e(trans('file.category')); ?></strong></label>
            <select name="parent_id" class="form-control selectpicker" id="parent">
                <option value="">No <?php echo e(trans('file.parent')); ?></option>
                <?php $__currentLoopData = $parent_ezpos_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-group">       
            <input type="submit" value="<?php echo e(trans('file.submit')); ?>" class="btn btn-primary">
          </div>
        </div>
      <?php echo e(Form::close()); ?>

    </div>
  </div>
</div>
<!-- Import Modal -->
<div id="importCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        <?php echo Form::open(['route' => 'category.import', 'method' => 'post', 'files' => true]); ?>

        <div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.import')); ?> <?php echo e(trans('file.category')); ?></h5>
          <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
           <p><?php echo e(trans('file.The correct column order is')); ?> (name*, parent_category) <?php echo e(trans('file.and you must follow this')); ?>.</p>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong><?php echo e(trans('file.Upload CSV File')); ?> *</strong></label>
                        <?php echo e(Form::file('file', array('class' => 'form-control','required'))); ?>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong> <?php echo e(trans('file.Sample File')); ?></strong></label>
                        <a href="public/sample_file/sample_category.csv" class="btn btn-info btn-block btn-md"><i class="fa fa-download"></i>  <?php echo e(trans('file.Download')); ?></a>
                    </div>
                </div>
            </div>
            <input type="submit" value="<?php echo e(trans('file.submit')); ?>" class="btn btn-primary">
        </div>
        <?php echo e(Form::close()); ?>

      </div>
    </div>
</div>

<script type="text/javascript">
    $("ul#product").siblings('a').attr('aria-expanded','true');
    $("ul#product").addClass("show");
    $("ul#product li").eq(0).addClass("active");

    function confirmDelete() {
      if (confirm("If you delete category all products under this category will also be deleted. Are you sure want to delete?")) {
          return true;
      }
      return false;
    }
$(document).ready(function() {
    $('.open-EditCategoryDialog').on('click', function(){
      var url ="category/"  
      var id = $(this).data('id').toString();
      url = url.concat(id).concat("/edit");
      
      $.get(url, function(data){
        $("#editModal input[name='name']").val(data['name']);
        $("#editModal select[name='parent_id']").val(data['parent_id']);
        $("#editModal input[name='category_id']").val(data['id']);
        $('.selectpicker').selectpicker('refresh');
      });
    });
});

    $('#category-table').DataTable( {
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
                footer:true
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                footer:true
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                footer:true
            },
            {
                extend: 'colvis',
                columns: ':gt(0)'
            },
        ],
    } );
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>