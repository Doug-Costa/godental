<?php
$paginaTitulo = 'Canal CVDentus - DentalGo';
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
/* Definir a altura exata da barra de navegação para ajustar o padding */
.bannerCvDentus {
    background: url({{ asset('imagens/canais/cvdentus/CVDENTUSGROSSODESKTOP.jpeg') }}) no-repeat center center;
    background-size: cover;
    width: 100%;
    height: auto;
    min-height: 416px;
    display: flex;
    align-items: flex-end;
    padding-top: 100px; /* Espaçamento maior para garantir que o conteúdo do banner fique abaixo da barra de navegação */
    padding-bottom: 0;
}

/* Ajuste para telas com resolução de 1366px */
@media (max-width: 1366px) {
    .bannerCvDentus {
        background-size: cover;
        min-height: 416px;
        height: auto;
        padding-top: 80px; /* Ajuste menor para resoluções médias */
    }
}

/* Ajuste para telas grandes (acima de 1600px) */
@media (min-width: 1600px) {
    .bannerCvDentus {
        height: 416px;
        background-size: cover;
        padding-top: 100px; /* Espaçamento grande para telas grandes */
    }
}







      @media (max-width: 1024px) {
      .bannerCvDentus {
         background: url({{ asset('imagens/canais/cvdentus/CVDENTUSMOBILELARGO.jpeg') }}) no-repeat; 
         -webkit-background-size: contain;
         -moz-background-size: contain;
         -o-background-size: contain;
         background-size: contain;
         min-height: 500px;
         display: flex; /* Usa flexbox */
         align-items: flex-end; /* Alinha os itens ao fundo */
         padding-bottom: 280px; /* Adiciona espaçamento inferior */
      }
    }
      .bannerCvDentus h1 {
         color: #FFFFFF;
      }


      .boddyCvDentus {
         background: url({{ asset('imagens/canais/cvdentus/body.jpg') }}) no-repeat center center fixed; 
         -webkit-background-size: cover;
         -moz-background-size: cover;
         -o-background-size: cover;
         background-size: cover;
      }

      .sectionnn {
            position: relative;
            overflow: hidden;
            background-color: #fff;
        }
        .bg-blue {
            background-image: url({{ asset('imagens/canais/cvdentus/Grupo-de-mascara-91.png') }});
            background-color: #2b4b80;
            color: #fff;
        }
        .bg-gray {
            background-color: #f7f7f7;
            color: #2b4b80;
        }
        .sectionnn h2 {
            font-size: 2rem;
            font-weight: bold;
            color: #fff;
        }
        .sectionnn .counter {
            font-size: 2rem;
            font-weight: bold;
            color: #2b4b80;
        }
        .sectionnn p {
            font-weight: 400;
            color: #2b4b80;
        }
        .sectionnn .elementor-button {
            margin-top: 20px;
        }
        .elementor-button-link {
            color: #fff;
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            text-decoration: none;
            display: inline-block;
        }

        .card-video {
            height: 200px;
            width: 100%;
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .card {
            height: 100%;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 2rem;
        }
        .main-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .small-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .hover-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .hover-overlay span {
            display: inline-block;
            padding: 10px 20px;
            border: 2px solid white;
            background: transparent;
            text-decoration: none;
            color: white;
            transition: background 0.3s ease, color 0.3s ease;
        }
        .hover-overlay a{
            color: #FFFFFF;
        }
        .position-relative:hover .hover-overlay {
            opacity: 1;
        }
        .position-relative {
            position: relative;
        }
        .row-eq-height {
            display: flex;
            flex-wrap: wrap;
        }
        .col-half {
            flex: 0 0 50%;
            max-width: 50%;
        }
        .col-full {
            flex: 0 0 100%;
            max-width: 100%;
        }
        .image-container {
            padding: 5px;
        }
        .image-container img {
            height: 100%;
        }

        .whatsapp-button {
            background-color: #25D366;
            color: white;
            border: none;
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            font-size:18px;
        }
        .whatsapp-button i {
            margin-right: 10px;
        }

        .whatsapp-button:hover{
            color: black;
        }

      
   </style>

   <div class="container-fluid bannerCvDentus" style="margin-bottom: 20px;">
      <div class="container">
         <div class="row">
            <!--<img src="https://cvdentus.com.br/phoatchy/2021/10/Grupo-5851.svg" class="img-fluid" style="max-height: 100px;">-->
         </div>
      </div>
   </div>
   <div class="container-fluid boddyCvDentus">
      <div class="container">
         <div class="row">
         <button type="button" class="btn"><a class="botaodescontocvdentus" href="https://conteudo.cvdentus.com.br/parceria-dental-press?utm_source=direct&utm_medium=link&utm_campaign=dental-press" target="_blank">QUERO O MEU DESCONTO</a></button>
            <div class="col-12">
               <h1 style="padding-top: 50px; font-weight: bold; text-align: center;">
                  CVDentus: transformamos inovação em experiência
               </h1>
               <p style="padding-top: 25px; padding-bottom: 50px; text-align: center;">
                  Uma das principais marcas do grupo CVDVale, a CVDentus® nasceu com o objetivo de desenvolver e comercializar pontas de ultrassom com o exclusivo Diamante-CVD. 
                  <br/><br/>
                  Desde o seu surgimento, em 2003, vem construindo uma sólida história. Com mais de 20 anos de experiência, a CVDentus possui um portfólio extenso de produtos, incluindo ultrassons, pontas, brocas e acessórios para o mercado odontológico.
               </p>
            </div>
         </div>
      </div>
   </div>


   <div class="container-fluid boddyCvDentus">
      <section class="section py-5">
            <div class="container">
                 <div class="row">
                     <div class="col-md-4 mb-4">
                         <div class="card h-100">
                             <div class="card-video">
                                 <iframe width="100%" height="200" src="https://www.youtube.com/embed/PCFeRKehPDc" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                             </div>
                             <div class="card-body">
                                 <h5 class="card-title">Opytmus – O piezo que atende a periodontia e a endodontia</h5>
                                 <p class="card-text">Este ultrassom é compacto, portátil e de fácil manuseio, favorece o dia a dia dos profissionais que buscam mais qualidade nos procedimentos e conforto para os seus pacientes.</p>
                             </div>
                         </div>
                     </div>
                     <div class="col-md-4 mb-4">
                         <div class="card h-100">
                             <div class="card-video">
                                 <iframe width="100%" height="200" src="https://www.youtube.com/embed/eHURySio6Yo" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                             </div>
                             <div class="card-body">
                                 <h5 class="card-title">Clinical Plus – O ultrassom que atende todas as especialidades clínicas</h5>
                                 <p class="card-text">Confere previsibilidade e segurança aos tratamentos, conforto aos pacientes e procedimentos minimamente invasivos. Com ele, também é possível realizar práticas exclusivas.</p>
                             </div>
                         </div>
                     </div>
                     <div class="col-md-4 mb-4">
                         <div class="card h-100">
                             <div class="card-video">
                                 <iframe width="100%" height="200" src="https://www.youtube.com/embed/za1LrR-Jp0o" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                             </div>
                             <div class="card-body">
                                 <h5 class="card-title">DentSurg Pro – O único piezo que atende todas as especialidades odontológicas</h5>
                                 <p class="card-text">Projetado para atingir a máxima performance, permite ainda procedimentos clínicos exclusivos e cirurgias com cortes ósseos precisos, com muita segurança e um pós-operatório mais confortável aos pacientes.</p>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </section>
      </div>

      <div class="container-fluid boddyCvDentus">
      <div class="container">
         <div class="row">
            <div class="col-12">
               <h2 style="font-weight: bold; text-align: center;">
                  Expertise para gerar tecnologias na odontologia
               </h2>
               <p style="padding-top: 50px; padding-bottom: 50px; text-align: center;">
                  Com a missão de pesquisar, desenvolver e identificar oportunidades, a CVDentus oferece produtos fortemente inovadores. A empresa tem se destacado por proporcionar alta precisão, qualidade, eficiência e segurança desde o primeiro ano de atuação, quando recebeu o prêmio de melhor invento da região Sudeste pela FINEP.
               </p>
            </div>
         </div>
      </div>
   </div>


   <div class="container-fluid">
      <div class="row">
         <section class="sectionnn">
                 <div class="row">
                     <div class="col-md-3 bg-blue text-center d-flex flex-column align-items-center justify-content-center" style="padding: 80px 0;">
                         <h2>INOVAÇÃO <br>EM NÚMEROS</h2>
                         <a href="https://cvdentus.com.br/porque-cvdentus/" target="_blank" class="elementor-button-link">SAIBA MAIS</a>
                     </div>
                     <div class="col-md-3 bg-gray text-center d-flex flex-column align-items-center justify-content-center" style="padding: 80px; background-color: #fbfbfb;">
                         <div class="counter">+ 7 patentes</div>
                         <p>A <strong>CVDVale</strong> é uma empresa em constante evolução. Somos movidos pela CIÊNCIA e TECNOLOGIA, na busca incansável pela INOVAÇÃO.</p>
                     </div>
                     <div class="col-md-3 bg-gray text-center d-flex flex-column align-items-center justify-content-center" style="padding: 80px; background-color:#f7f7f7;">
                         <div class="counter">+ 100 artigos</div>
                         <p>Tecnologia com embasamento técnico e científico. Acreditamos que saúde e segurança andam juntas, para isso buscamos dados e embasamento acadêmico.</p>
                     </div>
                     <div class="col-md-3 bg-gray text-center d-flex flex-column align-items-center justify-content-center" style="padding: 80px; background-color: #efeeee;">
                         <div class="counter">+ 10 prêmios</div>
                         <p>Com prêmios nacionais e internacionais, agradecemos aos nossos clientes e colaboradores, pelo compromisso de tornar esse sonho realidade.</p>
                     </div>
                 </div>
         </section>
      </div>
   </div>
   <div class="container-fluid boddyCvDentus">
      <div class="container">
         <div class="row">
            <div class="col-12">
               <h2 style="padding-top: 50px; font-weight: bold;">
                  Soluções versáteis
               </h2>
               <p style="padding-top: 25px; padding-bottom: 50px;">
                  O Diamante-CVD, fruto do espírito vanguardista da equipe, é um grande aliado na realização de procedimentos odontológicos eficientes, precisos, seguros e de alta qualidade. Mesmo sendo sintético, ele possui as mesmas propriedades físicas e químicas do cristal encontrado na natureza.
                  <br/><br/>
                  Esta tecnologia patenteada internacionalmente oferece uma dureza 30 vezes superior ao esmalte do dente e uma durabilidade muito superior às opções convencionais. Presente em várias pontas do portfólio CVDentus, suas principais vantagens são:
                  <br/><br/>
                  ●  Ausência de dor, permitindo que até 70% dos procedimentos sejam realizados sem anestesia;
                  <br/>
                  ●  Redução de sangramento, pois não lesiona o tecido mole;
                  <br/>
                  ●  Diminuição do risco de contaminação, sendo biocompatível;
                  <br/>
                  ●  Proporciona homogeneidade para melhor acabamento dos preparos, preservando o tecido sadio dos dentes e evitando extrações desnecessárias;
                  <br/>
                  ●  Junto com o ultrassom, oferece maior precisão, garantindo melhor visibilidade;
                  <br/>
                  ●  Ausência de ruído da alta rotação e eliminação do "spray" de água, proporcionando maior biossegurança ao profissional e acelerando o pós-operatório.
               </p>


               <section class="section py-5">
                  <div class="container">
                       <div class="section-title">
                           <h2>TRANSFORMAMOS INOVAÇÃO EM EXPERIÊNCIA</h2>
                       </div>
                       <div class="row row-eq-height">
                           <div class="col-12 col-md-6 image-container">
                               <div class="position-relative">
                                   <img src="https://cvdentus.com.br/phoatchy/2021/11/banner_1.png" class="main-img" alt="Imagem 1">
                                   <div class="hover-overlay">
                                       <a href="https://cvdentus.com.br/piezos/" target="_blank"><span>VEJA MAIS</span></a>
                                   </div>
                               </div>
                           </div>
                           <div class="col-12 col-md-6">
                               <div class="row row-eq-height">
                                   <div class="col-12 col-md-6 image-container">
                                       <div class="position-relative">
                                           <img src="https://cvdentus.com.br/phoatchy/2021/11/banner_2.png" class="small-img" alt="Imagem 2">
                                           <div class="hover-overlay">
                                               <a href="https://cvdentus.com.br/piezos/" target="_blank"><span>VEJA MAIS</span></a>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="col-12 col-md-6 image-container">
                                       <div class="position-relative">
                                           <img src="https://cvdentus.com.br/phoatchy/2021/11/banner_3.png" class="small-img" alt="Imagem 3">
                                           <div class="hover-overlay">
                                               <a href="https://cvdentus.com.br/piezos/" target="_blank"><span>VEJA MAIS</span></a>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="col-12 col-md-6 image-container">
                                       <div class="position-relative">
                                           <img src="https://cvdentus.com.br/phoatchy/2021/11/banner_4.png" class="small-img" alt="Imagem 4">
                                           <div class="hover-overlay">
                                               <a href="https://cvdentus.com.br/piezos/" target="_blank"><span>VEJA MAIS</span></a>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="col-12 col-md-6 image-container">
                                       <div class="position-relative">
                                           <img src="https://cvdentus.com.br/phoatchy/2021/11/banner_5.png" class="small-img" alt="Imagem 5">
                                           <div class="hover-overlay">
                                               <a href="https://cvdentus.com.br/piezos/" target="_blank"><span>VEJA MAIS</span></a>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </section>


               <h2 style="padding-top: 50px; font-weight: bold;">
                  A combinação de segurança com tecnologia
               </h2>
               <p style="padding-top: 25px;">
                  Para garantir segurança aos profissionais, alta qualidade nos procedimentos e maior conforto aos clientes, a linha de ultrassons da CVDentus oferece opções para todas as especialidades.
               </p>
            </div>
         </div>
      </div>

      <div class="container mt-5 text-center">
           <a href="https://api.whatsapp.com/send?phone=5512996376705&text=Ol%C3%A1!%20Sou%20aluno(a)%20da%20Dental%20Press/Dental%20Go%20e%20gostaria%20de%20saber%20mais%20sobre%20os%20ultrassons%20da%20CVDentus."
              class="whatsapp-button">
               <i class="fab fa-whatsapp"></i> SAIBA MAIS
           </a>
      </div>

      <br/><br/><br/><br/>
   </div>

   

@endsection