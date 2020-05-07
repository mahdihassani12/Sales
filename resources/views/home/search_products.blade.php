<style>
tr.search_resutl{
	cursor:pointer;
}
td.search_resutl{
	padding: 7px !important;
    color: #ddd;
    border: none !important;
}
</style>
<table class="table table-hover">
@foreach($result as $products)
 <tr product_id="{{$products->id}}" class="product search_resutl"><td class="search_resutl">{{$products->name}}-{{$products->code}}</td></tr>
@endforeach
</table>

<script>
   var APP_URL = {!! json_encode(url('/')) !!}

  $('.product').click(function(){
	  var pid=$(this).attr('product_id');
	   $("#serch_item").val($(this).text()); 
	   $('.home-search-result').css('display','none');
	  $.ajax({
		 url:''+APP_URL+'/select/specific_products/'+pid,
         type:'get',
         success:function(response){
			 $(".selected_item").html(response);
			 
		 },
        error:function(){
			
		}		 
	  });
	  
  });
  
  
</script>