
<header>
  <div class="container-fluid fixed-top ">
    <div class="row distancia-livros">
      <nav class="navbar navbar-expand-lg navbar-light mb-4 menu-hamburger <?php if(isset($tipoTopo)){ echo $tipoTopo; } ?>" style="background: linear-gradient(0deg, rgba(0,0,0,0.31985294117647056) 0%, rgba(0,0,0,1) 100%); z-index: 9999 !important; margin-botton: 0px !important;">
        <div class="container-fluid d-flex justify-content-between">
                <a href="{{ route('home') }}" class="align-items-center mr-auto  link-body-emphasis text-decoration-none">
                    <img src="{{ asset('imagens/Logo-dentalgo-branca-ATUALIZAADA.fw.png') }}" alt="DentalGo!" class="logoDentalGo img-fluid">
                </a>
                <div class="d-flex align-items-center">
                            @if(null == session()->get('token'))
                                <li class="nav-item me-2 acessar-mobile">
                                    <a class="nav-link acessar-button" style="color: #fff !important;" data-bs-toggle="modal" data-bs-target="#modalLogin">{{__("messages.TopoMenuAcess")}}</a>
                                </li>
                            @endif 
                    <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" style="color:#ffffff; background-color: transparent">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav col-lg-auto me-lg-auto mb-2 justify-content-center" >
                        <li class="nav-item"><a href="{{ route('colecoes') }}" class="nav-link topo-opçoes">{{__("messages.TopoMenuRevistas")}}</a></li>
                        <li class="nav-item"><a href="{{ route('videos') }}" class="nav-link topo-opçoes">{{__("messages.TopoMenuVideos")}}</a></li>
                        <li class="nav-item"><a href="{{ route('livros') }}" class="nav-link topo-opçoes">{{__("messages.TopoMenuLivros")}}</a></li>
                        @if(session()->get('token') && session()->get('tipoUsuario') == 'schoolar')
                            <li class="nav-item"><a href="{{ route('school') }}" class="nav-link topo-opçoes">Materiais Didáticos</a></li>
                        @endif
                        <li class="nav-item"><a style="cursor:pointer;" class="nav-link topo-opçoes" id="menuCanais" onmouseover="mostrarMenu()">{{__("messages.TopoMenuCanais")}}</a></li>
                      </ul>

                    <div class="positionsearch">
                        <form class="form-inline searchsize" id="search-form" method="GET" action="{{ route('busca-elastic') }}" enctype="multipart/form-data">
                            @csrf
                            <button style=" position:absolute; border:0; background:none; margin-top:6px; margin-left:4px">
                        <i class="fa-solid fa-magnifying-glass" style="color:rgb(42, 42, 42); outline:0px; text-decoration:none"></i>
                            </button>
                            <input style="; border-color:#e3e7e8; background-color:#e3e7e8; border-radius:10px; padding-left:35px" class="form-control mr-sm-2  search-bar-mobile barrateste"  type="search" placeholder="Pesquisar" id="search-bar" aria-label="Search" name="query">
                            <input type="hidden" name="fields" value="title,brief,authors.name">
                            <input type="hidden" name="page" value="1">
                            <input type="hidden" name="size" value="5000">
                        </form>
                    </div>
                    <div class="blocosearch">

                    </div>
                    <!--
                    <div class="search-container" style="display: inline-flex;">
                        <form id="search-form" method="GET" action="{{ route('busca-elastic') }}" enctype="multipart/form-data" class="d-flex">
                            @csrf
                            <input type="text" id="search-bar" class="search-bar search-bar-mobile" name="query" 
                                   placeholder="Digite sua pesquisa aqui...">
                        -->     
                            <!-- Campos ocultos para passar os parâmetros adicionais -->
                           <!-- <input type="hidden" name="fields" value="title,brief,authors.name">
                            <input type="hidden" name="page" value="1">
                            <input type="hidden" name="size" value="5000">

                            <button type="submit" id="search-submit" class="search-button" style="display: none;">
                                <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
                            </button>
                        </form>
                        
                        <button type="button" id="search-expand" class="search-button">
                            <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
                        </button>
                    </div>
                        -->
                      <!--<div class="notification-button" id="notificationButton" onclick="toggleNotificationTab()">
                        <i class="fas fa-bell" style="color: #ffffff;"></i>
                      </div>
                      
                      <div class="notification-tab" id="notificationTab">
                          <h2 class="notification-title">Suas notificações</h2>
                          <p>Nenhuma notificação no momento.</p>
                      </div>-->
                                <ul class="navbar-nav ">
                                    <li class="nav-item dropdown me-3">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-globe Globo-idioma"></i> {{session()->has('lang_code')?(session()->get('lang_code')=='pt'?'PT-BR':''):''}} {{session()->has('lang_code')?(session()->get('lang_code')=='en'?'EN':''):''}} {{session()->has('lang_code')?(session()->get('lang_code')=='es'?'ES':''):''}}
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <li>
                                                <a onclick="changeLanguage('pt')" class="dropdown-item {{session()->has('lang_code')?(session()->get('lang_code')=='pt'?'IdiomaSelecionado':''):''}}">PT-BR</a>
                                            </li>
                                            <li>
                                                <a onclick="changeLanguage('en')" class="dropdown-item {{session()->has('lang_code')?(session()->get('lang_code')=='en'?'IdiomaSelecionado':''):''}}">English</a>
                                            </li>
                                            <li>
                                                <a onclick="changeLanguage('es')" class="dropdown-item {{session()->has('lang_code')?(session()->get('lang_code')=='es'?'IdiomaSelecionado':''):''}}">Español</a>
                                            </li>
                                        </ul>
                                    </li>
                                    @if(null == session()->get('token'))
                                        <li class="nav-item me-2">
                                            <a class="nav-link acessar-button tn btn-light login-hamburger" style="color: gray;" data-bs-toggle="modal" data-bs-target="#modalLogin">{{__("messages.TopoMenuAcess")}}</a>
                                        </li>

                                        <!-- <li class="nav-item">
                                            <a class="nav-link tn btn-light botaoLogin" style="color: gray;" data-bs-toggle="modal" data-bs-target="#espacoParaAssinantes">{{__("messages.TopoMenuAssine")}}</a>
                                        </li> -->
                                        <li class="nav-item">
                                            <a class="nav-link tn btn-light botaoLogin" style="color: gray;" href="https://www.dentalgo.com.br/checkoutnovo">{{__("messages.TopoMenuAssine")}}</a>
                                        </li>
                                    @endif

                                    
                                    @if(null !== session()->get('token'))
                                    <?php
                                        $usuario = session()->get("usuario");
                                    ?>
                                    <li class="nav-item dropdown me-3">
                                        
                                        <a class="nav-link dropdown-toggle" style="color:#ffffff; href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="true" data-bs-toggle="modal" data-bs-target="#modalLogin">
                             @if(session()->get('tipoUsuario') == 'schoolar')
                                {{ is_array($usuario) ? $usuario['aluno']['nome'] : $usuario->aluno->nome }}
                             @else
                                {{ $usuario->fullName }}
                             @endif
                        </a>
                                        
                                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <?php
                                                if(in_array(session()->get('usuarioPermissao'), ['naotem','naotemVencido','naotemSemPlano'])){
                                                ?>
                                                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalGift"></a>{{__("messages.TopoMenuGift")}}</li>
                                                <?php
                                                }if(session()->get('tipoUsuario') == 'pessoal'){
                                                ?>
                                                <li><a class="dropdown-item" href="{{ route('minhaconta') }}">{{__("messages.TopoMenuMinhaConta")}}</a></li>
                                                <?php
                                                }
                                                ?>
                                                <li><a class="dropdown-item" href="{{ route('logout') }}">{{__("messages.TopoMenuSair")}}</a></li>
                                            </ul>

                                        @else 
                                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalLogin">{{__("messages.TopoMenuCadastrar")}}</a></li>
                                                <!-- <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#espacoParaAssinantes">{{__("messages.TopoMenuLogar")}}</a></li> -->
                                                <li><a class="dropdown-item" href="https://www.dentalgo.com.br/checkoutnovo">{{__("messages.TopoMenuLogar")}}</a></li>
                                            </ul>
                                        
                                    </li>
                                    @endif
                                    <li class="nav-item">
                                        <a class="nav-link menu-fontes" href="https://www.dentalgo.com.br/clube-de-vantagens">{{__("messages.MenuClube")}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link menu-fontes" href="{{ route('gointelligence.index') }}" style="color: #10b981; font-weight: bold;">
                                            <i class="fa-solid fa-robot"></i> Dentino AI
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    @foreach ($errors->all() as $error)

                        @if($error == 'logado')
                            <div class="alert alert-success alert-dismissable" role="alert" style="text-align: center; font-weight: bold; margin-top: -25px;">
                                {{__("messages.AlertSucess")}}
                            </div>
                        @elseif($error == 'senhaRedefinida')
                            <div class="alert alert-success alert-dismissable" role="alert" style="text-align: center; font-weight: bold; margin-top: -25px;">
                                {{__("messages.AlertRecSenhaSucess")}}
                            </div>
                        @elseif($error == 'logadoVencido')
                            <div class="alert alert-warning" role="alert" style="text-align: center; font-weight: bold;">
                                {{__("messages.AlertVencido")}} <a href="https://www.dentalgo.com.br/checkoutnovo"  type="button" class="btn btn-danger">{{__("messages.AlertVencidoRenovar")}}</a>
                            </div>
                        @elseif($error == 'logadoSem')
                            <div class="alert alert-info" role="alert" style="text-align: center; font-weight: bold;">
                                {{__("messages.AlertNoPlan")}} <a href="https://www.dentalgo.com.br/checkoutnovo"  type="button" class="btn btn-danger">{{__("messages.AlertNoPlanAssinar")}}</a>
                            </div>
                        @elseif($error == 'errousuario')
                            <div class="alert alert-danger" role="alert" style="text-align: center; font-weight: bold;">
                            {{__("messages.AlertUser")}}
                            </div>
                        @elseif($error == 'errosenha')
                            <div class="alert alert-danger" role="alert" style="text-align: center; font-weight: bold;">
                            {{__("messages.AlertSenha")}}
                            </div>
                        @elseif($error == 'errosenhaNova')
                            <div class="alert alert-danger" role="alert" style="text-align: center; font-weight: bold;">
                            {{__("messages.AlertSenhaNova")}}
                            </div>
                        @elseif($error == 'erroCadastro')
                            <div class="alert alert-danger" role="alert" style="text-align: center; font-weight: bold;">
                            {{__("messages.AlertErroCadastro")}}<a href="#"  type="button" class="btn btn-danger">{{__("messages.AlertErrorContato")}}</a>
                            </div>
                        @elseif($error == 'cadastroSucesso')
                            <div class="alert alert-info" role="alert" style="text-align: center; font-weight: bold;">
                              {{__("messages.AlertCadastroSucess")}} <a href="{{ route('assinatura') }}"  type="button" class="btn btn-danger">{{__("messages.AlertCadastroAssinar")}}</a>
                            </div>
                        @elseif($error == 'crieSeuCadastro')
                            <div class="alert alert-info" role="alert" style="text-align: center; font-weight: bold;">
                            {{__("messages.AlertExclusive")}}<a href="https://www.dentalgo.com.br/checkoutnovo"  type="button" class="btn btn-danger">{{__("messages.AlertCrieCadastroAssine")}}</a>
                            </div>
                        @elseif($error == 'recSenhaSucess')
                            <div class="alert alert-info" role="alert" style="text-align: center; font-weight: bold;">
                                {{__("messages.AlertRecSenhas")}}
                            </div>
                        @elseif($error == 'recSenhaErro')
                            <div class="alert alert-danger" role="alert" style="text-align: center; font-weight: bold;">
                              {{__("messages.AlertUserNaoLocalizado")}}
                            </div>
                        @endif

                    @endforeach

                    @if(session()->get('plano') == 277 && request()->input('plano') == 277)
                        <div class="alert alert-success alert-dismissable" role="alert" style="text-align: center; font-weight: bold; margin-top: -25px;">
                            Parabéns você recebeu 20% de desconto da Alado de R$98 por R$78 <a href="{{ route('cadastrar') }}"  type="button" class="btn btn-danger">{{__("messages.AlertCadastroAssinar")}}</a>
                        </div>                            
                    @endif
                </div>
                <div class="row" style="margin-top: -25px;background: linear-gradient(0deg, rgba(0,0,0,0.31985294117647056) 0%, rgba(0,0,0,0.31985294117647056) 100%); z-index: 9999 !important; margin-botton: 0px !important; border-top:1px solid #333333; padding: 15px 0;" id="menuListaCanais" onmouseover="cancelarOcultar()" onmouseout="ocultarMenu(event)" onmouseclick="cancelarOcultar()">
                    <div class="container">
                        <a href="https://www.dentalgo.com.br/parceiro/73/dvi"><img style="margin-left:5px; margin-bottom:5px;" class="img-fluid .d-none .d-sm-block" src="{{ asset('imagens/teste/dvi-finoteste.fw.png') }}" alt=""></a>
                        <a href="https://www.dentalgo.com.br/clinicorp"><img style="margin-left:5px;margin-bottom:5px;" class="img-fluid .d-none .d-sm-block" src="{{ asset('imagens/teste/clinicorp-finoteste.fw.png') }}" alt=""></a>
                        <a href="https://www.dentalgo.com.br/dentsplysirona" ><img  class="img-fluid .d-none .d-sm-block" style="margin-left: 5px;margin-bottom:5px;"  src="{{ asset('imagens/teste/dentsply-finoteste.fw.png') }}" alt=""></a>
                        <a href="https://www.dentalgo.com.br/invisalign" ><img  class="img-fluid .d-none .d-sm-block" style="margin-left: 5px;margin-bottom:5px;"   src="{{ asset('imagens/teste/Align-education.png')}}"alt=""></a>
                        <a href="https://dentalgo.com.br/biologix" ><img  class="img-fluid .d-none .d-sm-block" style="margin-left: 5px;margin-bottom:5px;"   src="{{ asset('imagens/teste/biologixcanais.png')}}"alt=""></a>
                        <a href="https://dentalgo.com.br/shining3d" ><img  class="img-fluid .d-none .d-sm-block" style="margin-left: 5px;margin-bottom:5px;"   src="{{ asset('imagens/teste/shining3dbannercanais.png')}}"alt=""></a>


                        <!-- <a href="https://www.dentalgo.com.br/cvdentus" ><img  class="img-fluid .d-none .d-sm-block" style="margin-left: 5px;margin-bottom:5px;"   src="{{ asset('imagens/teste/cvdentus-finoteste.fw.png')}}"alt=""></a>
                        <a href="https://www.dentalgo.com.br/ultradent" ><img  class="img-fluid .d-none .d-sm-block" style="margin-left: 5px;margin-bottom:5px;"   src="{{ asset('imagens/teste/ultradentTOPO.png')}}"alt=""></a> -->
                    </div>
                </div>
                <div class="row" style=" margin-top:83px; background: linear-gradient(0deg, rgba(0,0,0,0.31985294117647056) 0%, rgba(0,0,0,0.31985294117647056) 100%); z-index: 9999 !important; margin-botton: 0px !important; border-top:1px solid #333333; padding: 15px 0;" id="menuListaCanaisMobile" onmouseover="cancelarOcultar()" onmouseout="ocultarMenu(event)" onmouseclick="cancelarOcultar()">
                    <div class="container" style="max-height:400px; overflow-y: auto">
                        <a href="https://www.dentalgo.com.br/parceiro/73/dvi"><img class="img-fluid .d-none .d-sm-block" style="width:900px; margin-bottom:5px;" src="{{ asset('imagens/teste/dvi-finomobile.fw.png') }}" alt=""></a>
                        <a href="https://www.dentalgo.com.br/clinicorp"><img class="img-fluid .d-none .d-sm-block" style="width:900px; margin-bottom:5px;" src="{{ asset('imagens/teste/clinicorp-finomobile.fw.png') }}" alt=""></a>
                        <a href="https://www.dentalgo.com.br/dentsplysirona" ><img  class="img-fluid .d-none .d-sm-block" style="width:900px; margin-bottom:5px;"  src="{{ asset('imagens/teste/dentsply-finomobile.fw.png') }}" alt=""></a>
                        <a href="https://www.dentalgo.com.br/invisalign" ><img  class="img-fluid .d-none .d-sm-block" style="width:900px; margin-bottom:5px;"   src="{{ asset('imagens/teste/alignmobile.png')}}"alt=""></a>
                        <a href="https://www.dentalgo.com.br/biologix" ><img  class="img-fluid .d-none .d-sm-block" style="width:900px; margin-bottom:5px;"   src="{{ asset('imagens/teste/biologixmobile.png')}}"alt=""></a>
                        <a href="https://www.dentalgo.com.br/shining3d" ><img  class="img-fluid .d-none .d-sm-block" style="width:900px; margin-bottom:5px;"   src="{{ asset('imagens/teste/bannermobilecanais.png')}}"alt=""></a>
                         <div style="margin-bottom: 50px;"></div>                           
                        <!-- <a href="https://www.dentalgo.com.br/cvdentus" ><img  class="img-fluid .d-none .d-sm-block" style="width:900px; margin-bottom:5px;"  src="{{ asset('imagens/teste/cvdentusmobile.png')}}"alt=""></a>
                        <a href="https://www.dentalgo.com.br/ultradent" ><img  class="img-fluid .d-none .d-sm-block" style="width:900px; margin-bottom:5px;"  src="{{ asset('imagens/teste/ultradentmobile.png')}}"alt=""></a> -->
                    </div>
                </div>
                <style type="text/css">
                    #menuListaCanais{
                        display: none;
                    }
                    #menuListaCanaisMobile {
                        display: none;
                    }
                </style>
                    <script>
                        <?php
                        $user_agent = request()->header('User-Agent');
                            if ((strpos($user_agent, 'Android') !== false) || (strpos($user_agent, 'iPhone') !== false) || (strpos($user_agent, 'iPad') !== false)) {
                        ?>
                        
                    var timeout;

                        function mostrarMenu() {
                            var menuListaCanaisMobile = document.getElementById('menuListaCanaisMobile');
                            menuListaCanaisMobile.style.display = 'block';

                            // Adiciona um ouvinte de clique ao documento quando o menu é mostrado
                            document.addEventListener('touchstart', function clickout(event) {
                                // Verifica se o clique não é dentro do menu
                                if (!menuListaCanaisMobile.contains(event.target)) {
                                    menuListaCanaisMobile.style.display = 'none';
                                    // Remove o ouvinte de clique quando o menu é ocultado
                                    document.removeEventListener('touchstart', clickout);
                                }
                            });
                        }

                        function ocultarMenu() {
                            var menuListaCanaisMobile = document.getElementById('menuListaCanaisMobile');
                            // Atrasa a execução da função por 200 milissegundos
                            timeout = setTimeout(function () {
                                menuListaCanaisMobilestyle.display = 'none';
                            }, 200);
                        }

                        function cancelarOcultar() {
                            clearTimeout(timeout); // Cancela a ocultação se o mouse entra na div
                        }
                        <?php
                        }else{
                        ?>
                            var timeout;

                                function mostrarMenu() {
                                    var menuListaCanais = document.getElementById('menuListaCanais');
                                    menuListaCanais.style.display = 'block';

                                    // Adiciona um ouvinte de clique ao documento quando o menu é mostrado
                                    document.addEventListener('touchstart', function clickout(event) {
                                        // Verifica se o clique não é dentro do menu
                                        if (!menuListaCanais.contains(event.target)) {
                                            menuListaCanais.style.display = 'none';
                                            // Remove o ouvinte de clique quando o menu é ocultado
                                            document.removeEventListener('touchstart', clickout);
                                        }
                                    });
                                }

                                function ocultarMenu() {
                                    var menuListaCanais = document.getElementById('menuListaCanais');
                                    // Atrasa a execução da função por 200 milissegundos
                                    timeout = setTimeout(function () {
                                        menuListaCanais.style.display = 'none';
                                    }, 200);
                                }

                                function cancelarOcultar() {
                                    clearTimeout(timeout); // Cancela a ocultação se o mouse entra na div
                                }

                        <?php
                        }
                        ?>




                    </script>

              </div>
          </nav>
      </div>
    </div>
</header>
