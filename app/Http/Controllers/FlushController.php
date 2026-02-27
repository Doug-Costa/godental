<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;


class FlushController extends Controller
{

	public function cache()
    {
    	Cache::flush();

        // Executa o comando de limpar cache de rotas
        Artisan::call('route:clear');

    	echo 'CACHE LIMPACHO';
    }

}