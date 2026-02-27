<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Schoolar')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('css/dentalgo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/schoolar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">


    <script>
           $(document).ready(function(){
                $('.owl-carousel-revistasschoolar').owlCarousel({
                    loop: true,
                    margin: 20,
                    nav: false,
                    dots: true,
                    autoplay:true,
                    autoplayTimeout:2000,
                    autoplayHoverPause:true,
                    responsiveClass:true,
                    responsive: {
                        0: {
                            items: 3
                        },
                        600: {
                            items: 3
                        },
                        1000: {
                            items: 4
                        }
                    }
                });
            });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchToggle = document.getElementById('searchToggle');
        const header = document.getElementById('header');
        const searchInput = document.getElementById('searchInput');

        // Abrir/fechar com foco automático
        searchToggle.addEventListener('click', () => {
        header.classList.toggle('expanded');
        if (header.classList.contains('expanded')) {
            setTimeout(() => {
            searchInput.focus();
            }, 400); // espera a animação
        }
        });

        // Fecha a busca ao fazer scroll
        let lastScrollTop = 0;
        window.addEventListener("scroll", function () {
        const scrollTop = window.scrollY || document.documentElement.scrollTop;
        if (scrollTop > lastScrollTop && header.classList.contains('expanded')) {
            header.classList.remove('expanded');
        }
        lastScrollTop = scrollTop;
        });
    });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchToggleMOBILE = document.getElementById('searchToggleMOBILE');
            const headerMOBILE = document.getElementById('headerMOBILE');
            const searchInputMOBILE = document.getElementById('searchInputMOBILE');

            // Abrir/fechar com foco automático
            searchToggleMOBILE.addEventListener('click', () => {
            headerMOBILE.classList.toggle('expanded');
            if (header.classList.contains('expanded')) {
                setTimeout(() => {
                searchInput.focus();
                }, 400); // espera a animação
            }
            });

            // Fecha a busca ao fazer scroll
            let lastScrollTop = 0;
            window.addEventListener("scroll", function () {
            const scrollTop = window.scrollY || document.documentElement.scrollTop;
            if (scrollTop > lastScrollTop && header.classList.contains('expanded')) {
                header.classList.remove('expanded');
            }
            lastScrollTop = scrollTop;
            });
        });
    </script>

</head>
<body id="scholar-page">
    @include('schoolar.topo')

    <main class="container-fluid py-4">
        @yield('content')
    </main>


    @include('schoolar.rodape')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>