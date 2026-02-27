<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('ladingpage/img/go.ico') }}">
    <title>Landing Page Alado</title>
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
 
  <!-- Cover -->
  <div class="container-fluid bg-light pt-5" id="inicio" style="	background-image: url({{ asset('ladingpage/img/bg.png') }});	background-position: center;	background-size: cover;	background-repeat: no-repeat; ">
    <div class="container" class="fixed-top bg-dark navbar-light" style="background-color:transparent"> 
      <div class="row">
        <div class="col-md-6 col-sm-6">
          <a class="navbar-brand" href="#"><img class="img-fluid d-block" src="{{ asset('ladingpage/img/logo.png') }}" width="240" style=""></a> 
          <img class="img-fluid" style="margin-bottom: 50px;" src="{{ asset('ladingpage/img/logoBlanco2.png') }}" width="240" style="">
        </div>
        <div class="col-md-6 col-sm-6">

        </div>
      </div>
    </div>
    <div class="container  pb-5 ">
      <div class="row">
        <div class="text-lg-left text-left align-self-left pt-4 col-md-6 py-3" style="">
          <h1 class="text-white"><b class="">Elevando el conocimiento de la odontología y ciencia </b></h1>
          <p class="text-white"><b>¡La plataforma más grande de odontología brasileña, ahora, lista en español!<br></b><br>
		  <br>
          <a class="btn btn-lg btn-primary" style="width: 100%; word-wrap: break-word;  overflow-wrap: break-word;  white-space: normal;" href="{{ route('aladoemail') }}" target="blank"><b style="width: 100%;  overflow-wrap: break-word;">Rebaja de 20% para miembros de Alado</b></a>
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
          <h2>¿Por qué todos los dentistas deberían estar en Dental GO?</h2>
          <p><b>Mira algunas de las ventajas al adquirir nuestra plataforma de contenidos digitales</b></p>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 p-4">
          <div class="row">
            <div class="col-3 p-0 d-flex align-items-center"> <img class="img-fluid d-block" src="{{ asset('ladingpage/img/icon4.jpg') }}"> </div>
            <div class="col-9">
              <p class="lead mb-1"> <b>Siempre actualizando</b></p>
              <p class="mb-0" contenteditable="true">Conocimiento siempre actualizado, ¡uno periódico de ciencia nuevo cada 10 días!</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 p-4">
          <div class="row">
            <div class="col-3 p-0 d-flex align-items-center"> <img class="img-fluid d-block" src="{{ asset('ladingpage/img/icon5.jpg') }}"> </div>
            <div class="col-9">
              <p class="lead mb-1"> <b>Multiplataforma</b></p>
              <p class="mb-0">Celular, computadora o tablet, no importa donde, estaremos contigo </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 p-4">
          <div class="row">
            <div class="col-3 p-0 d-flex align-items-center"> <img class="img-fluid d-block" src="{{ asset('ladingpage/img/icon6.jpg') }}"> </div>
            <div class="col-9">
              <p class="lead mb-1"> <b>Investigación y Clínica</b></p>
              <p class="mb-0">Ya sea para una clínica o clase, ¡ la más grande colección lista para lectura!</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 p-4">
          <div class="row">
            <div class="col-3 p-0 d-flex align-items-center"> <img class="img-fluid d-block" src="{{ asset('ladingpage/img/icon7.jpg') }}"> </div>
            <div class="col-9">
              <p class="lead mb-1"> <b>Cabina</b></p>
              <p class="mb-0">Congresos y eventos exclusivos, de forma telematica, además de miles de horas de
              videoclases</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 p-4">
          <div class="row">
            <div class="col-3 p-0 d-flex align-items-center"> <img class="img-fluid d-block" src="{{ asset('ladingpage/img/icon8.jpg') }}"> </div>
            <div class="col-9">
              <p class="lead mb-1"> <b>Economía digital</b></p>
              <p class="mb-0">Acceso gratuito a libros digitales y 15% de rebaja en cursos de Dental Press </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 p-4">
          <div class="row">
            <div class="col-3 p-0 d-flex align-items-center"> <img class="img-fluid d-block rounded-circle" src="{{ asset('ladingpage/img/icon9.jpg') }}"> </div>
            <div class="col-9">
              <p class="lead mb-1"> <b>La mejor Odontología</b></p>
              <p class="mb-0">Todo el material es revisado por pares y las clases son impartidas por los profesionales más
              experimentados del mundo. </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


 

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
            <h2 class="text-left"><b>Alado y Dental Press</b></h2>
            <h5 class="text-left mb-3">¡Una asociación que se hace cada vez más fuerte! Además de tener lo periódico de ciencia
            oficial de Alado, Dental Press quiere estar cada vez más cerca de los dentistas de Latina
            América. ¡Por eso, tenemos un descuento exclusivo para profesionales de las más de 20
            entidades que forman Alado! ¡Ciencia cada vez más accesible, con contenidos diversos y
            educación promovida en portugués, inglés y español! Bienvenidos a Dental GO</h5> <!-- class="btn shadowed mt-2 btn-lg btn-block btn-primary" href="novocliente/">Começar Agora!</a> -->
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
          <div class="p-0 col-lg-12 order-2 order-lg-1" style=""> <img class="img-fluid d-block mx-auto" src="{{ asset('ladingpage/img/VINTEALADO.fw.png') }}"> </div>
        </div>
        <div class="align-self-center col-lg-7" style="">
          <div class="align-self-center text-md-left col-lg-12 text-left px-4 pt-3   " style="">
            <p><a class="btn shadowed mt-2 btn-lg btn-block btn-primary" style="padding-top: 20px;padding-bottom: 20px; white-space: normal; width: 100%;" href="{{ route('aladoemail') }}" target="blank">Rebaja de 20% para miembros de Alado</a></p>
          </div>
          </br>
        </div>
      </div>
      <hr class="mt-0">
    </div>
  </div>
  <br>
  <br>
 
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
        call_to_action: "Contáctanos", // Call to action
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

