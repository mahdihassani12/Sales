<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use DB; 
class ImageController extends Controller
{
  public function ajaxImage(Request $request)
    {
		$p_id=$request->product_id; 
        if ($request->isMethod('get')){
           
		}
       else {
            $validator = Validator::make($request->all(),
                [
                    'file' => 'image',
                ],
                [
                    'file.image' => 'The file must be an image (jpeg, png, bmp, gif, or svg)'
                ]);
            if ($validator->fails())
                return array(
                    'fail' => true,
                    'errors' => $validator->errors()
                );
				
            $extension = $request->file('file')->getClientOriginalExtension();
            $dir = 'public/images/product';
           $filename = 'dr'.rand(1,10000).time().'.'.$extension;
            $request->file('file')->move($dir, $filename);
            
           $res=DB::table('products')->where('id',$p_id)->update(['image'=>$filename]);
           if($res){
			   return $filename;
		   }
		   else{
			   return 0;
		   }
		}
    }






}