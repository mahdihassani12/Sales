
@extends('layout.nmain')
@section('content')
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
<style>
  .dashboard-counts .container-fluid .col-md-3{
	  padding-left:5px; 
	  padding-right:5px;
  }
  .count-title .icon{
	 color: #fff !important;
    font-size: 45px !important;
    border: none;
	width:auto; 
	height:auto;
	line-height:0;
  }
  .count-title span.label{
	width: 33px;
    height: 32px;
    border-radius: 50%;
    float: left;
    background: rgba(0,0,0,0.1) !important;
    padding: 9px;
    color: #fff;
	font-size:11px;
  }
  .count-title h1{
    margin-top: 10px;
    margin-bottom: 0px;
    font-size: 26px;
	color:#fff;
  }
 .count-title p{
	  color:#fff;
	  font-size:13px;
	  margin-bottom:0px;
  }
</style>

      <div class="row" >
	   <div class="container-fluid" style="margin-top:20px;">
	     <h2 style="padding:11px">{{trans('file.dashboard')}} <span style="float:left;font-size:19px;"><i class="fa fa-play" style="margin-left:10px;border:1px soild #fff;"></i><i class="fa fa-play" style="transform:rotate(180deg);border:1px soild #fff"></i></span></h2>
	   </div>
        <div class="container-fluid" style="display:none">
          <div class="col-md-12">
            <div class="brand-text float-left mt-4">
                <h3>{{trans('file.welcome')}} <span>{{Auth::user()->name}}</span> </h3>
            </div>
			
            <ul class="filter-toggle">
              <li><button class="btn btn-primary btn-sm date-btn" data-start_date="{{date('Y-m-d')}}" data-end_date="{{date('Y-m-d')}}">{{trans('file.Today')}}</button></li>
              <li><button class="btn btn-primary btn-sm date-btn" data-start_date="{{date('Y-m-d', strtotime(' -7 day'))}}" data-end_date="{{date('Y-m-d')}}">{{trans('file.Last 7 Days')}}</button></li>
              <li><button class="btn btn-primary btn-sm date-btn active" data-start_date="{{date('Y').'-'.date('m').'-'.'01'}}" data-end_date="{{date('Y-m-d')}}">{{trans('file.This Month')}}</button></li>
              <li><button class="btn btn-primary btn-sm date-btn" data-start_date="{{date('Y').'-01'.'-01'}}" data-end_date="{{date('Y').'-12'.'-31'}}">{{trans('file.This Year')}}</button></li>
            </ul>
          </div>
        </div>
      </div>
      <!-- Counts Section -->
      <section class="dashboard-counts ">
        <div class="container-fluid">
          <div class="row">
            <!-- Count item widget-->
            <div class="col-md-3">
              <div class="wrapper count-title home-buttons" data-toggle="modal" data-target="#jsells_modal" style="background:linear-gradient(to left, #15c3ae, #44cc68)">
                <div class="row">
				   <div class="col-sm-12">
				     <i class="icon ion-ios-cart"></i>
					 <span class="label">7/8</span>
				   </div>
				   <div class="col-sm-12">
				      <h1>واجهه المبیعات</h1>
					  <p>واجهه البیع و الکاشیر</p>
				   </div>
				</div>
              </div>
            </div>
            <!-- Count item widget-->
            <div class="col-md-3">
              <div class="wrapper count-title  home-buttons" style="border-radius:13px;background:linear-gradient(to left, #9d1cd2, #3b7ffb)">
                <div class="row">
				   <div class="col-sm-12">
				     <i class="icon ion-ios-cart"></i>
					 <span class="label">7/8</span>
				   </div>
				   <div class="col-sm-12">
				      <h1>واجهه المبیعات</h1>
					  <p>واجهه البیع و الکاشیر</p>
				   </div>
				</div>
              </div>
            </div>
            <!-- Count item widget-->
            <div class="col-md-3">
              <div class="wrapper count-title d-flex home-buttons" style="border-radius:13px;background:linear-gradient(to left, #ff5479, #ff9475)">
                <div class="row">
				   <div class="col-sm-12">
				     <i class="icon ion-ios-cart"></i>
					 <span class="label">7/8</span>
				   </div>
				   <div class="col-sm-12">
				      <h1>واجهه المبیعات</h1>
					  <p>واجهه البیع و الکاشیر</p>
				   </div>
				</div>
              </div>
            </div>
            <!-- Count item widget-->
            <div class="col-md-3">
              <div class="wrapper count-title d-flex home-buttons" style="background:linear-gradient(to left, #2b9cff, #01c3fe);border-radius:13px;">
                 <div class="row">
				   <div class="col-sm-12">
				     <i class="icon ion-ios-cart"></i>
					 <span class="label">7/8</span>
				   </div>
				   <div class="col-sm-12">
				      <h1>واجهه المبیعات</h1>
					  <p>واجهه البیع و الکاشیر</p>
				   </div>
				</div>
              </div>
            </div>
          
		  </div>
        </div>
      </section>
      <section class="mb-30px" style="display:none">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h4>{{trans('file.yearly report')}}</h4>
                </div>
                <div class="card-body">
                  <canvas id="saleChart" data-sale_chart_value = "{{json_encode($yearly_sale_amount)}}" data-purchase_chart_value = "{{json_encode($yearly_purchase_amount)}}"></canvas>
                </div>
              </div>
            </div>
            <div class="col-md-7">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4>{{trans('file.Recent Transaction')}}</h4>
                  <div class="right-column">
                    <div class="badge badge-primary">{{trans('file.latest')}} 5</div>
                  </div>
                </div>
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" href="#sale-latest" role="tab" data-toggle="tab">{{trans('file.Sale')}}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#purchase-latest" role="tab" data-toggle="tab">{{trans('file.Purchase')}}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#return-latest" role="tab" data-toggle="tab">{{trans('file.Return')}}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#payment-latest" role="tab" data-toggle="tab">{{trans('file.Payment')}}</a>
                  </li>
                </ul>

                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane show active" id="sale-latest">
                      <div class="table-responsive">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>{{trans('file.date')}}</th>
                              <th>{{trans('file.reference')}}</th>
                              <th>{{trans('file.customer')}}</th>
                              <th>{{trans('file.status')}}</th>
                              <th>{{trans('file.grand total')}}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($recent_sale as $sale)
                            <?php $customer = DB::table('customers')->find($sale->customer_id); ?>
                            <tr>
                              <td>{{date('d-m-Y', strtotime($sale->date))}}</td>
                              <td>{{$sale->reference_no}}</td>
                              <td>{{$customer->name}}</td>
                              @if($sale->sale_status == 1)
                              <td><div class="badge badge-success">Completed</div></td>
                              @else
                              <td><div class="badge badge-danger">Pending</div></td>
                              @endif
                              <td>{{$sale->grand_total}}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="purchase-latest">
                      <div class="table-responsive">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>{{trans('file.date')}}</th>
                              <th>{{trans('file.reference')}}</th>
                              <th>{{trans('file.Supplier')}}</th>
                              <th>{{trans('file.status')}}</th>
                              <th>{{trans('file.grand total')}}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($recent_purchase as $purchase)
                            <?php $supplier = DB::table('suppliers')->find($purchase->supplier_id); ?>
                            <tr>
                              <td>{{date('d-m-Y', strtotime($purchase->date))}}</td>
                              <td>{{$purchase->reference_no}}</td>
                              @if($supplier)
                                <td>{{$supplier->name}}</td>
                              @else
                                <td>N/A</td>
                              @endif
                              @if($purchase->status == 1)
                              <td><div class="badge badge-success">Recieved</div></td>
                              @elseif($purchase->status == 2)
                              <td><div class="badge badge-success">Partial</div></td>
                              @elseif($purchase->status == 3)
                              <td><div class="badge badge-danger">Pending</div></td>
                              @else
                              <td><div class="badge badge-danger">Ordered</div></td>
                              @endif
                              <td>{{$purchase->grand_total}}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="return-latest">
                      <div class="table-responsive">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>{{trans('file.date')}}</th>
                              <th>{{trans('file.reference')}}</th>
                              <th>{{trans('file.customer')}}</th>
                              <th>{{trans('file.grand total')}}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($recent_return as $return)
                            <?php $customer = DB::table('customers')->find($return->customer_id); ?>
                            <tr>
                              <td>{{date('d-m-Y', strtotime($return->date))}}</td>
                              <td>{{$return->reference_no}}</td>
                              <td>{{$customer->name}}</td>
                              <td>{{$return->grand_total}}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="payment-latest">
                      <div class="table-responsive">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>{{trans('file.date')}}</th>
                              <th>{{trans('file.reference')}}</th>
                              <th>{{trans('file.Amount')}}</th>
                              <th>{{trans('file.Paid')}} {{trans('file.By')}}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($recent_payment as $payment)
                            <tr>
                              <td>{{date('d-m-Y', strtotime($payment->date))}}</td>
                              <td>{{$payment->payment_reference}}</td>
                              <td>{{$payment->amount}}</td>
                              <td>{{$payment->paying_method}}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-5">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4>{{trans('file.best selling product').' '.date('F')}}</h4>
                  <div class="right-column">
                    <div class="badge badge-primary">{{trans('file.top')}} 5</div>
                  </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>SL No</th>
                          <th>{{trans('file.product details')}}</th>
                          <th>{{trans('file.qty')}}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($best_selling_qty as $key=>$sale)
                        <?php $product = DB::table('products')->find($sale->product_id); ?>
                        <tr>
                          <td>{{$key + 1}}</td>
                          <td>{{$product->name .'-'.$product->code}}</td>
                          <td>{{$sale->sold_qty}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4>{{trans('file.best selling product').' '.date('Y'). '('.trans('file.qty').')'}}</h4>
                  <div class="right-column">
                    <div class="badge badge-primary">{{trans('file.top')}} 5</div>
                  </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>SL No</th>
                          <th>{{trans('file.product details')}}</th>
                          <th>{{trans('file.qty')}}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($yearly_best_selling_qty as $key => $sale)
                        <?php $product = DB::table('products')->find($sale->product_id); ?>
                        <tr>
                          <td>{{$key + 1}}</td>
                          <td>{{$product->name .'-'.$product->code}}</td>
                          <td>{{$sale->sold_qty}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4>{{trans('file.best selling product').' '.date('Y') . '('.trans('file.price').')'}}</h4>
                  <div class="right-column">
                    <div class="badge badge-primary">{{trans('file.top')}} 5</div>
                  </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>SL No</th>
                          <th>{{trans('file.product details')}}</th>
                          <th>{{trans('file.grand total')}}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($yearly_best_selling_price as $key => $sale)
                        <?php $product = DB::table('products')->find($sale->product_id); ?>
                        <tr>
                          <td>{{$key + 1}}</td>
                          <td>{{$product->name .'-'.$product->code}}</td>
                          <td>{{number_format((float)$sale->total_price, 2, '.', '')}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </section>
	  
	  
	  <!-- Modal -->
<div id="jsells_modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span> اغلاق </span>&times;</button>
        <h4 class="modal-title">واجهه المبیعات</h4>
      </div>
      <div class="modal-body">
        <div class="sell_section">
		  <div class="sell_content">
		     <img src="{{asset('public/images/icons/shop.png')}}">
			 <h3>نقطه البیع</h3>
			 <p>تشمل فواتر بیع مباشره لازبون و فواتر معله و واجهه مبیعات متکامله للکاشیر</p>
		  
		  </div>
		</div>
		 <div class="sell_section">
		  <div class="sell_content">
		     <img src="{{asset('public/images/icons/shop.png')}}">
			 <h3>نقطه مندوب</h3>
			 <p>تشمل فواتر بیع مباشره لازبون و فواتر معله و واجهه مبیعات متکامله للکاشیر</p>
		  
		  </div>
		</div>
		 <div class="sell_section">
		  <div class="sell_content">
		     <img src="{{asset('public/images/icons/shop.png')}}">
			 <h3>نقطه البضایع</h3>
			 <p>تشمل فواتر بیع مباشره لازبون و فواتر معله و واجهه مبیعات متکامله للکاشیر</p>
		  </div>
		</div>
		 <div class="sell_section">
		  <div class="sell_content">
		    <img src="{{asset('public/images/icons/shop.png')}}">
			 <h3>البطاقات</h3>
			 <p>تشمل فواتر بیع مباشره لازبون و فواتر معله و واجهه مبیعات متکامله للکاشیر</p>
		  </div>
		</div>
		 <div class="sell_section">
		  <div class="sell_content">
		     <img src="{{asset('public/images/icons/shop.png')}}">
			 <h3>قوایم البیع</h3>
			 <p>تشمل فواتر بیع مباشره لازبون و فواتر معله و واجهه مبیعات متکامله للکاشیر</p>
		  </div>
		</div>
      </div>
    </div>

  </div>
</div>
	  
	  
<script type="text/javascript">

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
@endsection

