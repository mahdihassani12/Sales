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

       @if(Auth::user()->role_id !='12' && Auth::user()->role_id!='13')   
        <div class="row store_boxes">
          @foreach($data['stores'] as $st)     
      <div class="col-md-3"> 
            <div class="store_box">
                <div class="first_section">
                    <div class="col8">
                        <h1>{{$st->name}}</h1>
                    </div>
                    <div class="col4">
                     <img src="{{asset('public/images/icons/shop.svg')}}">
                    </div> 
                 </div>
         @if(Auth::user()->role_id!=10)
                 <div class="second_section">
                    <div class="col6">
                        <h1>جرد مخزني</h1>
                    </div>
                    <div class="col6 show_items">
                      <a href="{{asset('dashboard/store_movement')}}/{{$st->id}}"> مشاهدة <img src="{{asset('public/images/icons/focus.svg')}}"></a>
                    </div> 
                 </div>
                @endif
                 <div class="third_section">
                    <div class="col6">
                        <h1>طلبيات جديدة</h1>
                    </div>
                    <div class="col6">
                      <h3><?php echo DB::table('sales')->where('order_status','0')->where('store_id',$st->id)->count(); ?> &nbsp;<a href="{{asset('dashboard/orders')}}/{{$st->id}}"><img src="{{asset('public/images/icons/shopping-cart-black-shape.svg')}}"></a></h3>
                    </div> 
                 </div>
             </div>    
            </div> 
     @endforeach
         </div>
        @endif 
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

