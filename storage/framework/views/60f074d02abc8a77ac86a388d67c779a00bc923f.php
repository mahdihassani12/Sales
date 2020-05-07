 
  <?php $__env->startSection('content'); ?>
  
<?php if(session()->has('message')): ?>
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>


<section class="container">
 <div class="page_header">
	<h4 class=""><?php echo e(trans('file.order_items')); ?> </h4>
   <form method="get" action="<?php echo e(asset('sale/group_items')); ?>">	
	<div class="row" style="border-bottom:1px solid lightgray;">
	   <div class="col-md-3 form-group ">
	   <label><?php echo e(trans('file.sales_man')); ?></label>
	      <input type="hidden" value="search" name="search">
	      <select class="form-control select_salesman_name selectpicker" data-live-search="true" data-live-search-style="begins" title="Select Saleman..." name="sales_man">
		     <option value="all" stores="all" <?php if(isset($data['salesman']) and $data['salesman']=="all"): ?> <?php echo e('selected'); ?> <?php endif; ?>><?php echo e(trans('file.all')); ?></option>
			 <?php $__currentLoopData = $data['users']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			   <option value="<?php echo e($sl->id); ?>" stores="<?php echo e($sl->store_id); ?>"  <?php if(isset($data['salesman']) and $sl->id==$data['salesman']): ?> selected="selected" <?php endif; ?>><?php echo e($sl->name); ?></option>
			 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		  </select>
	   </div>
	   
	   <div class="col-md-3 form-group ">
	   <label><?php echo e(trans('file.Store')); ?></label>
	      <select class="form-control selectpicker  salesman_store" data-live-search="true" data-live-search-style="begins" title="Select Saleman..." name="store">
		     <option value="all" <?php if(isset($data['store']) and $data['store']=="all"): ?> <?php echo e('selected'); ?> <?php endif; ?>><?php echo e(trans('file.all')); ?></option>
			 <?php $__currentLoopData = $data['stores']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			   <option value="<?php echo e($st->id); ?>" <?php if(isset($data['store']) and $st->id==$data['store']): ?> selected="selected" <?php endif; ?>><?php echo e($st->name); ?></option>
			 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		  </select>
	   </div> 
	   
     <div class="col-md-3 form-group ">
     <label><?php echo e(trans('file.category')); ?></label>
        <select class="form-control  selectpicker category" data-live-search="true" data-live-search-style="begins" title="Select category..." name="category">
         <option value="all" <?php if(isset($data['categories']) and $data['categories']=="all"): ?> <?php echo e('selected'); ?> <?php endif; ?>><?php echo e(trans('file.all')); ?></option>
       <?php $__currentLoopData = $data['categories']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <option value="<?php echo e($ct->id); ?>" <?php if(isset($data['category']) and $ct->id==$data['category']): ?> selected="selected" <?php endif; ?>><?php echo e($ct->name); ?></option>
       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
     </div> 
       <div class="col-md-3 form-group ">
     <label><?php echo e(trans('file.sub_category')); ?></label>
        <select class="form-control  selectpicker category" data-live-search="true" data-live-search-style="begins" title="Select Sub category..." name="subcategory">
         <option value="all" <?php if(isset($data['subcategory']) and $data['subcategory']=="all"): ?> <?php echo e('selected'); ?> <?php endif; ?>><?php echo e(trans('file.all')); ?></option>
       <?php $__currentLoopData = $data['subcategories']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <option value="<?php echo e($sct->id); ?>" <?php if(isset($data['subcategory']) and $sct->id==$data['subcategory']): ?> selected="selected" <?php endif; ?>><?php echo e($sct->name); ?></option>
       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
     </div>
	 
	   <div class="col-md-2 form-group">
	      <label><?php echo e(trans('file.From')); ?> <?php echo e(trans('file.Date')); ?></label>
	      <input class="form-control date " name="from_date" autocomplete="off" <?php if(isset($data['start_date'])): ?> value="<?php echo e($data['start_date']); ?>" <?php endif; ?>>
	   </div>
	    <div class="col-md-2 form-group">
	      <label><?php echo e(trans('file.To')); ?> <?php echo e(trans('file.Date')); ?></label>
	      <input class="form-control date " name="to_date" autocomplete="off" <?php if(isset($data['end_date'])): ?> value="<?php echo e($data['end_date']); ?>" <?php endif; ?>>
	   </div>
	   <div class="col-md-2 form-group">
        <label style="visibility:hidden">search</label>
		<input type="submit" class="btn btn-primary form-control" value="<?php echo e(trans('file.search')); ?>">
	   </div>
	   
	    <div class="col-md-2 form-group">
        <label style="visibility:hidden">print</label>
		<input onclick="print()" type="button" class="btn btn-warning form-control" value="<?php echo e(trans('file.Print')); ?>">
	   </div>
	</div>
	</form>
 </div>	
  <div style="text-align:center;display:none;" class="print_page_header">
      <h2><?php echo e(trans('file.From')); ?> <?php echo e(trans('file.date')); ?> <?php if(isset($data['start_date'])): ?>  <?php echo e($data['start_date']); ?>   <?php endif; ?></h2>
      <h2><?php echo e(trans('file.To')); ?> <?php echo e(trans('file.date')); ?> <?php if(isset($data['end_date'])): ?>  <?php echo e($data['end_date']); ?>   <?php endif; ?> </h2>
  </div>
	<div class="main_container">
	   <table class="table rwd-table"  id="report-table">
	      <thead>
		     <tr>
		      <th class="not-exported"></th>
		      <th>No.</th>
		      <th><?php echo e(trans('file.product')); ?>.</th>
          <th><?php echo e(trans('file.arabic_name')); ?>.</th>
		      <th><?php echo e(trans('file.sub_category')); ?>.</th>
		      <th><?php echo e(trans('file.category')); ?>.</th>
		      <th><?php echo e(trans('file.Code')); ?>.</th>
		      <th><?php echo e(trans('file.qty')); ?>.</th>
		      <th><?php echo e(trans('file.date')); ?>.</th>
		      <th>اسم الموظف</th>
		     </tr>
		  </thead>
		  <?php $counter=1;?>
		 <tbody> 
		  <?php if(isset($data['products']) and count($data['products'])>0): ?>
			 <?php $__currentLoopData = $data['products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			 <tr>
			    <td></td>
		        <td><?php echo e($counter); ?></td>
		        <td><?php echo e($pr->prname); ?></td>
                <td><?php echo e($pr->arname); ?></td>
		        <td>
					<?php if($pr->parentCategory!=null): ?>
					<?php echo e($pr->cateName); ?>

					<?php else: ?> 
					<?php echo e('N\A'); ?>

					<?php endif; ?>				
				 </td>
				 <td>
					<?php if($pr->parentCategory==null): ?>
					  <?php echo e($pr->cateName); ?>

					<?php else: ?> 
					  <?php $category=DB::table('categories')->where('id',$pr->parentCategory)->get(); if(count($category)>0): echo $category[0]->name; endif;?> 
					<?php endif; ?>
				 </td>
		        <td><?php echo e($pr->prcode); ?></td>
		        <td><?php echo e($pr->totalqty); ?></td>
		        <td><?php echo e($pr->created_at); ?></td>
		        <td><?php echo e($pr->username); ?> </td>
             </tr>	
            <?php $counter++;?>			 
			 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
		  <?php endif; ?> 
			</body> 
			<tfoot class="tfoot active">
                <th></th>
                <th>اجمالي الكمية</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                
            </tfoot>
	   </table>
	</div>
</section>
  <style>
     @media  print{
		 .page_header,.default_page_design .dataTables_filter, .dataTables_length, .dt-buttons,div.dataTables_wrapper div.dataTables_filter,div.dataTables_wrapper div.dataTables_info,div.dataTables_wrapper div.dataTables_paginate{
			 display:none;
		 }
		 .print_page_header{
			 display:block !important;
		 }
		 
	 }
  </style>
  <script>
  
   $(document).ready(function() {
  $('.select_salesman_name').change(function() {	  
    var filter = $("option:selected", this).attr("stores");
    
	if(filter=="all"){
		$('.salesman_store option').each(function() {	
		$(this).show();
        $('.salesman_store').val(filter);
    });
	}
	else{
    filter=filter.split("-");
	$('.salesman_store option').each(function() {
	    
	  if (filter.includes($(this).val())==true || $(this).val()=="all") {	
		$(this).show();
      } else {
        $(this).hide();
      }
      $('.salesman_store').val(filter);
      //$('.selectpicker').selectpicker();
	});
	} 
  });
});

    var date = $('.date');
    date.datepicker({
     format: "yyyy-mm-dd",
     startDate: "<?php echo date('Y-m-d', strtotime('')); ?>",
     autoclose: true,
     todayHighlight: true
     });
	 
	 
	
    $('#report-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0]
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
		drawCallback: function () {
            var api = this.api();
            datatable_sum(api, false);
        }
    } );


	 function datatable_sum(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();

            $( dt_selector.column( 7 ).footer() ).html(dt_selector.cells( rows, 7, { page: 'current' } ).data().sum().toFixed(0));
        }
        else {
            $( dt_selector.column( 7 ).footer() ).html(dt_selector.cells( rows, 7, { page: 'current' } ).data().sum().toFixed(0));
        }
    }
	
  </script>
  <?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>