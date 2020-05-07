 <?php $__env->startSection('content'); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<?php echo e(Form::open(['route' => 'report.bestSellerByStore', 'method' => 'post', 'id' => 'report-form'])); ?>

			<input type="hidden" name="store_id_hidden" value="<?php echo e($store_id); ?>">
            <h4 class="text-center mt-3"><?php echo e(trans('file.Best Seller')); ?> <?php echo e(trans('file.From')); ?> <?php echo e($start_month.' - '.date("F Y")); ?> &nbsp;&nbsp;
            <select class="selectpicker" id="store_id" name="store_id">
				<option value="0"><?php echo e(trans('file.All')); ?> <?php echo e(trans('file.Store')); ?></option>
				<?php $__currentLoopData = $ezpos_store_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<option value="<?php echo e($store->id); ?>"><?php echo e($store->name); ?></option>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</select>
            </h4>
            <?php echo e(Form::close()); ?>

            <div class="card-body">
              <canvas id="bestSeller" data-product = "<?php echo e(json_encode($product)); ?>" data-sold_qty="<?php echo e(json_encode($sold_qty)); ?>" ></canvas>
            </div>
        </div>
	</div>
</div>

<script type="text/javascript">

	$("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report li").eq(1).addClass("active");

	$('#store_id').val($('input[name="store_id_hidden"]').val());
	$('.selectpicker').selectpicker('refresh');

	$('#store_id').on("change", function(){
		$('#report-form').submit();
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>