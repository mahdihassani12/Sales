<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Redirect;
use App\Language;

class LanguageController extends Controller
{
    public function switchLanguage($locale ,Request $request)
    {
        $language = Language::firstOrNew(['id' => 1]);
        $language->code = $locale;
        $language->save();
		$request->session()->put('language',$locale);
		
    	return Redirect::back();
    }
}
