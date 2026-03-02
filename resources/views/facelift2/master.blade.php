<!doctype html>
<html lang="pt">

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Google Tag Manager -->
  <script>(function (w, d, s, l, i) {
      w[l] = w[l] || []; w[l].push({
        'gtm.start':
          new Date().getTime(), event: 'gtm.js'
      }); var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
          'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-T9GKFKN');</script>
  <!-- End Google Tag Manager -->
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-RPYVFFJ26G"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());

    gtag('config', 'G-RPYVFFJ26G');
  </script>
  <!-- Hotjar Tracking Code for https://dentalgo.com.br/ -->
  <script>
    (function (h, o, t, j, a, r) {
      h.hj = h.hj || function () { (h.hj.q = h.hj.q || []).push(arguments) };
      h._hjSettings = { hjid: 3840888, hjsv: 6 };
      a = o.getElementsByTagName('head')[0];
      r = o.createElement('script'); r.async = 1;
      r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
      a.appendChild(r);
    })(window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=');
  </script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="{{ asset('imagens/Facelift/iconegonovo.png') }}">
  <script src="https://kit.fontawesome.com/5f28225d06.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
  <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
  <!-- <link rel="icon" href="assets/img/favicon.svg" /> -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <meta name="description" content="Bem vindo ao DentalGO a plataforma online dos melhores dentistas">
  <meta name="author" content="Dental Press">
  <meta name="facebook-domain-verification" content="erllqm4a40hmcrs1owzml812k9ae13" />

  <!-- Meta Pixel Code -->
  <script>
    !function (f, b, e, v, n, t, s) {
      if (f.fbq) return; n = f.fbq = function () {
        n.callMethod ?
          n.callMethod.apply(n, arguments) : n.queue.push(arguments)
      };
      if (!f._fbq) f._fbq = n; n.push = n; n.loaded = !0; n.version = '2.0';
      n.queue = []; t = b.createElement(e); t.async = !0;
      t.src = v; s = b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t, s)
    }(window, document, 'script',
      'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '2412797325723956');
    fbq('track', 'PageView');
  </script>
  <noscript><img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id=2412797325723956&ev=PageView&noscript=1" /></noscript>
  <!-- End Meta Pixel Code -->

  <!-- Meta Pixel Code -->
  <script>
    !function (f, b, e, v, n, t, s) {
      if (f.fbq) return; n = f.fbq = function () {
        n.callMethod ?
          n.callMethod.apply(n, arguments) : n.queue.push(arguments)
      };
      if (!f._fbq) f._fbq = n; n.push = n; n.loaded = !0; n.version = '2.0';
      n.queue = []; t = b.createElement(e); t.async = !0;
      t.src = v; s = b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t, s)
    }(window, document, 'script',
      'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '901692604168945');
    fbq('track', 'PageView');
  </script>
  <noscript><img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id=901692604168945&ev=PageView&noscript=1" /></noscript>

  <?php 
    if (isset($paginaTitulo)) {
    ?>
  <title>{{ $paginaTitulo }}</title>
  <?php
} else {
    ?>
  <title>DentalGo</title>
  <?php
}
    ?>

  @include('facelift2.estilo')

  @if(session()->has('tipoUsuario') && session()->get('tipoUsuario') === 'schoolar')
    <link rel="stylesheet" href="{{ asset('css/schoolar.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  @endif

  <!-- caio -->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>


  <style>
    /* Padronização Global de Modais (GoClinic Style - Topo com Margem) */
    .modal-backdrop {
      display: none !important;
    }

    .modal-content {
      box-shadow: 0 0 50px rgba(0, 0, 0, 0.4) !important;
      border: none !important;
    }

    /* Forçar topo para todos os modais, removendo centralização vertical */
    .modal-dialog,
    .modal-dialog-centered {
      display: block !important;
      /* Remove comportamento flex de centralização */
      margin-top: 85px !important;
      /* Distância segura do topo (botão de pesquisa) */
      margin-left: auto;
      margin-right: auto;
      min-height: auto !important;
      transform: none !important;
    }

    /* Garantir Z-Index alto */
    .modal {
      z-index: 100001 !important;
    }
  </style>
</head>

<body>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T9GKFKN" height="0" width="0"
      style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->


  @include('facelift2.topo')

  <div class="conteudoCentro">
    @yield('content')
  </div>


  <style type="text/css">
    #tela-de-carregamento {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.5);
      display: none;
      z-index: 9999;
    }

    .spinner {
      border: 5px solid #f3f3f3;
      border-top: 5px solid #3498db;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      animation: spin 1s linear infinite;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }
  </style>



  @if(session()->has('tipoUsuario') && session()->get('tipoUsuario') === 'schoolar')
    @include('schoolar.rodape')
  @else
    @include('facelift2.rodape')
  @endif

  @include('facelift2.scripts')

  <script type="text/javascript">
    const botoesComRedirecionamento = document.querySelectorAll('button[type="submit"], input[type="submit"]');
    const telaDeCarregamento = document.getElementById('tela-de-carregamento');

    botoesComRedirecionamento.forEach(function (botao) {
      botao.addEventListener('click', function () {
        telaDeCarregamento.style.display = 'block';
      });
    });

    document.addEventListener('submit', function (event) {
      telaDeCarregamento.style.display = 'block';
      // Permite que o formulário seja enviado normalmente
      return true;
    });
  </script>

  <script>
    function validateFormRecSenha() {
      var senha1 = document.getElementById("senhaLogin").value;
      var senha2 = document.getElementById("senhaConfirm").value;

      if (senha1 !== senha2) {
        document.getElementById("senhaError").innerHTML = "As senhas não coincidem";
        setTimeout(function () {
          document.getElementById('tela-de-carregamento').style.display = 'none';
        }, 500);
        return false;
      } else {
        document.getElementById("senhaError").innerHTML = "";
        return true;
      }
    }
  </script>

  <script type="text/javascript">
    function camposObrigatoriosNaoPreenchidos() {
      // seleciona todos os campos do formulário que possuem o atributo "required"
      var camposObrigatorios = document.querySelectorAll('#formCad input[required], #formCad select[required], #formCad textarea[required]');

      // percorre os campos obrigatórios e verifica se algum deles está vazio
      for (var i = 0; i < camposObrigatorios.length; i++) {
        if (camposObrigatorios[i].value.trim() === '') {
          return true; // há um campo obrigatório não preenchido
        }
      }

      // verifica se o checkbox dos termos foi marcado
      if (document.getElementById('CheckTermos').required && !document.getElementById('CheckTermos').checked) {
        return true; // o checkbox dos termos não foi marcado
      }

      return false; // todos os campos obrigatórios foram preenchidos
    }

    const formCad = document.querySelector('#formCad');
    if (formCad) {
      formCad.addEventListener('submit', function (event) {
        // previne o envio padrão do formulário
        event.preventDefault();

        // verifica se os campos obrigatórios foram preenchidos
        if (camposObrigatoriosNaoPreenchidos()) {
          // exibe uma mensagem de erro para o usuário
          alert('Por favor, preencha todos os campos obrigatórios.');

          setTimeout(function () {
            document.getElementById('tela-de-carregamento').style.display = 'none';
          }, 500);

        } else {
          // envia o formulário
          this.submit();
        }
      });
    }
  </script>

  <script type="text/javascript">
    $(document).ready(function () {
      var $videoSrc;
      $('.video-btn').click(function () {
        $videoSrc = $(this).data("src");
      });
      console.log($videoSrc);
      $('#modalVideo').on('shown.bs.modal', function (e) {
        $("#video").attr('src', "{{ route('videoplay') }}/" + $videoSrc + "");
      })
      $('#modalVideo').on('hide.bs.modal', function (e) {
        $("#video").attr('src', "{{ route('loadingvideo') }}");
      })
    });
  </script>

  <?php
if (null !== Request()->segment(5)) {
  if ($modalConteudo == 'permitido') {
    if (Request()->segment(2) == 'video') { 
?>
  <script type="text/javascript">
    $(document).ready(function () {
      $("#VideoId{{Request()->segment(5)}}").click();
    });
  </script>
  <?php
    } else {
?>
  <script type="text/javascript">
    $(document).ready(function () {
      $("#leiaCapitulo{{ Request()->segment(5) }}").modal('show');
      showPDF{{ Request()->segment(5) }}("");
    });
  </script>
  <?php
    }
  } else { 
?>
  <script type="text/javascript">
    // $(document).ready(function(){
    //     $("#{{ $modalConteudo }}").modal('show');
    // });
  </script>
  <?php 
    }
}
?>

  @yield('api')

  <!-- caio -->



  <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js"></script>
  <script src="{{ asset('script.js') }}"></script>

  <!-- MODAL GIFTCARD  -->
  <div class="modal fade" id="ModalGift" tabindex="-1" aria-labelledby="ModalGift" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modalCentraliza">

      <div class="modal-content conteudoDoModal modalRedondinho">

        <div class="modal-head modal-head-Vantagem2">
          <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="top: 40px; position:fixed; right: 10px;"></button> -->

          <div class="logo-modal">

            <img style="max-height:39px; margin: 20px auto; display:block "
              src="{{ asset('facelift2/img/go_logo_6.png') }}">
            <div class="modal-title tituloModal">
              <h5 class="modal-title" id="espacoParaAssinantesLabel">{{__("messages.ModGiftInf")}}</h5>
              <br>
              <form method="GET" action="{{ route('validagift') }}" enctype="multipart/form-data" id="form-giftcard">
                @csrf

                <div class="row" id="couponCode">
                  <div class="mb-3" style="padding:0 30px">
                    <label for="coupon" class="form-label">{{__("messages.ModGiftIsert")}}</label>
                    <input type="text" name="code" class="form-control" id="InputCoupon" aria-describedby="coupon"
                      style="text-align: center; font-size: 35px; border-radius: 20px;" required>
                  </div>
                </div>

                <div class="row">
                  <div class="mb-3">
                    <input type="submit" value="Ativar" name="submit-giftcard"
                      class="btn btn-danger dropdown-toggle botaoLogar">
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>

        <!-- Faixa com Icons -->

        <div class="modal-body background-assinantemodal">
          <div class="row">
            <div class="col-md-12 modal-title-baixo"></div>
          </div>

          <div class="row">
            <div class="col-4 iconeVantagem"> <i class="fa-solid fa-book-open fa-2xl" style="color: #d6d4ca"></i>
              <h6 class="textoModal">{{__("messages.IconsBook")}}</h6>
            </div>
            <div class="col-4 iconeVantagem"><i class="fa-solid fa-play fa-2xl" style="color: #d6d4ca"></i>
              <h6 class="textoModal">{{__("messages.IconsVideo")}}</h6>
            </div>
            <div class="col-4 iconeVantagem"><i class="fa-solid fa-house-laptop fa-2xl" style="color: #d6d4ca"></i>
              <h6 class="textoModal">{{__("messages.IconsHouse")}}</h6>
            </div>
          </div>
          <br>
          <br>

          <div class="row">
            <div class="col-4 iconeVantagem"> <i class="fa-solid fa-calendar-days fa-2xl"
                style="color: #d6d4ca"></i></i>
              <h6 class="textoModal">{{__("messages.IconsCalendar")}}</h6>
            </div>
            <div class="col-4 iconeVantagem"><i class="fa-solid fa-tags fa-2xl" style="color: #d6d4ca"></i>
              <h6 class="textoModal">{{__("messages.IconsDesc")}}</h6>
            </div>
            <div class="col-4 iconeVantagem"><i class="fa-solid fa-medal fa-2xl" style="color: #d6d4ca"></i>
              <h6 class="textoModal">{{__("messages.IconsMedal")}}</h6>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>

  <!-- MODAL Assinar Plano -->

  <div class="modal fade" id="vamosAssinar" tabindex="-1" aria-labelledby="vamosAssinarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modalCentraliza">

      <div class="modal-content conteudoDoModal modalRedondinho">

        <div class="modal-head modal-head-Vantagem2">
          <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="top: 40px; position:fixed; right: 10px;"></button> -->

          <div class="logo-modal">

            <img style="max-height:39px; margin: 20px auto; display:block "
              src="{{ asset('facelift2/img/go_logo_6.png') }}">
            <div class="modal-title tituloModal">
              <h5 class="modal-title" id="espacoParaAssinantesLabel">{{__("messages.ModMessgPlan")}}</h5>
              <p class="modal-title titulo-modalgeral1">{{__("messages.ModVenha")}}</p>
              <br>
              <p class="title-price-plan">{{__("messages.ModAssineApenas")}}</p>
              <h2 class="mb-3 title-price2-plan">R$ 89,00</h2>
              <br>
              <!-- <a href="{{ route('cadastrar') }}" class="btn btn-danger"  alt="assinar">{{__("messages.ModAssine")}}</a> -->
              <a href="https://www.dentalgo.com.br/checkoutnovo" class="btn btn-danger"
                alt="assinar">{{__("messages.ModAssine")}}</a>
            </div>
          </div>
        </div>

        <div class="modal-body background-assinantemodal">
          <div class="row">
            <div class="col-md-12 modal-title-baixo"></div>
          </div>

          <div class="row">
            <div class="col-4 iconeVantagem"> <i class="fa-solid fa-book-open"></i>
              <h6 class="textoModal">{{__("messages.IconsBook")}}</h6>
            </div>
            <div class="col-4 iconeVantagem"><i class="fa-solid fa-play"></i>
              <h6 class="textoModal">{{__("messages.IconsVideo")}}</h6>
            </div>
            <div class="col-4 iconeVantagem"><i class="fa-solid fa-house-laptop"></i>
              <h6 class="textoModal">{{__("messages.IconsHouse")}}</h6>
            </div>
          </div>
          <br>
          <br>

          <div class="row">
            <div class="col-4 iconeVantagem"> <i class="fa-solid fa-calendar-days"></i></i>
              <h6 class="textoModal">{{__("messages.IconsCalendar")}}</h6>
            </div>
            <div class="col-4 iconeVantagem"><i class="fa-solid fa-tags"></i>
              <h6 class="textoModal">{{__("messages.IconsDesc")}}</h6>
            </div>
            <div class="col-4 iconeVantagem"><i class="fa-solid fa-medal"></i>
              <h6 class="textoModal">{{__("messages.IconsMedal")}}</h6>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>



  <!-- MODAL Espaço Para Assinantes -->

  <div class="modal fade" id="espacoParaAssinantes" tabindex="-1" aria-labelledby="espacoParaAssinantesLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modalCentraliza">
      <div class="modal-content conteudoDoModal modalRedondinho">

        <div class="modal-head modal-head-Vantagem">
          <button type="button" class=" btn-close" data-bs-dismiss="modal" aria-label="Close"
            style="top: 40px; position:fixed; right: 20px; color: #fff !important;"></button>

          <div class="logo-modal">

            <img style="max-height:39px; margin: 20px auto; display:block "
              src="{{ asset('facelift2/img/go_logo_6.png') }}">
            <div class="modal-title tituloModal">
              <h5 class="modal-title titulo-modalgeral" id="espacoParaAssinantesLabel">{{__("messages.ModTopo")}}</h5>
              <p class="modal-title titulo-modalgeral1">{{__("messages.ModVenha")}}</p>
              <br>
              <p class="title-price">{{__("messages.ModAssineApenas")}}</p>
              <h2 class="mb-3 title-price2">R$ 89,00</h2>
              <!--<a href="{{ route('assine') }}" class="btn btn-danger btn-modalmargin"alt="assinar" data-bs-toggle="modal" data-bs-target="#modalCadastro">{{__("messages.ModAssine")}}</a>-->
              <!-- <a href="{{ route('cadastrar') }}" class="btn btn-danger btn-modalmargin"alt="assinar">{{__("messages.ModAssine")}}</a> -->
              <a href="https://www.dentalgo.com.br/checkoutnovo" class="btn btn-danger btn-modalmargin"
                alt="assinar">{{__("messages.ModAssine")}}</a>
            </div>
          </div>
        </div>

        <div class="modal-body background-assinantemodal">
          <div class="row">
            <div class="col-md-12 modal-title-baixo"><a href="{{ route('logar') }}"
                style="item-align:center; font-family:prompt" class="btn btn-dark" data-bs-toggle="modal"
                data-bs-target="#modalLogin">{{__("messages.ModAssine2")}}</a></div>
          </div>

          <div class="row">
            <div class="col-4 iconeVantagem"><i class="fa-solid fa-book-open" style="color: #d6d4ca"></i>
              <h6 class="textoModal">{{__("messages.IconsBook")}}</h6>
            </div>
            <div class="col-4 iconeVantagem"><i class="fa-solid fa-play" style="color: #d6d4ca"></i>
              <h6 class="textoModal">{{__("messages.IconsVideo")}}</h6>
            </div>
            <div class="col-4 iconeVantagem"><i class="fa-solid fa-house-laptop" style="color: #d6d4ca"></i>
              <h6 class="textoModal">{{__("messages.IconsHouse")}}</h6>
            </div>
          </div>
          <br>
          <br>

          <div class="row">
            <div class="col-4 iconeVantagem"> <i class="fa-solid fa-calendar-days" style="color: #d6d4ca"></i></i>
              <h6 class="textoModal">{{__("messages.IconsCalendar")}}</h6>
            </div>
            <div class="col-4 iconeVantagem"><i class="fa-solid fa-tags" style="color: #d6d4ca"></i>
              <h6 class="textoModal">{{__("messages.IconsDesc")}}</h6>
            </div>
            <div class="col-4 iconeVantagem"><i class="fa-solid fa-medal" style="color: #d6d4ca"></i>
              <h6 class="textoModal">{{__("messages.IconsMedal")}}</h6>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>

  <!-- MODAL Renove o plano -->

  <div class="modal fade" id="renoveOplano" tabindex="-1" aria-labelledby="renoveOplanoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modalCentraliza">
      <div class="modal-content conteudoDoModal modalRedondinho">

        <div class="modal-head modal-head-Vantagem">
          <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="top: 40px; position:fixed; right: 10px;"></button> -->

          <div class="logo-modal">

            <img style="max-height:39px; margin: 20px auto; display:block "
              src="{{ asset('facelift2/img/go_logo_6.png') }}">
            <div class="modal-title tituloModal">
              <h5 class="modal-title" id="espacoParaAssinantesLabel">{{__("messages.ModTopoVenceu")}}</h5>
              <p class="modal-title">{{__("messages.ModRenove")}}</p>
              <br>
              <p class="title-price">{{__("messages.ModAssineApenas")}}</p>
              <h2 class="mb-3 title-price2">R$ 89,00</h2>
              <!-- <a href="{{ route('assinatura') }}" class="btn btn-danger" alt="assinar">{{__("messages.ModRenovar")}}</a> -->
              <a href="https://www.dentalgo.com.br/checkoutnovo" class="btn btn-danger"
                alt="assinar">{{__("messages.ModRenovar")}}</a>
            </div>
          </div>
        </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 modal-title-baixo"><button style="item-align:center; font-family:prompt"
                class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalLogin">Dúvidas, Fale
                Conosco</button></div>
          </div>

          <div class="row">
            <div class="col-4 iconeVantagem"> <i class="fa-solid fa-book-open"></i>
              <h6 class="textoModal">{{__("messages.IconsBook")}}</h6>
            </div>
            <div class="col-4 iconeVantagem"><i class="fa-solid fa-play"></i>
              <h6 class="textoModal">{{__("messages.IconsVideo")}}</h6>
            </div>
            <div class="col-4 iconeVantagem"><i class="fa-solid fa-house-laptop"></i>
              <h6 class="textoModal">{{__("messages.IconsHouse")}}</h6>
            </div>
          </div>
          <br>
          <br>

          <div class="row">
            <div class="col-4 iconeVantagem"> <i class="fa-solid fa-calendar-days"></i></i>
              <h6 class="textoModal">{{__("messages.IconsCalendar")}}</h6>
            </div>
            <div class="col-4 iconeVantagem"><i class="fa-solid fa-tags"></i>
              <h6 class="textoModal">{{__("messages.IconsDesc")}}</h6>
            </div>
            <div class="col-4 iconeVantagem"><i class="fa-solid fa-medal"></i>
              <h6 class="textoModal">{{__("messages.IconsMedal")}}</h6>
            </div>
          </div>


        </div>

      </div>
    </div>
  </div>

  <div id="tela-de-carregamento">
    <div class="spinner"></div>
  </div>

  <!-- Modal Termo de Uso -->
  <div class="modal fade text-justify" id="termoDeUso" tabindex="-1" aria-labelledby="termoDeUsoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modalCentraliza">
      <div class="modal-content conteudoDoModal modalRedondinho">

        <div class="modal-head modal-head-Vantagem4">
          <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="top: 40px; position:fixed; right: 10px;"></button> -->

          <div class="logo-modal">

            <img style="max-height:39px; margin: 20px auto; display:block "
              src="{{ asset('facelift2/img/go_logo_6.png') }}">
            <div class="modal-title text-justify">
              <h5 class="modal-title" id="termoDeUso" style="font-size:19px; color:#000;">
                @php echo __("messages.ModalTermoDeUso") @endphp</h5>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>


  @if(null == session()->get('token'))

    <!-- MODAL LOGIN -->

    <div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modalCentraliza">
        <div class="modal-content modalRedondinho">
          <div class="modal-header" style="background-color:#fff">
            <h5 class="modal-title" id="modalLoginLabel">{{__("messages.ModaLogin")}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body-login">
            <form method="POST" action="{{ route('login') }}" enctype="multipart/form-data">
              @csrf

              <div class="row">
                <div class="mb-3">
                  <label for="emailLoginLabel" class="form-label">{{__("messages.ModalEmail")}}</label>
                  <input type="email" name="email" class="form-control" id="emailLoginLabel"
                    aria-describedby="emailLoginHelp" autocomplete="email">
                  <div id="emailLoginHelp" class="form-text">{{__("messages.ModalSubEmail")}}</div>
                </div>
              </div>

              <div class="row">
                <div class="mb-3">
                  <label for="senhaLogin" class="form-label">{{__("messages.ModalSenha")}}</label>
                  <input type="password" name="password" class="form-control" id="senhaLogin"
                    aria-describedby="passwordHelp" autocomplete="current-password">
                </div>
              </div>

              <div class="row">
                <div class="mb-3">
                  <a data-bs-toggle="modal" data-bs-target="#modalRecSenha" class="btn btn-secondary botaoLogin"><i
                      class="fa-solid fa-user"></i> {{__("messages.ModalSenhaEsqueceu")}}</a>
                  <input type="submit" value="{{__("messages.ModaLogin")}}"
                    class="btn btn-danger dropdown-toggle botaoLogar" style="float: right;">
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- MODAL LOGIN SCHOOLAR -->

    <div class="modal fade" id="modalLoginSchoolar" tabindex="-1" aria-labelledby="modalLoginSchoolarLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modalCentraliza">
        <div class="modal-content modalRedondinho">
          <div class="modal-header" style="background-color:#fff">
            <h5 class="modal-title" id="modalLoginSchoolarLabel">{{__("messages.ModaLogin")}} schoolar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body-login">
            <form method="POST" action="{{ route('schoolarlogin') }}" enctype="multipart/form-data">
              @csrf

              <div class="row">
                <div class="mb-3">
                  <label for="emailSchoolarLogin" class="form-label">{{__("messages.ModalEmail")}}</label>
                  <input type="email" name="email" class="form-control" id="emailSchoolarLogin"
                    aria-describedby="emailSchoolarHelp" autocomplete="email">
                  <div id="emailSchoolarHelp" class="form-text">{{__("messages.ModalSubEmail")}}</div>
                </div>
              </div>

              <div class="row">
                <div class="mb-3">
                  <label for="senhaSchoolarLogin" class="form-label">{{__("messages.ModalSenha")}}</label>
                  <input type="password" name="password" class="form-control" id="senhaSchoolarLogin"
                    aria-describedby="passwordSchoolarHelp" autocomplete="current-password">
                </div>
              </div>

              <div class="row">
                <div class="mb-3">
                  <a data-bs-toggle="modal" data-bs-target="#modalRecSenha" class="btn btn-secondary botaoLogin"><i
                      class="fa-solid fa-user"></i> {{__("messages.ModalSenhaEsqueceu")}}</a>
                  <input type="submit" value="{{__("messages.ModaLogin")}}"
                    class="btn btn-danger dropdown-toggle botaoLogar" style="float: right;">
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- MODAL RecuperaSenha -->

    <div class="modal fade" id="modalRecSenha" tabindex="-1" aria-labelledby="modalRecSenhaLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modalCentraliza">
        <div class="modal-content modalRedondinho">
          <div class="modal-header background-modalrec-header">
            <h5 class="modal-title" id="modalRecSenhaLabel">{{__("messages.ModRecSenha")}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body background-modalrec">
            <form method="POST" action="{{ route('recsenha') }}" enctype="multipart/form-data">
              @csrf

              <div class="row">
                <div class="mb-3">
                  <p>{{__("messages.ModInfEmailToken")}}</p>
                </div>
              </div>

              <div class="row">
                <div class="mb-3">
                  <label for="E-mail" class="form-label">{{__("messages.ModEmail")}}</label>
                  <input type="email" name="email" class="form-control" id="emailLoginLabel"
                    aria-describedby="emailLogin">
                  <div id="emailLogin" class="form-text">{{__("messages.ModEmailCadastrado")}}</div>
                </div>
              </div>

              <div class="row">
                <div class="mb-3">
                  <input type="submit" value="Recuperar" class="btn btn-danger dropdown-toggle botaoLogar">
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- MODAL CADASTRO -->

    <div class="modal fade" id="modalCadastro" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modalCentraliza">
        <div class="modal-content modalRedondinho">
          <div class="modal-header"
            style="background-color:#fff; border-top-right-radius: 30px;border-top-left-radius: 30px;">
            <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: #000; ">{{__("messages.ModCadTopo")}}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body"
            style="background-color:#fff; border-bottom-left-radius: 30px; border-bottom-right-radius: 30px;">
            <form id="formCad" method="POST" action="{{ route('cadastro') }}" enctype="multipart/form-data">
              @csrf

              <div class="row">
                <div class="mb-3">
                  <label for="nome" class="form-label">{{__("messages.ModCadNome")}}</label>
                  <input type="text" name="nome" class="form-control" id="InputNome" aria-describedby="yourName" required>
                </div>
              </div>

              <div class="row">
                <label for="telefone" class="form-label">{{__("messages.ModCadFone")}}</label>
                <div class="col-md-3">
                  <select class="form-select" name="ddi" id="InputDDI" aria-describedby="validationServer04Feedback"
                    required>
                    <option selected disabled value="">{{__("messages.ModCadSelecione")}}</option>
                    <option data-countryCode="BR" value="55">Brasil (+55)</option>
                    <option data-countryCode="PT" value="351">Portugal (+351)</option>
                    <option data-countryCode="PE" value="51">Peru (+51)</option>
                    <option data-countryCode="GQ" value="240">Equatorial Guinea (+240)</option>
                    <option data-countryCode="CL" value="56">Chile (+56)</option>
                    <option data-countryCode="BO" value="591">Bolivia (+591)</option>
                    <option data-countryCode="US" value="1">USA (+1)</option>
                    <option data-countryCode="DZ" value="213">Algeria (+213)</option>
                    <option data-countryCode="AD" value="376">Andorra (+376)</option>
                    <option data-countryCode="AO" value="244">Angola (+244)</option>
                    <option data-countryCode="AI" value="1264">Anguilla (+1264)</option>
                    <option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
                    <option data-countryCode="AR" value="54">Argentina (+54)</option>
                    <option data-countryCode="AM" value="374">Armenia (+374)</option>
                    <option data-countryCode="AW" value="297">Aruba (+297)</option>
                    <option data-countryCode="AU" value="61">Australia (+61)</option>
                    <option data-countryCode="AT" value="43">Austria (+43)</option>
                    <option data-countryCode="AZ" value="994">Azerbaijan (+994)</option>
                    <option data-countryCode="BS" value="1242">Bahamas (+1242)</option>
                    <option data-countryCode="BH" value="973">Bahrain (+973)</option>
                    <option data-countryCode="BD" value="880">Bangladesh (+880)</option>
                    <option data-countryCode="BB" value="1246">Barbados (+1246)</option>
                    <option data-countryCode="BY" value="375">Belarus (+375)</option>
                    <option data-countryCode="BE" value="32">Belgium (+32)</option>
                    <option data-countryCode="BZ" value="501">Belize (+501)</option>
                    <option data-countryCode="BJ" value="229">Benin (+229)</option>
                    <option data-countryCode="BM" value="1441">Bermuda (+1441)</option>
                    <option data-countryCode="BT" value="975">Bhutan (+975)</option>
                    <option data-countryCode="BA" value="387">Bosnia Herzegovina (+387)</option>
                    <option data-countryCode="BW" value="267">Botswana (+267)</option>
                    <option data-countryCode="BN" value="673">Brunei (+673)</option>
                    <option data-countryCode="BG" value="359">Bulgaria (+359)</option>
                    <option data-countryCode="BF" value="226">Burkina Faso (+226)</option>
                    <option data-countryCode="BI" value="257">Burundi (+257)</option>
                    <option data-countryCode="KH" value="855">Cambodia (+855)</option>
                    <option data-countryCode="CM" value="237">Cameroon (+237)</option>
                    <option data-countryCode="CA" value="1">Canada (+1)</option>
                    <option data-countryCode="CV" value="238">Cape Verde Islands (+238)</option>
                    <option data-countryCode="KY" value="1345">Cayman Islands (+1345)</option>
                    <option data-countryCode="CF" value="236">Central African Republic (+236)</option>
                    <option data-countryCode="CN" value="86">China (+86)</option>
                    <option data-countryCode="CO" value="57">Colombia (+57)</option>
                    <option data-countryCode="KM" value="269">Comoros (+269)</option>
                    <option data-countryCode="CG" value="242">Congo (+242)</option>
                    <option data-countryCode="CK" value="682">Cook Islands (+682)</option>
                    <option data-countryCode="CR" value="506">Costa Rica (+506)</option>
                    <option data-countryCode="HR" value="385">Croatia (+385)</option>
                    <option data-countryCode="CU" value="53">Cuba (+53)</option>
                    <option data-countryCode="CY" value="90392">Cyprus North (+90392)</option>
                    <option data-countryCode="CY" value="357">Cyprus South (+357)</option>
                    <option data-countryCode="CZ" value="42">Czech Republic (+42)</option>
                    <option data-countryCode="DK" value="45">Denmark (+45)</option>
                    <option data-countryCode="DJ" value="253">Djibouti (+253)</option>
                    <option data-countryCode="DM" value="1809">Dominica (+1809)</option>
                    <option data-countryCode="DO" value="1809">Dominican Republic (+1809)</option>
                    <option data-countryCode="EC" value="593">Ecuador (+593)</option>
                    <option data-countryCode="EG" value="20">Egypt (+20)</option>
                    <option data-countryCode="SV" value="503">El Salvador (+503)</option>
                    <option data-countryCode="ER" value="291">Eritrea (+291)</option>
                    <option data-countryCode="EE" value="372">Estonia (+372)</option>
                    <option data-countryCode="ET" value="251">Ethiopia (+251)</option>
                    <option data-countryCode="FK" value="500">Falkland Islands (+500)</option>
                    <option data-countryCode="FO" value="298">Faroe Islands (+298)</option>
                    <option data-countryCode="FJ" value="679">Fiji (+679)</option>
                    <option data-countryCode="FI" value="358">Finland (+358)</option>
                    <option data-countryCode="FR" value="33">France (+33)</option>
                    <option data-countryCode="GF" value="594">French Guiana (+594)</option>
                    <option data-countryCode="PF" value="689">French Polynesia (+689)</option>
                    <option data-countryCode="GA" value="241">Gabon (+241)</option>
                    <option data-countryCode="GM" value="220">Gambia (+220)</option>
                    <option data-countryCode="GE" value="7880">Georgia (+7880)</option>
                    <option data-countryCode="DE" value="49">Germany (+49)</option>
                    <option data-countryCode="GH" value="233">Ghana (+233)</option>
                    <option data-countryCode="GI" value="350">Gibraltar (+350)</option>
                    <option data-countryCode="GR" value="30">Greece (+30)</option>
                    <option data-countryCode="GL" value="299">Greenland (+299)</option>
                    <option data-countryCode="GD" value="1473">Grenada (+1473)</option>
                    <option data-countryCode="GP" value="590">Guadeloupe (+590)</option>
                    <option data-countryCode="GU" value="671">Guam (+671)</option>
                    <option data-countryCode="GT" value="502">Guatemala (+502)</option>
                    <option data-countryCode="GN" value="224">Guinea (+224)</option>
                    <option data-countryCode="GW" value="245">Guinea - Bissau (+245)</option>
                    <option data-countryCode="GY" value="592">Guyana (+592)</option>
                    <option data-countryCode="HT" value="509">Haiti (+509)</option>
                    <option data-countryCode="HN" value="504">Honduras (+504)</option>
                    <option data-countryCode="HK" value="852">Hong Kong (+852)</option>
                    <option data-countryCode="HU" value="36">Hungary (+36)</option>
                    <option data-countryCode="IS" value="354">Iceland (+354)</option>
                    <option data-countryCode="IN" value="91">India (+91)</option>
                    <option data-countryCode="ID" value="62">Indonesia (+62)</option>
                    <option data-countryCode="IR" value="98">Iran (+98)</option>
                    <option data-countryCode="IQ" value="964">Iraq (+964)</option>
                    <option data-countryCode="IE" value="353">Ireland (+353)</option>
                    <option data-countryCode="IL" value="972">Israel (+972)</option>
                    <option data-countryCode="IT" value="39">Italy (+39)</option>
                    <option data-countryCode="JM" value="1876">Jamaica (+1876)</option>
                    <option data-countryCode="JP" value="81">Japan (+81)</option>
                    <option data-countryCode="JO" value="962">Jordan (+962)</option>
                    <option data-countryCode="KZ" value="7">Kazakhstan (+7)</option>
                    <option data-countryCode="KE" value="254">Kenya (+254)</option>
                    <option data-countryCode="KI" value="686">Kiribati (+686)</option>
                    <option data-countryCode="KP" value="850">Korea North (+850)</option>
                    <option data-countryCode="KR" value="82">Korea South (+82)</option>
                    <option data-countryCode="KW" value="965">Kuwait (+965)</option>
                    <option data-countryCode="KG" value="996">Kyrgyzstan (+996)</option>
                    <option data-countryCode="LA" value="856">Laos (+856)</option>
                    <option data-countryCode="LV" value="371">Latvia (+371)</option>
                    <option data-countryCode="LB" value="961">Lebanon (+961)</option>
                    <option data-countryCode="LS" value="266">Lesotho (+266)</option>
                    <option data-countryCode="LR" value="231">Liberia (+231)</option>
                    <option data-countryCode="LY" value="218">Libya (+218)</option>
                    <option data-countryCode="LI" value="417">Liechtenstein (+417)</option>
                    <option data-countryCode="LT" value="370">Lithuania (+370)</option>
                    <option data-countryCode="LU" value="352">Luxembourg (+352)</option>
                    <option data-countryCode="MO" value="853">Macao (+853)</option>
                    <option data-countryCode="MK" value="389">Macedonia (+389)</option>
                    <option data-countryCode="MG" value="261">Madagascar (+261)</option>
                    <option data-countryCode="MW" value="265">Malawi (+265)</option>
                    <option data-countryCode="MY" value="60">Malaysia (+60)</option>
                    <option data-countryCode="MV" value="960">Maldives (+960)</option>
                    <option data-countryCode="ML" value="223">Mali (+223)</option>
                    <option data-countryCode="MT" value="356">Malta (+356)</option>
                    <option data-countryCode="MH" value="692">Marshall Islands (+692)</option>
                    <option data-countryCode="MQ" value="596">Martinique (+596)</option>
                    <option data-countryCode="MR" value="222">Mauritania (+222)</option>
                    <option data-countryCode="YT" value="269">Mayotte (+269)</option>
                    <option data-countryCode="MX" value="52">Mexico (+52)</option>
                    <option data-countryCode="FM" value="691">Micronesia (+691)</option>
                    <option data-countryCode="MD" value="373">Moldova (+373)</option>
                    <option data-countryCode="MC" value="377">Monaco (+377)</option>
                    <option data-countryCode="MN" value="976">Mongolia (+976)</option>
                    <option data-countryCode="MS" value="1664">Montserrat (+1664)</option>
                    <option data-countryCode="MA" value="212">Morocco (+212)</option>
                    <option data-countryCode="MZ" value="258">Mozambique (+258)</option>
                    <option data-countryCode="MN" value="95">Myanmar (+95)</option>
                    <option data-countryCode="NA" value="264">Namibia (+264)</option>
                    <option data-countryCode="NR" value="674">Nauru (+674)</option>
                    <option data-countryCode="NP" value="977">Nepal (+977)</option>
                    <option data-countryCode="NL" value="31">Netherlands (+31)</option>
                    <option data-countryCode="NC" value="687">New Caledonia (+687)</option>
                    <option data-countryCode="NZ" value="64">New Zealand (+64)</option>
                    <option data-countryCode="NI" value="505">Nicaragua (+505)</option>
                    <option data-countryCode="NE" value="227">Niger (+227)</option>
                    <option data-countryCode="NG" value="234">Nigeria (+234)</option>
                    <option data-countryCode="NU" value="683">Niue (+683)</option>
                    <option data-countryCode="NF" value="672">Norfolk Islands (+672)</option>
                    <option data-countryCode="NP" value="670">Northern Marianas (+670)</option>
                    <option data-countryCode="NO" value="47">Norway (+47)</option>
                    <option data-countryCode="OM" value="968">Oman (+968)</option>
                    <option data-countryCode="PW" value="680">Palau (+680)</option>
                    <option data-countryCode="PA" value="507">Panama (+507)</option>
                    <option data-countryCode="PG" value="675">Papua New Guinea (+675)</option>
                    <option data-countryCode="PY" value="595">Paraguay (+595)</option>
                    <option data-countryCode="PH" value="63">Philippines (+63)</option>
                    <option data-countryCode="PL" value="48">Poland (+48)</option>
                    <option data-countryCode="PR" value="1787">Puerto Rico (+1787)</option>
                    <option data-countryCode="QA" value="974">Qatar (+974)</option>
                    <option data-countryCode="RE" value="262">Reunion (+262)</option>
                    <option data-countryCode="RO" value="40">Romania (+40)</option>
                    <option data-countryCode="RU" value="7">Russia (+7)</option>
                    <option data-countryCode="RW" value="250">Rwanda (+250)</option>
                    <option data-countryCode="SM" value="378">San Marino (+378)</option>
                    <option data-countryCode="ST" value="239">Sao Tome &amp; Principe (+239)</option>
                    <option data-countryCode="SA" value="966">Saudi Arabia (+966)</option>
                    <option data-countryCode="SN" value="221">Senegal (+221)</option>
                    <option data-countryCode="CS" value="381">Serbia (+381)</option>
                    <option data-countryCode="SC" value="248">Seychelles (+248)</option>
                    <option data-countryCode="SL" value="232">Sierra Leone (+232)</option>
                    <option data-countryCode="SG" value="65">Singapore (+65)</option>
                    <option data-countryCode="SK" value="421">Slovak Republic (+421)</option>
                    <option data-countryCode="SI" value="386">Slovenia (+386)</option>
                    <option data-countryCode="SB" value="677">Solomon Islands (+677)</option>
                    <option data-countryCode="SO" value="252">Somalia (+252)</option>
                    <option data-countryCode="ZA" value="27">South Africa (+27)</option>
                    <option data-countryCode="ES" value="34">Spain (+34)</option>
                    <option data-countryCode="LK" value="94">Sri Lanka (+94)</option>
                    <option data-countryCode="SH" value="290">St. Helena (+290)</option>
                    <option data-countryCode="KN" value="1869">St. Kitts (+1869)</option>
                    <option data-countryCode="SC" value="1758">St. Lucia (+1758)</option>
                    <option data-countryCode="SD" value="249">Sudan (+249)</option>
                    <option data-countryCode="SR" value="597">Suriname (+597)</option>
                    <option data-countryCode="SZ" value="268">Swaziland (+268)</option>
                    <option data-countryCode="SE" value="46">Sweden (+46)</option>
                    <option data-countryCode="CH" value="41">Switzerland (+41)</option>
                    <option data-countryCode="SI" value="963">Syria (+963)</option>
                    <option data-countryCode="TW" value="886">Taiwan (+886)</option>
                    <option data-countryCode="TJ" value="7">Tajikstan (+7)</option>
                    <option data-countryCode="TH" value="66">Thailand (+66)</option>
                    <option data-countryCode="TG" value="228">Togo (+228)</option>
                    <option data-countryCode="TO" value="676">Tonga (+676)</option>
                    <option data-countryCode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option>
                    <option data-countryCode="TN" value="216">Tunisia (+216)</option>
                    <option data-countryCode="TR" value="90">Turkey (+90)</option>
                    <option data-countryCode="TM" value="7">Turkmenistan (+7)</option>
                    <option data-countryCode="TM" value="993">Turkmenistan (+993)</option>
                    <option data-countryCode="TC" value="1649">Turks &amp; Caicos Islands (+1649)</option>
                    <option data-countryCode="TV" value="688">Tuvalu (+688)</option>
                    <option data-countryCode="UG" value="256">Uganda (+256)</option>
                    <option data-countryCode="GB" value="44">UK (+44)</option>
                    <option data-countryCode="UA" value="380">Ukraine (+380)</option>
                    <option data-countryCode="AE" value="971">United Arab Emirates (+971)</option>
                    <option data-countryCode="UY" value="598">Uruguay (+598)</option>
                    <option data-countryCode="UZ" value="7">Uzbekistan (+7)</option>
                    <option data-countryCode="VU" value="678">Vanuatu (+678)</option>
                    <option data-countryCode="VA" value="379">Vatican City (+379)</option>
                    <option data-countryCode="VE" value="58">Venezuela (+58)</option>
                    <option data-countryCode="VN" value="84">Vietnam (+84)</option>
                    <option data-countryCode="VG" value="84">Virgin Islands - British (+1284)</option>
                    <option data-countryCode="VI" value="84">Virgin Islands - US (+1340)</option>
                    <option data-countryCode="WF" value="681">Wallis &amp; Futuna (+681)</option>
                    <option data-countryCode="YE" value="969">Yemen (North)(+969)</option>
                    <option data-countryCode="YE" value="967">Yemen (South)(+967)</option>
                    <option data-countryCode="ZM" value="260">Zambia (+260)</option>
                    <option data-countryCode="ZW" value="263">Zimbabwe (+263)</option>
                  </select>
                </div>
                <div class="col-md-9">
                  <input type="text" name="telefone" class="form-control" id="InputTelefone" aria-describedby="yourPhone"
                    required>
                  <div id="yourPhone" class="form-text">{{__("messages.ModCadDdd")}}</div>
                </div>
              </div>

              <div class="row" id="CadCPF" hidden>
                <div class="mb-3">
                  <label for="cpf" class="form-label">{{__("messages.ModCadCpf")}}</label>
                  <input type="text" name="cpf" class="form-control" id="InputCPF" aria-describedby="yourCPF">
                  <div id="cpfError" class="error-message"></div>
                </div>
              </div>

              <div class="row">
                <div class="mb-3">
                  <label for="E-mail" class="form-label">{{__("messages.ModCadEmail")}}</label>
                  <input type="email" name="email" class="form-control" id="InputEmail" aria-describedby="emailCadastro"
                    required>
                  <div id="emailCadastro" class="form-text">{{__("messages.ModCadSubMail")}}</div>
                </div>
              </div>

              <div class="row">
                <div class="mb-3">
                  <label for="password" class="form-label">{{__("messages.ModCadSenha")}}</label>
                  <input type="password" name="password" class="form-control" id="InputSenha"
                    aria-describedby="senhaCadastro" required>
                </div>
              </div>

              <div class="row">
                <div class="mb-3">
                  <label for="passwordpasswordConfirm" class="form-label">{{__("messages.ModCadSenhaConfirm")}}</label>
                  <input type="password" name="passwordConfirm" class="form-control" id="InputSenhaConfirma"
                    aria-describedby="senhaCadastro" required>
                </div>
              </div>

              <div class="row" id="couponCode" style="display:none;">
                <div class="mb-3">
                  <label for="coupon" class="form-label">{{__("messages.ModCadInsertCupom")}}</label>
                  <input type="text" name="coupon" class="form-control" id="InputCoupon" aria-describedby="coupon">
                </div>
              </div>

              <div class="form-group form-check mb-3">
                <input type="checkbox" class="form-check-input" id="CheckTermos" required>
                <label class="form-check-label" for="CheckTermos">{{__("messages.ModCadTermos")}}<a href="#"
                    style="color: black; font-weight:bold; text-decoration: none;"> {{__("messages.ModCadTermos2")}}</a>
                  {{__("messages.ModCadTermos3")}} <a href="#"
                    style="color: black; font-weight:bold; text-decoration: none;">{{__("messages.ModCadTermos4")}}</a>
                  {{__("messages.ModCadTermos5")}}</label>
              </div>

              <div class="row">
                <div class="mb-3">
                  <input type="submit" value="{{__("messages.ModCadBotao")}}"
                    class="btn btn-danger dropdown-toggle botaoLogar" style="float: right;">
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>


  @endif

</body>

</html>
