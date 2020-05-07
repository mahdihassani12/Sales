<?php $__env->startSection('content'); ?>
<section>
	<h3 class="text-center"><?php echo e(trans('file.Summary Report')); ?></h3>
	<?php echo Form::open(['route' => 'report.profitLoss', 'method' => 'post']); ?>

	<div class="col-md-6 offset-md-3 mt-4">
        <div class="form-group row">
            <label class="d-tc mt-2"><strong><?php echo e(trans('file.Choose Your Date')); ?></strong> &nbsp;</label>
            <div class="d-tc">
                <div class="input-group">
                    <input type="text" class="daterangepicker-field form-control" placeholder="<?php echo e($start_date); ?> To <?php echo e($end_date); ?>" required/>
                    <input type="hidden" name="start_date" />
                    <input type="hidden" name="end_date" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"><?php echo e(trans('file.submit')); ?></button>
                    </div>
                </div>
            </div>
        </div> 
    </div>
	<?php echo e(Form::close()); ?>

	<div class="container-fluid">
		<div class="row mt-4">
			<div class="col-md-4">
				<div class="colored-box">
					<i class="fa fa-heart"></i>
					<h3><?php echo e(trans('file.Purchase')); ?></h3>
					<hr>
					<div class="mt-3">
						<p class="mt-2"><?php echo e(trans('file.Amount')); ?> <span class="float-right"> <?php echo e(number_format((float)$purchase[0]->grand_total, 2, '.', '')); ?></span></p>
						<p class="mt-2"><?php echo e(trans('file.Purchase')); ?> <span class="float-right"><?php echo e($total_purchase); ?></span></p>
						<p class="mt-2"><?php echo e(trans('file.Paid')); ?> <span class="float-right"><?php echo e(number_format((float)$purchase[0]->paid_amount, 2, '.', '')); ?></span></p>
						<p class="mt-2"><?php echo e(trans('file.Tax')); ?> <span class="float-right"><?php echo e(number_format((float)$purchase[0]->tax, 2, '.', '')); ?></span></p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="colored-box">
					<i class="fa fa-shopping-cart"></i>
					<h3><?php echo e(trans('file.Sale')); ?></h3>
					<hr>
					<div class="mt-3">
						<p class="mt-2"><?php echo e(trans('file.Amount')); ?> <span class="float-right"> <?php echo e(number_format((float)$sale[0]->grand_total, 2, '.', '')); ?></span></p>
						<p class="mt-2"><?php echo e(trans('file.Sale')); ?> <span class="float-right"><?php echo e($total_sale); ?></span></p>
						<p class="mt-2"><?php echo e(trans('file.Paid')); ?> <span class="float-right"><?php echo e(number_format((float)$sale[0]->paid_amount, 2, '.', '')); ?></span></p>
						<p class="mt-2"><?php echo e(trans('file.Tax')); ?> <span class="float-right"><?php echo e(number_format((float)$sale[0]->tax, 2, '.', '')); ?></span></p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="colored-box">
					<i class="fa fa-random "></i>
					<h3><?php echo e(trans('file.Return')); ?></h3>
					<hr>
					<div class="mt-3">
						<p class="mt-2"><?php echo e(trans('file.Amount')); ?> <span class="float-right"> <?php echo e(number_format((float)$return[0]->grand_total, 2, '.', '')); ?></span></p>
						<p class="mt-2"><?php echo e(trans('file.Return')); ?> <span class="float-right"><?php echo e($total_return); ?></span></p>
						<p class="mt-2"><?php echo e(trans('file.Tax')); ?> <span class="float-right"><?php echo e(number_format((float)$return[0]->tax, 2, '.', '')); ?></span></p>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-2">
			<div class="col-md-4">
				<div class="colored-box">
					<i class="fa fa-money"></i>
					<h3><?php echo e(trans('file.profit')); ?> / <?php echo e(trans('file.Loss')); ?></h3>
					<hr>
					<div class="mt-3">
						<p class="mt-2"><?php echo e(trans('file.Sale')); ?> <span class="float-right"><?php echo e($sale[0]->grand_total); ?></span></p>
						<p class="mt-2"><?php echo e(trans('file.Purchase')); ?> <span class="float-right">- <?php echo e($purchase[0]->grand_total); ?></span></p>
						<p class="mt-2"><?php echo e(trans('file.profit')); ?> <span class="float-right"> <?php echo e(number_format((float)($sale[0]->grand_total - $purchase[0]->grand_total), 2, '.', '')); ?></span></p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="colored-box">
					<i class="fa fa-money"></i>
					<h3><?php echo e(trans('file.profit')); ?> / <?php echo e(trans('file.Loss')); ?></h3>
					<hr>
					<div class="mt-3">
						<p class="mt-2"><?php echo e(trans('file.Sale')); ?> <span class="float-right"><?php echo e($sale[0]->grand_total); ?></span></p>
						<p class="mt-2"><?php echo e(trans('file.Purchase')); ?> <span class="float-right">- <?php echo e($purchase[0]->grand_total); ?></span></p>
						<p class="mt-2"><?php echo e(trans('file.Return')); ?> <span class="float-right">- <?php echo e($return[0]->grand_total); ?></span></p>
						<p class="mt-2"><?php echo e(trans('file.profit')); ?> <span class="float-right"> <?php echo e(number_format((float)($sale[0]->grand_total - $purchase[0]->grand_total - $return[0]->grand_total), 2, '.', '')); ?></span></p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="colored-box">
					<i class="fa fa-money "></i>
					<h3>Net <?php echo e(trans('file.profit')); ?> / <?php echo e(trans('file.Loss')); ?></h3>
					<hr>
					<h4 class="text-center"><?php echo e(number_format((float)(($sale[0]->grand_total-$sale[0]->tax) - ($purchase[0]->grand_total-$purchase[0]->tax) - ($return[0]->grand_total-$return[0]->tax)), 2, '.', '')); ?></h4>
					<p class="text-center">
						(<?php echo e(trans('file.Sale')); ?> <?php echo e($sale[0]->grand_total); ?> - <?php echo e(trans('file.Tax')); ?> <?php echo e($sale[0]->tax); ?>) - (<?php echo e(trans('file.Purchase')); ?> <?php echo e($purchase[0]->grand_total); ?> - <?php echo e(trans('file.Tax')); ?> <?php echo e($purchase[0]->tax); ?>) - (<?php echo e(trans('file.Return')); ?> <?php echo e($return[0]->grand_total); ?> - <?php echo e(trans('file.Tax')); ?> <?php echo e($return[0]->tax); ?>)
					</p>
				</div>
			</div>
		</div>
		<div class="row mt-2">
			<div class="col-md-4">
				<div class="colored-box">
					<i class="fa fa-dollar"></i>
					<h3><?php echo e(trans('file.Payment')); ?> <?php echo e(trans('file.Recieved')); ?></h3>
					<hr>
					<div class="mt-3">
						<p class="mt-2"><?php echo e(trans('file.Amount')); ?> <span class="float-right"> <?php echo e(number_format((float)$payment_recieved, 2, '.', '')); ?></span></p>
						<p class="mt-2"><?php echo e(trans('file.Recieved')); ?> <span class="float-right"><?php echo e($payment_recieved_number); ?></span></p>
						<p class="mt-2">Cash <span class="float-right"><?php echo e(number_format((float)$cash_payment_sale, 2, '.', '')); ?></span></p>
						<p class="mt-2">Cheque <span class="float-right"><?php echo e(number_format((float)$cheque_payment_sale, 2, '.', '')); ?></span></p>
						<p class="mt-2">Credit Card <span class="float-right"><?php echo e(number_format((float)$credit_card_payment_sale, 2, '.', '')); ?></span></p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="colored-box">
					<i class="fa fa-dollar"></i>
					<h3><?php echo e(trans('file.Payment')); ?> <?php echo e(trans('file.Sent')); ?></h3>
					<hr>
					<div class="mt-3">
						<p class="mt-2"><?php echo e(trans('file.Amount')); ?> <span class="float-right"> <?php echo e(number_format((float)$payment_sent, 2, '.', '')); ?></span></p>
						<p class="mt-2"><?php echo e(trans('file.Recieved')); ?> <span class="float-right"><?php echo e($payment_sent_number); ?></span></p>
						<p class="mt-2">Cash <span class="float-right"><?php echo e(number_format((float)$cash_payment_purchase, 2, '.', '')); ?></span></p>
						<p class="mt-2">Cheque <span class="float-right"><?php echo e(number_format((float)$cheque_payment_purchase, 2, '.', '')); ?></span></p>
						<p class="mt-2">Credit Card <span class="float-right"><?php echo e(number_format((float)$credit_card_payment_purchase, 2, '.', '')); ?></span></p>
					</div>
					
				</div>
			</div>
			<div class="col-md-4">
				<div class="colored-box">
					<i class="fa fa-dollar"></i>
					<h3><?php echo e(trans('file.Expense')); ?></h3>
					<hr>
					<div class="mt-3">
						<p class="mt-2"><?php echo e(trans('file.Amount')); ?> <span class="float-right"> <?php echo e(number_format((float)$expense, 2, '.', '')); ?></span></p>
						<p class="mt-2"><?php echo e(trans('file.Expense')); ?> <span class="float-right"><?php echo e($total_expense); ?></span></p>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-2">
			<div class="col-md-4 offset-md-4">
				<div class="colored-box">
					<i class="fa fa-dollar"></i>
					<h3><?php echo e(trans('file.Cash in Hand')); ?></h3>
					<hr>
					<div class="mt-3">
						<p class="mt-2"><?php echo e(trans('file.In Hand')); ?> <span class="float-right"><?php echo e(number_format((float)($payment_recieved - $payment_sent - $return[0]->grand_total - $expense), 2, '.', '')); ?></span></p>
						<p class="mt-2"><?php echo e(trans('file.Recieved')); ?> <span class="float-right"> <?php echo e(number_format((float)($payment_recieved), 2, '.', '')); ?></span></p>
						<p class="mt-2"><?php echo e(trans('file.Sent')); ?> <span class="float-right">- <?php echo e(number_format((float)($payment_sent), 2, '.', '')); ?></span></p>
						<p class="mt-2"><?php echo e(trans('file.Return')); ?> <span class="float-right">- <?php echo e(number_format((float)$return[0]->grand_total, 2, '.', '')); ?></span></p>
						<p class="mt-2"><?php echo e(trans('file.Expense')); ?> <span class="float-right">- <?php echo e(number_format((float)$expense, 2, '.', '')); ?></span></p>
					</div>
					
				</div>
			</div>
		</div>
		<div class="row mt-2">
			<?php $__currentLoopData = $store_name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="col-md-4">
					<div class="colored-box">
						<i class="fa fa-money"></i>
						<h3><?php echo e($name); ?></h3>
						<h4 class="text-center"><?php echo e(number_format((float)($store_sale[$key][0]->grand_total - $store_purchase[$key][0]->grand_total - $store_return[$key][0]->grand_total), 2, '.', '')); ?></h4>
						<p class="text-center">
							<?php echo e(trans('file.Sale')); ?> <?php echo e(number_format((float)($store_sale[$key][0]->grand_total), 2, '.', '')); ?> - <?php echo e(trans('file.Purchase')); ?> <?php echo e(number_format((float)($store_purchase[$key][0]->grand_total), 2, '.', '')); ?> - <?php echo e(trans('file.Return')); ?> <?php echo e(number_format((float)($store_return[$key][0]->grand_total), 2, '.', '')); ?>

						</p>
						<hr style="border-color: rgba(0, 0, 0, 0.2);">
						<h4 class="text-center"><?php echo e(number_format((float)(($store_sale[$key][0]->grand_total - $store_sale[$key][0]->tax) - ($store_purchase[$key][0]->grand_total - $store_purchase[$key][0]->tax) - ($store_return[$key][0]->grand_total - $store_return[$key][0]->tax)), 2, '.', '')); ?></h4>
						<p class="text-center">
							Net <?php echo e(trans('file.Sale')); ?> <?php echo e(number_format((float)($store_sale[$key][0]->grand_total - $store_sale[$key][0]->tax), 2, '.', '')); ?> - Net <?php echo e(trans('file.Purchase')); ?> <?php echo e(number_format((float)($store_purchase[$key][0]->grand_total - $store_purchase[$key][0]->tax), 2, '.', '')); ?> - Net <?php echo e(trans('file.Return')); ?> <?php echo e(number_format((float)($store_return[$key][0]->grand_total - $store_return[$key][0]->tax), 2, '.', '')); ?>

						</p>
						<hr style="border-color: rgba(0, 0, 0, 0.2);">
						<h4 class="text-center"><?php echo e(number_format((float)$store_expense[$key], 2, '.', '')); ?></h4>
						<p class="text-center"><?php echo e(trans('file.Expense')); ?></p>
					</div>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
	</div>
</section>

<script type="text/javascript">

	$("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report li").eq(0).addClass("active");

	$(".daterangepicker-field").daterangepicker({
	  callback: function(startDate, endDate, period){
	    var start_date = startDate.format('YYYY-MM-DD');
	    var end_date = endDate.format('YYYY-MM-DD');
	    var title = start_date + ' to ' + end_date;
	    $(this).val(title);
	    $('input[name="start_date"]').val(start_date);
	    $('input[name="end_date"]').val(end_date);
	  }
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>