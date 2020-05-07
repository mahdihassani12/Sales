 

 <?php $__env->startSection('content'); ?>
   <div class="print_area" >
       <div class="site-logo">
	     <img src="<?php echo e(asset('public/logo/site_logo.png')); ?>">
	   </div>	
       <div class="row invoice">
	    <?php if(isset($data['order']) and count($data['order'])>0): ?>
				<?php $__currentLoopData = $data['order']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	      <div class="col-md-8 col-sm-12 col-xs-12 customer_details">
		       <h1> اسم الزبون:  <span> <?php echo e($order->customer_name); ?><span></h1>
		       <h1> رقم الهاتف: <span> <?php echo e($order->customer_phone); ?><span></h1>
		       <?php if($order->is_marketer_order=="1"): ?>
			   <h1> ملاحظات الطلب: <span> <?php echo e($order->marketer_note); ?><span></h1>
		       <?php else: ?>
			   <h1> المخزن <span> <?php echo e($order->storeName); ?><span></h1>
		       <?php endif; ?>
		  </div>
		  <div class="col-md-4 col-sm-12 col-xs-12 bill_details">
		       <h1> رقم الفاتورة: <span> <?php echo e($order->id); ?><span></h1>
		       <h1>  التاريخ: <span> <?php echo explode(' ',$order->created_at)[0];?><span></h1>
		  </div>
		  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>  
	   </div>
      
	   <table class="table items_table">
	      <thead>
		     <tr>
			   <th>ت</th>
			   <th>اسم المنتج</th>
			   <th> الاسم العربي</th>
			   <th>باركود</th>
			   <th>الكمية</th>
			 </tr>
		  </thead>
		  <tbody>
		   <?php $counter=1;?>
		   <?php $qr_code_data="";?>
		    <?php if(isset($data['orderItems']) and count($data['orderItems'])>0): ?>
				<?php $__currentLoopData = $data['orderItems']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			    <tr>
                   <td><?php echo e($counter); ?></td> 
                   <td><?php echo e($items->name); ?></td> 
                   <td><?php echo e($items->arabic_name); ?></td> 
                   <td><?php echo e($items->barcode); ?></td> 
                   <td><?php echo e($items->product_qty); ?></td> 
		         </tr>
			   <?php $counter++;?>
			   <?php $qr_code_data.=$items->barcode.' - '.$items->product_price.' - '.$items->product_qty.' <-----> ';?>
			   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php endif; ?>
		  </tbody>
	   </table>
	   
	    <?php if($qr_code_data==""){
		   $qr_code_data="null";
	   }
	   ?>
	   
	  <?php if(isset($data['order']) and count($data['order'])>0): ?>
		<?php $__currentLoopData = $data['order']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>		
	   <div class="row price_detials" style="display:none">
	      <div class="col-md-4 total">الاجمالي:  <?php echo e($order->subtotal); ?> </div>
	      <div class="col-md-4 shipping">كلفة التوصيل: <?php echo e($order->shipping_cost); ?></div>
	      <div class="col-md-4 grand_total">المبلغ النهائي: <?php echo e($order->total); ?></div>
	   </div>
	   
	   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php endif; ?> 
	  
	   <div style="text-align:center; margin-top:40px" >
	   </div>
	   <div class="qr_code" style="display:none">
             
	      <?php echo QrCode::generate($qr_code_data);; ?>

	   </div>
	   
    </div>
	
<style>
.header, nav.side-navbar ,.main-footer{
	display:none; 
}
.page{width:100%;}
.qr_code{
	text-align:center;
	margin-top:20px;
	
}
.qr_code svg{
	width:200px;
	height:200px;
}
.print_area{
	margin:30px 50px;
	background:#fff;
	padding:50px;
	
}
.print_area:before{
	content:"";
	background-image:url("<?php echo asset('public/logo/site_logo.png')?>");
    background-repeat: no-repeat;
    background-size: 300px;
    background-position: 500px 200px;
	-khtml-opacity:.10; 
 -moz-opacity:.10; 
 -ms-filter:"alpha(opacity=10)";
  filter:alpha(opacity=10);
  filter: progid:DXImageTransform.Microsoft.Alpha(opacity=0.2);
  opacity:.10; 
  width:100%;
  height:100%;
  position:absolute;
  right:0px;
}
.print_area .site-logo{
	text-align:center;
}
.price_detials{
	color:#000; 
	font-size:16px;
	font-weight:bold;	
}
.price_detials .shipping{
	text-align:center;
}
.price_detials .grand_total{
	text-align:left;
}
.btn.btn-primary.btn-lg{
	margin-top:30px;
}
.print_area .site-logo img{
	width:161px;
	border-bottom:1px solid black;
	padding-bottom:15px;
}

.print_area .invoice  h1{
	font-size:18px; 
	color:#707070;
	margin-bottom:15px;
}
.print_area .invoice h1 span{
	font-weight:bold; 
	color:#393939;
	margin-right:12px;
}
.print_area .invoice  .bill_details{
	text-align:left;
}
.items_table{
  border:1px solid #707070;	
}
.items_table thead{
	background:#00b76e;
	color:#fff;
}
.table th{
	border:none
}
.table td{
	border-bottom:1px solid #707070;
	color:#000000;
	font-size:14px;
	font-weight:500;
}
@media(max-width:450px){
	.print_area{
	  padding:10px !important;
	  margin:0px !important;
	}
	.customer_details{
		width:100% !important;
	}
}

@media  print{
	.fronted_body .side-navbar,header.header, .btn.btn-primary.btn-lg{
		display:none;
	}
	.fronted_body .page{
		width:100%;
	}
	.items_table thead{
		color:#000;
	}
	.qr_code{
		display:block;
	}
}
</style>
 <?php $__env->stopSection(); ?>
 
 <?php $__env->startSection('scripts'); ?>;

 <script>
     print();
    $(document).ready(function(){
		
	});
   
 </script>
	<?php $__env->stopSection(); ?>
 

<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>