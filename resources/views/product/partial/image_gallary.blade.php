@foreach($getPro as $proImag)
   <div class="product-gallery-image" id='remove_product{{$proImag->id}}'>
      <span class='fa fa-close close_btn' gimage_id="{{$proImag->id}}" image_src="{{$proImag->imag_gallery}}">
	  </span>
    @if($proImag->external_link==0) 
	  <img src="{{asset('public/images/product_variation')}}/{{$proImag->imag_gallery}}">
     @else
	   <img src="{{$proImag->imag_gallery}}">
     @endif
  </div>

@endforeach
<span class='devider'></span>

<style>
  #gallery_images .close_btn{
	color: red;
	cursor:pointer; 
    position: absolute;
    right: 14px;
    top: 12px;
    padding: 1px 2px;
    background: #ffffffd4;
    border-radius: 6px; 
}

#gallery_images #attachment_tbl .product-gallery-image{
	display:inline-block;
	position:relative;
}
</style>
<script>
var APP_URL = {!! json_encode(url('/')) !!}

    $(document).ready(function(){       
	  $(".close_btn").click(function(){
		var gid=$(this).attr('gimage_id');
		var gsrc=$(this).attr('image_src');
		
         $.ajax({
			 url:APP_URL+'/products/delete_image/'+gid,
			 type:'get',
			 success:function(){
				$("#remove_product"+gid).remove(); 
			 },
			 error:function(){
				 
			 }
		 })		
	   });
});	
</script>