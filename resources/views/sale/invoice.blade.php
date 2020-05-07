<style type="text/css">
@media print {
    #print-btn { display: none }
    #sale-list { display: none }
    .printarea { -webkit-print-color-adjust: exact }
    table.listthead { page-break-inside:auto }
    table.listthead tr { page-break-inside:avoid; page-break-after:auto }
    table.listthead thead { display:table-header-group }
    table.listthead tfoot { display:table-footer-group }
}
</style>
<title>{{$general_setting->site_title}}</title>
<style type="text/css">
    h1 {
        color: #7c5cc4;
    }
    #print-btn {
        font-weight: 400;
        border: 1px solid transparent;
        padding: 0.55rem 0.75rem;
        font-size: 0.9rem;
        line-height: 1.5;
        border-radius: 0;
        background-color: #17a2b8;
        border-color: #17a2b8;
        color: #fff;
    }
    #sale-list {
        font-weight: 400;
        border: 1px solid transparent;
        padding: 0.55rem 0.75rem;
        font-size: 0.9rem;
        line-height: 1.5;
        border-radius: 0;
        background-color: #7c5cc4;
        border-color: #7c5cc4;
        color: #fff;
        text-decoration: none;
    }
    @media print {
    #print-btn { display: none }
    #sale-list { display: none }
    .printarea { -webkit-print-color-adjust: exact }
    table.listthead { page-break-inside:auto }
    table.listthead tr { page-break-inside:avoid; page-break-after:auto }
    table.listthead thead { display:table-header-group }
    table.listthead tfoot { display:table-footer-group }
}
</style>

&nbsp;<button type="button" id="print-btn">{{trans('file.Print')}}</button>&nbsp;
<a id="sale-list" href="{{route('sale.index')}}">{{trans('file.Go To')}} {{trans('file.Sale')}} {{trans('file.List')}}</a>
<div class="printarea" style="margin: 75px 50px; font-family: Arial">
    <table style="width: 100%" cellpadding="5px">
        <tr>

            <td style="width: 50%">
                <h1>{{trans('file.Invoice')}}</h1>
                <table style="width: 100%" cellpadding="5px" cellspacing="0">
                    <tr style="background-color: #8cc98d">
                        <td style="width: 33.33%; border: 1px solid rgba(0,0,0,0.3)">{{trans('file.Invoice')}} No.</td>
                        <td style="width: 33.33%; border: 1px solid rgba(0,0,0,0.3)">{{trans('file.date')}}</td>
                        <td style="width: 33.33%; border: 1px solid rgba(0,0,0,0.3)">{{trans('file.Payment')}} {{trans('file.Mode')}}</td>
                    </tr>
                    <tr>
                        <td style="width: 33.33%; border: 1px solid rgba(0,0,0,0.3)">{{$ezpos_sale_data->reference_no}}</td>
                        <td style="width: 33.33%; border: 1px solid rgba(0,0,0,0.3)">{{$ezpos_sale_data->created_at->toDateString()}}</td>
                        @if($ezpos_sale_data->payment_status == 1)
                        <td style="width: 33.33%; border: 1px solid rgba(0,0,0,0.3)">Pending</td>
                        @elseif($ezpos_sale_data->payment_status == 2)
                        <td style="width: 33.33%; border: 1px solid rgba(0,0,0,0.3)">Due</td>
                        @elseif($ezpos_sale_data->payment_status == 3)
                        <td style="width: 33.33%; border: 1px solid rgba(0,0,0,0.3)">Partial</td>
                        @elseif($ezpos_sale_data->payment_status == 4)
                        <td style="width: 33.33%; border: 1px solid rgba(0,0,0,0.3)">Paid</td>
                        @endif
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="height: 30px"><td></td><td></td></tr>
        <tr>
            <td style="background-color: #8cc98d; width: 50%">
                <strong>{{trans('file.Bill')}} {{trans('file.To')}}</strong>
            </td>
            <td style="width: 50%"></td>
        </tr>
        <tr>            
            <td style="width: 50%">
                      
			    <?php 
				    $checkOrder=DB::table('sales')->where('id',$id)->get()[0];
				if($checkOrder->request_id !=""):?>
                  <?php 
				     $requestedOrders=DB::table('request')
					 ->join('country','country.country_id','request.customer_city')
					 ->where('request.id',$checkOrder->request_id)
					 ->select('country.country as customerCity','request.*')
					 ->get()[0];
				  ?>
				  <span>{{$requestedOrders->customer_name}}</span><br>
                 <span>{{$requestedOrders->customerCity}}</span><br>
                 <span>{{$requestedOrders->customer_phone}}</span><br>
				
				<?php
				else:
				?>
				<span>{{$ezpos_customer_data->name}}</span><br>
                <span>{{$ezpos_customer_data->company_name}}</span><br>
                <span>{{$ezpos_customer_data->address}}</span><br>
                <span>{{$ezpos_customer_data->phone_number}}</span><br>
                <span>{{$ezpos_customer_data->email}}</span><br>
				<?php 
				endif;
				?>
            </td>
            <td style="width: 50%"></td>
        </tr>
    </table>
    <table class="listthead" style="width: 100%" cellpadding="5px" cellspacing="0">
        <thead>
            <tr style="height: 30px"></tr>
            <tr style="background-color: #8cc98d;">
                <td style="width: 10%; border: 1px solid rgba(0,0,0,0.3)"><strong>Sl No</strong></td>
                <td style="width: 50%; border: 1px solid rgba(0,0,0,0.3)"><strong>{{trans('file.product')}} {{trans('file.name')}}</strong></td>
                <td style="width: 10%; text-align: center; border: 1px solid rgba(0,0,0,0.3)"><strong>{{trans('file.Quantity')}}</strong></td>
                <td style="width: 15%; text-align: center; border: 1px solid rgba(0,0,0,0.3)"><strong>{{trans('file.Unit Price')}}</strong></td>
                <td style="width: 15%; text-align: center; border: 1px solid rgba(0,0,0,0.3)"><strong>{{trans('file.Total')}}</strong></td>
            </tr>
        </thead>
        <tfoot>
           
        </tfoot>
        <!-- LOOP START -->
        @foreach($ezpos_product_sale_data as $key => $product_sale)
        <?php 
            $product = DB::table('products')->find($product_sale->product_id);
            if($product_sale->unit != 'null')
                $unit = ' '.$product_sale->unit.'';
            else
                $unit = '';
         ?>
        <tr>
            <td style="width: 10%; border: 1px solid rgba(0,0,0,0.3)">{{$key + 1}}</td>
            <td style="width: 50%; border: 1px solid rgba(0,0,0,0.3)">{{$product->name}}</td>
            <td style="width: 10%; text-align: center; border: 1px solid rgba(0,0,0,0.3)">{{$product_sale->qty.$unit}}</td>
            <td style="width: 15%; text-align: center; border: 1px solid rgba(0,0,0,0.3)">{{$product_sale->total / $product_sale->qty}}</td>
            <td style="width: 15%; text-align: center; border: 1px solid rgba(0,0,0,0.3)">{{$product_sale->total}}</td>
        </tr>
        @endforeach
        <!-- LOOP END -->
        
        <tr>
            <td colspan="2" style="width: 60%; border: 1px solid rgba(0,0,0,0.3)"><strong>{{trans('file.grand total')}}</strong></td>
            <td style="width: 10%; text-align: center; border: 1px solid rgba(0,0,0,0.3)"><strong>{{$ezpos_sale_data->total_qty}}</strong></td>
            <td colspan="2" style="width: 30%; text-align: center; border: 1px solid rgba(0,0,0,0.3)"><strong>{{$ezpos_sale_data->grand_total}}</strong></td>
        </tr>
        <tr>
            <td colspan="5" style="width: 100%; text-align: center; border: 1px solid rgba(0,0,0,0.3)"><strong>{{trans('file.In Words')}}: <span style="text-transform: uppercase">{{$general_setting->currency}}</span> <span style="text-transform: capitalize">{{str_replace("-"," ",$numberInWords)}}</span></strong></td>
        </tr>
        <tr style="height: 30px"><td colspan="5"></td></tr>
        <tr><td colspan="5"><strong>{{trans('file.Note')}}:</strong> {{$ezpos_sale_data->sale_note}}</td></tr>
    </table>
    <br><br>
    <table style="width: 100%;"">
        <tr>            
            <td style="width: 30%; text-align: center; border-top: 1px solid rgba(0,0,0,0.7)">
                {{trans('file.Stamp')}} & {{trans('file.Signature')}}
            </td>
            <td style="width: 70%"></td>
        </tr>
        <tr style="height: 30px"><td></td><td></td></tr>
        <tr>
            <td colspan="2"style="width: 100%; text-align: center; border-top: 1px solid rgba(0,0,0,0.3); font-size: 12px;padding-top:15px">
                {{trans('file.Invoice')}} {{trans('file.Generate')}} {{trans('file.By')}} <strong>{{$general_setting->site_title}}</strong>.
                {{trans('file.Developed')}} {{trans('file.By')}} <a style="text-decoration: none; color: #60bf62;" href="http://lion-coders.com"><strong>LionCoders</strong></a>
            </td>
        </tr>
    </table>
</div>
<script type="text/javascript" src="<?php echo asset('public/vendor/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/jquery/jquery-ui.min.js') ?>"></script>

<script type="text/javascript">
    $('#print-btn').on('click', function(){
        window.print();
    });
</script>