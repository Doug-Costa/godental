<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\CheckoutnovoController;
use App\Http\Controllers\CadastroController; // Importe o controller
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\BuscaElasticController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'App\Http\Controllers'], function()
{  
    //Rota de login
    Route::post('/login', 'LoginController@login')->name('login');
    //Rota de login Institucional
    Route::post('/logininstitucional', 'LoginInstitucionalController@login')->name('logininstitucional');
    //Rota Solicita Recuperar Senha
    Route::post('/recsenha', 'LoginController@recsenha')->name('recsenha');
    //Rota Aplicar Recuperar Senha
    Route::post('/recsenhaaply', 'ConsultaUserIdController@recsenhaaply')->name('recsenhaaply');
    //Rota de login do Books
    Route::post('/loginbooks', 'LoginBooksController@login')->name('loginbooks');
    //Rota de Logout
    Route::get('/logout', 'LoginController@logout')->name('logout');
    //Rota de cadastro
    Route::post('/cadastro', 'CadastroController@cadastro')->name('cadastro');
    //Atualiza dados de cadastro
    Route::post('/attcadastro', 'minhacontaController@attcadastro')->name('attcadastro');
    //Atualiza o endereço
    Route::post('/attendereco', 'minhacontaController@attendereco')->name('attendereco');

    
    //LIMPA CACHE
    //Route::get('/flush_cache', 'FlushController@cache')->name('flush_cache');


    //ACESSO RESTRITO A ASSINANTES
    Route::get('/restrito_assinante', 'RestritoController@assinante')->name('restrito_assinante');
    //Assinar Plano
    Route::get('/assinarplano/{id?}', 'AssinaturaController@assinarPlano')->name('assinarplano');
    //CheckoutPagamento
    Route::get('/checkoutpay/{id?}', 'CheckoutController@checkoutpaypay')->name('checkoutpay');
    //Rota de 7 dias gratis
    Route::post('/setediascad', 'SeteDiasController@userID')->name('setediascad');

    //GERA GIFTCARD 
    //Route::get('/geragift', 'GiftController@generate')->name('generate');
    // Exporta os GIFTCARD
    //Route::get('/exportagift', 'GiftController@getAndExportCsv')->name('getAndExportCsv');
    // Valida GiftCard
    Route::get('/validagift', 'GiftController@validagift')->name('validagift'); 

});


Route::group(['middleware' => 'Language'], function () {
    //VERIFICA QUAL DISPOSITIVO ESTÁ ACESSANDO
    $user_agent = request()->header('User-Agent');
    //configura linguagem
    Route::get('/change-language/{lang}',"\App\Http\Controllers\PagesController@changeLang");
    


    if ((strpos($user_agent, 'Android') !== false) || (strpos($user_agent, 'iPhone') !== false) || (strpos($user_agent, 'iPad') !== false)) {
        //pagina Base
        Route::get('/', "\App\Http\Controllers\PagesController@indexMobile")->name('home');
        //colecoes Revistas
        Route::get('/colecoes', '\App\Http\Controllers\PagesController@colecoesMobile')->name('colecoes');
        //colecao Revista
        Route::get('/colecao/{id?}', '\App\Http\Controllers\PagesController@colecaoMobile')->name('colecao');
    }else{
        //pagina Base
        Route::get('/', "\App\Http\Controllers\PagesController@index")->name('home');
        //colecoes Revistas
        Route::get('/colecoes', '\App\Http\Controllers\PagesController@colecoes')->name('colecoes');
        //colecao Revista
        Route::get('/colecao/{id?}', '\App\Http\Controllers\PagesController@colecao')->name('colecao');
    }

    //Busca direta pelo Elastic Search
    Route::get('/busca-elastic', [BuscaElasticController::class, 'buscar'])->name('busca-elastic');

    // Busca no Elasticsearch com filtros aplicados
    Route::get('/busca-elastic-filtrada', [BuscaElasticController::class, 'buscarFiltrada'])->name('busca-elastic-filtrada');

    //LandingPage 7 dias Assinar
    Route::get('/assine', "\App\Http\Controllers\PagesController@assine")->name('assine');
    Route::get('/setedias', "\App\Http\Controllers\PagesController@setedias")->name('setedias');
    Route::get('/setedias/email', "\App\Http\Controllers\PagesController@setediasemail")->name('setediasemail');

    //LandingPageALADO Assinar
    Route::get('/alado', "\App\Http\Controllers\PagesController@alado")->name('alado');
    Route::get('/alado/email', "\App\Http\Controllers\PagesController@aladoemail")->name('aladoemail');

    //Politica de privacidade
    Route::get('/politica', "\App\Http\Controllers\PagesController@politica")->name('politica');


    //Logar
    Route::get('/logar', "\App\Http\Controllers\PagesController@logar")->name('logar');

    //Recuperar Senha
    Route::get('/recuperarsenha', "\App\Http\Controllers\PagesController@recuperarsenha")->name('recuperarsenha');

    //Logar Books
    Route::get('/logarbooks', "\App\Http\Controllers\PagesController@logarbooks")->name('logarbooks');

    //Cadastrar
    Route::get('/cadastrar', "\App\Http\Controllers\PagesController@cadastrar")->name('cadastrar');
    Route::get('/hub', "\App\Http\Controllers\PagesController@hub")->name('hub');

    //Minha Conta
    Route::get('/minhaconta', "\App\Http\Controllers\PagesController@minhaconta")->name('minhaconta');

    //Minha Conta Books
    Route::get('/minhacontabooks', "\App\Http\Controllers\PagesController@minhacontabooks")->name('minhacontabooks');

    //Loading Videos
    Route::get('/loadingvideo', "\App\Http\Controllers\PagesController@loadingvideo")->name('loadingvideo');

    //Pagina revista e livro e produtoComprado
    Route::get('/revista/{id?}/{nome?}/{id_artigo?}/{nome_artigo?}/{variavel?}', '\App\Http\Controllers\PagesController@revista')->name('revista');
     //ARTIGOS
    Route::get('/artigo/{id?}/{nome?}/{id_artigo?}/{nome_artigo?}/{variavel?}', '\App\Http\Controllers\PagesController@artigo')->name('artigo');
    //COMRPA DE ARTIGOS
    Route::get('/compraartigo/{id?}/{nome?}/{id_artigo?}/{nome_artigo?}/{variavel?}', '\App\Http\Controllers\PagesController@compraartigo')->name('compraartigo');
    Route::get('/livro/{id?}/{nome?}', '\App\Http\Controllers\PagesController@livro')->name('livro');
    Route::get('/produtocomprado/{id?}/{nome?}', '\App\Http\Controllers\PagesController@produtocomprado')->name('produtocomprado');


    Route::get('/livro/{id?}/{nome?}', '\App\Http\Controllers\PagesController@livro')->name('livro');
    Route::get('/produtocomprado/{id?}/{nome?}', '\App\Http\Controllers\PagesController@produtocomprado')->name('produtocomprado');
    //BOOKS LEITOR
    Route::get('/produtocompradobooks/{id?}/{nome?}', '\App\Http\Controllers\PagesController@produtocompradobooks')->name('produtocompradobooks');

    //Videos
    Route::get('/videos', '\App\Http\Controllers\PagesController@videos')->name('videos');
    Route::get('/video/{id?}/{nome?}/{id_video?}', '\App\Http\Controllers\PagesController@video')->name('video');
    Route::get('/videoplay/{id?}', "\App\Http\Controllers\PagesController@videoplay")->name('videoplay');

    //Livros
    Route::get('/livros/{barear?}', '\App\Http\Controllers\PagesController@livros')->name('livros');

    //Comercial
    Route::get('/comercial/autores', '\App\Http\Controllers\PagesController@comercialAutores')->name('comercialAutores');
    Route::get('/comercial/autor/{id?}/{nome?}', '\App\Http\Controllers\PagesController@comercialAutor')->name('comercialAutor');

    //Autores
    Route::get('/autores', '\App\Http\Controllers\PagesController@autoresAutores')->name('autoresAutores');
    Route::get('/autor/{id?}/{nome?}', '\App\Http\Controllers\PagesController@autoresAutor')->name('autoresAutor');

    //BUSCA
    Route::get('/busca/{id?}/', '\App\Http\Controllers\PagesController@busca')->name('busca');

    //Politica Cancelamento
    Route::get('/politicacancelamento/', '\App\Http\Controllers\PagesController@politicacancelamento')->name('politicacancelamento');

    //Politica Troca
    Route::get('/politicatroca/', '\App\Http\Controllers\PagesController@politicatroca')->name('politicatroca');

    //Politica Entrega
    Route::get('/politicaentrega/', '\App\Http\Controllers\PagesController@politicaentrega')->name('politicaentrega');

    //Politica Seguranca
    Route::get('/politicaseguranca/', '\App\Http\Controllers\PagesController@politicaseguranca')->name('politicaseguranca');

    //Perguntas Frequentes
    Route::get('/perguntasfrequentes/', '\App\Http\Controllers\PagesController@perguntasfrequentes')->name('perguntasfrequentes');

    //Assinatura
    Route::get('/assinatura/{id?}/', '\App\Http\Controllers\PagesController@assinatura')->name('assinatura');

    //CHECKOUT PRODUTO
    Route::get('/checkout/{id?}/{artigos?}', '\App\Http\Controllers\PagesController@checkout')->name('checkout');

    //Parceiros
    //DVI
    Route::get('/parceiro/{id?}/{parceiro?}/', '\App\Http\Controllers\PagesController@parceiro')->name('parceiro');
    //CLINICORP
    Route::get('/clinicorp/{id?}/{parceiro?}/', '\App\Http\Controllers\PagesController@clinicorp')->name('clinicorp');
    //Destisply
    Route::get('/dentsplysirona/{id?}/{parceiro?}/', '\App\Http\Controllers\PagesController@dentsplysirona')->name('dentsplysirona');
    // //CvDentus
    // Route::get('/cvdentus/{id?}/{parceiro?}/', '\App\Http\Controllers\PagesController@cvdentus')->name('cvdentus');
    // //Ultradent
    // Route::get('/ultradent/{id?}/{parceiro?}/', '\App\Http\Controllers\PagesController@ultradent')->name('ultradent');
    //Invisalign
    Route::get('/invisalign/{id?}/{parceiro?}/', '\App\Http\Controllers\PagesController@invisalign')->name('invisalign');
    //Biologix
    Route::get('/biologix/{id?}/{parceiro?}/', '\App\Http\Controllers\PagesController@biologix')->name('biologix');
    //Shining3D
    Route::get('/shining3d/{id?}/{parceiro?}/', '\App\Http\Controllers\PagesController@shining3d')->name('shining3d');

    //TESTE
    Route::get('/teste', "\App\Http\Controllers\PagesController@teste")->name('teste');

    // ROTA PARA MOSTRAR A PÁGINA DE CHECKOUT (AGORA COM IDs DE PLANO OPCIONAIS)
    // {planId1?} e {planId2?} indicam que os parâmetros são opcionais.
    Route::get('/checkoutnovo/{planId1?}/{planId2?}', [CheckoutnovoController::class, 'show'])->name('checkoutnovo');

    // ROTA POST: Quando o JS do login envia os dados, chama a "Tarefa 2" (login)
    Route::post('/checkout/login', [CheckoutnovoController::class, 'login']);

        // ROTA PARA OBTER STATUS DO USUÁRIO LOGADO
    Route::get('/api/user-status', [CheckoutnovoController::class, 'getUserStatus']);


    // ROTA PARA PROCESSAR O CADASTRO DO CHECKOUT
    Route::post('/register', [CadastroController::class, 'storeCheckout']);

    
    // Rota para salvar a escolha do plano.
    // O JavaScript da Etapa 2 fará uma requisição para este endereço.
    Route::post('/checkout/select-plan', [CheckoutnovoController::class, 'savePlan']);
    // Rota que recebe a requisição do JavaScript de pagamento
    Route::post('/checkout/process-payment', [PaymentController::class, 'process']);

    // Futuramente, a rota de pagamento também virá aqui dentro.
    // Route::post('/checkout/process-payment', [PaymentController::class, 'process']);

    //SCHOOLAR
    Route::get('/school', "\App\Http\Controllers\PagesController@school")->name('school');
    Route::get('/schoologin', "\App\Http\Controllers\PagesController@schoologin")->name('schoologin');
    Route::post('/schoolar/login', "\App\Http\Controllers\SchoolarController@login")->name('schoolarlogin');

    //APOSTILA

    Route::get('/apostila/{id?}/', '\App\Http\Controllers\PagesController@apostila')->name('apostila');

       // ROTA PARA MOSTRAR A PÁGINA DE CHECKOUT TIPADA (plano|produto)
    Route::get('/checkoutnovo/{type}/{planId1?}/{planId2?}', [CheckoutnovoController::class, 'show'])
        ->where('type', 'plano|produto|plan|product')
        ->name('checkoutnovo.typed');

    // ROTA PARA MOSTRAR A PÁGINA DE CHECKOUT (AGORA COM IDs DE PLANO OPCIONAIS)
    // {planId1?} e {planId2?} indicam que os parâmetros são opcionais.
    Route::get('/checkoutnovo/{planId1?}/{planId2?}', [CheckoutnovoController::class, 'show'])->name('checkoutnovo');

    // ROTA POST: Quando o JS do login envia os dados, chama a "Tarefa 2" (login)
    Route::post('/checkout/login', [CheckoutnovoController::class, 'login']);

        // ROTA PARA OBTER STATUS DO USUÁRIO LOGADO
    Route::get('/api/user-status', [CheckoutnovoController::class, 'getUserStatus']);

    // ROTA PARA VALIDAR TOKEN VIA API DENTALGO
    Route::post('/api/validate-token', [CheckoutnovoController::class, 'validateToken']);


    // ROTA PARA PROCESSAR O CADASTRO DO CHECKOUT
    Route::post('/register', [CadastroController::class, 'storeCheckout']);

    
    // Rota para salvar a escolha do plano.
    // O JavaScript da Etapa 2 fará uma requisição para este endereço.
    Route::post('/checkout/select-plan', [CheckoutnovoController::class, 'savePlan']);
    // Rota que recebe a requisição do JavaScript de pagamento
    Route::post('/checkout/process-payment', [CheckoutnovoController::class, 'processPayment'])->name('checkoutnovo.processPayment');


    
    // Rota para salvar a escolha do plano.
    // O JavaScript da Etapa 2 fará uma requisição para este endereço.
    Route::post('/checkout/select-plan', [CheckoutnovoController::class, 'savePlan']);
    // Rota que recebe a requisição do JavaScript de pagamento
    Route::post('/checkout/process-payment', [CheckoutnovoController::class, 'processPayment'])->name('checkoutnovo.processPayment');
});