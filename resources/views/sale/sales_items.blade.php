@extends('layout.main') 
  @section('content')
  
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div> 
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif


<section class="container">
 <div class="page_header">
	<h4 class="">{{trans('file.order_items')}} </h4>
   <form method="get" action="{{asset('sale/items_sales')}}">	
	<div class="row" style="border-bottom:1px solid lightgray;">
	   <div class="col-md-3 form-group ">
	   <label>{{trans('file.sales_man')}}</label>
	      <input type="hidden" value="search" name="search">
	      <select class="form-control selectpicker	 select_salesman_name" data-live-search="true" data-live-search-style="begins" title="Select Saleman..." name="sales_man">
		     <option value="all" stores="all" @if(isset($data['salesman']) and $data['salesman']=="all") {{'selected'}} @endif>{{trans('file.all')}}</option>
			 @foreach($data['users'] as $sl)
			   <option stores="{{$sl->store_id}}" value="{{$sl->id}}" @if(isset($data['salesman']) and $sl->id==$data['salesman']) selected="selected" @endif>{{$sl->name}}</option>
			 @endforeach
		  </select>
	   </div> 
	   
	    <div class="col-md-3 form-group ">
	   <label>{{trans('file.Store')}}</label>
	      <select class="form-control  selectpicker salesman_store" data-live-search="true" data-live-search-style="begins" title="Select Saleman..." name="store">
		     <option value="all" @if(isset($data['store']) and $data['store']=="all") {{'selected'}} @endif>{{trans('file.all')}}</option>
			 @foreach($data['stores'] as $st)
			   <option value="{{$st->id}}" @if(isset($data['store']) and $st->id==$data['store']) selected="selected" @endif>{{$st->name}}</option>
			 @endforeach
		  </select>
	   </div> 

      <div class="col-md-3 form-group ">
     <label>{{trans('file.category')}}</label>
        <select class="form-control  selectpicker category" data-live-search="true" data-live-search-style="begins" title="Select category..." name="category">
         <option value="all" @if(isset($data['category']) and $data['category']=="all") {{'selected'}} @endif>{{trans('file.all')}}</option>
       @foreach($data['categories'] as $ct)
         <option value="{{$ct->id}}" @if(isset($data['category']) and $ct->id==$data['category']) selected="selected" @endif>{{$ct->name}}</option>
       @endforeach
      </select>
     </div> 
	   
      <div class="col-md-3 form-group ">
     <label>{{trans('file.sub_category')}}</label>
        <select class="form-control  selectpicker category" data-live-search="true" data-live-search-style="begins" title="Select Sub category..." name="subcategory">
         <option value="all" @if(isset($data['subcategory']) and $data['subcategory']=="all") {{'selected'}} @endif>{{trans('file.all')}}</option>
       @foreach($data['subcategories'] as $sct)
         <option value="{{$sct->id}}" @if(isset($data['subcategory']) and $sct->id==$data['subcategory']) selected="selected" @endif>{{$sct->name}}</option>
       @endforeach
      </select>
     </div> 	 

	 <div class="col-md-2 form-group">
	      <label>{{trans('file.From')}} {{trans('file.Date')}}</label>
	      <input class="form-control date " name="from_date" autocomplete="off" @if(isset($data['start_date'])) value="{{$data['start_date']}}" @endif>
	   </div>
	    <div class="col-md-2 form-group">
	      <label>{{trans('file.To')}} {{trans('file.Date')}}</label>
	      <input class="form-control date " name="to_date" autocomplete="off" @if(isset($data['end_date'])) value="{{$data['end_date']}}" @endif>
	   </div>
	   <div class="col-md-2 form-group">
        <label style="visibility:hidden">search</label>
		<input type="submit" class="btn btn-primary form-control" value="{{trans('file.search')}}">
	   </div>
	   
	    <div class="col-md-2 form-group">
        <label style="visibility:hidden">print</label>
		<input onclick="print()" type="button" class="btn btn-warning form-control" value="{{trans('file.Print')}}">
	   </div>
	</div>
	</form>
 </div>	
  <div style="text-align:center;display:none;" class="print_page_header">
      <h2>{{trans('file.From')}} {{trans('file.date')}} @if(isset($data['start_date']))  {{$data['start_date']}}   @endif</h2>
      <h2>{{trans('file.To')}} {{trans('file.date')}} @if(isset($data['end_date']))  {{$data['end_date']}}   @endif </h2>
  </div>
	<div class="main_container">
	   <table class="table rwd-table"  id="report-table">
	      <thead>
		     <tr>
		      <th class="not-exported"></th>
		      <th>No.</th>
		      <th>{{trans('file.product')}}.</th>
          <th>{{trans('file.arabic_name')}}.</th>
		      <th>{{trans('file.sub_category')}}.</th>
		      <th>{{trans('file.category')}}.</th>
		      <th>{{trans('file.Code')}}.</th>
		      <th>{{trans('file.qty')}}.</th>
		      <th>{{trans('file.date')}}.</th>
		      <th>اسم الموظف</th>
		     </tr>
		  </thead>
		  <?php $counter=1;?>
		 <tbody> 
		  @if(isset($data['products']) and count($data['products'])>0)
			 @foreach ($data['products'] as $pr)
			 <tr>
			    <td></td>
		        <td>{{$counter}}</td>
		        <td>{{$pr->prname}}</td>
                <td>{{$pr->arname}}</td>
		        <td>
					@if($pr->parentCategory!=null)
					{{$pr->cateName}}
					@else 
					{{'N\A'}}
					@endif				
				 </td>
				 <td>
					@if($pr->parentCategory==null)
					  {{$pr->cateName}}
					@else 
					  <?php $category=DB::table('categories')->where('id',$pr->parentCategory)->get(); if(count($category)>0): echo $category[0]->name; endif;?> 
					@endif
				 </td>
		        <td>{{$pr->prcode}}</td>
		        <td>{{$pr->qty}}</td>
		        <td>{{$pr->created_at}}</td>
		        <td>{{$pr->username}} </td>
             </tr>	
            <?php $counter++;?>			 
			 @endforeach 
		  @endif 
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
     @media print{
		 .page_header,.default_page_design .dataTables_filter, .dataTables_length, .dt-buttons,div.dataTables_wrapper div.dataTables_filter,div.dataTables_wrapper div.dataTables_info,div.dataTables_wrapper div.dataTables_paginate{
			 display:none;
		 }
		 .print_page_header{
			 display:block !important;
		 }
		 
	 }
  </style>
  <script>
  /* $(document).ready(function() {
    var filter = $("option:selected", ".select_salesman_name").attr("stores");
	if(filter=="all"){
		$('.salesman_store option').each(function() {	
		$(this).show();
        $('.salesman_store').val(filter);
    });
	}
	else{
    filter=filter.split("-");
	$('.salesman_store option').each(function() {
	    
	  if (filter.includes($(this).val())==true) {	
		$(this).show();
      } else {
        $(this).hide();
      }
      $('.salesman_store').val(filter);
    });
	}
  });
 
   */
 
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
     });

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
  @endsection