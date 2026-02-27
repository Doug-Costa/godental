<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Cache;


class RestritoController extends Controller
{

    public function cache()
    {
        echo 'ACESSO EXCLUSIVO A ASSINANTES DENTAL GO';
    }

}