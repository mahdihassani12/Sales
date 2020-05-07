<?php $__env->startSection('content'); ?>
<?php if(session()->has('message')): ?>
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>

<section>
    <div class="container-fluid" >
	    
        <button data-target="#adjustment_modal" data-toggle="modal" class="btn btn-info"><i class="fa fa-plus"></i> <?php echo e(trans('file.add')); ?> <?php echo e(trans('file.Adjustment')); ?> </button>
        
	</div>
    <div class="table-responsive">
        <table id="adjustment-table" class="table table-hover purchase-list rwd-table" data-autogen-headers="true">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.Date')); ?></th>
                    <th><?php echo e(trans('file.reference')); ?> No</th>
                    <th><?php echo e(trans('file.Store')); ?></th>
                    <th><?php echo e(trans('file.product')); ?>s</th>
                    <th><?php echo e(trans('file.type')); ?></th>
                    <th><?php echo e(trans('file.Note')); ?></th>
                    <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $ezpos_adjustment_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$adjustment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($key); ?></td>
                    <td><?php echo e(date('d-m-Y', strtotime($adjustment->date))); ?></td>
                    <td><?php echo e($adjustment->reference_no); ?></td>
                    <?php $store = DB::table('stores')->find($adjustment->store_id) ?>
                    <td><?php echo e($store->name); ?></td>
                    <td>
                    <?php
                    	$product_adjustment_data = DB::table('product_adjustments')->where('adjustment_id', $adjustment->id)->get();
                    	foreach ($product_adjustment_data as $key => $product_adjustment) {
                    	 	$product = DB::table('products')->find($product_adjustment->product_id);
                    	 	if($key)
                    	 		echo '<br>';
                    	 	echo $product->name;
                    	 } 
                    ?>
                    </td>
                    <td>
					<?php if($adjustment->type=="out_store"): ?>
					  <?php echo e(trans('file.out_store')); ?>

				    <?php else: ?>
					  <?php echo e(trans('file.in_store')); ?>

					<?php endif; ?>
					</td>
                    <td><?php echo e($adjustment->note); ?></td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo e(trans('file.action')); ?><span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                <?php if(in_array("adjusment-edit", $all_permission)): ?>
								<li>
                                    <a href="<?php echo e(route('qty_adjustment.edit', ['id' => $adjustment->id])); ?>" class="btn btn-link"><i class="fa fa-edit"></i> <?php echo e(trans('file.edit')); ?></a> 
                                </li>
								<?php endif; ?>
                                <li class="divider"></li>
								
								<?php if(in_array("adjustment-delete", $all_permission)): ?>
                                <?php echo e(Form::open(['route' => ['qty_adjustment.destroy', $adjustment->id], 'method' => 'DELETE'] )); ?>

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
</section>

<!-- Modal -->
<div id="adjustment_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background:#2f67bd; color:#fff">
        <button type="button" class="close" data-dismiss="modal" style="padding:0px;">&times;</button>
        <h4 class="modal-title"><?php echo e(trans('file.add')); ?> <?php echo e(trans('file.Adjustment')); ?></h4>
      </div>
      <div class="modal-body adjustment_sections">
        <div class="row">
		     <div class="col-sm-6">
		    <a href="<?php echo e(route('qty_adjustment.create')); ?>" class="box-link">
			   <div class="home-box">
                   <p>ادخال المواد الی المخازن و تصنیفها</p>
				   <h2><?php echo e(trans('file.in_store')); ?> <img src="<?php echo e(asset('public/images/icons/instore.png')); ?>"></h2>
               </div>			  
			</a>
	      </div>
		  <div class="col-sm-6">
		    <a href="<?php echo e(route('qty_adjustment.out_store')); ?>" class="box-link">
			   <div class="home-box">
                   <p>ادخال المواد الی المخازن و تصنیفها</p>
				   <h2><?php echo e(trans('file.out_store')); ?> <img src="<?php echo e(asset('public/images/icons/outstore.png')); ?>"></h2>
               </div>			  
			</a>
	      </div>
		</div>
      </div>
    </div>

  </div>
</div>

<style>
   .mobile-table td[data-title]:before{
	 padding-left:10px;
	 padding-right:10px;
 }
</style>
<script type="text/javascript">
    $("ul#adjustment").siblings('a').attr('aria-expanded','true');
    $("ul#adjustment").addClass("show");
    $("ul#adjustment li").eq(0).addClass("active");

    function confirmDelete() {
        if (confirm("Are you sure want to delete?")) {
            return true;
        }
        return false;
    }

    $('#adjustment-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 6]
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