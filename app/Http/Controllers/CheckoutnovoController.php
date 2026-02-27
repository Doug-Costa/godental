<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Client\PendingRequest;

class CheckoutnovoController extends Controller
{


    /**
     * TAREFA 1: Monta e exibe a página de checkout de forma inteligente.
     */
    public function show($typeOrPlanId1 = null, $planId1 = null, $planId2 = null)
    {
        $initialStep = 1;
        // Ajusta contexto a partir do primeiro parâmetro quando vier da rota tipada
        $checkoutType = null;
        if ($typeOrPlanId1 !== null && is_string($typeOrPlanId1) && in_array(strtolower($typeOrPlanId1), ['plano','produto','plan','product'])) {
            $checkoutType = strtolower($typeOrPlanId1);
            // Normaliza para 'plan' ou 'product'
            $checkoutType = in_array($checkoutType, ['plano','plan']) ? 'plan' : 'product';
        }
        if ($checkoutType) {
            session()->put('checkout_context', [
                'type' => $checkoutType === 'plan' ? 'plan' : 'product',
                'allowedPlanIds' => [], // será preenchido abaixo após resolver IDs
            ]);
            session()->save();
        }
        // NOVO: Se a rota não for tipada e o primeiro parâmetro for ID numérico, assumir 'product'
        if (!$checkoutType) {
            if ($typeOrPlanId1 !== null && (is_numeric($typeOrPlanId1) || (is_string($typeOrPlanId1) && ctype_digit($typeOrPlanId1)))) {
                $checkoutType = 'product';
                session()->put('checkout_context', [
                    'type' => 'product',
                    'allowedPlanIds' => [],
                ]);
                session()->save();
            }
        }
        $usuario = null;
        $filteredPlansObject = (object)['plans' => []];
        $subscriptionStatus = null; // Nova variável para o status da assinatura

                // Se o usuário já está logado, verificamos sua assinatura
        if (session()->has('token')) {
            $initialStep = 2;
            $usuario = session()->get('usuario');
            
            // Log detalhado para análise da discrepância
            Log::info('Análise completa do usuário da sessão:', [
                'usuario_id' => $usuario->id ?? 'N/A',
                'subscription_exists' => isset($usuario->subscription),
                'subscription_status' => $usuario->subscription->status ?? 'N/A',
                'subscription_planId' => $usuario->subscription->planId ?? 'N/A',
                'subscription_startAt' => $usuario->subscription->startAt ?? 'N/A',
                'subscription_expiresIn' => $usuario->subscription->expiresIn ?? 'N/A',
                'subscription_canceledAt' => $usuario->subscription->canceledAt ?? 'N/A',
                'subscription_overdue' => $usuario->subscription->overdue ?? 'N/A',
                'plan_status' => $usuario->subscription->plan->status ?? 'N/A',
                'dados_completos' => json_encode($usuario->subscription ?? 'sem subscription')
            ]);
             
             // Busca dados atualizados da API para comparação
             try {
                 $apiResponse = Http::withToken(session()->get('token'))->get('https://api.dentalgo.com.br/account/current-user');
                 
                 if ($apiResponse->status() === 401) {
                     Log::warning('Token inválido/expirado detectado em show(): limpando sessão e voltando para step 1');
                     session()->forget('token');
                     session()->forget('usuario');
                     session()->save();
                     $initialStep = 1;
                     $usuario = null;
                 } elseif ($apiResponse->successful()) {
                     $usuarioAtualizado = $apiResponse->object();
                     
                     Log::info('Dados atualizados da API:', [
                         'usuario_id' => $usuarioAtualizado->id ?? 'N/A',
                         'subscription_exists' => isset($usuarioAtualizado->subscription),
                         'subscription_status' => $usuarioAtualizado->subscription->status ?? 'N/A',
                         'subscription_planId' => $usuarioAtualizado->subscription->planId ?? 'N/A',
                         'subscription_startAt' => $usuarioAtualizado->subscription->startAt ?? 'N/A',
                         'subscription_expiresIn' => $usuarioAtualizado->subscription->expiresIn ?? 'N/A',
                         'subscription_canceledAt' => $usuarioAtualizado->subscription->canceledAt ?? 'N/A',
                         'subscription_overdue' => $usuarioAtualizado->subscription->overdue ?? 'N/A',
                         'plan_status' => $usuarioAtualizado->subscription->plan->status ?? 'N/A'
                     ]);
                     
                     // Compara os dados
                     $statusSessao = $usuario->subscription->status ?? 'N/A';
                     $statusAPI = $usuarioAtualizado->subscription->status ?? 'N/A';
                     
                     if ($statusSessao !== $statusAPI) {
                         Log::warning('DISCREPÂNCIA ENCONTRADA!', [
                             'status_na_sessao' => $statusSessao,
                             'status_na_api' => $statusAPI,
                             'diferenca_detectada' => true
                         ]);
                         
                         // Atualiza a sessão com dados mais recentes
                         $usuarioAtualizado->tipoUsuario = 'pessoal';
                         session()->put('usuario', $usuarioAtualizado);
                         session()->save();
                         $usuario = $usuarioAtualizado;
                         
                         Log::info('Sessão atualizada com dados da API');
                     }
                 }
             } catch (\Exception $e) {
                 Log::error('Erro ao buscar dados atualizados da API: ' . $e->getMessage());
             }
            
            // Verifica se o usuário possui uma assinatura ativa
            // Baseado no objeto subscription que já vem no usuário da sessão
            if (isset($usuario->subscription) && 
                isset($usuario->subscription->status) && 
                isset($usuario->subscription->plan) && 
                isset($usuario->subscription->plan->status)) {
                
                $subscriptionStatus = trim($usuario->subscription->status);
                $planStatus = $usuario->subscription->plan->status;
                $paymentValidationRequired = session()->get('payment_validation_required', false);
                
                // Verifica se a assinatura está ativa E o plano está ativo (status true)
                // Também verifica se não está cancelada ou expirada
                if ($subscriptionStatus === 'active' && 
                    $planStatus === true && 
                    (is_null($usuario->subscription->canceledAt) || $usuario->subscription->canceledAt === null)) {
                    
                    // Se há flag de validação de pagamento pendente, considera como inativa
                    if (!$paymentValidationRequired) {
                        $subscriptionStatus = 'active';
                    } else {
                        Log::warning('Assinatura marcada como ativa mas com validação de pagamento pendente', [
                            'user_id' => $usuario->id ?? 'N/A',
                            'subscription_id' => $usuario->subscription->id ?? 'N/A'
                        ]);
                        $subscriptionStatus = null; // Permite prosseguir com a compra
                    }
                } else {
                    $subscriptionStatus = null; // Permite prosseguir com a compra
                }
            }
        }

        // 1. Define a lista de IDs permitidos com base na URL
        // Considera a assinatura nova (primeiro param pode ser o tipo) e a antiga (primeiro param já é um ID)
        $urlPlanIds = [];
        if ($checkoutType) {
            // Rota tipada: IDs vêm em $planId1 e $planId2
            $urlPlanIds = array_filter([$planId1, $planId2], function($v){ return $v !== null && $v !== ''; });
        } else {
            // Rota antiga: $typeOrPlanId1 é o primeiro possível ID
            $urlPlanIds = array_filter([$typeOrPlanId1, $planId1], function($v){ return $v !== null && $v !== ''; });
        }

        if (!empty($urlPlanIds)) {
            // Se a URL contém IDs, eles serão os únicos itens exibidos
            $allowedPlanIds = $urlPlanIds;
        } else {
            // Se a URL não tem IDs: para planos usamos um padrão, para produto mantemos vazio
            $allowedPlanIds = (($checkoutType ?: 'plan') === 'plan') ? [262] : [];
        }

        // Variáveis para prévia de itens parciais (usadas na view do checkout novo)
        $partialItems = [];
        $partialTotalPrice = 0;

        try {
            if (($checkoutType ?: 'plan') === 'plan') {
                // Busca todos os planos da API e filtra pelos IDs permitidos
                $response = Http::get('https://api.dentalgo.com.br/catalog/plans');

                if ($response->successful()) {
                    $allPlansData = $response->object();
                    
                    // Filtra a lista completa de planos usando a nossa lista de IDs permitidos
                    if (isset($allPlansData->plans) && is_array($allPlansData->plans)) {
                        $filteredPlans = array_filter($allPlansData->plans, function($plan) use ($allowedPlanIds) {
                            return isset($plan->id) && in_array($plan->id, $allowedPlanIds);
                        });
                        $filteredPlansObject->plans = array_values($filteredPlans);
                    }
                }
            } else {
                // Tipo: produto. Busca os dados do(s) produto(s) específico(s)
                $products = [];
                $tokenPreview = session()->get('token');

                // NOVO: suportar casos de PARCIAL apenas com productItemsIds (sem productId)
                try {
                    $productItemsIdsRaw = request()->input('productItemsIds', request()->input('q.productItemsIds', null));
                    if ($productItemsIdsRaw === null) {
                        $q = request()->input('q');
                        if (is_array($q) && isset($q['productItemsIds'])) {
                            $productItemsIdsRaw = $q['productItemsIds'];
                        }
                    }
                    $productItemsIds = null;
                    if (is_string($productItemsIdsRaw)) {
                        $parts = preg_split('/[\s,;]+/', trim($productItemsIdsRaw));
                        $productItemsIds = array_values(array_filter(array_map(function($v){ return ctype_digit((string)$v) ? (int)$v : null; }, $parts), function($v){ return $v !== null; }));
                    } elseif (is_array($productItemsIdsRaw)) {
                        $productItemsIds = array_values(array_map('intval', $productItemsIdsRaw));
                    }

                    if (!empty($productItemsIds)) {
                        Log::info('Checkout PARCIAL detectado na show(): productItemsIds=' . json_encode($productItemsIds));
                        if ($tokenPreview) {
                            $queryParams = [];
                            foreach ($productItemsIds as $index => $id) {
                                $queryParams["q[productItemsIds][$index]"] = $id;
                            }
                            try {
                                $previewResp = Http::withToken($tokenPreview)->get(
                                    'https://api.dentalgo.com.br/catalog/purchases/preview',
                                    $queryParams
                                );
                                if ($previewResp->successful()) {
                                    $pr = $previewResp->object();
                                    $priceCents = $pr->price ?? ($pr->priceCents ?? 0);

                                    // Guarda itens e total para exibir resumo detalhado na Etapa 3
                                    if (isset($pr->productItems)) {
                                        // Mantém estrutura como veio da API (array de stdClass)
                                        $partialItems = is_array($pr->productItems) ? $pr->productItems : (array) $pr->productItems;
                                    }
                                    $partialTotalPrice = (int) $priceCents;

                                    // Apenas o card sintético deve aparecer quando for parcial
                                    $products[] = (object) [
                                        'id' => 0,
                                        'title' => 'Itens selecionados',
                                        'description' => 'Conteúdo parcial',
                                        'price' => $priceCents,
                                        'cover' => null,
                                    ];
                                } else {
                                    Log::warning('Preview de itens retornou falha na show(): HTTP ' . $previewResp->status());
                                }
                            } catch (\Exception $e) {
                                Log::warning('Falha na preview de itens na show(): ' . $e->getMessage());
                            }
                        } else {
                            // Sem token: tenta inferir itens e preço a partir do endpoint público do produto da URL
                            try {
                                $productIdFromUrl = !empty($allowedPlanIds) ? (int) $allowedPlanIds[0] : null;
                                $computedTotal = 0;
                                $collectedItems = [];
                                if ($productIdFromUrl) {
                                    $prodResp = Http::get('https://api.dentalgo.com.br/catalog/products/' . $productIdFromUrl);
                                    if ($prodResp->successful()) {
                                        $p = $prodResp->object();
                                        $items = isset($p->productItems) && is_array($p->productItems) ? $p->productItems : [];
                                        // filtra itens pelos IDs informados
                                        foreach ($items as $it) {
                                            $itId = $it->id ?? null;
                                            if ($itId !== null && in_array((int)$itId, $productItemsIds, true)) {
                                                $collectedItems[] = $it; // mantém objeto original
                                                $computedTotal += (int) ($it->price ?? 0);
                                            }
                                        }
                                    }
                                }
                                if (!empty($collectedItems)) {
                                    $partialItems = $collectedItems;
                                    $partialTotalPrice = (int) $computedTotal;
                                } else {
                                    Log::warning('Sem token e não foi possível obter itens públicos para os IDs: ' . json_encode($productItemsIds));
                                    $partialItems = [];
                                    $partialTotalPrice = 0;
                                }

                                // Cria card sintético com o total calculado (ou zero, se não encontrado)
                                $products[] = (object) [
                                    'id' => 0,
                                    'title' => 'Itens selecionados',
                                    'description' => 'Conteúdo parcial',
                                    'price' => $partialTotalPrice,
                                    'cover' => null,
                                ];
                            } catch (\Exception $e) {
                                Log::warning('Falha ao montar prévia pública para itens parciais: ' . $e->getMessage());
                                // Fallback: ainda cria um card genérico para não exibir mensagem de erro
                                $products[] = (object) [
                                    'id' => 0,
                                    'title' => 'Itens selecionados',
                                    'description' => 'Conteúdo parcial',
                                    'price' => 0,
                                    'cover' => null,
                                ];
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::warning('Erro ao processar productItemsIds no show(): ' . $e->getMessage());
                }

                // Quando NÃO for parcial, incluímos os cartões dos produtos "brutos" normalmente
                $isPartialSelection = !empty($productItemsIds ?? []);
                if (!$isPartialSelection) {
                    foreach ($allowedPlanIds as $pid) {
                    try {
                        $idValue = (int) $pid;
                        $title = 'Produto';
                        $description = '';
                        $cover = null;
                        $priceCents = 0;

                        // 1) Tenta usar o endpoint de PREVIEW (como no checkout antigo), se houver token
                        $previewOk = false;
                        if ($tokenPreview) {
                            try {
                                $previewResp = Http::withToken($tokenPreview)->get(
                                    'https://api.dentalgo.com.br/catalog/purchases/preview',
                                    [ 'q[productId]' => $pid ]
                                );
                                if ($previewResp->successful()) {
                                    $pr = $previewResp->object();
                                    // Mapeamento flexível dos campos esperados para a view
                                    $pObj = $pr->product ?? null;
                                    if ($pObj) {
                                        $idValue = $pObj->id ?? $idValue;
                                        $title = $pObj->title ?? ($pObj->name ?? $title);
                                        $description = $pObj->description ?? $description;
                                        $cover = $pObj->cover ?? ($pObj->thumbnail ?? $cover);
                                        $priceCents = $pr->price ?? ($pr->priceCents ?? ($pObj->price ?? $priceCents));
                                    } else {
                                        // fallback para campos na raiz
                                        $idValue = $pr->id ?? $idValue;
                                        $title = $pr->title ?? ($pr->name ?? $title);
                                        $description = $pr->description ?? $description;
                                        $cover = $pr->cover ?? ($pr->thumbnail ?? $cover);
                                        $priceCents = $pr->price ?? ($pr->priceCents ?? $priceCents);
                                    }
                                    $previewOk = true;
                                }
                            } catch (\Exception $e) {
                                Log::warning('Falha na preview do produto ID ' . $pid . ': ' . $e->getMessage());
                            }
                        }

                        // 2) Fallback para endpoint público de produto, caso preview falhe ou sem token
                        if (!$previewOk) {
                            $prodResp = Http::get('https://api.dentalgo.com.br/catalog/products/' . $pid);
                            if ($prodResp->successful()) {
                                $p = $prodResp->object();
                                if ($p) {
                                    $idValue = $p->id ?? $idValue;
                                    $title = $p->title ?? ($p->name ?? $title);
                                    $description = $p->description ?? $description;
                                    $cover = $p->cover ?? ($p->thumbnail ?? $cover);
                                    $priceCents = $p->price ?? $priceCents;
                                }
                            }
                        }

                        $products[] = (object) [
                            'id' => $idValue,
                            'title' => $title,
                            'description' => $description,
                            'price' => $priceCents,
                            'cover' => $cover,
                        ];
                    } catch (\Exception $e) {
                        // Ignora erro individual de produto para não quebrar a página
                        Log::warning('Falha ao buscar produto ID ' . $pid . ': ' . $e->getMessage());
                    }
                }
                $filteredPlansObject->plans = $products;
            }
            }
        } catch (\Exception $e) {
            // Trata falha na API
            Log::error('Erro ao buscar dados para o checkout: ' . $e->getMessage());
        }

        // Atualiza contexto em sessão com allowedPlanIds e tipo preservando o contexto anterior
        $currentCtx = session()->get('checkout_context', []);
        $typeToPersist = $checkoutType ?: 'plan';
        session()->put('checkout_context', [
            'type' => $typeToPersist,
            'allowedPlanIds' => array_values($allowedPlanIds),
        ]);
        session()->save();

        // Busca parâmetros do sistema (percentual de desconto para assinante)
        $subscriberPurchaseDiscountPercent = 0;
        try {
            $sysResp = Http::get('https://api.dentalgo.com.br/catalog/system-parameters');
            if ($sysResp->successful()) {
                $sysObj = $sysResp->object();
                if (isset($sysObj->subscriberPurchaseDiscountPercent)) {
                    $subscriberPurchaseDiscountPercent = (int) $sysObj->subscriberPurchaseDiscountPercent;
                }
            } else {
                Log::warning('Falha ao obter system-parameters: HTTP ' . $sysResp->status());
            }
        } catch (\Exception $e) {
            Log::warning('Exceção ao obter system-parameters: ' . $e->getMessage());
        }

        // Envia a lista JÁ FILTRADA para a view
        return view('checkoutnovo', [
            'initialStep' => $initialStep,
            'usuario' => $usuario,
            'plans' => $filteredPlansObject,
            'subscriptionStatus' => $subscriptionStatus,
            'checkoutType' => $typeToPersist,
            // NOVO: dados para o resumo dos itens parciais
            'partialItems' => $partialItems,
            'partialTotalPrice' => $partialTotalPrice,
            // NOVO: percent de desconto do assinante
            'subscriberPurchaseDiscountPercent' => $subscriberPurchaseDiscountPercent,
        ]);
    }

    /**
     * TAREFA 2: Processa o login do formulário e cria a sessão completa.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Campos inválidos.'], 422);
        }

        // 1. Pega o token
        $loginResponse = Http::asForm()->post('https://api.dentalgo.com.br/sessions/sign-in', [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        if (!$loginResponse->successful() || !isset($loginResponse->object()->token)) {
            $status = $loginResponse->status();
            $body = null;
            $code = null;
            $message = 'Credenciais inválidas.';

            // Tenta parsear a resposta da API para obter detalhes (code/message)
            try {
                $body = $loginResponse->json();
                if (is_array($body)) {
                    $code = $body['code'] ?? $body['errorCode'] ?? null;
                    $message = $body['message'] ?? $body['errorMessage'] ?? $message;
                }
            } catch (\Throwable $e) {
                // Ignora erros de parse e mantém mensagem genérica
            }

            // Log auxiliar para diagnosticar a causa do 401/404 no ambiente
            try {
                \Log::warning('Falha no login via DentalGo (sign-in)', [
                    'status' => $status,
                    'code' => $code,
                    'message' => $message,
                    'raw_body' => is_string($loginResponse->body()) ? substr($loginResponse->body(), 0, 500) : null,
                ]);
            } catch (\Throwable $e) {}

            // Mapeia de forma explícita "usuário não encontrado"
            $isUserNotFound = ($code === 'userNotFound')
                || (is_string($message) && preg_match('/(usu[aá]rio|user).*(n[aã]o encontrado|not found|inexistente)/i', $message))
                || ($status === 404);

            if ($isUserNotFound) {
                return response()->json([
                    'success' => false,
                    'code' => 'userNotFound',
                    'message' => 'Usuário não encontrado.'
                ], 404);
            }

            // Mapeia senha incorreta
            $isWrongPassword = ($code === 'wrongPassword')
                || (is_string($message) && preg_match('/(senha|password).*(incorreta|errada|wrong)/i', $message));

            if ($isWrongPassword) {
                return response()->json([
                    'success' => false,
                    'code' => 'wrongPassword',
                    'message' => 'Senha incorreta.'
                ], 401);
            }

            // Caso a API tenha retornado algum outro status 4xx, repassa esse status e mensagem
            if ($status >= 400 && $status < 500) {
                return response()->json([
                    'success' => false,
                    'code' => $code,
                    'message' => $message
                ], $status);
            }

            // Fallback
            return response()->json(['success' => false, 'message' => 'Credenciais inválidas.'], 401);
        }
    
        // 2. Com o token, busca os dados completos do usuário
        $token = $loginResponse->object()->token;
        $userResponse = Http::withToken($token)->get('https://api.dentalgo.com.br/account/current-user');

        if (!$userResponse->successful()) {
            return response()->json(['message' => 'Não conseguimos obter os detalhes da sua conta.'], 400);
        }
    
        // 3. Prepara o objeto de usuário antes de salvar
        $usuario = $userResponse->object();
        
        // ===================================================================
        // AQUI ESTÁ A CORREÇÃO: Adiciona a propriedade 'tipoUsuario'
        // ===================================================================
        $usuario->tipoUsuario = 'pessoal';

        // 4. SOLUÇÃO ROBUSTA: Salva dados na sessão com verificação múltipla
        Log::info('🔄 Salvando token na sessão: ' . substr($token, 0, 20) . '...');
        
        // Salva os dados na sessão usando múltiplas tentativas
        for ($i = 0; $i < 3; $i++) {
            session()->put('token', $token);
            session()->put('usuario', $usuario);
            session()->save();
            
            // Verifica se foi salvo corretamente
            if (session()->get('token') === $token && session()->get('usuario')) {
                Log::info('✓ Dados salvos com sucesso na tentativa ' . ($i + 1));
                break;
            }
            
            Log::warning('⚠️ Tentativa ' . ($i + 1) . ' de salvar dados falhou, tentando novamente...');
            usleep(100000); // Aguarda 100ms antes da próxima tentativa
        }
        
        // Verifica se a sessão foi salva corretamente
        $tokenSalvo = session()->get('token');
        $usuarioSalvo = session()->get('usuario');
        
        Log::info('✓ Token após salvar: ' . ($tokenSalvo ? substr($tokenSalvo, 0, 20) . '...' : 'AUSENTE'));
        Log::info('✓ Usuário após salvar: ' . ($usuarioSalvo ? 'PRESENTE' : 'AUSENTE'));
        Log::info('✓ Session ID: ' . session()->getId());
        
        if (!$tokenSalvo || !$usuarioSalvo) {
            Log::error('✗ Erro: Token ou usuário não foram salvos na sessão');
            return response()->json(['success' => false, 'message' => 'Erro ao salvar dados da sessão.'], 500);
        }

        return response()->json(['success' => true]);
   }

    /**
     * Verifica se o token da sessão é válido via API da DentalGo
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateToken()
    {
        // Verifica se existe token na sessão
        if (!session()->has('token')) {
            return response()->json([
                'valid' => false,
                'message' => 'Token não encontrado na sessão'
            ], 401);
        }

        $token = session()->get('token');

        try {
            // Usa um endpoint de leitura e sem efeitos colaterais para validar o token
            $response = Http::withToken($token)->get('https://api.dentalgo.com.br/account/current-user');

            // Token inválido/expirado
            if ($response->status() === 401) {
                Log::warning('Token inválido/expirado na validação. Limpando sessão.', [
                    'token_prefix' => substr($token, 0, 20) . '...'
                ]);
                session()->flush();

                return response()->json([
                    'valid' => false,
                    'message' => 'Token inválido, sessão limpa'
                ], 401);
            }

            // Falhas não-401
            if (!$response->successful()) {
                Log::warning('Falha ao validar token em account/current-user', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return response()->json([
                    'valid' => false,
                    'message' => 'Erro ao validar token'
                ], 500);
            }

            // Token válido: sincroniza os dados mais recentes do usuário na sessão
            $usuarioAtualizado = $response->object();
            if ($usuarioAtualizado) {
                $usuarioAtualizado->tipoUsuario = 'pessoal';
                session()->put('usuario', $usuarioAtualizado);
                session()->save();
            }

            return response()->json([
                'valid' => true,
                'message' => 'Token válido'
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao validar token via account/current-user: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'message' => 'Erro ao validar token: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Retorna os dados atualizados do usuário logado
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserStatus()
    {
        if (!session()->has('token')) {
            return response()->json(['message' => 'Usuário não logado.'], 401);
        }

        $usuario = session()->get('usuario');
        
        if (!$usuario) {
            return response()->json(['message' => 'Dados do usuário não encontrados.'], 404);
        }

        // Força a gravação da sessão para garantir persistência
        session()->save();
        
        // Retorna os dados do usuário da sessão
        return response()->json($usuario);
    }

    /**
     * Processa o pagamento do checkout seguindo o padrão do CheckoutController
     * Suporta tanto produtos individuais quanto itens de produtos
     */
    public function processPayment(Request $request)
    {
        Log::info('=== INICIANDO PROCESSAMENTO DE PAGAMENTO ===');
        Log::info('Timestamp: ' . now()->toISOString());
        Log::info('Request Method: ' . $request->method());
        Log::info('Request URL: ' . $request->fullUrl());
        Log::info('Request Headers: ' . json_encode($request->headers->all()));
        Log::info('Request IP: ' . $request->ip());
        Log::info('Request User Agent: ' . $request->userAgent());
        Log::info('Request Content Type: ' . $request->header('Content-Type'));
        Log::info('Request completa: ' . json_encode($request->all()));
        Log::info('Request input count: ' . count($request->all()));
        Log::info('Session data: ' . json_encode(session()->all()));
        Log::info('CSRF Token from request: ' . $request->header('X-CSRF-TOKEN'));
        Log::info('CSRF Token from session: ' . session()->token());
        
        // PRIMEIRO: Verifica se o token ainda está na sessão
        $tokenAtual = session()->get('token');
        $usuarioAtual = session()->get('usuario');
        
        Log::info('🔍 Verificação de sessão no início do pagamento:');
        Log::info('- Token: ' . ($tokenAtual ? substr($tokenAtual, 0, 20) . '...' : 'AUSENTE'));
        Log::info('- Usuário: ' . ($usuarioAtual ? 'PRESENTE' : 'AUSENTE'));
        Log::info('- Todos os dados da sessão: ' . json_encode(session()->all()));
        
        // Recebe o cardHash (token) gerado pelo frontend via Iugu
        $cardHash = $request->input('token');
        $paymentGatewayType = 'iugu';
        // Aceita 'plan_id' (snake_case) e 'planId' (camelCase) por compatibilidade
        $planId = $request->input('plan_id', $request->input('planId'));
        
        // Normaliza productItemsIds a partir de múltiplas possíveis fontes (corpo e query)
        $productItemsIdsRaw = $request->input('productItemsIds', $request->input('q.productItemsIds', null));
        if ($productItemsIdsRaw === null) {
            $q = $request->input('q');
            if (is_array($q) && isset($q['productItemsIds'])) {
                $productItemsIdsRaw = $q['productItemsIds'];
            }
        }
        if (is_string($productItemsIdsRaw)) {
            $parts = preg_split('/[\s,;]+/', trim($productItemsIdsRaw));
            $productItemsIds = array_values(array_filter(array_map(function($v){ return ctype_digit((string)$v) ? (int)$v : null; }, $parts), function($v){ return $v !== null; }));
        } elseif (is_array($productItemsIdsRaw)) {
            $productItemsIds = array_values(array_map('intval', $productItemsIdsRaw));
        } else {
            $productItemsIds = null;
        }
        
        // Contexto do checkout
        $explicitType = $request->input('itemType', $request->input('type'));
        $checkoutContext = session()->get('checkout_context', []);
        $contextType = isset($checkoutContext['type']) ? strtolower((string)$checkoutContext['type']) : '';
        $allowedPlanIdsCtx = $checkoutContext['allowedPlanIds'] ?? [];
        
        // Deriva o productId como no checkout original: pela URL (segmento 2) e fallbacks
        $productId = null;
        $seg2 = $request->segment(2);
        $seg3 = $request->segment(3);
        $seg2lower = is_string($seg2) ? strtolower($seg2) : '';
        // Novo: prioriza product_id/productId enviado no corpo da requisição
        $productIdFromReq = $request->input('product_id', $request->input('productId'));
        if ($productIdFromReq !== null && ctype_digit((string)$productIdFromReq)) {
            $productId = (int)$productIdFromReq;
        }
        if ($seg2 && ctype_digit((string)$seg2) && $productId === null) {
            $productId = (int)$seg2;
        } elseif (in_array($seg2lower, ['product','produto'])) {
            if ($seg3 && ctype_digit((string)$seg3) && $productId === null) {
                $productId = (int)$seg3;
            }
        }
        if ($productId === null && $planId !== null && ctype_digit((string)$planId)) {
            $productId = (int)$planId; // fallback quando o front envia o id do produto em planId
        }
        if ($productId === null && !empty($allowedPlanIdsCtx) && count($allowedPlanIdsCtx) === 1) {
            $only = $allowedPlanIdsCtx[0];
            if (ctype_digit((string)$only)) {
                $productId = (int)$only;
            }
        }
        
        Log::info('Dados extraídos:');
        Log::info('- cardHash: ' . ($cardHash ? 'Presente (' . strlen($cardHash) . ' chars)' : 'AUSENTE'));
        Log::info('- paymentGatewayType: ' . $paymentGatewayType);
        Log::info('- planId (bruto): ' . ($planId !== null ? $planId : 'AUSENTE'));
        Log::info('- productId (derivado): ' . ($productId !== null ? $productId : 'AUSENTE'));
        Log::info('- productItemsIds: ' . (!empty($productItemsIds) ? json_encode($productItemsIds) : 'AUSENTE'));

        // Detecta tipo do item (assinatura/plano vs produto) com múltiplas fontes
        $isSubscription = false;
        if ($explicitType) {
            $t = strtolower($explicitType);
            if (in_array($t, ['plan','plano','subscription','assinatura'])) {
                $isSubscription = true;
            } elseif (in_array($t, ['product','produto'])) {
                $isSubscription = false;
            }
        } elseif ($contextType) {
            if (in_array($contextType, ['plan','plano','subscription','assinatura'])) {
                $isSubscription = true;
            } elseif (in_array($contextType, ['product','produto'])) {
                $isSubscription = false;
            }
        } elseif (!empty($productItemsIds)) {
            $isSubscription = false;
        }
        // Preferência pela URL: se a rota indicar produto explicitamente ou o segundo segmento for numérico, força produto
        $forceProductByUrl = false;
        if (($seg2 && ctype_digit((string)$seg2)) || (in_array($seg2lower, ['product','produto']) && $seg3 && ctype_digit((string)$seg3))) {
            $forceProductByUrl = true;
        }
        if ($forceProductByUrl) {
            $isSubscription = false;
        }
        // Se não veio tipo explícito e temos indícios de produto (productId ou productItemsIds), tratar como produto
        if (!$explicitType && ($productId !== null || !empty($productItemsIds))) {
            $isSubscription = false;
        }
        // Se nada informar o tipo, assume assinatura apenas quando IDs permitidos vieram de plano explicitamente
        if (!$explicitType && !$isSubscription && $productId === null && empty($productItemsIds) && $planId !== null && !empty($allowedPlanIdsCtx) && in_array((int)$planId, array_map('intval', $allowedPlanIdsCtx))) {
            $isSubscription = true;
        }
        Log::info('- Tipo detectado: ' . ($isSubscription ? 'ASSINATURA (plano)' : 'PRODUTO'));

        // Validação básica
        Log::info('Iniciando validação dos dados...');
        $erro = 0;
        if ($cardHash === null) {
            Log::error('✗ cardHash ausente');
            $erro = 1;
        }
        if ($paymentGatewayType === null) {
            Log::error('✗ paymentGatewayType ausente');
            $erro = 1;
        }
        
        if ($isSubscription) {
            if ($planId === null || !ctype_digit((string)$planId)) {
                Log::error('✗ Assinatura selecionada, mas planId ausente ou inválido');
                $erro = 1;
            }
        } else {
            // Para produto, exige productId OU productItemsIds
            if ($productId === null && empty($productItemsIds)) {
                Log::error('✗ Compra de produto sem productId e sem productItemsIds');
                $erro = 1;
            }
        }
        if($erro == 1){
            Log::error('ERRO: Validação falhou - retornando erro 400');
            return response()->json([
                'success' => false,
                'message' => 'Dados de pagamento inválidos. Informe o plano ou produto corretamente.'
            ], 400);
        }
        Log::info('✓ Validação concluída com sucesso');

        // Preparar dados para a API
        Log::info('Preparando dados para a API...');
        if ($isSubscription) {
            Log::info('Modo: Assinatura (plano)');
            $infoAssinatura = [
                'cardHash' => (string)$cardHash,
                'paymentGatewayType' => (string)$paymentGatewayType,
                'couponCode' => '',
                // Envia no formato esperado pela API: objeto plan com id
                'plan' => ['id' => (int)$planId],
            ];
            $url = 'https://api.dentalgo.com.br/catalog/subscriptions';
            Log::info('URL da API (subscriptions): ' . $url);
        } else {
            if (empty($productItemsIds)) {
                Log::info('Modo: Produto simples (sem productItemsIds)');
                $infoAssinatura = [
                    'cardHash' => (string)$cardHash,
                    'paymentGatewayType' => (string)$paymentGatewayType,
                    'couponCode' => '',
                ];
                $url = 'https://api.dentalgo.com.br/catalog/purchases/products/' . $productId;
                Log::info('URL da API (products): ' . $url);
            } else {
                Log::info('Modo: Itens de produtos');
                $productItemsIds = array_map('intval', $productItemsIds);
                $infoAssinatura = [
                    'cardHash' => (string)$cardHash,
                    'paymentGatewayType' => (string)$paymentGatewayType,
                    'couponCode' => '',
                    'productItemsIds' => $productItemsIds,
                ];
                $url = 'https://api.dentalgo.com.br/catalog/purchases/product-items';
                Log::info('URL da API: ' . $url);
            }
        }

        $infoAssinaturaJ = json_encode($infoAssinatura);
        $token = session()->get('token');
        
        Log::info('Dados preparados para envio:');
        Log::info('- infoAssinatura: ' . $infoAssinaturaJ);
        Log::info('- token da sessão: ' . ($token ? 'Presente (' . strlen($token) . ' chars)' : 'AUSENTE'));

        // Validar se o token da sessão existe
        if (!$token) {
            Log::error('ERRO: Token da sessão não encontrado');
            Log::error('Dados da sessão atual: ' . json_encode(session()->all()));
            return response()->json([
                'success' => false,
                'message' => 'Sessão expirada. Faça login novamente'
            ], 401);
        }
        
        // Força a gravação da sessão antes de fazer a requisição
        session()->save();

        // Fazer requisição para a API da DentalGo (como no original)
        Log::info('Iniciando chamada cURL para a API...');
        
        $ch = curl_init($url); 
        $authorization = "Authorization: Bearer ".session()->get('token');
        
        Log::info('Configurando cURL:');
        Log::info('- URL: ' . $url);
        Log::info('- Authorization header: Bearer [TOKEN_PRESENTE]');
        
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $infoAssinaturaJ);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        // Timeouts para evitar travas (não altera comportamento do original)
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_TIMEOUT, 45);
        
        Log::info('Executando requisição cURL...');
        $result = curl_exec($ch);
        
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        
        curl_close($ch);
        
        Log::info('Resposta da API recebida:');
        Log::info('- HTTP Code: ' . $httpCode);
        Log::info('- cURL Error: ' . ($curlError ? $curlError : 'Nenhum'));
        Log::info('- Response Body: ' . $result);

        $retorno = json_decode($result);
        Log::info('Response decodificada: ' . json_encode($retorno));

        // Tratar resposta (como no original)
        Log::info('Iniciando tratamento da resposta...');
        
        if(isset($retorno->code)){
            Log::info('Resposta contém código de erro: ' . $retorno->code);
            
            if($retorno->code == "unknown"){
                Log::error('Erro "unknown" detectado');
                if(isset($retorno->additionalProperties->errors->cpf_cnpj)){
                    Log::error('Erro específico: CPF/CNPJ inválido');
                    return response()->json([
                        'success' => false,
                        'message' => 'CPF/CNPJ inválido'
                    ], 400);
                }else{
                    Log::error('Erro genérico nos dados do cartão');
                    return response()->json([
                        'success' => false,
                        'message' => 'Erro nos dados do cartão'
                    ], 400);
                }
            }elseif($retorno->code == "unauthorized"){
                Log::error('Erro de autorização - sessão expirada');
                return response()->json([
                    'success' => false,
                    'message' => 'Sessão expirada. Faça login novamente'
                ], 401);
            }elseif($retorno->code == "purchasePaymentError"){
                Log::error('Erro no processamento do pagamento');
                return response()->json([
                    'success' => false,
                    'message' => 'Erro no processamento do pagamento. Verifique os dados do cartão'
                ], 400);
            }elseif($retorno->code == "recordNotFound"){
                Log::error('Registro não encontrado na API: ' . json_encode($retorno->additionalProperties ?? []));
                return response()->json([
                    'success' => false,
                    'message' => 'Item não encontrado. Verifique o identificador informado.'
                ], 404);
            }else{
                Log::error('Código de erro não reconhecido: ' . $retorno->code);
                return response()->json([
                    'success' => false,
                    'message' => 'Erro desconhecido: ' . $retorno->code
                ], 400);
            }
        }else{
            Log::info('✓ Resposta indica sucesso - sem código de erro');
            if ($isSubscription) {
                Log::info('Verificando status da assinatura via /subscription...');
                // Verificar status da assinatura via API DentalGo (igual ao AssinaturaController)
                $subscriptionUrl = 'https://api.dentalgo.com.br/subscription';
                $chSub = curl_init($subscriptionUrl);
                $authorizationSub = "Authorization: Bearer " . session()->get('token');
                Log::info('Configurando verificação de status:');
                Log::info('- URL: ' . $subscriptionUrl);
                curl_setopt($chSub, CURLOPT_HTTPGET, 1);
                curl_setopt($chSub, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($chSub, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorizationSub));
                Log::info('Executando verificação de status (GET)...');
                $subscriptionResult = curl_exec($chSub);
                $subscriptionHttpCode = curl_getinfo($chSub, CURLINFO_HTTP_CODE);
                $subscriptionCurlError = curl_error($chSub);
                curl_close($chSub);
                Log::info('Resposta da verificação de status:');
                Log::info('- HTTP Code: ' . $subscriptionHttpCode);
                Log::info('- cURL Error: ' . ($subscriptionCurlError ? $subscriptionCurlError : 'Nenhum'));
                Log::info('- Response Body: ' . $subscriptionResult);
                $subscriptionRetorno = json_decode($subscriptionResult);
                // Verificar se houve erro na consulta de status
                if (isset($subscriptionRetorno->code)) {
                    Log::error('Erro na verificação de status: ' . $subscriptionRetorno->code);
                    if ($subscriptionRetorno->code == 'unauthorized') {
                        Log::error('Token expirado durante verificação de status');
                        return response()->json([
                            'success' => false,
                            'message' => 'Sessão expirada. Faça login novamente'
                        ], 401);
                    } elseif ($subscriptionRetorno->code == 'subscriptionExpired') {
                        Log::error('Assinatura expirada ou pagamento inválido na verificação de status');
                        return response()->json([
                            'success' => false,
                            'message' => __('messages.Checkoutformainvalidaexpirada')
                        ], 400);
                    } else {
                        Log::error('Erro inesperado na verificação de status: ' . $subscriptionRetorno->code);
                        // Fallback: validar assinatura via /account/current-user
                        Log::info('Tentando fallback de validação via /account/current-user...');
                        $currentUserUrlFallback = 'https://api.dentalgo.com.br/account/current-user';
                        $chUserFallback = curl_init($currentUserUrlFallback);
                        $authorizationUserFallback = "Authorization: Bearer " . session()->get('token');
                        curl_setopt($chUserFallback, CURLOPT_HTTPGET, 1);
                        curl_setopt($chUserFallback, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($chUserFallback, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorizationUserFallback));
                        $fallbackUserResult = curl_exec($chUserFallback);
                        $fallbackUserHttpCode = curl_getinfo($chUserFallback, CURLINFO_HTTP_CODE);
                        $fallbackUserCurlError = curl_error($chUserFallback);
                        curl_close($chUserFallback);
                        Log::info('Resposta do fallback /account/current-user:');
                        Log::info('- HTTP Code: ' . $fallbackUserHttpCode);
                        Log::info('- cURL Error: ' . ($fallbackUserCurlError ? $fallbackUserCurlError : 'Nenhum'));
                        Log::info('- Response Body: ' . $fallbackUserResult);
                        $fallbackUserRetorno = json_decode($fallbackUserResult);
                        if ($fallbackUserRetorno && !isset($fallbackUserRetorno->code)) {
                            $sub = $fallbackUserRetorno->subscription ?? null;
                            $plan = $sub->plan ?? null;
                            $isActive = $sub && isset($sub->status) && trim($sub->status) === 'active';
                            $planOk = $plan && isset($plan->status) && $plan->status === true;
                            $notCanceled = $sub && (!isset($sub->canceledAt) || $sub->canceledAt === null);
                            if ($isActive && $planOk && $notCanceled) {
                                Log::info('Fallback confirmou assinatura ativa. Prosseguindo normalmente.');
                                 // segue o fluxo sem retornar erro
                            } else {
                                Log::error('Fallback não confirmou assinatura ativa (status/plano inválidos).');
                                return response()->json([
                                    'success' => false,
                                    'message' => 'Erro ao verificar a assinatura'
                                ], 400);
                            }
                        } else {
                            if ($fallbackUserRetorno && isset($fallbackUserRetorno->code) && $fallbackUserRetorno->code === 'unauthorized') {
                                Log::error('Token expirado durante fallback de verificação de usuário');
                                return response()->json([
                                    'success' => false,
                                    'message' => 'Sessão expirada. Faça login novamente'
                                ], 401);
                            }
                            Log::error('Falha no fallback /account/current-user.');
                            return response()->json([
                                'success' => false,
                                'message' => 'Erro ao verificar a assinatura'
                            ], 400);
                        }
                    }
                }
                Log::info('✓ Status da assinatura verificado com sucesso');
            } else {
                Log::info('Checkout de PRODUTO - pulando verificação de status da assinatura');
            }

            // Após sucesso (assinatura ou produto), verificar dados do usuário e finalizar login
            Log::info('Verificando dados do usuário via /account/current-user...');
            $currentUserUrl = 'https://api.dentalgo.com.br/account/current-user';
            $chUser = curl_init($currentUserUrl);
            $authorizationUser = "Authorization: Bearer " . session()->get('token');

            Log::info('Configurando verificação de usuário:');
            Log::info('- URL: ' . $currentUserUrl);

            curl_setopt($chUser, CURLOPT_HTTPGET, 1);
            curl_setopt($chUser, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($chUser, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorizationUser));

            Log::info('Executando verificação de usuário...');
            $userResult = curl_exec($chUser);
            $userHttpCode = curl_getinfo($chUser, CURLINFO_HTTP_CODE);
            $userCurlError = curl_error($chUser);
            curl_close($chUser);

            Log::info('Resposta da verificação de usuário:');
            Log::info('- HTTP Code: ' . $userHttpCode);
            Log::info('- cURL Error: ' . ($userCurlError ? $userCurlError : 'Nenhum'));
            Log::info('- Response Body: ' . $userResult);

            $userRetorno = json_decode($userResult);
            // Verificar se houve erro na consulta de usuário
            if (isset($userRetorno->code)) {
                Log::error('Erro na verificação de usuário: ' . $userRetorno->code);
                if ($userRetorno->code == 'unauthorized') {
                    Log::error('Token expirado durante verificação de usuário');
                    return response()->json([
                        'success' => false,
                        'message' => 'Sessão expirada. Faça login novamente'
                    ], 401);
                } else {
                    Log::error('Erro desconhecido na verificação de usuário: ' . $userRetorno->code);
                    return response()->json([
                        'success' => false,
                        'message' => 'Erro na verificação dos dados do usuário'
                    ], 400);
                }
            }

            // Opcional: atualizar sessão com usuário retornado
            try {
                if ($userRetorno) {
                    session()->put('usuario', $userRetorno);
                    session()->save();
                    Log::info('Sessão de usuário atualizada após pagamento com sucesso.');
                }
            } catch (\Exception $e) {
                Log::warning('Falha ao atualizar usuário na sessão após pagamento: ' . $e->getMessage());
            }

            Log::info('Executando loginAuto EXATAMENTE como no checkout original...');
            // EXATAMENTE como no checkout antigo: chama loginAuto e retorna sucesso
            app('App\\Http\\Controllers\\LoginController')->loginAuto(session()->get('token'));

            Log::info('✓ Pagamento processado e validado com sucesso!');

            return response()->json([
                'success' => true,
                'message' => 'Pagamento processado com sucesso!'
            ]);
        }
        // Fim do tratamento de sucesso/erro
    }



    // Métodos de validação externa removidos - agora usamos loginAuto diretamente como no checkout original

    function changeLang($langcode){ 
    
      App::setLocale($langcode);
      session()->put("lang_code",$langcode);
      return redirect()->back();
    }  

}
 