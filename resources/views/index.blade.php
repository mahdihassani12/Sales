@extends('layout.main')
@section('content')
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
     <div id="store_dashboard">
	 <div class="container-fluid" >
        <form>
	     <input type="text" name="search" class="form-control" placeholder="إبحث عن الكلمات هنا...">
         <span class="fa fa-search"></span>
        </form> 
        <h2 style="margin-top: 12px;border-bottom: 1px solid lightgray;padding-bottom: 8px;">المحلات

          <a href="{{asset('dashboard/store')}}/all" style="font-size: 15px;float:left;">عرض كل المخازن</a>
        </h2>
       @if(Auth::user()->role_id!='12')    
        <div class="row store_boxes">
         @foreach($data['store_cat'] as $st) 
           <div class="col-md-3">
          <a href="{{asset('dashboard/store')}}/{{$st->id}}">
            <div class="store_box">
                <div class="first_section">
                    <div class="col-12 store_category_name">
					   <div class="image"> 
					    <img src="{{asset('public/images/icons/shop.svg')}}">
                       </div>
					   <div class="name">
					     <span>{{$st->name}}</span>
					   </div>
					</div>
                    <div class="col-12">
					     <?php 
						 $all_Orders_count=0;
						  $stors=DB::table('stores')->where('is_active',true)->get();
						  foreach($stors as $str){
							$selectedStores=explode("-" , $str->store_category_id);
                             for($i=0; $i<count($selectedStores); $i++ ):							
						       if($st->id==$selectedStores[$i]){
							    $all_Orders_count+=  DB::table('sales')->where('order_status','0')->where('store_id',$str->id)->count(); 
						       }
							 endfor;
						  }
						 ?>
						 
                       <h3 class="store_category">&nbsp; <img src="{{asset('public/images/icons/shopping-cart-black-shape.svg')}}"> &nbsp; <span style="font-size:22px"> {{$all_Orders_count}} </span> <span class="order-lable"> &nbsp; الطلبات الكلية </span></h3>
                    </div> 
                 </div>
             </div>
             </a>    
            </div>   
         @endforeach
          </div>
		   @endif 
    </div>
	   </div>
     </div> 	 
<style>
.store_boxes .col-md-3{
	padding-left:5px;
	padding-right:5px;
}
#store_dashboard .store_box{height: 146px;padding:10px 0px;}
#store_dashboard .store_box .first_section{border:none;text-align:left;color: #3e3d3d;}
.store_boxes a{
  width: 100%;
}
#store_dashboard .store_box .first_section .store_category_name .image{
	width:25%;
	float:left;
}
#store_dashboard .store_box .first_section .store_category_name .name{
	width:75%;
	float:left;
	padding-top:14px;
}
#store_dashboard .store_box .store_category{
	font-size:15px;
	direction:rtl;
	margin-top:25px;
    text-align: right;
}
#store_dashboard .store_box .store_category .order-lable{color: #908e8e;}
#store_dashboard .store_box .store_category img{
	width:25px;
}
#store_dashboard .store_box .first_section h1{
  font-size: 17px;
  margin-top: 13px;
}
#store_dashboard .store_box .first_section .store_category_name{
	    font-size: 18px;
    font-weight: bold;
    margin-left: 1px;
    display: inline-block;
}
.first_section .col-12{
  
}
.first_section .col-12 img{
	width: 45px;
    margin-top: 6px;
	}
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
   var APP_URL = {!! json_encode(url('/')) !!}
     
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
@endsection

