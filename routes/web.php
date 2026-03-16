<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\CheckoutnovoController;
use App\Http\Controllers\CadastroController; // Importe o controller
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\BuscaElasticController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\GoIntelligenceController;
use App\Http\Controllers\AnamnesisController;

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

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    //Rota GET para exibir página de login
    Route::get('/login', 'PagesController@logar')->name('login.form');
    //Rota GET para exibir página de login escolar
    Route::get('/loginschoolar', 'SchoolarController@loginSchoolar')->name('loginschoolar.form');
    //Rota de login
    Route::post('/login', 'LoginController@login')->name('login')->middleware('rate.limit');
    //Rota de login escolar
    Route::post('/loginschoolar', 'SchoolarController@login')->name('loginschoolar')->middleware('rate.limit');
    //Rota de login Institucional
    Route::post('/logininstitucional', 'LoginInstitucionalController@login')->name('logininstitucional')->middleware('rate.limit');
    //Rota Solicita Recuperar Senha
    Route::post('/recsenha', 'LoginController@recsenha')->name('recsenha')->middleware('rate.limit');
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


    // Rota temporária para debug da sessão
    Route::get('/debug-session', function () {
        return response()->json([
            'session_data' => [
                'token' => session()->get('token'),
                'tipoUsuario' => session()->get('tipoUsuario'),
                'all_session' => session()->all()
            ]
        ]);
    });

    //LIMPA CACHE
    //Route::get('/flush_cache', 'FlushController@cache')->name('flush_cache');


    //ACESSO RESTRITO A ASSINANTES
    Route::get('/restrito_assinante', 'RestritoController@assinante')->name('restrito_assinante');
    //Assinar Plano
    Route::get('/assinarplano/{id?}', 'AssinaturaController@assinarPlano')->name('assinarplano');
    //CheckoutPagamento
    Route::get('/checkoutpay/{id?}', 'CheckoutController@checkoutpaypay')->name('checkoutpay');
    //Rota de 7 dias gratis
    // Route::post('/setediascad', 'SeteDiasController@userID')->name('setediascad');
    Route::post('/promosuryacad', 'PromoSuryaController@userID')->name('promosuryacad');

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
    Route::get('/change-language/{lang}', "\App\Http\Controllers\PagesController@changeLang");

    Route::get('/facelift25', "\App\Http\Controllers\PagesController@faceindex")->name('facehome');

    //videos facelift25

    Route::get('facelift25/videos', '\App\Http\Controllers\PagesController@facevideos')->name('facevideos');

    //colecoes facelift25
    Route::get('facelift25/colecoes', '\App\Http\Controllers\PagesController@facecolecoes')->name('facecolecoes');
    //livros facelift25
    Route::get('facelift25/livros', '\App\Http\Controllers\PagesController@facelivros')->name('facelivros');

    //livro facelift25  made in yusuke 
    Route::get('facelift25/livro/{id?}/{nome?}', '\App\Http\Controllers\PagesController@facelivro')->name('facelivro');
    //produtocomprado facelift25 made in yusuke
    Route::get('facelift25/produtocomprado/{id?}/{nome?}', '\App\Http\Controllers\PagesController@faceprodutocomprado')->name('faceprodutocomprado');

    //canais facelift25
    Route::get('facelift25/canais', '\App\Http\Controllers\PagesController@facecanais')->name('facecanais');
    //colecao facelift25
    Route::get('facelift25/colecao/{id?}', '\App\Http\Controllers\PagesController@facecolecao')->name('facecolecao');
    // revista facelift25
    Route::get('facelift25/revista/{id?}/{nome?}/{id_artigo?}/{nome_artigo?}/{variavel?}', '\App\Http\Controllers\PagesController@facerevista')->name('facerevista');
    //artigo facelift25
    Route::get('/facelift25/artigo/{id?}/{nome?}/{id_artigo?}/{nome_artigo?}/{variavel?}', '\App\Http\Controllers\PagesController@faceartigo')->name('faceartigo');
    //video
    Route::get('/facelift25/video/{id?}/{nome?}/{id_video?}', '\App\Http\Controllers\PagesController@facevideo')->name('facevideo');
    Route::get('/facelift25/videoplay/{id?}', "\App\Http\Controllers\PagesController@facevideoplay")->name('facevideoplay');
    //Loading Videos
    Route::get('/facelift25/loadingvideo', "\App\Http\Controllers\PagesController@faceloadingvideo")->name('faceloadingvideo');

    //Parceiros
    //DVI
    Route::get('facelift25/parceiro/{id?}/{parceiro?}/', '\App\Http\Controllers\PagesController@faceparceiro')->name('faceparceiro');
    //CLINICORP
    Route::get('facelift25/clinicorp/{id?}/{parceiro?}/', '\App\Http\Controllers\PagesController@faceclinicorp')->name('faceclinicorp');
    //Destisply
    Route::get('facelift25/dentsplysirona/{id?}/{parceiro?}/', '\App\Http\Controllers\PagesController@facedentsplysirona')->name('facedentsplysirona');
    // //CvDentus
    // Route::get('facelift25/cvdentus/{id?}/{parceiro?}/', '\App\Http\Controllers\PagesController@cvdentus')->name('cvdentus');
    // //Ultradent
    // Route::get('facelift25/ultradent/{id?}/{parceiro?}/', '\App\Http\Controllers\PagesController@ultradent')->name('ultradent');
    //Invisalign
    Route::get('facelift25/invisalign/{id?}/{parceiro?}/', '\App\Http\Controllers\PagesController@faceinvisalign')->name('faceinvisalign');
    //Biologix
    Route::get('facelift25/biologix/{id?}/{parceiro?}/', '\App\Http\Controllers\PagesController@facebiologix')->name('facebiologix');
    //Shining3D
    Route::get('facelift25/shining3d/{id?}/{parceiro?}/', '\App\Http\Controllers\PagesController@faceshining3d')->name('faceshining3d');





    // ==============================================================
    // FACELIFT 2.0 - PRODUCTION ROUTES
    // ==============================================================

    // Home (Oficial - Home 2)
    Route::get('/', "\App\Http\Controllers\PagesController@facehome2")->name('home');

    // Home Original (Legado)
    Route::get('/home-original', "\App\Http\Controllers\PagesController@faceindex")->name('home.original');

    // Coleções (Lista Geral)
    Route::get('/colecoes', '\App\Http\Controllers\PagesController@facecolecoes')->name('colecoes');

    // Coleção (Detalhe da Revista/Coleção)
    Route::get('/colecao/{id?}', '\App\Http\Controllers\PagesController@facecolecao')->name('colecao');

    // Revista (Detalhe da Edição)
    Route::get('/revista/{id?}/{nome?}/{id_artigo?}/{nome_artigo?}/{variavel?}', '\App\Http\Controllers\PagesController@facerevista')->name('revista');

    // Artigo (Leitura)
    Route::get('/artigo/{id?}/{nome?}/{id_artigo?}/{nome_artigo?}/{variavel?}', '\App\Http\Controllers\PagesController@faceartigo')->name('artigo');

    // Videos
    Route::get('/videos', '\App\Http\Controllers\PagesController@facevideos')->name('videos');
    Route::get('/video/{id?}/{nome?}/{id_video?}', '\App\Http\Controllers\PagesController@facevideo')->name('video');
    Route::get('/videoplay/{id?}', "\App\Http\Controllers\PagesController@facevideoplay")->name('videoplay');

    // Parceiros
    Route::get('/parceiro/{id?}/{parceiro?}/', '\App\Http\Controllers\PagesController@faceparceiro')->name('parceiro');
    Route::get('/clinicorp/{id?}/{parceiro?}/', '\App\Http\Controllers\PagesController@faceclinicorp')->name('clinicorp');
    Route::get('/dentsplysirona/{id?}/{parceiro?}/', '\App\Http\Controllers\PagesController@facedentsplysirona')->name('dentsplysirona');
    Route::get('/invisalign/{id?}/{parceiro?}/', '\App\Http\Controllers\PagesController@faceinvisalign')->name('invisalign');
    Route::get('/biologix/{id?}/{parceiro?}/', '\App\Http\Controllers\PagesController@facebiologix')->name('biologix');
    Route::get('/shining3d/{id?}/{parceiro?}/', '\App\Http\Controllers\PagesController@faceshining3d')->name('shining3d');

    //Clube de vantagens
    Route::get('/clube-de-vantagens', '\App\Http\Controllers\PagesController@clubeDeVantagens')->name('clube-de-vantagens');

    //GoTalks
    Route::get('/gotalks', '\App\Http\Controllers\PagesController@gotalks')->name('gotalks');

    // TEST / PARALLEL ROUTES
    // Route::get('/home2', '\App\Http\Controllers\PagesController@facehome2')->name('facehome2'); // Agora é a rota principal '/'
    Route::get('/painel-crm', '\App\Http\Controllers\PagesController@consultasHub')->name('consultas.hub');
    Route::get('/painel-consultas', '\App\Http\Controllers\PagesController@consultasIndex')->name('consultas.index');
    Route::delete('/painel-consultas/{id}', '\App\Http\Controllers\PagesController@consultasDestroy')->name('consultas.destroy')->where('id', '[a-zA-Z0-9_\-]+');
    Route::get('/painel-consultas/{id}', '\App\Http\Controllers\PagesController@consultasShow')->name('consultas.show')->where('id', '[a-zA-Z0-9_\-]+');

    // CRM Go Clinic
    Route::resource('patients', \App\Http\Controllers\PatientController::class);
    Route::get('/api/patients-search', [\App\Http\Controllers\PatientController::class, 'search'])->name('patients.search');
    Route::get('/patients/check-history/{id}', [\App\Http\Controllers\PatientController::class, 'checkHistory'])->name('patients.check-history');

    // Casos Clínicos
    Route::post('/clinical-cases', [\App\Http\Controllers\ClinicalCaseController::class, 'store'])->name('clinical-cases.store');
    Route::get('/clinical-cases/{id}', [\App\Http\Controllers\ClinicalCaseController::class, 'show'])->name('clinical-cases.show');
    Route::post('/clinical-cases/{id}/close', [\App\Http\Controllers\ClinicalCaseController::class, 'close'])->name('clinical-cases.close');
    Route::post('/clinical-cases/{id}/reopen', [\App\Http\Controllers\ClinicalCaseController::class, 'reopen'])->name('clinical-cases.reopen');
    Route::get('/api/clinical-cases/{patientId}/active', [\App\Http\Controllers\ClinicalCaseController::class, 'activeCases'])->name('clinical-cases.active');

    // Consulta - Campos Clínicos
    Route::post('/api/consultations/{id}/clinical-fields', [\App\Http\Controllers\ClinicalCaseController::class, 'updateConsultationFields'])->name('consultations.update-fields');
    Route::post('/api/consultations/store', [\App\Http\Controllers\ClinicalCaseController::class, 'storeConsultation'])->name('consultations.ajax-store');

    // Planos de Tratamento e Procedimentos
    Route::post('/treatment-plans', [\App\Http\Controllers\ClinicalCaseController::class, 'storeTreatmentPlan'])->name('treatment-plans.store');
    Route::post('/treatment-plans/{id}/approve', [\App\Http\Controllers\ClinicalCaseController::class, 'approveTreatmentPlan'])->name('treatment-plans.approve');
    Route::post('/procedures', [\App\Http\Controllers\ClinicalCaseController::class, 'storeProcedure'])->name('procedures.store');
    Route::post('/api/procedures/{id}/status', [\App\Http\Controllers\ClinicalCaseController::class, 'updateProcedureStatus'])->name('procedures.update-status');

    // Agenda
    Route::get('/agenda', [\App\Http\Controllers\AgendaController::class, 'index'])->name('agenda.index');
    Route::get('/api/agenda/events', [\App\Http\Controllers\AgendaController::class, 'events'])->name('agenda.events');
    Route::post('/api/agenda', [\App\Http\Controllers\AgendaController::class, 'store'])->name('agenda.store');
    Route::put('/api/agenda/{id}', [\App\Http\Controllers\AgendaController::class, 'update'])->name('agenda.update');
    Route::patch('/api/agenda/{id}/status', [\App\Http\Controllers\AgendaController::class, 'updateStatus'])->name('agenda.updateStatus');
    Route::delete('/api/agenda/{id}', [\App\Http\Controllers\AgendaController::class, 'destroy'])->name('agenda.destroy');
    Route::get('/api/agenda/metrics', [\App\Http\Controllers\AgendaController::class, 'metrics'])->name('agenda.metrics');

    // Dashboard e Kanban
    Route::get('/dashboard-clinico', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/atendimentos-kanban', [\App\Http\Controllers\DashboardController::class, 'kanban'])->name('kanban.index');
    Route::post('/api/kanban/{id}/move', [\App\Http\Controllers\DashboardController::class, 'updateKanbanStage'])->name('kanban.move');

    // Administração
    Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    // Doctors
    Route::post('/api/admin/doctors', [\App\Http\Controllers\AdminController::class, 'storeDoctor'])->name('admin.doctors.store');
    Route::put('/api/admin/doctors/{id}', [\App\Http\Controllers\AdminController::class, 'updateDoctor'])->name('admin.doctors.update');
    Route::delete('/api/admin/doctors/{id}', [\App\Http\Controllers\AdminController::class, 'deleteDoctor'])->name('admin.doctors.delete');
    // Service Prices
    Route::post('/api/admin/service-prices', [\App\Http\Controllers\AdminController::class, 'storeServicePrice'])->name('admin.service-prices.store');
    Route::put('/api/admin/service-prices/{id}', [\App\Http\Controllers\AdminController::class, 'updateServicePrice'])->name('admin.service-prices.update');
    Route::delete('/api/admin/service-prices/{id}', [\App\Http\Controllers\AdminController::class, 'deleteServicePrice'])->name('admin.service-prices.delete');
    // Doctor Schedules
    Route::post('/api/admin/doctor-schedules', [\App\Http\Controllers\AdminController::class, 'storeDoctorSchedule'])->name('admin.doctor-schedules.store');
    Route::put('/api/admin/doctor-schedules/{id}', [\App\Http\Controllers\AdminController::class, 'updateDoctorSchedule'])->name('admin.doctor-schedules.update');
    Route::delete('/api/admin/doctor-schedules/{id}', [\App\Http\Controllers\AdminController::class, 'deleteDoctorSchedule'])->name('admin.doctor-schedules.delete');

    // ─── ANAMNESIS TEMPLATES CRUD ───
    Route::post('/api/admin/anamnesis-templates', [\App\Http\Controllers\AdminController::class, 'storeAnamnesisTemplate'])->name('admin.anamnesis-templates.store');
    Route::put('/api/admin/anamnesis-templates/{id}', [\App\Http\Controllers\AdminController::class, 'updateAnamnesisTemplate'])->name('admin.anamnesis-templates.update');
    Route::delete('/api/admin/anamnesis-templates/{id}', [\App\Http\Controllers\AdminController::class, 'deleteAnamnesisTemplate'])->name('admin.anamnesis-templates.delete');

    // Financeiro
    Route::get('/financial', [\App\Http\Controllers\FinancialController::class, 'index'])->name('financial.index');
    Route::post('/financial', [\App\Http\Controllers\FinancialController::class, 'store'])->name('financial.store');
    Route::put('/financial/{id}', [\App\Http\Controllers\FinancialController::class, 'update'])->name('financial.update');
    Route::delete('/financial/{id}', [\App\Http\Controllers\FinancialController::class, 'destroy'])->name('financial.destroy');
    Route::post('/financial/categories', [\App\Http\Controllers\FinancialController::class, 'storeCategory'])->name('financial.categories.store');
    Route::post('/financial/suppliers', [\App\Http\Controllers\FinancialController::class, 'storeSupplier'])->name('financial.suppliers.store');

    // Estoque
    Route::get('/inventory', [\App\Http\Controllers\InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory', [\App\Http\Controllers\InventoryController::class, 'store'])->name('inventory.store');
    Route::put('/inventory/{id}', [\App\Http\Controllers\InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{id}', [\App\Http\Controllers\InventoryController::class, 'destroy'])->name('inventory.destroy');
    Route::post('/inventory/{id}/stock-entry', [\App\Http\Controllers\InventoryController::class, 'stockEntry'])->name('inventory.stock-entry');

    // ==============================================================
    // MISSING ROUTES RESTORATION (From Legacy)
    // ==============================================================
    //COMPRA DE ARTIGOS
    Route::get('/compraartigo/{id?}/{nome?}/{id_artigo?}/{nome_artigo?}/{variavel?}', '\App\Http\Controllers\PagesController@compraartigo')->name('compraartigo');
    //LIVROS E PRODUTOS COMPRADOS
    Route::get('/livro/{id?}/{nome?}', '\App\Http\Controllers\PagesController@facelivro')->name('livro');
    Route::get('/produtocomprado/{id?}/{nome?}', '\App\Http\Controllers\PagesController@faceprodutocomprado')->name('produtocomprado');
    Route::get('/produtocompradobooks/{id?}/{nome?}', '\App\Http\Controllers\PagesController@produtocompradobooks')->name('produtocompradobooks');
    Route::get('/livros/{barear?}', '\App\Http\Controllers\PagesController@facelivros')->name('livros');


    // ==============================================================
    // SEARCH ROUTES (Original & Facelift)
    // ==============================================================
    Route::get('/busca-elastic', [BuscaElasticController::class, 'buscar'])->name('busca-elastic');
    Route::get('/busca-elastic25', [BuscaElasticController::class, 'buscar25'])->name('busca-elastic25');
    Route::get('/busca-elastic-filtrada', [BuscaElasticController::class, 'buscarFiltrada'])->name('busca-elastic-filtrada');
    Route::get('/busca-elastic-filtrada25', [BuscaElasticController::class, 'buscarFiltrada25'])->name('busca-elastic-filtrada25');
    // Updated to use Facelift version (wrapped in facebusca to handle segments)
    Route::get('/busca/{id?}/', '\App\Http\Controllers\PagesController@facebusca')->name('busca');

    // Loading Video
    Route::get('/loadingvideo', "\App\Http\Controllers\PagesController@loadingvideo")->name('loadingvideo');

    // ==============================================================
    // USER ACCOUNT ROUTES (Restored for Header Compatibility)
    // ==============================================================
    Route::get('/logar', "\App\Http\Controllers\PagesController@logar")->name('logar');
    Route::get('/recuperarsenha', "\App\Http\Controllers\PagesController@recuperarsenha")->name('recuperarsenha');
    Route::get('/logarbooks', "\App\Http\Controllers\PagesController@logarbooks")->name('logarbooks');
    Route::get('/cadastrar', "\App\Http\Controllers\PagesController@cadastrar")->name('cadastrar');
    Route::get('/hub', "\App\Http\Controllers\PagesController@hub")->name('hub');
    Route::get('/minhaconta', "\App\Http\Controllers\PagesController@minhaconta")->name('minhaconta');
    Route::get('/minhacontabooks', "\App\Http\Controllers\PagesController@minhacontabooks")->name('minhacontabooks');

    // ==============================================================
    // LANDING PAGES & POLICIES (Restored for Links)
    // ==============================================================
    //LandingPage 7 dias Assinar
    Route::get('/assine', "\App\Http\Controllers\PagesController@assine")->name('assine');

    // Promo Surya
    Route::get('/promosurya', "\App\Http\Controllers\PagesController@promosuryaemail")->name('promosuryaemail');

    //LandingPageALADO Assinar
    Route::get('/alado', "\App\Http\Controllers\PagesController@alado")->name('alado');
    Route::get('/alado/email', "\App\Http\Controllers\PagesController@aladoemail")->name('aladoemail');

    //Politicas
    Route::get('/politica', "\App\Http\Controllers\PagesController@politica")->name('politica');
    Route::get('/politicacancelamento/', '\App\Http\Controllers\PagesController@politicacancelamento')->name('politicacancelamento');
    Route::get('/politicatroca/', '\App\Http\Controllers\PagesController@politicatroca')->name('politicatroca');
    Route::get('/politicaentrega/', '\App\Http\Controllers\PagesController@politicaentrega')->name('politicaentrega');
    Route::get('/politicaseguranca/', '\App\Http\Controllers\PagesController@politicaseguranca')->name('politicaseguranca');
    Route::get('/perguntasfrequentes/', '\App\Http\Controllers\PagesController@perguntasfrequentes')->name('perguntasfrequentes');

    // Assinatura & Checkout Antigo (Required by some links)
    Route::get('/assinatura/{id?}/', '\App\Http\Controllers\PagesController@assinatura')->name('assinatura');
    Route::get('/checkout/{id?}/{artigos?}', '\App\Http\Controllers\PagesController@checkout')->name('checkout');

    // Teste
    Route::get('/teste', "\App\Http\Controllers\PagesController@teste")->name('teste');

    // ==============================================================
    // LEGACY ROUTES (COMMENTED OUT)
    // ==============================================================
    /*
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

    //Pagina revista e livro e produtoComprado
    Route::get('/revista/{id?}/{nome?}/{id_artigo?}/{nome_artigo?}/{variavel?}', '\App\Http\Controllers\PagesController@revista')->name('revista');
     //ARTIGOS
    Route::get('/artigo/{id?}/{nome?}/{id_artigo?}/{nome_artigo?}/{variavel?}', '\App\Http\Controllers\PagesController@artigo')->name('artigo');
    //COMPRA DE ARTIGOS
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
    */

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
    Route::get('/school/blog/{id}', "\App\Http\Controllers\PagesController@blogPost")->name('school.blog');

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

    // FINANCEIRO
    Route::get('/financial', [FinancialController::class, 'index'])->name('financial.index');
    Route::post('/financial', [FinancialController::class, 'store'])->name('financial.store');
    Route::put('/financial/{id}', [FinancialController::class, 'update'])->name('financial.update');
    Route::delete('/financial/{id}', [FinancialController::class, 'destroy'])->name('financial.destroy');
    Route::post('/financial/categories', [FinancialController::class, 'storeCategory'])->name('financial.categories.store');
    Route::post('/financial/suppliers', [FinancialController::class, 'storeSupplier'])->name('financial.suppliers.store');
    Route::put('/financial/{id}/confirm-payment', [FinancialController::class, 'confirmPayment'])->name('financial.confirm-payment');

    // Bank Accounts
    Route::resource('bank-accounts', \App\Http\Controllers\BankAccountController::class)->except(['create', 'edit', 'show']);

    // Payment Methods
    Route::resource('payment-methods', \App\Http\Controllers\PaymentMethodController::class)->except(['create', 'edit', 'show']);

    // Suppliers & Categories
    Route::resource('suppliers', \App\Http\Controllers\SupplierController::class)->except(['create', 'edit', 'show']);
    Route::resource('financial-categories', \App\Http\Controllers\FinancialCategoryController::class)->except(['create', 'edit', 'show']);

    // Remuneration
    Route::post('/remuneration/payroll', [\App\Http\Controllers\RemunerationController::class, 'generatePayroll'])->name('remuneration.payroll');

    // ESTOQUE
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
    Route::post('/inventory/{id}/stock', [InventoryController::class, 'stockEntry'])->name('inventory.stock.entry');

    // MARKETING
    Route::view('/marketing', 'marketing.index')->name('marketing.index');

    // GO INTELLIGENCE (DENTINO AI)
    Route::post('/gointelligence/proxy', [GoIntelligenceController::class, 'proxy'])->name('gointelligence.proxy');
    Route::get('/gointelligence', [GoIntelligenceController::class, 'index'])->name('gointelligence.index');

    // ANAMNESE OBRIGATÓRIA
    Route::get('/anamnese/{token}', [AnamnesisController::class, 'show'])->name('anamnesis.show');
    Route::post('/anamnese/{token}', [AnamnesisController::class, 'store'])->name('anamnesis.store');
    Route::get('/api/anamnese/{id}/status', [AnamnesisController::class, 'checkStatus'])->name('anamnesis.status');

    // MOCK SAVE GoTalks
    Route::post('/mock-save', [\App\Http\Controllers\PagesController::class, 'mockSave'])->name('mock-save');
});