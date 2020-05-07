<?php $__env->startSection('content'); ?>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>
     <div id="store_dashboard">
	 <div class="container-fluid">
      <div class="row">
	     <div class="col-md-4">
		    <a href="<?php echo e(route('qty_adjustment.create')); ?>" class="box-link">
			   <div class="home-box">
                   <p>ادخال المواد الی المخازن و تصنیفها</p>
				   <h2><?php echo e(trans('file.in_store')); ?> <img src="<?php echo e(asset('public/images/icons/instore.png')); ?>"></h2>
               </div>			  
			</a>
	      </div>
		  <div class="col-md-4">
		    <a href="<?php echo e(route('qty_adjustment.out_store')); ?>" class="box-link">
			   <div class="home-box">
                   <p>ادخال المواد الی المخازن و تصنیفها</p>
				   <h2><?php echo e(trans('file.out_store')); ?> <img src="<?php echo e(asset('public/images/icons/outstore.png')); ?>"></h2>
               </div>			  
			</a>
	      </div>
		  <div class="col-md-4">
		    <a href="<?php echo e(route('transfers.index')); ?>" class="box-link">
			   <div class="home-box">
                   <p>ادخال المواد الی المخازن و تصنیفها</p>
				   <h2><?php echo e(trans('file.Transfers')); ?> <img src="<?php echo e(asset('public/images/icons/transferstore.png')); ?>"></h2>
               </div>			  
			</a>
	      </div>
		</div>  
	 
	  <div class="row home_Page_second_row" style="margin-top: 34px;" >
	     <div class="col-md-4">
		    <a href="<?php echo e(route('sale.index')); ?>" class="box-link">
			   <div class="home-box">
                   <p>ادخال المواد الی المخازن و تصنیفها</p>
				   <h2><?php echo e(trans('file.orders')); ?> <img src="<?php echo e(asset('public/images/icons/orders.png')); ?>"></h2>
               </div>			  
			</a>
	      </div>
		  <div class="col-md-4">
		    <a href="<?php echo e(asset('offers1')); ?>" class="box-link">
			   <div class="home-box">
                   <p>ادخال المواد الی المخازن و تصنیفها</p>
				   <h2><?php echo e(trans('file.send')); ?> <img src="<?php echo e(asset('public/images/icons/send.png')); ?>"></h2>
               </div>			  
			</a>
	      </div>
		  <div class="col-md-4">
		    <a href="<?php echo e(route('report.movement')); ?>" class="box-link">
			   <div class="home-box">
                   <p>ادخال المواد الی المخازن و تصنیفها</p>
				   <h2><?php echo e(trans('file.reports')); ?> <img src="<?php echo e(asset('public/images/icons/reports.png')); ?>"></h2>
               </div>			  
			</a>
	      </div>
		</div>  
	 
	   <div class="row" style="margin-top: 24px;">
	     <div class="col-md-4">
		     <div class="recent-query">
                   <h3><?php echo e(trans('file.last_store_in')); ?> </h3>
				   <table class="table table-hover">
				     <thead>
					    <tr><th><?php echo e(trans('file.Store')); ?> <?php echo e(trans('file.name')); ?></th><th><?php echo e(trans('file.qty')); ?></th><th><?php echo e(trans('file.View')); ?></th></tr>
					 </thead>
					 <tbody>
					    <?php $__currentLoopData = $addition; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inStorItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					      <tr><td><?php echo e($inStorItem->name); ?></td><td style="color:green"><?php echo e($inStorItem->addedQty); ?></td><td><a href="<?php echo e(asset('adjustment/view')); ?>/<?php echo e($inStorItem->reference_no); ?>/<?php echo e($inStorItem->type_invoice); ?>/in"><img src="<?php echo e(asset('public/images/icons/view.png')); ?>"></a></td></tr>
					    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					 </tbody>
				   </table>
               </div>			  
	      </div>
	     
		 <div class="col-md-4">
		     <div class="recent-query">
                   <h3><?php echo e(trans('file.last_store_out')); ?></h3>
				   <table class="table table-hover">
				     <thead style="background:">
					    <tr><th><?php echo e(trans('file.Store')); ?> <?php echo e(trans('file.name')); ?></th><th><?php echo e(trans('file.qty')); ?></th><th><?php echo e(trans('file.View')); ?></th></tr>
					 </thead>
					 <tbody>
					    <?php $__currentLoopData = $subtraction; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $outStorItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					      <tr><td><?php echo e($outStorItem->name); ?></td><td style="color:red"><?php echo e($outStorItem->minusedQty); ?></td><td><a href="<?php echo e(asset('adjustment/view')); ?>/<?php echo e($outStorItem->reference_no); ?>/<?php echo e($outStorItem->type_invoice); ?>/out"><img src="<?php echo e(asset('public/images/icons/view.png')); ?>"></a></td></tr>
					    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					 </tbody>
				   </table>
               </div>			  
	      </div>
	      <div class="col-md-4">
		     <div class="recent-query">
                   <div class="search_product">
				     <h3><?php echo e(trans('file.search_product')); ?> </h3>
				     <form method="" action="" onsubmit="return false;">
					   <span class="fa fa-search"></span>
				       <input type="text" name="serch_item" autocomplete="off" id="serch_item" class="form-control" placeholder="<?php echo e(trans('file.product_name_barcode')); ?>">
					    <div class="home-search-result">
					    </div>
				     </form>
					 </div>
					 <div class="selected_item">
					 <h5><?php echo e(trans('file.product')); ?> <?php echo e(trans('file.name')); ?></h5>
					 <h6><?php echo e(trans('file.total_qty')); ?> <span class="total_item">0</span></h6>
				   
				   <table class="table table-hover">
				     <thead>
					    <tr><th><?php echo e(trans('file.name')); ?> <?php echo e(trans('file.Store')); ?></td><th><?php echo e(trans('file.count')); ?></th></tr>
					 </thead>
					 <tbody>
					    
					   
					 </tbody>
				   </table>
				  </div> 
               </div>			  
	      </div>
	     
	  </div>  
	 
	 </div>
     </div> 	 
<style>
 .home-search-result::-webkit-scrollbar{
	 width: 5px;
 }
 .home-search-result::-webkit-scrollbar-track {
    box-shadow: outset 4px 14px 5px red; 
    border-radius: 10px;
}
.home-search-result::-webkit-scrollbar-thumb {
    background: #bbbec3; 
    border-radius: 10px;
}
</style>
<script type="text/javascript">
   var APP_URL = <?php echo json_encode(url('/')); ?>

     
	$('body').click(function(evt){    
       if(evt.target.class != "home-search-result")
          $(".home-search-result").css('display',"none");
      });

 
    $("#serch_item").keyup(function(){
		var word=$(this).val();
		$.ajax({
			url:''+APP_URL+'/search/products/'+word,
			type:'get',
			success:function(response){
				
			      $('.home-search-result').css('display','block');	
			      $('.home-search-result').html(response);
							   
			},
			error:function(){
				
			}
		})
		
	})
	
    $(".date-btn").on("click", function() {
        var index = $(this).parent('li').index();
        //alert(index);
        var start_date = $(this).data('start_date');
        var end_date = $(this).data('end_date');
        $.get('dashboard-filter/' + start_date + '/' + end_date, function(data) {
            $(".date-btn").removeClass("active");
            $("ul.filter-toggle li:eq("+index+") .date-btn").addClass("active");
            dashboardFilter(data);
        });
    });

    function dashboardFilter(data){
        $('.revenue-data').hide();
        $('.revenue-data').html(data[0]);
        $('.revenue-data').show(500);

        $('.return-data').hide();
        $('.return-data').html(data[1]);
        $('.return-data').show(500);

        $('.profit-data').hide();
        $('.profit-data').html(data[2]);
        $('.profit-data').show(500);

        $('.sale-data').hide();
        $('.sale-data').html(data[3]);
        $('.sale-data').show(500);
    }
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>