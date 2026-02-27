<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script> 

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<script defer src="{{ asset ('js/fontawesome.js')}}"></script>

<script defer src="{{ asset ('js/owl.carousel.min.js')}}"></script>


<script src="https://rawgit.com/RobinHerbots/Inputmask/5.x/dist/jquery.inputmask.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/noframework.waypoints.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>


<script type="text/javascript">




function toggleNotificationTab() {
  var notificationButton = document.getElementById("notificationButton");

  // Verifica se a notification-tab já foi criada
  var notificationTab = document.getElementById("notificationTab");
  if (!notificationTab) {
    notificationTab = document.createElement("div");
    notificationTab.id = "notificationTab";
    notificationTab.className = "notification-tab";
    notificationTab.innerHTML = `
      <h2 class="notification-title">Suas notificações</h2>
      <p>Nenhuma notificação no momento.</p>
    `;
    document.body.appendChild(notificationTab);
  }

  // Posiciona a notification-tab em relação ao botão
  var buttonRect = notificationButton.getBoundingClientRect();
  var notificationTabStyle = notificationTab.style;
  var windowWidth = window.innerWidth;

  // Verifica se há mais espaço à direita ou à esquerda do botão
  var spaceRight = windowWidth - buttonRect.right;
  var spaceLeft = buttonRect.left;

  if (spaceRight >= spaceLeft) {
    // Posiciona à direita do botão
    notificationTabStyle.left = buttonRect.left + "px";
    notificationTabStyle.right = "auto";
  } else {
    // Posiciona à esquerda do botão
    notificationTabStyle.right = (windowWidth - buttonRect.right) + "px";
    notificationTabStyle.left = "auto";
  }

  notificationTabStyle.top = buttonRect.bottom + "px";

  // Altera a visibilidade da notification-tab
  notificationTab.classList.toggle("show-tab");
  notificationButton.classList.toggle("expanded");

  document.addEventListener("click", function (event) {
    if (
      notificationTab.classList.contains("show-tab") &&
      event.target !== notificationTab &&
      event.target !== notificationButton
    ) {
      notificationTab.classList.remove("show-tab");
      notificationButton.classList.remove("expanded");
    }
  });

}
$(document).ready(function(){
  <?php
   $user_agent = request()->header('User-Agent');
      if ((strpos($user_agent, 'Android') !== false) || (strpos($user_agent, 'iPhone') !== false) || (strpos($user_agent, 'iPad') !== false)) {
  ?>
const imagemToBackgroundMap = {
    imagem1: "url('{{ asset('imagens/Facelift/banner-clinical1024.png') }}')",
    imagem2: "url('{{ asset('imagens/Facelift/BANNERDPJOMOBILEV24N4.png') }}')",
    imagem3: "url('{{ asset('imagens/Facelift/hof-volume-2.png---mobile.png') }}')", 
    // imagem4: "url('{{ asset('imagens/Facelift/JCDAMMOBILEV2N3.fw.png') }}')",
    imagem4: "url('{{ asset('imagens/Facelift/BANNERESTETICAMOBILE.fw.png') }}')",
    imagem5: "url('{{ asset('imagens/Facelift/banner-JBCOMSMobile.fw.png') }}')",
    imagem6: "url('{{ asset('imagens/Facelift/endo-mobile.png') }}')",
    imagem7: "url('{{ asset('imagens/Facelift/Banner-Perio - setembro 2023Mobile.png') }}')",

    imagem8: "url('{{ asset('imagens/Facelift/Banner-CONSOLAROMobile.png') }}')",
    imagem9: "url('{{ asset('imagens/Facelift/BannerdrbrunoMobile2024.fw.png') }}')",
    imagem10: "url('{{ asset('imagens/Facelift/DanielMachadoMobile.png') }}')",
    imagem11: "url('{{ asset('imagens/Facelift/Untitled-5.fw.png') }}')",
    imagem12: "url('{{ asset('imagens/Facelift/BANNERPATRICIAPROGIANTEMOBILE.fw.png') }}')",
    imagem13: "url('{{ asset('imagens/Facelift/BannerImunoMobile2024.fw.png') }}')",
    // Adicione outras imagens aqui, se necessário
};
<?php
}else{
  ?>
const imagemToBackgroundMap = {
    imagem1: "url('{{ asset('imagens/Facelift/capa-clinica-maio.png') }}')",
    imagem2: "url('{{ asset('imagens/Facelift/dpjosemcriatividade.png') }}')",
    imagem3: "url('{{ asset('imagens/Facelift/capa-oh-2-v-2.png') }}')",
    // imagem4: "url('{{ asset('imagens/Facelift/JCDAM-v2n3.png') }}')",
    imagem4: "url('{{ asset('imagens/Facelift/bannerESTETICAmarço2025.png') }}')", 
    imagem5: "url('{{ asset('imagens/Facelift/capa-cirurgia.png') }}')",
    imagem6: "url('{{ asset('imagens/Facelift/capa-endo.png') }}')",
    imagem7: "url('{{ asset('imagens/Facelift/Banner-Perio - setembro 2023.png') }}')",

    imagem8: "url('{{ asset('imagens/Facelift/Banner-CONSOLARO.fw.png') }}')",
    imagem9: "url('{{ asset('imagens/Facelift/banner--dr-bruno1.jpg') }}')",
    imagem10: "url('{{ asset('imagens/Facelift/capa daniel machado.png') }}')",
    imagem11: "url('{{ asset('imagens/Facelift/Estetica-em-Ortodontia-invertidoteste35.jpg') }}')",
    imagem12: "url('{{ asset('imagens/Facelift/Patricia-Progiante-capa-maior.png') }}')",
    imagem13: "url('{{ asset('imagens/Facelift/bannerImu.png') }}')",

    // Adicione outras imagens aqui, se necessário
};
  <?php
}
?>

const logoMap = {
    imagem1: "{{ asset('imagens/Facelift/logo-clinica.png') }}", //clinical
    imagem2: "{{ asset('imagens/Facelift/LOGO-DPJO-PRETO.fw.png') }}", //dpjo
    imagem3: "{{ asset('imagens/Facelift/OHLogoBranco.fw.png') }}", //orofacial
    // imagem4: "{{ asset('imagens/Facelift/JCDAMLOGOBRANCA.fw.png') }}", //jcdam
    imagem4: "{{ asset('imagens/Facelift/Logoesteticabranco.fw.png') }}", //estetica
    imagem5: "{{ asset('imagens/Facelift/JBCOMS-logobranco.fw.png') }}", //jbcoms
    imagem6: "{{ asset('imagens/Facelift/endoLogo.fw.png') }}", //endo
    imagem7: "{{ asset('imagens/Facelift/logo-periobranco.fw.png') }}", //perio

    imagem8: "{{ asset('imagens/Facelift/Consolaro.fw.png') }}",
    imagem9: "{{ asset('imagens/Facelift/drbrunoLogo.fw.png') }}",
    imagem10: "{{ asset('imagens/Facelift/LogoEntrevista.fw.png') }}",
    imagem11: "{{ asset('imagens/Facelift/teste.fw.png') }}",
    imagem12: "{{ asset('imagens/Facelift/DentalGO%20-%20Academy%20-%20black.png') }}",
    imagem13: "{{ asset('imagens/Facelift/imun.fw.png') }}",
    // Adicione outras imagens aqui, se necessário
};

 
const textMap = {
    imagem1: "{{__("messages.CarouselTextoClinical")}}", //clinical
    imagem2: "{{__("messages.CarouselTextoDpjo")}}", //dpjo
    imagem3: "{{__("messages.CarouselTextoOrofacial")}}", //orofacial
    // imagem4: "{{__("messages.CarouselTextoJCDAM")}}", //jcdam
    imagem4: "{{__("messages.CarouselTextoEstetica")}}", //estetica
    imagem5: "{{__("messages.CarouselTextoCollege")}}", //jbcoms
    imagem6: "{{__("messages.CarouselTextoEndo")}}", //endo
    imagem7: "{{__("messages.CarouselTextoPerio")}}", //perio

    imagem8: "Prof Alberto Consolaro",
    imagem9: "{{__("messages.CarouselTexto2")}}",
    imagem10: "{{__("messages.CarouselTexto3")}}",
    imagem11: "ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ",
    imagem12: "{{__("messages.CarouselTexto4")}}",
    imagem13: "{{__("messages.CarouselTexto5")}}",
    // Adicione outras imagens aqui, se necessário
};

const colorMap = {
    imagem1: "white", //clinical
    imagem2: "black", //dpjo
    imagem3: "white", //orofacial
    // imagem4: "white", //jcdam
    imagem4: "white", //estetica
    imagem5: "white", //jbcoms
    imagem6: "white", //endo
    imagem7: "white", //perio
    imagem8:  "white",
    imagem9: "white",
    imagem10: "white",
    imagem11: "white",
    imagem12: "white",
    imagem13: "white",
};

const linkSlideButton = {
    imagem1: "https://dentalgo.com.br/revista/1134/Clinical-2024-v24n04/5?language=pt", //clinical
    imagem2: "https://dentalgo.com.br/revista/1130/Journal-2024-v30n4/6?language=pt", //dpjo
    imagem3: "https://www.dentalgo.com.br/revista/1127/Orofacial-Harmony-2024-v3n1/67", //orofacial
    // imagem4: "https://dentalgo.com.br/revista/1072/JCDAM-v03n2/79?language=en", //jcdam
    imagem4: "https://www.dentalgo.com.br/revista/1129/Est%C3%A9tica-%7C-JCDR-2024-v22n2/4", //estetica
    imagem5: "https://dentalgo.com.br/revista/1126/JBCOMS-2025-v11n3/1", //jbcoms
    imagem6: "https://dentalgo.com.br/revista/1133/Endodontics-2024-v15n2/2", //endo
    imagem7: "https://www.dentalgo.com.br/revista/1108/Periodontology-v35n2/50", //perio

    imagem8: "https://novo.dentalpresscursos.com.br/livro_maxilares/",
    imagem9: "https://www.dentalgo.com.br/video/681/Revisitando-as-indica%C3%A7%C3%B5es-do-tratamento-da-classe-II-em%C2%A0duas%C2%A0fases/14121",
    imagem10: "https://www.dentalgo.com.br/video/719/Entrevista---Daniel-Machado/9272",
    imagem11: "https://www.dentalpressbooks.com/books/3058/",
    imagem12: "https://www.dentalgo.com.br/video/681/Do-Diagn%C3%B3stico-de-DTM-e-Parafun%C3%A7%C3%B5es-Assintom%C3%A1ticas-At%C3%A9-a-Confer%C3%AAncia-Final-do-Padr%C3%A3o-De-Normalidade/15515",
    imagem13: "https://www.dentalpressbooks.com/books/imunologia-aplicada-a-odontologia/",
};

const buttonMap = {
    imagem1: "{{__("messages.VejaMaisAll")}}",
    imagem2: "{{__("messages.VejaMaisAll")}}",
    imagem3: "{{__("messages.VejaMaisAll")}}",
    // imagem4: "{{__("messages.VejaMaisAll")}}",
    imagem4: "{{__("messages.VejaMaisAll")}}",
    imagem5: "{{__("messages.VejaMaisAll")}}",
    imagem6: "{{__("messages.VejaMaisAll")}}",
    imagem7: "{{__("messages.LeiaMaisAll")}}",
    imagem8: '{{__("messages.AssistaAgoraAll")}}',
    imagem9: '{{__("messages.AssistaAgoraAll")}}',
    imagem10: "{{__("messages.LeiaMaisAll")}}",
    imagem11: "{{__("messages.LeiaMaisAll")}}",
    imagem12: "{{__("messages.LeiaMaisAll")}}",
    imagem13: "{{__("messages.LeiaMaisAll")}}",
    // Adicione outras imagens aqui, se necessário
};

const button2Map = {
    imagem1: "{{__("messages.MinhaLista")}}",
    imagem2: "{{__("messages.MinhaLista")}}",
    imagem3: "{{__("messages.MinhaLista")}}",
    // imagem4: "{{__("messages.MinhaLista")}}",
    imagem4: "{{__("messages.MinhaLista")}}",
    imagem5: "{{__("messages.MinhaLista")}}",
    imagem6: "{{__("messages.MinhaLista")}}",
    imagem7: "{{__("messages.MinhaLista")}}",
    imagem8: '@php echo __("messages.MaisInfo") @endphp',
    imagem9: '@php echo __("messages.MaisInfo") @endphp',
    imagem10: "{{__("messages.MinhaLista")}}",
    imagem11: "{{__("messages.MinhaLista")}}",
    imagem12: "{{__("messages.MinhaLista")}}",
    imagem13: "{{__("messages.MinhaLista")}}",
    // Adicione outras imagens aqui, se necessário
};

const slider = $(".owl-carousel-tres");
const fundoClinical = document.querySelector(".fundo-clinical");
const textoClinical = document.querySelector(".text-clinical");
const logoClinical = document.querySelectorAll(".clinical-logo"); // Use as classes corretas aqui
const buttonClinical = document.querySelector(".botao-banner");
const button2Clinical = document.querySelector(".botao-banner2");

slider.on("changed.owl.carousel", function(event) {
    const activeSlideIndex = event.item.index;
    const activeSlide = slider.find(".owl-item").eq(activeSlideIndex).find(".imagemRevistaCol");

    const imagemClass = activeSlide.attr("data-image-class");
    const textoClass = activeSlide.attr("data-image-class");
    const logoClass = activeSlide.attr("data-image-class");
    const buttonClass = activeSlide.attr("data-image-class");
    const button2Class = activeSlide.attr("data-image-class");


    fundoClinical.style.transition = "background-image 3s ease-in-out";
    fundoClinical.style.backgroundImage = imagemToBackgroundMap[imagemClass];


    const animationDuration = 1500; // Duração da animação

    logoClinical.forEach(logo => {
        logo.style.transition = `opacity ${animationDuration}ms ease-in-out, transform ${animationDuration}ms ease-in-out`;
        logo.style.opacity = 0;
        logo.style.transform = "translateX(50px)";
    });

    const link = linkSlideButton[imagemClass]; // Obtém o link com base na classe do slide ativo

    // Define o atributo href do seu link
    const aTag = document.querySelector(".botao-link");
    aTag.href = link;
  

    textoClinical.style.transition = `opacity ${animationDuration}ms ease-in-out, transform ${animationDuration}ms ease-in-out`;
    textoClinical.style.opacity = 0;
    textoClinical.style.transform = "translateX(50px)"; // Inicia a animação deslocando para a direita


    buttonClinical.style.transition = `opacity ${animationDuration}ms ease-in-out, transform ${animationDuration}ms ease-in-out`;
    buttonClinical.style.opacity = 0;
    buttonClinical.style.transform = "translateX(50px)"; // Inicia a animação deslocando para a direita


    button2Clinical.style.transition = `opacity ${animationDuration}ms ease-in-out, transform ${animationDuration}ms ease-in-out`;
    button2Clinical.style.opacity = 0;
    button2Clinical.style.transform = "translateX(50px)"; // Inicia a animação deslocando para a direita

    setTimeout(() => {
        logoClinical.forEach(logo => {
            logo.src = logoMap[logoClass];
            logo.style.opacity = 1;
            logo.style.transform = "translateX(0)";
        });

        textoClinical.innerHTML = textMap[textoClass];
        textoClinical.style.color = colorMap[textoClass];
        textoClinical.style.opacity = 1;
        textoClinical.style.transform = "translateX(0)"; // Conclui a animação deslocando para a esquerda (posição original)

        buttonClinical.innerHTML = buttonMap[buttonClass];
        buttonClinical.style.opacity = 1;
        buttonClinical.style.transform = "translateX(0)"; // Conclui a animação deslocando para a esquerda (posição original)

        button2Clinical.innerHTML = button2Map[button2Class];
        button2Clinical.style.opacity = 1;
        button2Clinical.style.transform = "translateX(0)"; // Conclui a animação deslocando para a esquerda (posição original)
    }, animationDuration);
});
});
function animateNumbers() {
    const numbersContainers = document.querySelectorAll('.juntar-letrasNumeros');

    numbersContainers.forEach((container) => {
        const numberElement = container.querySelector('.contagem');
        const targetValue = parseInt(numberElement.textContent, 10); // Valor final
        let currentValue = 0;

        new Waypoint({
            element: container,
            handler: function (direction) {
                if (direction === 'down' && currentValue < targetValue) {
                    const animationInterval = setInterval(() => {
                        // Aumenta o valor atual gradualmente
                        if (currentValue < targetValue) {
                            currentValue += 10; // Ajuste o incremento (exemplo: +10 a cada iteração)
                            numberElement.textContent = currentValue;
                        } else {
                            clearInterval(animationInterval); // Pare a animação quando atingir o valor final
                        }
                    }, 10); // Intervalo de tempo entre as atualizações (ajuste conforme necessário)
                }
                this.destroy(); // Uma vez que a animação começou, destrua o waypoint para evitar repetição
            },
            offset: '80%', // Inicie a animação quando 80% do elemento estiver visível
        });
    });
}

</script>


<script type="text/javascript">
$(document).ready(function(){

$('.owl-carousel-um').owlCarousel({
loop:true,
items:1,
margin:10,
nav:true,
center:true,
autoplay:true,
dots:false,
navText : ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right"  aria-hidden="true"></i>' ],

responsive : {
0 : {
items:1

},
480 : {
items:1
  
},
768 : {
items:1
  
}
}
})

$(document).ready(function(){
$('.owl-carousel-schoolar').owlCarousel({
loop:true,
items:1,
margin:10,
nav:true,
center:true,
autoplay:true,
dots:false,
navText : ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right"  aria-hidden="true"></i>' ],

responsive : {
0 : {
items:1

},
480 : {
items:1
  
},
768 : {
items:1
  
}
}
})

})

$(document).ready(function(){
$('.owl-carousel-nove').owlCarousel({
loop:true,
items:1,
margin:10,
nav:true,
center:true,
autoplay:true,
autoplayTimeout: 5000,
autoplayHoverPause: true,
dots:false,
navText : ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],

responsive : {
0 : {
items:1

},
480 : {
items:1
  
},
768 : {
items:1
  
}
}
})

})


$(document).ready(function(){
$(".owl-carousel-quatro").owlCarousel({
    loop: true,
    margin:10,
    nav: true,
    autoplay: true,
    autoplayTimeout: 1400,
    autoplayHoverPause: true,
    center: true,
    responsiveClass: true,
    navText: [
        "<i class='fa fa-angle-left'></i>",
        "<i class='fa fa-angle-right'></i>"
    ],
    responsive: {
        0: {
            items: 2
        },
        600: {
            items: 2
        },
        900: {
            items: 2
        },
        1000: {
            items: 3
        },
        1920: {
          items: 5
        },
        2160: {
            items: 5
        },
        3000: {
          items : 5
        },
        4000: {
          items : 5
        },
    },
});
})
$(document).ready(function(){
$(".owl-carousel-tres").owlCarousel({
  	loop:true,
    margin: 10,
    nav:true,
	  autoplay:true,
    autoplayTimeout:5000,
    autoplayHoverPause:true,
    center: true,
    responsiveClass:true,
    navText: [
	    "<i class='fa fa-angle-left'></i>",
	    "<i class='fa fa-angle-right'></i>"
	],
    responsive:{
        0:{
            items:1
            // items:2
        },
        405:{
            items:2
        },
        640:{
            items:3
        },
        900:{
            items:4
        },
        990: {
            items:4
        },
        1000:{
          items:6
        },
        1400:{
            items:7
        },
        1600:{
            items:8
        },
        1900:{
            items:9
        },
        2000:{
            items:10
        },
        3000:{
            items:14
        }
    }
    
  });
})
$(document).ready(function(){
  $(".owl-carousel-tres").owlCarousel({
    loop: true,
    margin: 10,
    nav: true,
    autoplay: true,
    autoplayTimeout: 3000,
    autoplayHoverPause: true,
    center: true,
    responsiveClass: true,
    navText: [
      "<i class='fa fa-angle-left'></i>",
      "<i class='fa fa-angle-right'></i>"
    ],
    responsive: {
      0:{
            items:3
        },
        600:{
            items:3
        },
        900:{
            items:3
        },
        1000:{
          items:5
        },
        1100:{
            items:7
        },
        1600:{
            items:8
        },
        1900:{
            items:9
        },
        2000:{
            items:10
        },
        3000:{
            items:14
        },
        4000:{
           items:15
        },
    },
    onChanged: handleSlideChange
  });
})
$(document).ready(function(){
  $('.owl-carousel-livros-comprar').owlCarousel({
    loop:true,
    items:3,
    margin:10,
    nav:true,
    center:true,
    autoplay:true,
    dots:false,
    navText : ['<i class="fa fa-angle-left setas" aria-hidden="true"></i>','<i class="fa fa-angle-right setas" aria-hidden="true"></i>'],

    responsive : {
    0 : {
    items:2

    },
    480 : {
    items:2
      
    },
    768 : {
    items:2
    
    },

    1100:{
      items:3
    },
    }
  })
});
})
$(document).ready(function(){
    if ($(window).width() <= 768) {
        $('.rodape-mobilesumido').hide();
    }
});





function handleSlideChange(event) {
  var currentItemIndex = event.item.index;
  var $slideInfos = $(".slide-info");

  // Mostra o slide-info correspondente ao item atual
  $slideInfos.removeClass("active");
  $slideInfos.eq(currentItemIndex).addClass("active");
}
$(document).ready(function(){

$(".owl-carousel-seis").owlCarousel({
  loop: true,
  margin: 20,
  nav: true, 
  autoplay: true,
  autoplayTimeout: 5000,
  autoplayHoverPause: true,
  center: true,
  responsiveClass: true,
  navText : ['<i class="fa fa-angle-left fa-2xl setas" aria-hidden="true"></i>','<i class="fa fa-angle-right fa-2xl setas" aria-hidden="true"></i>'],
  responsive:{
      0:{
          items: 2
      },
      600:{
          items: 3
      },
      900:{
          items: 2
      },
      1000:{
          items: 4
      },
      1920:{
          items: 5
      },
      2160:{
          items: 5
      },
      3000:{
        items : 5
      },
      4000:{
        items : 5
      }


  }
});
$(document).ready(function(){
$(".owl-carousel-tecnologia").owlCarousel({
  loop: true,
  margin: 20,
  nav: true, 
  autoplay: true,
  autoplayTimeout: 4000,
  autoplayHoverPause: true,
  center: true,
  responsiveClass: true,
  responsive:{
      0:{
          items: 1
      },
      600:{
          items: 1
      },
      900:{
          items: 1
      },
      1000:{
          items: 3
      },
      1920:{
          items: 4
      },
      2160:{
          items: 5
      },
      3000:{
        items : 5
      },
      4000:{
        items : 5
      },
  }
});
})

$(document).ready(function(){
$(".owl-carousel-cinco").owlCarousel({
  loop: true,
  margin: 10,
  nav: true, 
  autoplay: true,
  autoplayTimeout: 5000,
  autoplayHoverPause: true,
  center: true,
  responsiveClass: true,
  responsive:{
      0:{
          items: 2
      },
      600:{
          items: 3
      },
      900:{
          items: 2
      },
      1000:{
          items: 6
      }
  }
});






var owl = $('.owl-carousel-cinco');
owl.owlCarousel();
$('.carousel-custom-prev').click(function() {
  owl.trigger('prev.owl.carousel');
});
$('.carousel-custom-next').click(function() {
  owl.trigger('next.owl.carousel');
});
})
$(document).ready(function(){
$(".owl-carousel-oito").owlCarousel({
  loop: true,
  margin: 5,
  nav: true,
  dots: false, 
  autoplay: true,
  autoplayTimeout: 5000,
  autoplayHoverPause: true,
  center: true,
  responsiveClass: true,
    navText: [
      "<i class='fa fa-angle-left'></i>",
      "<i class='fa fa-angle-right'></i>"
    ],
  responsive:{
    0:{
            items:3
        },
        600:{
            items:3
        },
        900:{
            items:5
        },
        1000:{
          items:5
        },
        1100:{
            items:7
        },
        1600:{
            items:8
        },
        1900:{
            items:9
        },
      2000:{
          items: 10
      },
      3000:{
          items: 12
      }
  }
});
})
$(document).ready(function(){
var el = $('.owl-carousel1'); 

var carousel;
var carouselOptions = {
  margin: 20,
  nav: true,
  dots: false,
  loop: true,
  autoplay:true,
  autoplayTimeout:10000,
  autoplayHoverPause:true,
  center: true,
  responsiveClass:true,
  slideBy: 'page',
  responsive: {
    0: {
      items: 1,
      rows: 4 //custom option not used by Owl Carousel, but used by the algorithm below
    },
    768: {
      items: 2,
      rows: 2 //custom option not used by Owl Carousel, but used by the algorithm below
    },
    991: {
      items: 3,
      rows: 3 //custom option not used by Owl Carousel, but used by the algorithm below
    }
  }
};
});
})


// Mapeie os IDs dos vídeos para suas descrições



$(document).ready(function() {
   
    // Variável para o player de vídeo do YouTube
    let player;


    // Configuração do carousel
    const carousel = $(".owl-carousel-sete").owlCarousel({
        center: true,
        loop: true,
        autoplay:true,
        autoplayTimeout:20000,
        autoplayHoverPause:true,
        margin: 10,
        video:true,
        nav:false,
        lazyLoad:true,
        responsiveClass:true,
        slideBy: 'page',
        responsive: {
          0:{
            items:1
        },
        600:{
            items:3
        },
        900:{
            items:3
        },
        1000:{
          items:4
        },
        1100:{
            items:4
        },
        1600:{
            items:4
        },
        1900:{
            items:5
        },
        2000:{
            items:7
        },
        3000:{
            items:9
        }
    }
    });
    const videoData = [
    {
        videoId: 'RocAeiXTRoM',
    },
    {
        videoId: 'RocAeiXTRoM',
    },
    {
        videoId: 'RocAeiXTRoM',
    },
    // Adicione mais vídeos e descrições conforme necessário
];

    var $owl = $('.owl-carousel-vinte');

$owl.children().each( function( index ) {
  $(this).attr( 'data-position', index ); // NB: .attr() instead of .data()
});

$owl.owlCarousel({
  center: true,
  loop: true,
  items: 5,
});

$(document).on('click', '.owl-item>div', function() {
  // see https://owlcarousel2.github.io/OwlCarousel2/docs/api-events.html#to-owl-carousel
  var $speed = 300;  // in ms
  $owl.trigger('to.owl.carousel', [$(this).data( 'position' ), $speed] );
});

    

    function updateVideoTitle(currentSlideIndex) {
        const currentSlide = carousel.find('.owl-item').eq(currentSlideIndex);
        const videoTitle = currentSlide.find('.slider-card').attr('data-title');
        const videoDescription = currentSlide.find('.slider-card').attr('data-description');
        const videoButton = currentSlide.find('.slider-card').attr('data-button');
        const linkButton = currentSlide.find('.slider-card').attr('data-link');
        const videoButton2 = currentSlide.find('.slider-card').attr('data-button2');
        const linkButton2 = currentSlide.find('.slider-card').attr('data-link2');
        $('.video-title').text(videoTitle);
        $('.video-description').text(videoDescription);
        $('.video-button').text(videoButton);
        $('.video-link').attr('href', linkButton);

        if (videoButton2 && videoButton2.trim() !== '') {
        $('.video-link-second').text(videoButton2);
        $('.video-link-second').attr('href', linkButton2);
        $('.video-link-second').show();
        } else {
            $('.video-link-second').hide();
        }
    }

    // Atualize o título no início
    updateVideoTitle(0);

    carousel.on('changed.owl.carousel', function(event) {
        const currentSlideIndex = event.item.index;
        updateVideoTitle(currentSlideIndex);
    });

    // Adicione o seguinte trecho de código dentro do evento 'translated.owl.carousel':
    carousel.on('translated.owl.carousel', function(event) {
        const currentSlideIndex = event.page.index;
        const currentVideoId = videoData[currentSlideIndex].videoId;
        player.loadVideoById(currentVideoId);

        // Remova a classe "expanded-slide" de todos os slides
        carousel.find('.owl-item').removeClass('expanded-slide');

        // Adicione a classe "expanded-slide" ao slide atual
        const currentSlide = carousel.find('.owl-item').eq(currentSlideIndex);
        currentSlide.addClass('expanded-slide');

        // Remova a classe "highlighted-slide" de todos os slides
        carousel.find('.owl-item').removeClass('highlighted-slide');

        // Adicione a classe "highlighted-slide" ao slide atual para destacá-lo
        currentSlide.addClass('highlighted-slide');

        // Atualize o título do vídeo com base no índice do slide
        const currentTitle = currentSlide.attr('data-title');
        $('.video-title').text(currentTitle);
    });


    // Função para criar o player de vídeo do YouTube
    function createYouTubePlayer(videoId) {
        // Configuração do player
        const playerConfig = {
            videoId: videoId,
            playerVars: {
                controls: 0,        // Desativar os controles do vídeo
                autoplay: 1,        // Iniciar a reprodução automaticamente
                mute: 1,            // Áudio mutado
                showinfo: 0,        // Ocultar o título e informações do vídeo
                modestbranding: 1,  // Remover a marca d'água do YouTube
                disablekb: 1,       // Desativar o teclado
                rel: 0,             // Evitar vídeos relacionados no final
                iv_load_policy: 3  // Ocultar anotações
            },
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        };

        // Crie um player de vídeo do YouTube
        player = new YT.Player('player', playerConfig);

        // Função chamada quando o player estiver pronto
        function onPlayerReady(event) {
            // Inicie a reprodução automaticamente
            event.target.playVideo();
        }

        // Função chamada quando o estado do player mudar (término do vídeo)
        function onPlayerStateChange(event) {
            if (event.data === YT.PlayerState.ENDED) {
                // Se o vídeo atual terminou, avance para o próximo vídeo na lista
                const currentVideoIndex = (carousel.find('.owl-item.center').index() + videoData.length) % videoData.length;
                const nextVideoIndex = (currentVideoIndex + 1) % videoData.length; // Próximo vídeo na lista
                const nextVideoId = videoData[nextVideoIndex].videoId;
                player.loadVideoById(nextVideoId);
                highlightCurrentSlide(nextVideoIndex);
            }
        }



        // Destaque o slide atual com o vídeo em reprodução
        function highlightCurrentSlide(index) {
            carousel.find('.owl-item').removeClass('current-slide');
            const currentSlide = carousel.find('.owl-item').eq(index);
            currentSlide.addClass('current-slide');
        }
    }

    // Carregue a função createYouTubePlayer após a API do YouTube ser carregada
    window.onYouTubeIframeAPIReady = function() {
        // Inicialize o player com o primeiro vídeo
        const initialVideoId = videoData[0].videoId;
        createYouTubePlayer(initialVideoId);
    };

    carousel.on('translated.owl.carousel', function(event) {
        const currentSlideIndex = event.page.index;
        const currentVideoId = videoData[currentSlideIndex].videoId;
        player.loadVideoById(currentVideoId);

        // Remova a classe "expanded-slide" de todos os slides
        carousel.find('.owl-item').removeClass('expanded-slide');

        // Adicione a classe "expanded-slide" ao slide atual
        const currentSlide = carousel.find('.owl-item').eq(currentSlideIndex);
        currentSlide.addClass('expanded-slide');

        // Remova a classe "highlighted-slide" de todos os slides
        carousel.find('.owl-item').removeClass('highlighted-slide');

        // Adicione a classe "highlighted-slide" ao slide atual para destacá-lo
        currentSlide.addClass('highlighted-slide');
    });


    // Impedir que o link dentro do slide seja seguido
    carousel.on('click', '.slide-info a', function(event) {
        event.preventDefault();
    });

    if (typeof YT !== 'undefined' && typeof YT.Player !== 'undefined') {
    // Inicialize o player com o primeiro vídeo
    const initialVideoId = videoData[0].videoId;
    createYouTubePlayer(initialVideoId);
}
});


$(document).ready(function() {
window.addEventListener('load', animateNumbers);

$(document).ready(function() {
  $(".accordion-button").on('click', function() {
    var $accordionItem = $(this).closest('.accordion-item');

    if ($accordionItem.hasClass("active")) {
      // Se o item já estiver aberto, remove a classe 'active' no evento hide.bs.collapse
      $accordionItem.on('hide.bs.collapse', function() {
        $accordionItem.removeClass("active");
      });
    } else {
      // Se o item estiver fechado, adiciona a classe 'active' no evento show.bs.collapse
      $accordionItem.on('show.bs.collapse', function() {
        $accordionItem.addClass("active");
      });
    }
  });
});
});


</script>

<script src="https://www.youtube.com/iframe_api"></script>


<script>
$(document).ready(function() {
  $("#formCad").validate({
    rules: {
      InputCPF: {
        required: function() {
          return $("#InputDDI").val() === "55";
        },
        cpf: true
      }
    },
    messages: {
        InputCPF: {
          cpf: "CPF inválido"
        }
    }
  });
  
  $.validator.addMethod("cpf", function(value, element) {
    value = $.trim(value);
    value = value.replace(".", "");
    value = value.replace(".", "");
    cpf = value.replace("-", "");
    while (cpf.length < 11) cpf = "0" + cpf;
    var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
    var a = [];
    var b = new Number;
    var c = 11;
    for (i = 0; i < 11; i++) {
      a[i] = cpf.charAt(i);
      if (i < 9) b += a[i] * --c;
    }
    if ((x = b % 11) < 2) {
      a[9] = 0;
    } else {
      a[9] = 11 - x;
    }
    b = 0;
    c = 11;
    for (y = 0; y < 10; y++) b += a[y] * c--;
    if ((x = b % 11) < 2) {
      a[10] = 0;
    } else {
      a[10] = 11 - x;
    }
    var retorno = true;
    if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) {
      document.getElementById("InputCPF").setCustomValidity("O CPF é inválido");
      retorno = false;
    } else {
      document.getElementById("InputCPF").setCustomValidity("");
    }
    return this.optional(element) || retorno;
  });

  $("#InputCPF").blur(function() {
    if (!$(this).valid()) {
      	document.getElementById("InputCPF").setCustomValidity("O CPF é inválido");
      	$(this).addClass('is-invalid');
	  	$(this).next().text("O CPF é inválido")
    }else{
    	$(this).removeClass('is-invalid');
	    $(this).next().text('');
    }
  });
  
  document.getElementById("InputDDI").addEventListener("change", function() {
    if (this.value === "55") {
      document.getElementById("CadCPF").hidden = false;
    } else {
      document.getElementById("CadCPF").hidden = true;
    }
  });
});
</script>

<script>
$(document).ready(function() {
  $("#formCad2").validate({
    rules: {
      InputCPF: {
        required: function() {
          return $("#InputDDI2").val() === "55";
        },
        cpf: true
      }
    },
    messages: {
        InputCPF: {
          cpf: "CPF inválido"
        }
    }
  });
  
  $.validator.addMethod("cpf", function(value, element) {
    value = $.trim(value);
    value = value.replace(".", "");
    value = value.replace(".", "");
    cpf = value.replace("-", "");
    while (cpf.length < 11) cpf = "0" + cpf;
    var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
    var a = [];
    var b = new Number;
    var c = 11;
    for (i = 0; i < 11; i++) {
      a[i] = cpf.charAt(i);
      if (i < 9) b += a[i] * --c;
    }
    if ((x = b % 11) < 2) {
      a[9] = 0;
    } else {
      a[9] = 11 - x;
    }
    b = 0;
    c = 11;
    for (y = 0; y < 10; y++) b += a[y] * c--;
    if ((x = b % 11) < 2) {
      a[10] = 0;
    } else {
      a[10] = 11 - x;
    }
    var retorno = true;
    if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) {
      document.getElementById("InputCPF2").setCustomValidity("O CPF é inválido");
      retorno = false;
    } else {
      document.getElementById("InputCPF2").setCustomValidity("");
    }
    return this.optional(element) || retorno;
  });

  $("#InputCPF2").blur(function() {
    if (!$(this).valid()) {
        document.getElementById("InputCPF2").setCustomValidity("O CPF é inválido");
        $(this).addClass('is-invalid');
      $(this).next().text("O CPF é inválido")
    }else{
      $(this).removeClass('is-invalid');
      $(this).next().text('');
    }
  });
  document.getElementById("InputDDI2").addEventListener("change", function() {
    if (this.value === "55") {
      document.getElementById("CadCPF2").hidden = false;
    } else {
      document.getElementById("CadCPF2").hidden = true;
    }
  });
});
</script>

<script type="text/javascript">
  window.onload = function() {
var password = document.getElementById("InputSenha")
  , confirm_password = document.getElementById("InputSenhaConfirma");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("As senhas não correspondem");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
  }
</script>


<script>
    //Aplica a máscara para o input de cupom
    $(document).ready(function(){ 
       Inputmask("A99-999-999-999").mask("#InputCoupon");
       Inputmask("999.999.999-99").mask("#InputCPF");
       Inputmask("999.999.999-99").mask("#InputCPF2");
       Inputmask("99/99").mask("#ExpiracaoCartao");
    });


    //Declara variáveis e atribui elementos do HTML
    var modalAction;
    var couponCode = document.getElementById("couponCode");

    //Função de inicialização do jQuery
    $(document).ready(function(){

        //Evento para quando o modal é aberto
        $('#modalCadastro').on('show.bs.modal', function (e) {
            //Se a ação do modal é ativar cupom, mostra o input de cupom
            if (modalAction === 'activateCoupon') {
                couponCode.style.display = "block";
            } 
            //Se não, esconde o input de cupom
            else {
                couponCode.style.display = "none";
            }
        });
    });

    //Função para abrir o modal
    function openModal(action) {
        modalAction = action;
        //Se a ação do modal é ativar cupom, mostra o input de cupom
        if (modalAction === 'activateCoupon') {
            couponCode.style.display = "block";
            document.getElementById("InputCoupon").required = true;

        } 
        //Se não, esconde o input de cupom
        else {
            couponCode.style.display = "none";
            document.getElementById("InputCoupon").required = false;
        }
        $('#modalCadastro').modal('show');
    }
    
</script>


<script>  
	function changeLanguage(lang){
	    window.location='{{url("change-language")}}/'+lang;
	}
</script>


<script>
  // Função para ocultar o alerta após um determinado tempo (milissegundos)
  function hideAlert(alert) {
    alert.style.display = 'none';
  }

  // Ocultar todos os alertas automaticamente após 5 segundos (5000 milissegundos)
  const alerts = document.querySelectorAll('.alert-dismissable');
  alerts.forEach((alert) => {
    setTimeout(() => {
      hideAlert(alert);
    }, 10000); // 5000 milissegundos (5 segundos)
  });
</script>

<script>
$(document).ready(function(){
    $(".owl-carousel-trinta").owlCarousel({
      loop:true,
      margin:5,
      nav:true,
      autoplay:true,
      autoplayTimeout:3000,
      autoplayHoverPause:true,
      center: true,
      responsiveClass:true,
      
      responsive:{
          0:{
              items:3
          },
          600:{
              items:3
          },
          900:{
              items:3
          },
          1000:{
              items:6,
              loop: true,
          },
          2000:{
              items:8,
              loop: true,
          },
          3000:{
              items:10,
              loop: true,
          },
          4000:{
              items:12,
              loop: true,
          },
      }
    }); 
  });
  </script>


<script>
$(document).ready(function(){
    $(".owl-carousel-zero").owlCarousel({
      loop:true,
      margin:10,
      nav:true,
      autoplay:true,
      autoplayTimeout:3000,
      autoplayHoverPause:true,
      center: false,
      responsiveClass:true,
      
      responsive:{
          0:{
              items:1
          },
          600:{
              items:1
          },
          900:{
              items:3
          },
          1000:{
              items:5
          }
      }
    }); 
  });
  </script>

<script>
    $("document").ready(function(){
  $(".tab-slider--body").hide();
  $(".tab-slider--body:first").show();
});

$(".tab-slider--nav li").click(function() {
  $(".tab-slider--body").hide();
  var activeTab = $(this).attr("rel");
  $("#"+activeTab).fadeIn();
  if($(this).attr("rel") == "tab2"){
    $('.tab-slider--tabs').addClass('slide');
  }else{
    $('.tab-slider--tabs').removeClass('slide');
  }
  $(".tab-slider--nav li").removeClass("active");
  $(this).addClass("active");
});
  </script>

   <script type="text/javascript">
        $(document).ready(function(){
            $(".tab-slider--body").hide();
            $(".tab-slider--body:first").show();

            $(".tab-slider--nav li").click(function() {
                $(".tab-slider--body").hide();
                var activeTab = $(this).attr("rel");
                $("#" + activeTab).fadeIn();
                if($(this).attr("rel") == "tab2") {
                    $('.tab-slider--tabs').addClass('slide');
                } else {
                    $('.tab-slider--tabs').removeClass('slide');
                }
                $(".tab-slider--nav li").removeClass("active");
                $(this).addClass("active");
            });
        });
        $(document).ready(function(){
        $(".owl-carousel-cinco").owlCarousel({
            loop: true,
            margin: 10,
            nav: true, 
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            center: true,
            responsiveClass: true,
            responsive:{
                0:{
                    items: 2
                },
                600:{
                    items: 3
                },
                900:{
                    items: 2
                },
                1000:{
                    items: 6
                }
            }
            });
            var owl = $('.owl-carousel-cinco');
            owl.owlCarousel();
            $('.carousel-custom-prev').click(function() {
            owl.trigger('prev.owl.carousel');
            });
            $('.carousel-custom-next').click(function() {
            owl.trigger('next.owl.carousel');
            });

          })
    </script>

<script>
 $(document).ready(function() {
    // Inicializa o Tab Slider
    $(".tab-slider--body").hide();
    $(".tab-slider--body:first").show();

    // Lógica para clique nas abas
    $(".tab-slider--nav li").click(function() {
        var activeTab = $(this).attr("rel");

        // Esconde todas as abas
        $(".tab-slider--body").hide();

        // Mostra a aba correspondente ao clique
        $("#" + activeTab).fadeIn();

        // Remove a classe 'active' de todas as abas
        $(".tab-slider--nav li").removeClass("active");

        // Adiciona a classe 'active' apenas na aba clicada
        $(this).addClass("active");

        // Desativa e reativa o Owl Carousel para evitar conflitos
        $(".owl-carousel-noventa").trigger('destroy.owl.carousel');
        $(".owl-carousel-noventa").owlCarousel({
            loop: true,
            margin: 10,
            nav: true, 
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            center: true,
            responsiveClass: true,
            responsive:{
                0:{
                    items: 2
                },
                600:{
                    items: 3
                },
                900:{
                    items: 2
                },
                1000:{
                    items: 6
                }
            }
        });
    });
});

    </script>

    <script>

$(document).ready(function(){
  $(".owl-carousel-setenta").owlCarousel({
  	loop:true,
    margin:10,
    nav:true,
	autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
    center: true,
    responsiveClass:true,
    navText: [
	    "<i class='fa fa-angle-left'></i>",
	    "<i class='fa fa-angle-right'></i>"
	],
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        900:{
            items:2
        },
        1000:{
            items:6
        }
    }
  });
  
   $(".owl-carousel-t").owlCarousel({
  	loop:true,
    margin:10,
    nav:true,
	autoplay:false,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
    center: true,
    responsiveClass:true,
    navText: [
	    "<i class='fa fa-angle-left'></i>",
	    "<i class='fa fa-angle-right'></i>"
	],
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        900:{
            items:2
        },
        1000:{
            items:6
        }
    }
  });
});

    </script>

<script> 
// Verificar se os elementos existem antes de tentar usá-los
const searchBar = document.getElementById("search-bar");
const searchExpandButton = document.getElementById("search-expand");
const searchSubmitButton = document.getElementById("search-submit");
const searchForm = document.getElementById("search-form");
const searchWarning = document.getElementById("search-warning");

// Só executar o código se os elementos necessários existirem
if (searchBar && searchExpandButton && searchForm) {
    function isMobile() {
      return window.innerWidth <= 768;
    }

    function updateMobileSearchClass() {
      if (isMobile()) {
        searchForm.classList.add("mobile-active");
      } else {
        searchForm.classList.remove("mobile-active");
      }
    }

    window.addEventListener("resize", updateMobileSearchClass);
    updateMobileSearchClass();

    searchExpandButton.addEventListener("click", function () {
        searchBar.classList.add("active");
        searchBar.focus();
        searchExpandButton.style.display = "none";
        if (searchSubmitButton) {
            searchSubmitButton.style.display = "block";
        }
        if (searchWarning) {
            searchWarning.style.display = "none";
        }
    });

    searchForm.addEventListener("submit", function (event) {
        if (searchBar.value.trim() === "") {
            event.preventDefault(); 
            if (searchWarning) {
                searchWarning.style.display = "block";
            }
        }
    });

    searchBar.addEventListener("blur", function () {
        if (searchBar.value.trim() === "") {
            searchBar.classList.remove("active");
            searchExpandButton.style.display = "block";
            if (searchSubmitButton) {
                searchSubmitButton.style.display = "none";
            }
            if (searchWarning) {
                searchWarning.style.display = "none";
            }
        }
    });

    searchBar.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            if (searchBar.value.trim() === "") {
                event.preventDefault(); 
                if (searchWarning) {
                    searchWarning.style.display = "block";
                }
            } else {
                if (searchWarning) {
                    searchWarning.style.display = "none";
                }
            }
        }
    });
}



</script>

<script>

$(document).ready(function() {
   
   // Variável para o player de vídeo do YouTube
   let player;


   // Configuração do carousel
   const carousel = $(".owl-carousel-slidesparceiros").owlCarousel({
       center: true,
       loop: true,
       autoplay:true,
       autoplayTimeout:20000,
       autoplayHoverPause:true,
       margin: 10,
       video:true,
       nav:false,
       lazyLoad:true,
       responsiveClass:true,
       slideBy: 'page',
       responsive: {
         0:{
           items:2
       },
       600:{
           items:3
       },
       900:{
           items:3
       },
       1000:{
         items:4
       },
       1100:{
           items:4
       },
       1600:{
           items:4
       },
       1900:{
           items:5
       },
       2000:{
           items:7
       },
       3000:{
           items:9
       }
   }
  })
   });

</script>