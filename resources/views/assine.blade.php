<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php
        $atigosUltimaRevista = $ultimaRevista[1]->productItems;
        if (count($atigosUltimaRevista) < 3) {
            $key = array_rand($atigosUltimaRevista, 2);
            $ultimoArtigo1 = $atigosUltimaRevista[$key[0]];
            $ultimoArtigo2 = $atigosUltimaRevista[$key[1]];
            $ultimoArtigo3 = null;
        }else{
            $key = array_rand($atigosUltimaRevista, 3); 
            $ultimoArtigo1 = $atigosUltimaRevista[$key[0]];
            $ultimoArtigo2 = $atigosUltimaRevista[$key[1]];
            $ultimoArtigo3 = $atigosUltimaRevista[$key[2]]; 
        }

        $linguagem = request('language');
        if($linguagem == null){
          $linguagem = 'pt';
        }

    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assine DentalGO</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="{{ asset ('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="owlcarousel/owl.theme.default.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assinea/css/assine-style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script async src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script defer src="{{ asset ('js/owl.carousel.min.js')}}"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
        $(".owl-carousel-assine").owlCarousel({
        loop: true,
        margin: 20,
        nav: false, 
        dots: false,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        center: true,
        responsiveClass: true,
        responsive:{
            0:{
                items: 1
            },
            692:{
                items: 4
            },
            1024:{
                items: 6
            },
            1920:{
                items: 8
            },
            2160:{
                items: 8
            },
        }
        });
    })


    $(document).ready(function(){
        $('.owl-carousel-revistas').owlCarousel({
            loop: true,
            margin: 20,
            nav: false,
            autoplay:true,
            autoplayTimeout:2000,
            autoplayHoverPause:true,
            responsiveClass:true,
            center: true,
            responsive: {
                0: {
                    items: 4
                },
                600: {
                    items: 4
                },
                1000: {
                    items: 7
                }
            }
        });
    });

    </script>
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

            <!-- Meta Pixel Code -->
        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '2412797325723956');
        fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=2412797325723956&ev=PageView&noscript=1"
        /></noscript>
        <!-- End Meta Pixel Code -->

</head>
<body>
<div class="desktop">
    <section class="container-fluid section1">
        <img class="img-fluid background-1" src="{{ asset('assinea/imagens/banner-01.png') }}">
        <div class="container">
            <div class="row">
                <div class="col-1"></div>
                <div class="col-5 section1-left">
                    <img class="logo" src="{{ asset('assinea/imagens/DentalGoLogo.png') }}" alt="">
                    <div class="frase">
                        <p>LEIA . OUÇA . ASSISTA</p>
                    </div>
                    <h3 class="title">A&nbsp;MUDANÇA&nbsp;COMEÇA&nbsp;AGORA</h3>
                    <p class="choice">Agora Com Novidade!<br>Ouça seus artigos com <b>GoTalks</b></p>
                </div>
                <div class="col-1"></div>
                <div class="col-5 section1-right">
                    <div class="card-valor text-center" style=" width: 65%; margin-top: 50px; color: #000000;">
                        <div class="text-center">
                            <p class="etiqueta">Plano <span>DentalGo</span></p>
                        </div>
                        <div>
                            <p><span style="font-size: 200%; font-weight: 800;">89,00</span>/mês</p>
                        </div>
                        <p>Esse plano sai<br>por <span style="font-weight: 800; font-size: 100%;">apenas R$ 2,99/ dia</span></p>
                        <div class="line"></div>
                        <p>Acesso a todo<br>acervo de revistas<br>+ de 6.000 artigos</p>
                        <p>Dental GO Academy</p>
                        <p>Clube de descontos<br>Dental Press</p>
                        <p>Livros Cortesia</p>
                        <p>Entrevista em Vídeos</p>
                        <p>Dicas e Drops em Vídeo</p>
                        <div class="line"></div>
                        <!-- <a class="btn-assinar" href="{{ route('cadastrar') }}">ASSINE AGORA</a> -->
                        <a class="btn-assinar" href="https://www.dentalgo.com.br/checkoutnovo">ASSINE AGORA</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


        <section class="section2 container-fluid">
        <div class="container mt-5">
            <div class="row">
                <div class="col-1"></div>
                <div class="col-11 top text-left mb-4">
                    <h2 class="title">Conheça o <span>GoTalks</span> Uma nova maneira de <span>Ouvir a ciência</span></h2>
                </div>
                <div class="col-1"></div>
            </div>

            <div class="row align-items-center"> <!-- Mantém os elementos alinhados verticalmente -->
                <div class="col-1"></div>
                
                <!-- Spotify Playlist -->
                <div class="col-md-5">
                <iframe style="border-radius:12px" src="https://open.spotify.com/embed/playlist/1R0SQA5Z68OGGIpcYXiV0s?utm_source=generator&theme=0" 
                    width="100%" height="352" frameBorder="0" allowfullscreen=""
                     allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
                </div>

                <!-- Player de Vídeo -->
                <div class="col-md-5 text-center">
                    <div class="video-wrapper">
                        <video id="videoPlayer" width="100%" controls>
                            <source src="{{ asset('assinea/videos/video.mp4') }}" type="video/mp4">
                            Seu navegador não suporta vídeos.
                        </video>
                    </div>
                </div>

                <div class="col-1"></div>
            </div>

            <style>
                .video-wrapper {
                    max-width: 700px;
                    margin: 0 auto;
                    border-radius: 10px;
                    overflow: hidden;
                }
            </style>
        </div>
    </section>



    <section class="section2 container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-1"></div>
                <div class="col-11 top">
                    <h3 class="title">Por que assinar o <span>DentalGO?</span></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-1"></div>
                <div class="col-3">
                    <div class="d-flex align-items-center icon">
                        <img src="{{ asset('assinea/imagens/icone-atualizar.png') }}" alt="">
                        <p><span>Atualização constante</span><br>Todos os meses você encontra novos conteúdos no formato de aulas, dicas e revistas</p>

                    </div>
                    <div class="d-flex align-items-center icon">
                        <img src="{{ asset('assinea/imagens/icone-camarote.png') }}" alt="">
                        <p><span>Multiplataforma</span><br>Celular, computador ou tablet, não importa onde estaremos com você</p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="d-flex meio align-items-center icon">
                        <img src="{{ asset('assinea/imagens/icones---cursor.png') }}" alt="">
                        <p><span>Somente o melhor</span><br>Tudo o que você consome nas revistas publicadas passou pelos mais rigorosos padrões de avaliação científica
                         </p>
                    </div>
                    <div class="d-flex meio align-items-center icon">
                        <img src="{{ asset('assinea/imagens/icones-dinheiro.png') }}" alt="">
                        <p><span>Economia digital</span><br>Acesso gratuito a livros digitais e 15% de desconto em cursos Dental Press</p>
                    </div>
                </div>
                <div class="col-3">
                    <div class="d-flex direita align-items-center icon">
                        <img src="{{ asset('assinea/imagens/icones-pesquisa.png') }}" alt="">
                        <p><span>Acesso rápido e fácil</span><br>Com as ferramentas de pesquisa do Dental GO, você encontra rapidamente o assunto que está procurando</p>
                    </div>
                    <div class="d-flex direita align-items-center icon">
                        <img src="{{ asset('assinea/imagens/icones---homem.png') }}" alt="">
                        <p><span>Exclusividade</span><br>Acesso exclusivo a eventos digitais, ao vivo com os principais nomes da Odontologia </p>
                    </div>
                </div>
                <div class="col-1"></div>
            </div>
        </div>
    </section>

    <section class="container-fluid section3">
        <div class="container">
            <div class="row">
                <div class="col-4 text-center counter" style="background-color: #77172e;">
                    <span id="cont1">+9</span>
                    <p>Periódicos</p>
                </div>
                <div class="col-4 text-center counter" style="background-color: #c9274d;">
                    <span id="cont2">+1000</span>
                    <p>Autores</p>
                </div>
                <div class="col-4 text-center counter" style="background-color: #852a3f;">
                    <span id="cont3">+6000</span>
                    <p>Artigos</p>
                </div>
            </div>
        </div>
    </section>

    <script>
      // Seleciona os elementos que serão incrementados
      const cont1 = document.getElementById('cont1');
      const cont2 = document.getElementById('cont2');
      const cont3 = document.getElementById('cont3');
      
      // Seleciona a seção
      const section3 = document.querySelector('.section3');

      // Função de incremento
      function increment(i, max, element) {
        if (i > max) return;
        setTimeout(function() {
          element.innerText = Math.round(i);
          increment(i + (max / 100), max, element);
        }, 10);
      }

      // Variável para garantir que só executamos uma vez
      let alreadyAnimated = false;

      function checkScroll() {
        // Pega a distância entre o topo do viewport e o topo da seção
        const sectionPosition = section3.getBoundingClientRect().top;

        // Define até onde a seção precisa “entrar” no viewport para considerarmos “visível”.
        // Aqui usei window.innerHeight, mas você pode ajustar como preferir
        if (sectionPosition < window.innerHeight && !alreadyAnimated) {
          // Executa a animação
          increment(0, 9, cont1);
          increment(0, 1000, cont2);
          increment(0, 6000, cont3);

          // Marca como já executado para não repetir
          alreadyAnimated = true;
          
          // Se desejar, você pode remover o listener para otimizar
          window.removeEventListener('scroll', checkScroll);
        }
      }

      // Escuta o evento de scroll
      window.addEventListener('scroll', checkScroll);
    </script>

    <section class="section4 container-fluid">
        <div class="container">
            <img src="{{ asset('assinea/imagens/ARTE-CAPAS.png') }}" alt="">
        </div>

        <div class="faixa1 text-center">
            <span>Videoaulas, Dicas e Entrevistas</span>
        </div>

        <div class="tablet container">    
            <div class="owl-carousel owl-carousel-assine"> 
                <div class="item">
                    <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                        <img src="{{ asset('assinea/imagens/LEOPOLDINO-CAPELOZZA.fw.png') }}" class="img-fluid">                         
                    </a>
                </div>
                <div class="item">
                    <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                        <img src="{{ asset('assinea/imagens/DEYSE-CUNHA.fw.png') }}" class="img-fluid">                         
                    </a>
                </div>
                <div class="item">
                    <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                        <img src="{{ asset('assinea/imagens/DANIELA-FEU.fw.png') }}" class="img-fluid">                         
                    </a>
                </div>
                <div class="item">
                    <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                        <img src="{{ asset('assinea/imagens/CARLOS-CAMARA.fw.png') }}" class="img-fluid">                         
                    </a>
                </div>
                <div class="item">
                    <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                        <img src="{{ asset('assinea/imagens/SERGIO-CURY.fw.png') }}" class="img-fluid">                         
                    </a>
                </div>
                <div class="item">
                    <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                        <img src="{{ asset('assinea/imagens/ROMULO-LUSTOSA.fw.png') }}" class="img-fluid">                         
                    </a>
                </div>
                <div class="item">
                    <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                        <img src="{{ asset('assinea/imagens/PRISCILA-HILGENBERG.fw.png') }}" class="img-fluid">                         
                    </a>
                </div>
                <div class="item">
                    <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                        <img src="{{ asset('assinea/imagens/FABIANO-MARSON.fw.png') }}" class="img-fluid">                         
                    </a>
                </div>
                <div class="item">
                    <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                        <img src="{{ asset('assinea/imagens/THALLITA-QUEIROZ.fw.png') }}" class="img-fluid">                         
                    </a>
                </div>
                <div class="item">
                    <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                        <img src="{{ asset('assinea/imagens/HENRIQUE-VILLELA.fw.png') }}" class="img-fluid">                         
                    </a>
                </div>
                <div class="item">
                    <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                        <img src="{{ asset('assinea/imagens/ALBERTO-CONSOLARO.fw.png') }}" class="img-fluid">                         
                    </a>
                </div>
                <div class="item">
                    <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                        <img src="{{ asset('assinea/imagens/MARCOS-JANSON.fw.png') }}" class="img-fluid">                         
                    </a>
                </div>
            </div>
        </div>

        <div class="faixa2 text-center">
            <span>Conheça também nossas coleções</span>
        </div>

        <style>
            .link-textonaoclicavel {
            text-decoration: none;
            color: #383838;
            transition: 0.5s ease;
            }

            .link-textonaoclicavel:hover {
            color: #ccc;
            }

            .owl-carousel .item {
            display: flex;
            justify-content: center;
            align-items: center;
            }

            .owl-carousel .item img {
            display: block;
            width: 100%;
            height: auto;
            border-radius: 10px;
            }

            .ultimas-revistas {
            display: flex;
            justify-content: space-between;
            align-items: center;
            }

            .owl-nav {
            position: absolute;
            top: 50%;
            width: 100%;
            display: none !important;
            justify-content: space-between;
            transform: translateY(-50%);
            }

            .owl-nav button {
            background: none;
            display:none !important;
            border: none;
            font-size: 2rem;
            color: #ccc;
            }

            .owl-nav button:hover {
            color: #333;
            display:none !important;
            }
        </style>
        <div class="owl-carousel owl-carousel-revistas">
            @foreach ($colecoes[0]->collections->magazines as $index => $revista)
                <div class="item">
                    <a href="{{ route('colecao') }}/{{ $revista->id }}" style="text-decoration: none;">
                        <img src="{{ $revista->lastProductCover }}" alt="{{ $ultimoArtigo1->title }}" class="img-fluid" style="border-radius: 10px;">
                    </a>
                </div>
            @endforeach
        </div>

    </section>

    <section class="container-fluid section5">
        <div class="container">
            <div class="row">
                <p class="top text-center">Para quem é o <span>DentalGO?</span></p>
            </div>
            <div class="row posters">
                <div class="col-4 d-flex justify-content-center poster">
                    <img class="img-fluid" src="{{ asset('assinea/imagens/clinico.png') }}" alt="">
                    <div class="poster-text text-center">
                        <span>CLÍNICOS</span>
                        <p>Tenha acesso ao acervo completo da Dental Press e apresente para os seus pacientes casos semelhantes, utilizando imagens e recursos visuais presentes nas mais de 540 revistas, com uma busca simples por palavras-chave e mostre que o tratamento é validado no ponto de vista científico.</p>    
                    </div>
                </div>
                <div class="col-4 d-flex justify-content-center poster">
                    <img class="img-fluid" src="{{ asset('assinea/imagens/estudantes.png') }}" alt="">
                    <div class="poster-text text-center">
                        <span>ESTUDANTES</span>
                        <p>Faça consultas e busque referências de uma forma rápida e dinâmica, valendo-se de toda a inteligência de busca dos artigos por palavra-chave ou por autores. Todas as revistas Dental Press levam em consideração os mais altos padrões editoriais e boas-práticas científicas, como revisão por pares e por duplo cego.</p>
                    </div>
                </div>    
                <div class="col-4 d-flex justify-content-center poster">
                    <img class="img-fluid" src="{{ asset('assinea/imagens/professores.png') }}" alt="">
                    <div class="poster-text text-center">
                        <span>PROFESSORES</span>
                        <p>Crie aulas utilizando os artigos publicados na Dental Press. Todo processo editorial da Dental Press é feito com o foco no conteúdo e na forma, garantindo uma estética única e atrelada a conteúdos relevantes. Utilize o Dental GO como uma ferramenta para expandir suas possibilidades didático-pedagógicas.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <p class="top text-center">Faça parte dos profissionais <span>preocupados com a ciência</span></p>
                
            </div>
            <BR>
                <!-- <a class="btn-assinar" href="{{ route('cadastrar') }}" style="background-color: #77172e; color: #FFFFFF; text-decoration: none; padding: 25px 50px; border-color: #f3f3f3; border-radius: 25px; margin: 0 auto 50px auto; text-align: center; align-items: center; display: table;">ASSINE AGORA</a> -->
                 <a class="btn-assinar" href="https://www.dentalgo.com.br/checkoutnovo" style="background-color: #77172e; color: #FFFFFF; text-decoration: none; padding: 25px 50px; border-color: #f3f3f3; border-radius: 25px; margin: 0 auto 50px auto; text-align: center; align-items: center; display: table;">ASSINE AGORA</a>
                <BR>
        </div>
    </section>

    <section class="section6 container-fluid">
        <div class="side">
            <p><span>São milhares de profissionais</span> de todas as regiões do Brasil que são assinantes do DentalGO<br>Faça parte você também desse seleto grupo que vive a experiência Dental Press</p>
            <!-- <a class="btn-final" style="color: #FFFFFF;" href="{{ route('cadastrar') }}">ASSINE</a> -->
             <a class="btn-final" style="color: #FFFFFF;" href="https://www.dentalgo.com.br/checkoutnovo">ASSINE</a>
        </div>
        <div class="container">
            <img class="background-2" src="{{ asset('assinea/imagens/MAPA-BRASIL.png') }}" alt="">
        </div>
    </section>
</div>

<div class="mobile">
    <section class="container-fluid section1" style="text-align: center; color: #FFFFFF; background-image: url({{ asset('assinea/imagens/banner-mobile.png') }}); background-position: center top; background-size: 100% auto; background-repeat: no-repeat;">
        <img class="img-fluid background-1" src="">
        <div class="container">
            <div class="row">
                <div></div>
                <div class="section1-top">
                    <img class="logo" src="{{ asset('assinea/imagens/DentalGoLogo.png') }}" alt="" style="margin: 40px auto; display: block;">
                    <div class="frase">
                        <p>LEIA . OUÇA . ASSISTA</p>
                    </div>
                    <h3 class="title">A&nbsp;MUDANÇA<br>COMEÇA&nbsp;AGORA</h3>
                    <p class="choice">Novidade!!!<br>Agora Você também ouve os artigos no GoTalks!</p>
                </div>
                <div></div>
                <div class="section1-right">
                    <div class="card-valor text-center" style="width: 90%; margin-top: 25px; color: #000000;">
                        <div class="text-center">
                            <p class="etiqueta">Plano <span>DentalGo</span></p>
                        </div>
                        <div>
                            <p><span class="cost">89,00</span>/mês</p>
                        </div>
                        <p>Esse plano sai<br>por <span style="font-weight: 800; font-size: 100%;">apenas R$ 2,99/ dia</span></p>
                        <div class="line"></div>
                        <p>Acesso a todo<br>acervo de revistas<br>+ de 6.000 artigos</p>
                        <p>Dental GO Academy</p>
                        <p>Clube de descontos<br>Dental Press</p>
                        <p>Livros Cortesia</p>
                        <p>Entrevista em Vídeos</p>
                        <p>Ouça com GoTalks</p>
                        <div class="line"></div>
                            <a class="btn-assinar" href="{{ route('cadastrar') }}">ASSINE AGORA</a>
                        </div>
                </div>
            </div>
        </div>
    </section>



    <section class="section2 container-fluid">
        <div class="container mt-5">
            <div class="row">
                <div class="col-1"></div>
                <div class="col-11 top text-left mb-4">
                    <h2 class="title">Conheça o <span>GoTalks </span>- Uma nova maneira de <span>Ouvir a ciência</span></h2>
                </div>
                <div class="col-1"></div>
            </div>

            <div class="row align-items-center"> <!-- Mantém os elementos alinhados verticalmente -->
                <div class="col-1"></div>
                
                <!-- Spotify Playlist -->
                <div class="col-md-5">
                <iframe style="border-radius:12px" src="https://open.spotify.com/embed/playlist/1R0SQA5Z68OGGIpcYXiV0s?utm_source=generator"
                     width="100%" height="400" frameBorder="0" allowfullscreen="" 
                     allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" 
                     loading="lazy"></iframe>
                </div>

                <!-- Player de Vídeo -->
                <video id="videoPlayer" width="100%" controls poster="{{ asset('assinea/imagens/thumb.jpg') }}">
                    <source src="{{ asset('assinea/videos/video.mp4') }}" type="video/mp4">
                    Seu navegador não suporta vídeos.
                </video>

                <div class="col-1"></div>
            </div>

            <style>
                .video-wrapper {
                    max-width: 700px;
                    margin: 0 auto;
                    border-radius: 10px;
                    overflow: hidden;
                }
            </style>
        </div>
    </section>


    <section class="section2 container-fluid">
        <div class="container text-center" style="margin-bottom: 0;">
            <div class="row">
                <div></div>
                <div class="top">
                    <h3 class="title" style="margin-bottom: 50px;">Por que assinar o <span>DentalGO?</span></h3>
                </div>
            </div>
            <div class="row text-center">
                <div>
                    <div class="icon">
                        <img src="{{ asset('assinea/imagens/icone-atualizar.png') }}" alt="">
                        <p><span>Atualização constante</span><br>Todos os meses você encontra novos conteúdos no formato de aulas, dicas e entrevistas, além de lançamentos de revistas de diferentes áreas da Odontologia.</p>

                    </div>
                    <div class="icon">
                        <img src="{{ asset('assinea/imagens/icones---cursor.png') }}" alt="">
                        <p><span>Multiplataforma</span><br>Com o aplicativo do Dental GO, você  pode acessar os conteúdos da DentalPress de onde quiser: via computador, smartphone ou tablet, em uma interface amigável e responsiva</p>
                    </div>
                </div>
                <div>
                    <div class="icon">
                        <img src="{{ asset('assinea/imagens/icones-pesquisa.png') }}" alt="">
                        <p><span>Acesso rápido e fácil</span><br>Com as ferramentas de pesquisa do  DentalGO, você encontra rapidamente o assunto que está procurando - seja em revistas, seja em vídeos - em um acervo de mais de 30 anos da editora</p>
                    </div>
                    <div class="icon">
                        <img src="{{ asset('assinea/imagens/icone-camarote.png') }}" alt="">
                        <p><span>Eventos exclusivos</span><br>Com as ferramentas de pesquisa do  DentalGO, você encontra rapidamente o assunto que está procurando - seja em revistas, seja em vídeos - em um acervo de mais de 30 anos da editora</p>
                    </div>
                </div>
                <div>
                    <div class="icon">
                        <img src="{{ asset('assinea/imagens/icones-dinheiro.png') }}" alt="">
                        <p><span>Condições especiais</span><br>Além de garantir desconto em produtos  da DentalPress, como cursos, congressos e livros, você receberá condições especiais de empresas parceiras na compra de insumos e materiais odontológicos</p>
                    </div>
                    <div class="icon">
                        <img src="{{ asset('assinea/imagens/icones---homem.png') }}" alt="">
                        <p><span>O que há de Melhor</span><br>Tudo o que você consome nas revistas publicadas passou pelos mais rigorosos padrões de avaliação científica, como revisão por pares e duplo-cego</p>
                    </div>
                </div>
            </div>
        </div>
        <a class="btn-assinar text-center" href="{{ route('cadastrar') }}" style="margin-block: 0 70px;">ASSINE AGORA</a>
    </section>

    <section class="container-fluid section3">
      <div class="container">
        <div class="row">
          <div class="text-center counter" style="background-color: #77172e;">
            <span id="punheta1">9</span>
            <p>periódicos</p>
          </div>
          <div class="text-center counter" style="background-color: #c9274d;">
            <span id="punheta2">+6000</span>
            <p>artigos</p>
          </div>
          <div class="text-center counter" style="background-color: #852a3f;">
            <span id="punheta3">+1000</span>
            <p>autores</p>
          </div>
        </div>
      </div>
    </section>

    <script>
      // Seleciona os elementos que serão incrementados
      const punheta1 = document.getElementById('punheta1');
      const punheta2 = document.getElementById('punheta2');
      const punheta3 = document.getElementById('punheta3');
      
      // Seleciona a seção
      const section3 = document.querySelector('.section3');

      // Função de incremento
      function increment(i, max, element) {
        if (i > max) return;
        setTimeout(function() {
          element.innerText = Math.round(i);
          increment(i + (max / 100), max, element);
        }, 10);
      }

      // Variável para garantir que só executamos uma vez
      let alreadyAnimated = false;

      function checkScroll() {
        // Pega a distância entre o topo do viewport e o topo da seção
        const sectionPosition = section3.getBoundingClientRect().top;

        // Define até onde a seção precisa “entrar” no viewport para considerarmos “visível”.
        // Aqui usei window.innerHeight, mas você pode ajustar como preferir
        if (sectionPosition < window.innerHeight && !alreadyAnimated) {
          // Executa a animação
          increment(0, 9, punheta1);
          increment(0, 6000, punheta2);
          increment(0, 1000, punheta3);

          // Marca como já executado para não repetir
          alreadyAnimated = true;
          
          // Se desejar, você pode remover o listener para otimizar
          window.removeEventListener('scroll', checkScroll);
        }
      }

      // Escuta o evento de scroll
      window.addEventListener('scroll', checkScroll);
    </script>

    <section class="section4 container-fluid">
        <div class="container">
            <!-- <img src="{{ asset('assinea/imagens/revista-mobile.png') }}" alt=""> -->
            <h3 class="title" style="color: #080808; font-weight: bold; text-align: center;">Revistas disponíveis no DentalGO</h3>
            <div class="row celular" style="padding: 10px">
                @foreach ($colecoes[0]->collections->magazines as $index => $revista)
                    @if ($revista->id == 79)
                        @continue
                    @endif
                    <div class="col imagem-col"> <!--imagem-col{{ $index === 0 ? ' primeira-imagem' : '' }}-->
                        <div class="artigoFavSombraRevistas">
                            <div class="imagemultimaRevistaCol">
                                <a href="{{ route('colecao') }}/{{ $revista->id }}" style="text-decoration: none;">
                                    <img src="{{ $revista->lastProductCover }}" alt="{{ $ultimoArtigo1->title }}" class="img-fluid">                         

                                    @if($index === 0 ? ' primeira-imagem' : '')
   
                                        <div class="d-flex" style="position: absolute; max-width: 50%; ">
                                            <img src="{{ asset('imagens/Facelift/logo_abor.png') }}"  class="img-fluid logo-abor-revista-mobile mostrar-imagem imagem-portugues imagem-ingles"  style=" @if($linguagem == 'es') display:none; @endif max-height: 25px; margin: -45px 0 0 25px;">
                                            <img src="{{ asset('imagens/Facelift/logo-aladosemfundo.png') }}"  class="img-fluid logo-alado-revista-mobile mostrar-imagem imagem-portugues imagem-ingles imagem-espanhol" style="max-height: 75px; margin: -70px 0 0 20px;">                     
                                        </div>
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="tablet">
                <style>
                    .link-textonaoclicavel {
                    text-decoration: none;
                    color: #383838;
                    transition: 0.5s ease;
                    }
    
                    .link-textonaoclicavel:hover {
                    color: #ccc;
                    }
    
                    .owl-carousel .item {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    }
    
                    .owl-carousel .item img {
                    display: block;
                    width: 100%;
                    height: auto;
                    border-radius: 10px;
                    }
    
                    .ultimas-revistas {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    }
    
                    .owl-nav {
                    position: absolute;
                    top: 50%;
                    width: 100%;
                    display: none !important;
                    justify-content: space-between;
                    transform: translateY(-50%);
                    }
    
                    .owl-nav button {
                    background: none;
                    display:none !important;
                    border: none;
                    font-size: 2rem;
                    color: #ccc;
                    }
    
                    .owl-nav button:hover {
                    color: #333;
                    display:none !important;
                    }
                </style>
                <div class="owl-carousel owl-carousel-revistas">
                    @foreach ($colecoes[0]->collections->magazines as $index => $revista)
                        <div class="item">
                            <a href="{{ route('colecao') }}/{{ $revista->id }}" style="text-decoration: none;">
                                <img src="{{ $revista->lastProductCover }}" alt="{{ $ultimoArtigo1->title }}" class="img-fluid" style="border-radius: 10px;">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <a class="btn-assinar text-center" href="{{ route('cadastrar') }}">ASSINE AGORA</a>

            <div class="container">
                <div class="row">
                    <div class="text-center counter" style="background-color: #77172e;">
                        <span id="punheta1">+300</span>
                        <p>vídeos</p>
                    </div>
                    <div class="text-center counter" style="background-color: #c9274d;">
                        <h3>Com os melhores da área</h3>
                    </div>
                </div>
            </div>

            <div class="row videos celular" style="padding: 10px">
                <div class="col imagem-col"> <!--imagem-col{{ $index === 0 ? ' primeira-imagem' : '' }}-->
                    <div class="artigoFavSombraRevistas">
                        <div class="imagemultimaRevistaCol">
                            <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                                <img src="{{ asset('assinea/imagens/LEOPOLDINO-CAPELOZZA.fw.png') }}" class="img-fluid">                         
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col imagem-col"> <!--imagem-col{{ $index === 0 ? ' primeira-imagem' : '' }}-->
                    <div class="artigoFavSombraRevistas">
                        <div class="imagemultimaRevistaCol">
                            <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                                <img src="{{ asset('assinea/imagens/DEYSE-CUNHA.fw.png') }}" class="img-fluid">                         
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col imagem-col"> <!--imagem-col{{ $index === 0 ? ' primeira-imagem' : '' }}-->
                    <div class="artigoFavSombraRevistas">
                        <div class="imagemultimaRevistaCol">
                            <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                                <img src="{{ asset('assinea/imagens/DANIELA-FEU.fw.png') }}" class="img-fluid">                         
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col imagem-col"> <!--imagem-col{{ $index === 0 ? ' primeira-imagem' : '' }}-->
                    <div class="artigoFavSombraRevistas">
                        <div class="imagemultimaRevistaCol">
                            <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                                <img src="{{ asset('assinea/imagens/CARLOS-CAMARA.fw.png') }}" class="img-fluid">                         
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col imagem-col"> <!--imagem-col{{ $index === 0 ? ' primeira-imagem' : '' }}-->
                    <div class="artigoFavSombraRevistas">
                        <div class="imagemultimaRevistaCol">
                            <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                                <img src="{{ asset('assinea/imagens/SERGIO-CURY.fw.png') }}" class="img-fluid">                         
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col imagem-col"> <!--imagem-col{{ $index === 0 ? ' primeira-imagem' : '' }}-->
                    <div class="artigoFavSombraRevistas">
                        <div class="imagemultimaRevistaCol">
                            <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                                <img src="{{ asset('assinea/imagens/ROMULO-LUSTOSA.fw.png') }}" class="img-fluid">                         
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col imagem-col"> <!--imagem-col{{ $index === 0 ? ' primeira-imagem' : '' }}-->
                    <div class="artigoFavSombraRevistas">
                        <div class="imagemultimaRevistaCol">
                            <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                                <img src="{{ asset('assinea/imagens/PRISCILA-HILGENBERG.fw.png') }}" class="img-fluid">                         
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col imagem-col"> <!--imagem-col{{ $index === 0 ? ' primeira-imagem' : '' }}-->
                    <div class="artigoFavSombraRevistas">
                        <div class="imagemultimaRevistaCol">
                            <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                                <img src="{{ asset('assinea/imagens/FABIANO-MARSON.fw.png') }}" class="img-fluid">                         
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col imagem-col"> <!--imagem-col{{ $index === 0 ? ' primeira-imagem' : '' }}-->
                    <div class="artigoFavSombraRevistas">
                        <div class="imagemultimaRevistaCol">
                            <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                                <img src="{{ asset('assinea/imagens/THALLITA-QUEIROZ.fw.png') }}" class="img-fluid">                         
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col imagem-col"> <!--imagem-col{{ $index === 0 ? ' primeira-imagem' : '' }}-->
                    <div class="artigoFavSombraRevistas">
                        <div class="imagemultimaRevistaCol">
                            <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                                <img src="{{ asset('assinea/imagens/HENRIQUE-VILLELA.fw.png') }}" class="img-fluid">                         
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col imagem-col"> <!--imagem-col{{ $index === 0 ? ' primeira-imagem' : '' }}-->
                    <div class="artigoFavSombraRevistas">
                        <div class="imagemultimaRevistaCol">
                            <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                                <img src="{{ asset('assinea/imagens/ALBERTO-CONSOLARO.fw.png') }}" class="img-fluid">                         
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col imagem-col"> <!--imagem-col{{ $index === 0 ? ' primeira-imagem' : '' }}-->
                    <div class="artigoFavSombraRevistas">
                        <div class="imagemultimaRevistaCol">
                            <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                                <img src="{{ asset('assinea/imagens/MARCOS-JANSON.fw.png') }}" class="img-fluid">                         
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tablet container">    
            <div class="owl-carousel owl-carousel-assine"> 
                <div class="item">
                    <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                        <img src="{{ asset('assinea/imagens/LEOPOLDINO-CAPELOZZA.fw.png') }}" class="img-fluid">                         
                    </a>
                </div>
                <div class="item">
                    <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                        <img src="{{ asset('assinea/imagens/DEYSE-CUNHA.fw.png') }}" class="img-fluid">                         
                    </a>
                </div>
                <div class="item">
                    <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                        <img src="{{ asset('assinea/imagens/DANIELA-FEU.fw.png') }}" class="img-fluid">                         
                    </a>
                </div>
                <div class="item">
                    <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                        <img src="{{ asset('assinea/imagens/CARLOS-CAMARA.fw.png') }}" class="img-fluid">                         
                    </a>
                </div>
                <div class="item">
                    <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                        <img src="{{ asset('assinea/imagens/SERGIO-CURY.fw.png') }}" class="img-fluid">                         
                    </a>
                </div>
                <div class="item">
                    <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                        <img src="{{ asset('assinea/imagens/ROMULO-LUSTOSA.fw.png') }}" class="img-fluid">                         
                    </a>
                </div>
                <div class="item">
                    <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                        <img src="{{ asset('assinea/imagens/PRISCILA-HILGENBERG.fw.png') }}" class="img-fluid">                         
                    </a>
                </div>
                <div class="item">
                    <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                        <img src="{{ asset('assinea/imagens/FABIANO-MARSON.fw.png') }}" class="img-fluid">                         
                    </a>
                </div>
                <div class="item">
                    <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                        <img src="{{ asset('assinea/imagens/THALLITA-QUEIROZ.fw.png') }}" class="img-fluid">                         
                    </a>
                </div>
                <div class="item">
                    <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                        <img src="{{ asset('assinea/imagens/HENRIQUE-VILLELA.fw.png') }}" class="img-fluid">                         
                    </a>
                </div>
                <div class="item">
                    <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                        <img src="{{ asset('assinea/imagens/ALBERTO-CONSOLARO.fw.png') }}" class="img-fluid">                         
                    </a>
                </div>
                <div class="item">
                    <a href="https://dentalgo.com.br/video/681" style="text-decoration: none;">
                        <img src="{{ asset('assinea/imagens/MARCOS-JANSON.fw.png') }}" class="img-fluid">                         
                    </a>
                </div>
            </div>
        </div>

            <a class="btn-assinar text-center" href="{{ route('cadastrar') }}">ASSINE AGORA</a>
        </div>
    </section>

    <section class="container-fluid section5">
        <div class="container">
            <div class="row">
                <p class="top text-center" style="margin: 20px auto 50px;">Para quem é o <span>DentalGO?</span></p>
            </div>
            <div class="row posters">
                <div class="d-flex justify-content-center poster" style="min-height: 600px; margin-bottom: 50px;">
                    <img class="img-fluid" src="{{ asset('assinea/imagens/clinico.png') }}" alt="">
                    <div class="poster-text text-center">
                        <span>CLÍNICOS</span>
                        <p>Tenha acesso ao acervo completo da Dental Press e apresente para os seus pacientes casos semelhantes, utilizando imagens e recursos visuais presentes nas mais de 540 revistas, com uma busca simples por palavras-chave e mostre que o tratamento é validado no ponto de vista científico.</p>
                    </div>
                </div>
                <div class="d-flex justify-content-center poster" style="min-height: 600px; margin-bottom: 50px;">
                    <img class="img-fluid" src="{{ asset('assinea/imagens/estudantes.png') }}" alt="">
                    <div class="poster-text text-center">
                        <span>ESTUDANTES</span>
                        <p>Faça consultas e busque referências de uma forma rápida e dinâmica, valendo-se de toda a inteligência de busca dos artigos por palavra-chave ou por autores. Todas as revistas Dental Press levam em consideração os mais altos padrões editoriais e boas-práticas científicas, como revisão por pares e por duplo cego.</p>
                    </div>
                </div>    
                <div class="d-flex justify-content-center poster" style="min-height: 600px;">
                    <img class="img-fluid" src="{{ asset('assinea/imagens/professores.png') }}" alt="">
                    <div class="poster-text text-center">
                        <span>PROFESSORES</span>
                        <p>Crie aulas utilizando os artigos publicados na Dental Press. Todo processo editorial da Dental Press é feito com o foco no conteúdo e na forma, garantindo uma estética única e atrelada a conteúdos relevantes. Utilize o Dental GO como uma ferramenta para expandir suas possibilidades didático-pedagógicas.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <p class="top text-center" style="margin: 30px auto;">Faça parte dos profissionais<span><br>preocupados com a ciência</span></p>
            </div>
        </div>
        <a class="btn-assinar" href="{{ route('cadastrar') }}" style="background-color: #77172e; color: #FFFFFF; text-decoration: none; padding: 25px 50px; border-color: #f3f3f3; border-radius: 25px; margin: 0 auto 50px auto; text-align: center; align-items: center; display: table;">ASSINE AGORA</a>
    </section>


    <section class="section6 container-fluid" style="background-color: #080808;">
        <div class="container">
            <img class="background-2" src="{{ asset('assinea/imagens/banner-brazil-mobile.png') }}" alt="">
        </div>
        <br>
        <div class="background-color">
            <div class="side" style="width: 90%; top: 70%; text-align: center; padding-bottom: 100px;">
                <p><span>São milhares de profissionais</span> de todas as regiões do Brasil que são assinantes do DentalGO<br>Faça parte você também desse seleto grupo que vive a experiência Dental Press</p>
                <a class="btn-final" href="{{ route('cadastrar') }}" style="color: #FFFFFF; font-size: 25px;">ASSINE JÁ</a>
            </div>

        </div>
    </section>
</div>

</body>
</html>