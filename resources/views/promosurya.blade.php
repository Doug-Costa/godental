<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('ladingpage/img/go.ico') }}">
    <title>Landing Page Dental GO</title>
    <meta name="description" content="A Maior Plataforma da conhecimento Odontológico ao seu dispor, informação e atualização com o que há de mais moderno na Odontologia...">
    <meta name="keywords" content="Conhecimento Acessivel de maneira fácil e rápida">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('ladingpage/css/meupedido.css') }}">
    <script src="{{ asset('ladingpage/js/navbar-ontop.js') }}"></script>
    <script src="{{ asset('ladingpage/js/animate-in.js') }}"></script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-06LXEX0626"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-06LXEX0626');
    </script>
        <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-T9GKFKN');</script>
    <!-- End Google Tag Manager -->

</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T9GKFKN"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

  <nav class="navbar navbar-expand-md fixed-top bg-dark navbar-light" style="background-color:#ffffff">
    <div class="container"> <a class="navbar-brand" href="#"><img class="img-fluid d-block" src="{{ asset('ladingpage/img/logo.png') }}" width="240" style=""></a> <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar2SupportedContent" aria-controls="navbar2SupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
      <div class="collapse navbar-collapse text-center justify-content-end" id="navbar2SupportedContent">
        <ul class="navbar-nav">
          <li class="nav-item mx-2"> <a class="nav-link" href="#inicio">Início</a> </li>
          <li class="nav-item mx-2"> <a class="nav-link" href="#video">Como Funciona?</a> </li>
        </ul> <a class="btn navbar-btn mx-2 btn-primary text-light" href="{{ route('promosuryaemail') }}" target="blank"><b>Começar Agora!</b></a>
      </div>
    </div>
  </nav>
 
  <!-- Cover -->
  <div class="container-fluid bg-light pt-5" id="inicio" style="	background-image: url({{ asset('ladingpage/img/bg.png') }});	background-position: center;	background-size: cover;	background-repeat: no-repeat; ">
    <div class="container pt-5 pb-4">
      <div class="row">
        <div class="text-lg-left text-left align-self-left pt-4 col-md-6 py-3" style="">
          <h1 class="text-white"><b class="">Elevando o Padrão da Odontologia com Conhecimento Científico </b></h1>
          <p class="text-white"><b>A maior plataforma da odontologia brasileira!<br></b><br>
		  <br>
          <a class="btn btn-lg btn-primary" href="{{ route('promosuryaemail') }}" target="blank"><b>Quero 7 dias grátis</b></a>
        </div>
        <div class="col-md-6" style=""></div> 
       
      </div>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
    </div>
  </div>
  <!-- passo -->

  <!-- Mostrar Erros -->
  @if ($errors->any())
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="errorModalLabel">ATENÇÃO</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
          </div>
        </div>
      </div>
    </div>
  @endif


  <!-- Article style section -->
  <div class="py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <h2>Porque todo dentista deve assinar o Dental GO?</h2>
          <p><b>Veja algumas das vantagens ao adquirir o nossa plataforma digital de conteúdo</b></p>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 p-4">
          <div class="row">
            <div class="col-3 p-0 d-flex align-items-center"> <img class="img-fluid d-block" src="{{ asset('ladingpage/img/icon4.jpg') }}"> </div>
            <div class="col-9">
              <p class="lead mb-1"> <b>Sempre Atualizando</b></p>
              <p class="mb-0" contenteditable="true">Conhecimento sempre atualizado, uma nova revista a cada 10 dias!</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 p-4">
          <div class="row">
            <div class="col-3 p-0 d-flex align-items-center"> <img class="img-fluid d-block" src="{{ asset('ladingpage/img/icon5.jpg') }}"> </div>
            <div class="col-9">
              <p class="lead mb-1"> <b>Multiplataforma</b></p>
              <p class="mb-0">Celular,computador ou tablet, não importa onde estaremos com você </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 p-4">
          <div class="row">
            <div class="col-3 p-0 d-flex align-items-center"> <img class="img-fluid d-block" src="{{ asset('ladingpage/img/icon6.jpg') }}"> </div>
            <div class="col-9">
              <p class="lead mb-1"> <b>Pesquisa À mão</b></p>
              <p class="mb-0">Seja para clinica ou aula, tenha o maior acervo nacional ao seu dispor!</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 p-4">
          <div class="row">
            <div class="col-3 p-0 d-flex align-items-center"> <img class="img-fluid d-block" src="{{ asset('ladingpage/img/icon7.jpg') }}"> </div>
            <div class="col-9">
              <p class="lead mb-1"> <b>Camarote!</b></p>
              <p class="mb-0">Congressos e eventos exclusivos, mais milhares de horas de videoaulas</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 p-4">
          <div class="row">
            <div class="col-3 p-0 d-flex align-items-center"> <img class="img-fluid d-block" src="{{ asset('ladingpage/img/icon8.jpg') }}"> </div>
            <div class="col-9">
              <p class="lead mb-1"> <b>Economia Digital</b></p>
              <p class="mb-0">Acesso gratuito a livros digitais e 15% de desconto em cursos Dental Press </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 p-4">
          <div class="row">
            <div class="col-3 p-0 d-flex align-items-center"> <img class="img-fluid d-block rounded-circle" src="{{ asset('ladingpage/img/icon9.jpg') }}"> </div>
            <div class="col-9">
              <p class="lead mb-1"> <b>Somente os Melhores</b></p>
              <p class="mb-0">Todo material tem revisao por pares, e as aulas feitas pelos profissionais mais renovados! </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!--acesso-->
  <div class="text-center py-5">
    <div class="container">
      <div class="col-md-12 text-center">
        <h1>Como ter acesso a tudo isso ?</h1>
        <p>Comece hoje mesmo a ter acesso ao Dental GO.</p>
      </div>
      <div class="row">
        <div class="col-lg-4 p-3">
          <div class="card">
            <div class="card-body p-4"> <img class="img-fluid d-block mb-3 mx-auto" src="{{ asset('ladingpage/img/1.png') }}" width="230">
              <p class="lead"><b>Cadastre grátis por 7 dias</b></p>
              <p class="mb-0"> O Dental GO é uma plataforma no conceito poroso. Ou seja você
                pode navegar livremente pela ferramenta e identificar assuntos ou publicações de
                seu interesse antes de assinar. O acesso aos materiais completos só será possível
                após a assinatura.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 p-3 col-md-6">
          <div class="card">
            <div class="card-body p-4"> <img class="img-fluid d-block mb-3 mx-auto" src="{{ asset('ladingpage/img/2.png') }}" width="230">
              <p class="lead"><b>Escolha Seu plano</b></p>
              <p class="mb-0">O Dental GO tem duas possibilidades de planos disponíveis, a
                assinatura anual e a de recorrência. Caso você opte pela recorrência, pode cancelar
                sua assinatura quando bem entender.Após escolher o seu plano, você irá preencher os seus
                dados de acesso e pagamento. A Dental Press irá encaminhar um e-mail validando
                seu acesso</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 p-3 col-md-6">
          <div class="card">
            <div class="card-body p-4" style=""> <img class="img-fluid d-block mb-3 mx-auto" src="{{ asset('ladingpage/img/3.png') }}" width="230">
              <p class="lead"><b>Acesso A ferramenta.</b></p>
              <p class="mb-0">Com os dados preenchidos e pagamento efetuado, basta
                colocar login e senha e navegar pela plataforma. Dental GO é extremamente
                intuitivo. Você pode escolher os livros, revistas ou aulas que quer ler ou assistir, pelo
                menu principal ou pela barra de buscas.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- passo -->


 <!--mulher pensado-->

  <div class="py-4" style="">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
        </div>
      </div>
      <div class="row pt-3">
        <div class="align-self-center text-md-left col-lg-6 px-4 text-left" style="" id="video">
          <img class="img-fluid d-block" src="{{ asset('ladingpage/img/img2.png') }}">
        </div>
        <div class="align-self-center col-lg-6" style="">
          <div class="align-self-center text-md-left col-lg-12 text-left px-4 pt-3" style="">
            <h2 class="text-left"><b>Dental GO, o acervo mais rico da odontologia!</b></h2>
            <h5 class="text-left mb-3">O Dental GO oferece também um vasto acervo audiovisual, com aulas, entrevistas, dicas
              e drops. Todos os meses, o assinante tem, também, uma nova aula disponível no <b>Dental
              GO Academy, com professores convidados de diferentes áreas da Odontologia.</b> São
              aulas dinâmicas de até 50 minutos, para que o assinante fique por dentro das novidades
              da Odontologia.</h5> <!-- class="btn shadowed mt-2 btn-lg btn-block btn-primary" href="novocliente/">Começar Agora!</a> -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- porque ter um catálogo -->
  <!-- porque ter um catálogo -->


  <!-- garantia -->
  <div class="my-4 bg-dark2 py-4" style="background-color: #ccc;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
        </div>
      </div>
      <div class="row pt-3 mb-2">
        <div class="align-self-center text-md-left col-lg-5 px-4 text-left" style="">
          <div class="p-0 col-lg-12 order-2 order-lg-1" style=""> <img class="img-fluid d-block mx-auto" src="{{ asset('ladingpage/img/garantia.png') }}"> </div>
        </div>
        <div class="align-self-center col-lg-7" style="">
          <div class="align-self-center text-md-left col-lg-12 text-left px-4 pt-3   " style="">
            <h2 class="">&nbsp;<b>Conheça por 7 Dias gratuitamente</b></h2>
            <p class="mb-0" align="justify"><b>Teste todas as funcionalidades, conheça a plataforma, Assista à entrevistas e videoaulas e crie sua própria jornada de conhecimento</b></p>
            <br>
            <p><a class="btn shadowed mt-2 btn-lg btn-block btn-primary" href="{{ route('promosuryaemail') }}" target="blank">Começar Agora!</a></p>
          </div>
        </div>
      </div>
      <hr class="mt-0">
    </div>
  </div>
  <br>
  <br>
  <!-- garantia -->

  <div class="row">
    <div class="col-md-12 text-center">
      <h2>Para quem foi desenvolvido o Dental GO?</h2>
      <p><b>Fomentamos ciência e inovação para todos os momentos da carreira do dentista!</b></p>
    </div>
  </div>

  <div class="text-center py-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 p-3">
          <div class="card">
            <div class="card-body p-4"> <img class="img-fluid d-block mb-3 mx-auto rounded-circle" src="{{ asset('ladingpage/img/icon1.jpg') }}" width="130">
              <p class="lead"><b>Clínicos</b></p>
              <p class="mb-0">Tenha acesso ao acervo completo da Dental Press e apresente para os seus
                pacientes casos semelhantes, utilizando imagens e recursos visuais presentes nas
                mais de 540 revistas, com uma busca simples por palavras-chave e mostre que o
                tratamento é validado no ponto de vista científico  &nbsp;</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 p-3 col-md-6">
          <div class="card">
            <div class="card-body p-4"> <img class="img-fluid d-block mb-3 mx-auto rounded-circle" src="{{ asset('ladingpage/img/icon2.jpg') }}" width="130">
              <p class="lead"><b>Estudantes</b></p>
              <p class="mb-0"> Faça consultas e busque referências de uma forma rápida e dinâmica, valendo-se
                de toda a inteligência de busca dos artigos por palavra-chave ou por autores. Todas
                as revistas Dental Press levam em consideração os mais altos padrões editoriais e
                boas-práticas científicas, como revisão por pares e por duplo cego. </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 p-3 col-md-6">
          <div class="card">
            <div class="card-body p-4" style=""> <img class="img-fluid d-block mb-3 mx-auto rounded-circle" src="{{ asset('ladingpage/img/icon3.jpg') }}" width="130">
              <p class="lead"><b>Professores</b></p>
              <p class="mb-0">Crie aulas utilizando os artigos publicados na Dental Press. Todo processo editorial
                da Dental Press é feito com o foco no conteúdo e na forma, garantindo uma estética
                única atrelada a conteúdos relevantes. Utilize o Dental GO como uma ferramenta
                para expandir suas possibilidades didático-pedagógicas.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- FAQ -->
  <div class="py-5 my-3 bg-primary" id="plano" style="	background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.2)), url({{ asset('ladingpage/img/bg3.jpg') }});	background-position: top center;	background-size: cover;	background-repeat: no-repeat;">
    <div class="container">
      <div class="row">
        <div class="text-center col-md-12">
          <h2 class="mb-0">Uma experiência única em pesquisa, mais facilidade na hora de estudar com conteúdo atualizado.</h2>
          <p>Tenha acesso ao maior acervo da odontologia mundial, com revistas, congressos, livros, aulas e muito mais!</p>
          <br>
          <a class="btn btn-lg btn-primary" href="{{ route('promosuryaemail') }}" target="blank" target="blank"><b>Quero 7 dias grátis</b></a>
        </div>
      </div>
      <div class="row">
        		 
		 </div> 
       	     
    </div>
  </div>
  <div class="py-5">
    <div class="container">
      <div class="row">
        <div class="text-center col-md-12">
          <h1><b>Dúvidas Frequentes</b></h1>
        </div>
        <div class="col-12 mx-auto">
          <div class="accordion" id="faqExample">
            <div class="card">
              <div class="card-header p-2" id="headingOne">
                <h5 class="mb-0">
                  <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> <i class="fa fa-arrow-right" aria-hidden="true"></i> O que é o Dental GO? </button>
                </h5>
              </div>
              <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqExample">
                <div class="card-body"> Dental GO é uma plataforma digital que contém a maior biblioteca de artigos científicos de
                  Odontologia em língua portuguesa do mundo e aulas recorrentes, com foco na promoção da
                  educação e ciência odontológica do Brasil </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header p-2 " id="headingTwo">
                <h5 class="mb-0">
                  <button class="btn btn-link collapsed d-none d-lg-block d-xl-block" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> <i class="fa fa-arrow-right" aria-hidden="true"></i> Qual a diferença do plano recorrência para o plano anual? </button>
                  <!-- Button Mobile especifico para tela menor -->
                  <button class="btn btn-link collapsed d-block d-sm-none" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> <i class="fa fa-arrow-right" aria-hidden="true" style="padding-right:1 rem"></i> Qual a diferença do plano recorrência <br> para o plano anual?</button>
                </h5>
              </div>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#faqExample">
                <div class="card-body"> No plano mensal de recorrência você pode cancelar sua assinatura quando quiser. No plano
                  anual, você tem o desconto no valor da mensalidade, mas só poderá cancelar após o
                  período de vigência da assinatura (ou seja, após 12 meses). </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header p-2" id="headingThree">
                <h5 class="mb-0">
                  <button class="btn btn-link collapsed d-none d-lg-block d-xl-block" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> <i class="fa fa-arrow-right" aria-hidden="true"></i> Como funciona o cancelamento da assinatura anual? </button>
                  <!-- Button Mobile  -->
                  <button class="btn btn-link collapsed d-block d-sm-none" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> <i class="fa fa-arrow-right" aria-hidden="true" style="padding-right:1 rem"></i> Como funciona o cancelamento <br> da assinatura anual?</button>
                </h5>
              </div>
              <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#faqExample">
                <div class="card-body"> Conforme a Lei nº 8.078 de 11 de setembro de 1990, a chamada “Lei do Consumidor”, o
                  usuário/assinante tem prazo de 7 dias para se arrepender da compra ou contrato de
                  assinatura a contar da liberação dos acessos. Dessa forma, você tem 7 dias para cancelar
                  sua assinatura. Após esse período o vencimento é após 12 meses para cancelamentos. </div>
              </div>
            </div>
            

            <div class="card">
              <div class="card-header p-2" id="headingFive">
                <h5 class="mb-0">
                  <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive"> <i class="fa fa-arrow-right" aria-hidden="true"></i> O que é o Clube de Descontos Dental Press? </button>
                </h5>
              </div>
              <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#faqExample">
                <div class="card-body"> Assinantes do Dental GO têm descontos nos produtos Dental Press (Cursos e livros), bem
                  como descontos com empresas parceiras da Dental Press. Entre em contato com nosso
                  time de vendas e veja as inúmeras possibilidades que você tem! </div>
              </div>
            </div>

            <div class="card">
              <div class="card-header p-2" id="headingSix">
                <h5 class="mb-0">
                  <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix"> <i class="fa fa-arrow-right" aria-hidden="true"></i> O Dental GO tem app?</button>
                </h5>
              </div>
              <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#faqExample">
                <div class="card-body"> Neste momento, não. Nossa equipe de tecnologia da informação e desenvolvimento está
                  trabalhando para que dentro em breve você assinante possa desfrutar de mais essa vantagem!, MAS a plataforma e totalmente responsível 
                e você poderá acessar com facilidade a partir do navegador de seu celular ou tablet </div>
              </div>
            </div>

            <div class="card">
              <div class="card-header p-2" id="headingSevem">
                <h5 class="mb-0">
                  <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSevem" aria-expanded="false" aria-controls="collapseSevem"> <i class="fa fa-arrow-right" aria-hidden="true"></i> Posso baixar os arquivos do Dental GO?</button>
                </h5>
              </div>
              <div id="collapseSevem" class="collapse" aria-labelledby="headingSevem" data-parent="#faqExample">
                <div class="card-body"> Todos os artigos presentes no Dental GO podem ser baixados no formato PDF não editável.
                  Isso não se aplica, entretanto, aos conteúdos audiovisuais ou revistas completas. </div>
              </div>
            </div>

            <div class="card">
              <div class="card-header p-2" id="headingEigth">
                <h5 class="mb-0">
                  <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseEigth" aria-expanded="false" aria-controls="collapseEigth"> <i class="fa fa-arrow-right" aria-hidden="true"></i> Como posso pagar o Dental GO?</button>
                </h5>
              </div>
              <div id="collapseEigth" class="collapse" aria-labelledby="headingEigth" data-parent="#faqExample">
                <div class="card-body"> Você pode assinar o Dental GO com cartão de crédito, na recorrência. Pode também pagar
                  o plano anual a vista com o Pix, ou parcelar a compra em até 12x sem juros no cartão. Você
                  pode contatar um de nossos consultores e tirar dúvidas sobre outras formas de pagamento. </div>
              </div>
            </div>

            <div class="card">
              <div class="card-header p-2" id="headingNine">
                <h5 class="mb-0">
                  <button class="btn btn-link collapsed d-none d-lg-block d-xl-block" type="button" data-toggle="collapse" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine"> <i class="fa fa-arrow-right" aria-hidden="true"></i> Com quem posso conversar sobre minha assinatura ?</button>
                <!-- Button Mobile  -->
                <button class="btn btn-link collapsed d-block d-sm-none" type="button" data-toggle="collapse" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine"> <i class="fa fa-arrow-right" aria-hidden="true" style="padding-right:1 rem"></i> Com quem posso conversar <br>sobre minha assinatura ?</button>
                </h5>
              </div>
              <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#faqExample">
                <div class="card-body"> Se você tiver outras dúvidas em relação ao Dental GO ficaremos contentes em conversar
                  com você atendimento2@dentalpress.com.br | (44) 3033-9812 | Chat online: <www class="dentalpress com br"></www></div>
              </div>
            </div>
             
          </div>
        </div>
      </div>
      <!--/row-->
    </div>
    <!--container-->
  </div>
  <!-- FAQ FINAL-->
  <!-- Features -->
  <!-- Features -->
  <!-- Carousel reviews -->
  <!-- Call to action -->

<div class="mt-5 pt-5 pb-5 footer">
  <div class="container">
    <div class="row">
      <div class="col-lg-5 col-xs-12 about-company">
        <div class="container"> 
          <a class="navbar-brand" href="#">
            <img class="img-fluid d-block" src="{{ asset('ladingpage/img/logo.png') }}" width="300" style="">
          </a> 
          <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar2SupportedContent" aria-controls="navbar2SupportedContent" aria-expanded="false" aria-label="Toggle navigation"> 
            <span class="navbar-toggler-icon"></span> 
          </button>
        <p class="pr-5 text-white-50"> DentalGO é uma plataforma digital que oferece publicações e recursos para profissionais da odontologia., </p>
        <p><a href="https://www.facebook.com/dentalpresseditora/?locale=pt_BR"><i class="fa fa-facebook-square mr-1"></i></a><a href="https://www.instagram.com/dentalgo_official/"><i class="fa fa-instagram"></i></a></p>
        </div>
      </div>
      <div class="col-lg-3 col-xs-12 links">
        <h2 class="mt-lg-0 mt-sm-3">Links Úteis</h2>
          <ul class="m-0 p-0">
            <li>- <a href="http://www.dentalpress.com.br">Portal Dental Press</a></li>
            <li>- <a href="#">Submeter artigos</a></li>
            <li>- <a href="#">App Dental GO</a></li>
            <li>- <a href="https://novo.dentalpresspub.com/">Editora Dental Press</a></li>
            <li>- <a href="http://www.dentalpress.com.br/cursos">Cursos de Especialização</a></li>
            <li>- <a href="https://dentalpress.com.br/portal/acesso-do-assinante/">Acesso Assinantes</a></li>
          </ul>
      </div>
      <div class="col-lg-4 col-xs-12 location">
        <h2 class="mt-lg-0 mt-sm-4"><b></b>Onde nos encontrar ?<b></b></h2>
        <p>Avenida Dr. Luiz Teixeira Mendes, 2712</p>
        <p>Maringá - Paraná - 87045-000</p>
        <p class="mb-0"><i class="fa fa-phone mr-3"></i>(44) 3033-9812</p>
        <p><i class="fa fa-envelope-o mr-3"></i>atendimento2@dentalpress.com.br</p>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col copyright">
        <p class=""><small class="text-white-50">© 2024. All Rights Reserved. Dental Press International</small></p>
      </div>
    </div>
  </div>
  </div>


  
  <!-- JavaScript dependencies -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <!-- Script: Smooth scrolling between anchors in the same page -->
  <script src="{{ asset('ladingpage/js/smooth-scroll.js') }}"></script>
  <!-- botão whats -->
  <script type="text/javascript">
    (function() {
      var options = {
        whatsapp: "+554430339812", // WhatsApp number
        call_to_action: "Fale Conosco", // Call to action
        position: "right", // Position may be 'right' or 'left'
      };
      var proto = document.location.protocol,
        host = "getbutton.io",
        url = proto + "//static." + host;
      var s = document.createElement('script');
      s.type = 'text/javascript';
      s.async = true;
      s.src = url + '/widget-send-button/js/init.js';
      s.onload = function() {
        WhWidgetSendButton.init(host, proto, options);
      };
      var x = document.getElementsByTagName('script')[0];
      x.parentNode.insertBefore(s, x);
    })();
  </script>
   @if ($errors->any())
    <script>
      $(document).ready(function() {
        $('#errorModal').modal('show');
      });
    </script>
  @endif
  <!-- /botão whats -->
</body>

</html>

