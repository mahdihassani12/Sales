@extends('layout.main')
@section('content')
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div> 
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif

<section>
    <div class="container-fluid" >
	    
        <button data-target="#adjustment_modal" data-toggle="modal" class="btn btn-info" style="display:none;"><i class="fa fa-plus"></i> {{trans('file.add')}} {{trans('file.Adjustment')}} </button>
        
	</div>
    <div class="table-responsive">
        <table id="adjustment-table" class="table table-hover purchase-list rwd-table" data-autogen-headers="true">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Date')}}</th>
                    <th>{{trans('file.reference')}} No</th>
                    <th>{{trans('file.Store')}}</th>
                    <th>{{trans('file.product')}}s</th>
                    <th>{{trans('file.type')}}</th>
                    <th>{{trans('file.Note')}}</th>
                 @if(Auth::user()->role_id==1 || Auth::user()->role_id==2 )                     
                    <th class="not-exported">{{trans('file.action')}}</th>
                 @endif
                </tr>
            </thead>
            <tbody>
                @foreach($ezpos_adjustment_all as $key=>$adjustment)
                <tr>
                    <td>{{$key}}</td>
                    <td>{{ date('d-m-Y', strtotime($adjustment->date)) }}</td>
                    <td>{{ $adjustment->reference_no }}</td>
                    <?php $store = DB::table('stores')->find($adjustment->store_id) ?>
                    <td>{{ $store->name }}</td>
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
					@if($adjustment->type=="out_store")
					  {{trans('file.out_store')}}
				    @else
					  {{trans('file.in_store')}}
					@endif
					</td>
                    <td>{{$adjustment->note}}</td>
                @if(Auth::user()->role_id==1 || Auth::user()->role_id==2 )                     
                     <td>                    
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}<span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                @if(in_array("adjusment-edit", $all_permission))
								<li>
                                    <a href="{{ route('qty_adjustment.edit', ['id' => $adjustment->id]) }}" class="btn btn-link"><i class="fa fa-edit"></i> {{trans('file.edit')}}</a> 
                                </li>
								@endif
                                <li class="divider"></li>
								
								@if(in_array("adjustment-delete", $all_permission))
                                {{ Form::open(['route' => ['qty_adjustment.destroy', $adjustment->id], 'method' => 'DELETE'] ) }}
                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> {{trans('file.delete')}}</button>
                                </li>
                                {{ Form::close() }}
								@endif
                            </ul>
                        </div>
                    </td>
                  @endif
                </tr>
                @endforeach
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
        <h4 class="modal-title">{{trans('file.add')}} {{trans('file.Adjustment')}}</h4>
      </div>
      <div class="modal-body adjustment_sections">
        <div class="row">
		     <div class="col-sm-6">
		    <a href="{{route('qty_adjustment.create')}}" class="box-link">
			   <div class="home-box">
                   <p>ادخال المواد الی المخازن و تصنیفها</p>
				   <h2>{{trans('file.in_store')}} <img src="{{asset('public/images/icons/instore.png')}}"></h2>
               </div>			  
			</a>
	      </div>
		  <div class="col-sm-6">
		    <a href="{{route('qty_adjustment.out_store')}}" class="box-link">
			   <div class="home-box">
                   <p>ادخال المواد الی المخازن و تصنیفها</p>
				   <h2>{{trans('file.out_store')}} <img src="{{asset('public/images/icons/outstore.png')}}"></h2>
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
@endsection