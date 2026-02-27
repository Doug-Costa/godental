\<?php
$paginaTitulo = 'Canal Ultradent - DentalGo';
$tipoTopo = 'topoPreto';
$assinar = 0;
function limita_caracteres($texto, $limite, $quebra = true){
   $tamanho = strlen($texto);
   if($tamanho <= $limite){ //Verifica se o tamanho do texto é menor ou igual ao limite
      $novo_texto = $texto;
   }else{ // Se o tamanho do texto for maior que o limite
      if($quebra == true){ // Verifica a opção de quebrar o texto
         $novo_texto = trim(substr($texto, 0, $limite))."...";
      }else{ // Se não, corta $texto na última palavra antes do limite
         $ultimo_espaco = strrpos(substr($texto, 0, $limite), " "); // Localiza o útlimo espaço antes de $limite
         $novo_texto = trim(substr($texto, 0, $ultimo_espaco))."..."; // Corta o $texto até a posição localizada
      }
   }
   return $novo_texto; // Retorna o valor formatado
}

/*$materias = $canal[4];
$videos = $canal[5];*/
?>
@extends('layouts.master')

@section('content')
   <style>

    body {
        background-color: #000 !important;
    }

    .overview-section-divider {
        display: block;
        margin: 0 auto;
        padding: 0;
        height: 28px;
        width: 100%;
        background-image: radial-gradient(farthest-side at center center, rgba(255, 255, 255, 1) 0%, rgba(0, 0, 0, 0) 100%);
        background-color: #000;
        border: none;
    }


    .penis {
        background-color: transparent;
        transition: 0.5s ease;
        border: 5px solid #fff !important;
        display: inline-block;
        padding: 10px 15px;
        margin-top: 100px;
        margin-bottom: 100px;
        font-size: 25px;
        text-align: center;
        border-radius: 10px;
        text-decoration: none;
        color: #fff;
        border: none;
        cursor: pointer;
        font-weight: bold;
    }

    .penis:hover {
        color: #000;
        border: 5px solid #ccc !important;
        background-color: #fff;
    }

    .penis:active {
        background-color: #fdc000;
        color: #fdc001 !important;
        border: 5px solid #fdc000 !important;
    }

    .background-pad {
        background: url('/imagens/canais/ultradent/gemini-evo-fig6-photobiomodulation.jpg') no-repeat;
    }

    .shadowteste{
        text-shadow: 4px 4px 2px rgba(0,0,0,0.6);

    }
    
    @media (max-width: 760px) {
        .desktop-only {
            display: none;
        }
    }

    @media (min-width: 760px) {
        .mobile-only {
            display: none;
        }
    }

      
   </style>
     <div class="container-fluid desktop-only" style="margin-left: auto !important;  margin-right: auto !important; background: url('/imagens/canais/ultradent/2banner--ultradent.png') no-repeat; height:600px;">
        <div class="row">
            <div class="container">
                <div class="row" style="position: relative; width: 40%; margin-left: auto; top: 100px; margin-right:100px;">
                    <script data-b24-form="inline/164/qq7b5m" data-skip-moving="true"> (function(w,d,u){ var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/180000|0); var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h); })(window,document,'https://cdn.bitrix24.com.br/b30819577/crm/form/loader_164.js'); </script>
                </div>
                    <div class="col-6 col-sm-6" style="position:absolute; left:10%; top: 130px;">
                        <img class="img-fluid" style="margin-bottom: 32px !important; width: 70%; filter:brightness(1000%)"  src="{{ asset('imagens/canais/ultradent/gemini-evo-logo.png') }}" alt="LOGIGEMINI">
                            <div style="color: white; margin-left:50px; margin-right:100px; font-weight:bold" class="shadowteste"><h2 class="shadowteste" style="color: #fff;  font-weight: bold; text-align: left; width: 40%;">Gemini Ultradent</h2>
                            <p>Participe do evento de lançamento do Laser Gemini Ultradent, na Dental Press!</p><p> Evento gratuito e exclusivo! As vagas são limitadas:</p>
                            <ul>
                                <li>27/03 - Convidados</li>
                                <li>28/03 - Aberto ao público</li>
                            </ul>
                            <p>Inscrições abertas para o dia 28 de março com aula expositiva e demonstração do Gemini Ultradent!</p><p>Inscreva-se já e viva a experiência Dental Press:</p>
                            </div>
                    </div>
            </div>
        </div>
   </div>
    <!-- banner forms mobile -->
    <div class="container-fluid mobile-only" style="margin-left: auto !important;  margin-right: auto !important; background: url('/imagens/canais/ultradent/2banner--ultradent.png') no-repeat; height:600px;">
        <div class="row">
            <div class="container">
                <div class="row" style="position: relative; width: 100%; margin:auto; top:100px">
                    <script data-b24-form="inline/164/qq7b5m" data-skip-moving="true"> (function(w,d,u){ var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/180000|0); var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h); })(window,document,'https://cdn.bitrix24.com.br/b30819577/crm/form/loader_164.js'); </script>
                </div>
                    
            </div>
        </div>
   </div>
   <div class="container mobile-only" style="padding: 64px !important;">
        <div class="row">
            <h3 style="color:#fff;  margin-bottom:20px; font-weight: bold;">Gemini Ultradent</h3>
            <p style="color:#fff; margin-bottom:20px; font-weight: bold; font-size: 18px;" >Participe do evento de lançamento do Laser Gemini Ultradent, na Dental Press!</p>
            <p style="color:#fff; font-weight:bold;"> Evento gratuito e exclusivo! As vagas são limitadas:</p>
            <ul style="color:#fff; font-weight:bold;">
                <li>27/03 - Convidados</li>
                <li>28/03 - Aberto ao público</li>
            </ul>
            <p style="color:#fff;  margin-bottom:20px; font-weight: bold; font-size: 18px;">Inscrições abertas para o dia 28 de março com aula expositiva e demonstração do Gemini Ultradent!</p>
            <p style="color:#fff; font-weight:bold;">Inscreva-se já e viva a experiência Dental Press:</p>
        </div>
    </div>

   <!--<div class="container desktop-only" style="margin-left: auto !important;  margin-right: auto !important;">
        <div class="row">
            <div class="col-6 col-sm-6" style="margin: 200px auto;">
                <img class="img-fluid" style="margin-bottom: 32px !important;"  src="{{ asset('imagens/canais/ultradent/gemini-evo-logo.png') }}" alt="LOGIGEMINI">
                <h2 style="color: #fff;  font-weight: bold; text-align: left; width: 40%;">
                    Uma evolução na odontologia! Precisão e segurança
                </h2>
            </div>
            <div class="col-6 col-sm-6" >
                <img class="img-fluid" src="{{ asset('imagens/canais/ultradent/gemini-evo-laser-console.png') }}" alt="">
            </div>
        </div>
   </div>
        -->

   
        <div class="container desktop-only">
        <div class="row">
            <div>
                <div class="row" style="margin-top: 40px;">
                    <iframe width="560" height="860" src="{{ asset('imagens/canais/ultradent/VIDEO_GEMINI.mp4') }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
   <div class="container mobile-only" style="margin-left: auto !important;  margin-right: auto !important;">
        <div class="row" style="margin-top: 40px;">
            <iframe width="560" height="860" src="{{ asset('imagens/canais/ultradent/VIDEO_GEMINI.mp4') }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
        <div class="row">
                <img class="img-fluid" style="margin-bottom: 40px !important; margin-top: 100px;"  src="{{ asset('imagens/canais/ultradent/gemini-evo-logo.png') }}" alt="LOGIGEMINI">

                <img class="img-fluid" style="margin-bottom: 40px;" src="{{ asset('imagens/canais/ultradent/gemini-evo-laser-console.png') }}" alt="">
                
        </div>

   </div>
    <div class="container-fluid" style=" margin-top: 40px; ">
        <div class="row">
            <hr style="height:0; border-bottom: 2px solid #ffd132;">
        </div>
    </div>
    <div class="container desktop-only" style="padding: 64px !important;">
        <div class="row">
            <div class="col-6 col-sm-6">
                <img class="img-fluid" src="{{ asset('imagens/canais/ultradent/gemini-evo-fig1-100watts.png') }}" alt="">
                <img class="img-fluid" src="{{ asset('imagens/canais/ultradent/gemini-evo-fig2-dualwave.png') }}" alt="">
            </div>
            <div class="col-6 col-sm-6" >
                <h3 style="color:#fff;  margin-bottom:16px; font-weight: bold;">Uma evolução na odontologia! Precisão e segurança</h3>
                <p style="color:#fff; margin-bottom:16px; font-weight: bold; font-size: 18px;" >O impressionante laser de diodo Gemini EVO de comprimento de onda duplo oferece 100 watts de pico de potência super pulsada para que você possa fazer incisões rápidas e ultralimpas. Sua potência superpulsada permite um período de relaxamento térmico mais longo, o que permite que os tecidos moles esfriem melhor, reduzindo indesejados danos térmicos enquanto melhora a velocidade e a precisão do corte.</p>
                <p style="color:#fff;  margin-bottom:16px; font-weight: bold; font-size: 18px;">Os dois comprimentos de onda (810 nm e 980 nm) do laser Gemini EVO estão disponíveis em três modos para fornecer a versatilidade que você precisa. Selecione 810 nm para coagulação ideal, 980 nm para ablação ideal ou modo de comprimento de onda dual para a combinação ideal.</p>
            </div>
        </div>
    </div>
    <div class="container mobile-only" style="padding: 64px !important;">
        <div class="row">
            <h3 style="color:#fff;  margin-bottom:20px; font-weight: bold;">Uma evolução na odontologia! Precisão e segurança</h3>
            <img class="img-fluid" src="{{ asset('imagens/canais/ultradent/gemini-evo-fig1-100watts.png') }}" alt="">
            <p style="color:#fff; margin-bottom:20px; font-weight: bold; font-size: 18px;" >O impressionante laser de diodo Gemini EVO de comprimento de onda duplo oferece 100 watts de pico de potência super pulsada para que você possa fazer incisões rápidas e ultralimpas. Sua potência superpulsada permite um período de relaxamento térmico mais longo, o que permite que os tecidos moles esfriem melhor, reduzindo indesejados danos térmicos enquanto melhora a velocidade e a precisão do corte.</p>
            <img class="img-fluid" src="{{ asset('imagens/canais/ultradent/gemini-evo-fig2-dualwave.png') }}" alt="">
            <p style="color:#fff;  margin-bottom:20px; font-weight: bold; font-size: 18px;">Os dois comprimentos de onda (810 nm e 980 nm) do laser Gemini EVO estão disponíveis em três modos para fornecer a versatilidade que você precisa. Selecione 810 nm para coagulação ideal, 980 nm para ablação ideal ou modo de comprimento de onda dual para a combinação ideal.</p>
        </div>
    </div>
    <div class="container desktop-only" style="margin-top: 90px; margin-bottom: 90px;">
        <div class="row">
            <hr class="overview-section-divider" style="">
        </div>
    </div>
    <div class="container mobile-only" style="margin-top: 20px; margin-bottom: 90px;">
        <div class="row">
            <hr class="overview-section-divider" style="">
        </div>
    </div>
    <!--<div class="container">
        <div class="row">
            <iframe width="560" height="860" src="https://www.youtube.com/embed/ue8CyfUYwYY?si=a6u2K8V2lz2AIr6K" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
    </div>
            -->
    <div class="container desktop-only" style="margin-top: 80px;">
        <div class="row">
            <div class="col-6 col-sm-6">
                <h3 style="margin-bottom:16px !important; color:#fff; font-weight: bold; ">Tecnologia fácil de usar!</h3>
                <p style="color:#fff; font-weight: bold; font-size: 18px;">A odontologia a laser nunca foi tão fácil como com o laser Gemini EVO. Está pronto para uso imediato com 16 configurações de procedimento pré-programadas. A interface de toque guiada com confirmação de voz ajuda você a fazer a seleção adequada com facilidade.</p>
                <p style="color:#fff; font-weight: bold; font-size: 18px; margin-bottom: 60px;">A iluminação da ponta agora é ainda mais brilhante para melhorar a visibilidade no local da cirurgia, e sua intensidade variável permite ajustar a iluminação conforme necessário. A tecnologia háptica integrada pode ser habilitada no pedal para fornecer ao operador um indicador tátil de que o laser está disparando. O toque háptico também está disponível na peça de mão durante procedimentos predefinidos de fotobiomodulação para adicionar sensação física ao paciente durante o tratamento.</p>
                <p style="color:#fff; font-weight: bold; font-size: 18px;">O laser de diodo Gemini EVO é habilitado para Wi-Fi, para que você possa atualizar seu software ou obter suporte para solução de problemas sem complicações. Além disso, com o Gemini EVO Dashboard, você pode visualizar o número de procedimentos realizados, rastrear o ROI, garantir que seu software esteja atualizado, baixar relatórios de procedimentos, monitorar estatísticas completas de uso e muito mais!</p>
            </div>
            <div class="col-6 col-sm-6">
                <div class="row">
                    <img style="width: 30%; height: 20%; margin-right: auto; margin-left: auto;" class="img-fluid" src="{{ asset('imagens/canais/ultradent/gemini-evo-fig3-pedal_1.png') }}" alt="">
                </div>
                <div class="row" style="margin-top: 40px;">
                    <img style="width: 30%; height: 20%;  margin-right: auto; margin-left: auto;" class="img-fluid" src="{{ asset('imagens/canais/ultradent/gemini-evo-fig4-laserhead_1.png') }}" alt="">
                </div>
                <div class="row" style="margin-top: 80px;">
                    <img style="width: 20%; height: 250px; margin-right: auto; margin-left: auto;" class="img-fluid" src="{{ asset('imagens/canais/ultradent/gemini-evo-fig5-mobiledevice.jpg') }}" alt="">
                </div>
            </div>
        </div>
    </div>
    <div class="container mobile-only" style="margin-top: 80px;">
        <div class="row">
                <h2 style="margin-bottom:30px !important; color:#fff; font-weight: bold; ">Tecnologia fácil de usar!</h2>
                <p style="color:#fff; font-weight: bold; font-size: 18px; text-align:justify;">A odontologia a laser nunca foi tão fácil como com o laser Gemini EVO. Está pronto para uso imediato com 16 configurações de procedimento pré-programadas. A interface de toque guiada com confirmação de voz ajuda você a fazer a seleção adequada com facilidade.</p>
                <img style="width: 50%; height: 40%; margin-bottom: 30px; margin-right: auto; margin-left: auto;" class="img-fluid" src="{{ asset('imagens/canais/ultradent/gemini-evo-fig3-pedal_1.png') }}" alt="">
                <p style="color:#fff; font-weight: bold; font-size: 18px; margin-bottom: 60px; text-align:justify;">A iluminação da ponta agora é ainda mais brilhante para melhorar a visibilidade no local da cirurgia, e sua intensidade variável permite ajustar a iluminação conforme necessário. A tecnologia háptica integrada pode ser habilitada no pedal para fornecer ao operador um indicador tátil de que o laser está disparando. O toque háptico também está disponível na peça de mão durante procedimentos predefinidos de fotobiomodulação para adicionar sensação física ao paciente durante o tratamento.</p>
                <img style="width: 50%; height: 40%;  margin-right: auto; margin-left: auto; margin-bottom: 30px;" class="img-fluid" src="{{ asset('imagens/canais/ultradent/gemini-evo-fig4-laserhead_1.png') }}" alt="">
                <p style="color:#fff; font-weight: bold; font-size: 18px; text-align:justify;">O laser de diodo Gemini EVO é habilitado para Wi-Fi, para que você possa atualizar seu software ou obter suporte para solução de problemas sem complicações. Além disso, com o Gemini EVO Dashboard, você pode visualizar o número de procedimentos realizados, rastrear o ROI, garantir que seu software esteja atualizado, baixar relatórios de procedimentos, monitorar estatísticas completas de uso e muito mais!</p>
                <img style="width: 40%; height: 280px; margin-right: auto; margin-left: auto; margin-top: 30px;" class="img-fluid" src="{{ asset('imagens/canais/ultradent/gemini-evo-fig5-mobiledevice.jpg') }}" alt="">
            </div>
        </div>
    </div>

    <div class="container" style="margin-top: 90px; margin-bottom: 90px;">
        <div class="row">
            <hr class="overview-section-divider" style="">
        </div>
    </div>

    <div class="container background-pad">
        <div class="row">
            <div class="col-md-6 col-sm-6" >

            </div>
            <div class="col-md-6 col-sm-6">
                <h3 style="color:#fff; font-weight: bold;"> Terapia de fotobiomodulação simplificada</h3>
                <p style="color:#fff; font-weight: bold;">Agora você pode realizar tratamentos de terapia de fotobiomodulação (PBMT) com a categoria adicional de procedimentos PBM do laser Gemini EVO. O laser torna os PBMTs simples e fáceis, predefinindo a densidade de energia adequada para cada adaptador PBM. Existe até uma calculadora de tratamento PBM fácil de usar no painel móvel para ajudá-lo a determinar o tempo de tratamento adequado. Tudo o que você precisa fazer é selecionar a ponta apropriada para a área de tratamento, selecionar o tempo de tratamento e o laser Gemini EVO fará o resto.</p>
                <p style="color:#fff; font-weight: bold;">Cada laser Gemini EVO inclui três adaptadores PBM, para que você possa se diferenciar e aproveitar ao máximo seu laser expandindo imediatamente para procedimentos PBM.</p>
                <ul>
                    <li style="color:#fff; font-weight: bold;">Ponteira de 3 mm - PBM (fotobiomodulação) Altamente direcionado para pequenas áreas de tratamento - (Intraoral)</li>
                    <li style="color:#fff; font-weight: bold;">Ponteira PBM de 7 mm –   (fotobiomodulação) Ideal para tratamento de áreas localizadas, como úlceras aftosas e herpéticas  - (Intraoral)</li>
                    <li style="color:#fff; font-weight: bold;">Ponteira PBM de 25 mm –   (fotobiomodulação) Projetado para tratamento extraoral eficiente de regiões com uma área maior, como a área ao redor da ATM  - (Intraoral)</li>
                </ul>
            </div>
        </div>
    </div>



   



   

@endsection