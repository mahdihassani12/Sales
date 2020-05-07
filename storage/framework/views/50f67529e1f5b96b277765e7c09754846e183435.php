 <?php $__env->startSection('content'); ?>

<section>
	<h4 class="text-center"><?php echo e(trans('file.select')); ?> <?php echo e(trans('file.Store')); ?> </h4>
	<div class="container list_of_item" style='padding:0px 110px;'>
       <select class='form-control select_store '>
	       <option value="all" store_name="<?php echo e(trans('file.all')); ?>"><?php echo e(trans('file.all')); ?></option>
		   <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		     <option value='<?php echo e($store->id); ?>' store_name="<?php echo e($store->name); ?>"><?php echo e($store->name); ?> </option>
		   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	   </select>
	   <h3 style="padding:20px 0px 5px; border-bottom:1px solid gray;margin-bottom:20px "><?php echo e(trans('file.all')); ?> <?php echo e(trans('item')); ?> <?php echo e(trans('in')); ?> <span id='store_name'>-----</span> <?php echo e(trans('file.Store')); ?></h3>
	   <div id="store_items">
	   
	   </div>
    </div>
</section>
<style>
@media(max-width:992px){
  .list_of_item{
	  padding:0px !important;
  }
  .container{
	  max-width:98%;
  }
}
</style>
<script type="text/javascript">
    var APP_URL = <?php echo json_encode(url('/')); ?>


	
   $('.selectpicker').selectpicker({
	  style: 'btn-link',
	});
	
  $(".select_store").change(function(){
	 var store_id=$(this).val(); 
	 var storeName=$('option:selected', this).attr('store_name');
	 $.ajax({
		url:APP_URL+'/report/store_item/'+store_id,
        type:'get',
        success:function(response){
			$("#store_items").html(response);
			$("#store_name").html(storeName);
		},
       error:function(){
		   alert('no');
	   }		
	 });
  });	
  
  
    $("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report li").eq(10).addClass("active");

    $('#report-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': 0
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
            }
        ],
    } );

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>