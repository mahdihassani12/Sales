
	 @foreach($product as $products)
	   <li class="edit_product" product_id="{{$products->id}}">{{$products->name}}</li>
	 @endforeach

<style>
 li.edit_product{
	 list-style-type:none;
	 cursor:pointer;
	 padding:4px 10px; 
	 border-bottom:1px solid gray;
 }
</style>	 
<script>

   $(".edit_product").click(function(){
	   var product_id=$(this).attr('product_id');
	   $.ajax({
		   url:APP_URL+'/products/searchPro/'+product_id,
		   type:'get',
		   success:function(response){
			   $("#product_name").val(response.split(',')[0]);
			   $('#category_id option:contains("'+response.split(',')[1]+'")').attr('selected', 'selected');
			   $("#category_id").val(response.split(',')[1]);
			   $("#category_id").val(response.split(',')[1]);
			   $("#quantity").val(response.split(',')[2]);
			   $("#price").val(response.split(',')[3]);
			   $("#cost").val(response.split(',')[4]);
			   $("#unit").val(response.split(',')[5]);
			   $("#alert_quantity").val(response.split(',')[6]);
			   $("#barcode").val(response.split(',')[7]);
			   $("#product_id").val(product_id);
		   },
		   error:function(data){
			  alert(data); 
		   }
	   })
   });

</script>	 