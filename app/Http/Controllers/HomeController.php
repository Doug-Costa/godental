<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Cache;

use App;
class HomeController extends Controller
{
   function index(){
    
      return view("home");
   }
   
   function changeLang($langcode){
    
      App::setLocale($langcode);
      session()->put("lang_code",$langcode);
      return redirect()->back();
  }  
}