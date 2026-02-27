document.addEventListener('DOMContentLoaded', () => {

    // --- Mobile Menu Toggle ---
    const menuToggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('.nav');
    const navLinks = document.querySelectorAll('.nav-list a');

    if (menuToggle && nav) {
        menuToggle.addEventListener('click', () => {
            nav.classList.toggle('active');

            // Toggle menu icon animation
            const spans = menuToggle.querySelectorAll('span');
            if (nav.classList.contains('active')) {
                spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
            } else {
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });

        // Close menu when clicking a link
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (nav.classList.contains('active')) {
                    menuToggle.click();
                }
            });
        });
    }

    // --- Scroll Animations (Intersection Observer) ---
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px"
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in-up');
                entry.target.style.opacity = '1';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Elements to animate
    const animatedElements = document.querySelectorAll('.section-title, .content-card, .audience-card, .feature-item, .hero-content > *, .experience-visual');

    animatedElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        observer.observe(el);
    });

    // --- Header Scroll Effect ---
    const header = document.querySelector('.header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.style.boxShadow = '0 4px 6px -1px rgba(0,0,0,0.1)';
        } else {
            header.style.boxShadow = 'none';
        }
    });

    // --- Experience Image Carousel ---
    const experienceImg = document.querySelector('.experience-img');
    if (experienceImg) {
        const images = [
            'assets/capas revistas e conteudo/SERGIO-CURY.fw.png',
            'assets/capas revistas e conteudo/HENRIQUE-VILLELA.fw.png',
            'assets/capas revistas e conteudo/DANIELA-FEU.fw.png',
            'assets/capas revistas e conteudo/CARLOS-CAMARA.fw.png',
            'assets/capas revistas e conteudo/LEOPOLDINO-CAPELOZZA.fw.png',
            'assets/capas revistas e conteudo/THALLITA-QUEIROZ.fw.png',
            'assets/capas revistas e conteudo/ROMULO-LUSTOSA.fw.png',
            'assets/capas revistas e conteudo/PRISCILA-HILGENBERG.fw.png',
            'assets/capas revistas e conteudo/DEYSE-CUNHA.fw.png'
        ];

        let currentIndex = 0;

        setInterval(() => {
            experienceImg.style.opacity = '0';

            setTimeout(() => {
                currentIndex = (currentIndex + 1) % images.length;
                experienceImg.src = images[currentIndex];

                setTimeout(() => {
                    experienceImg.style.opacity = '1';
                }, 50);

            }, 1000);

        }, 5000);
    }

    // --- Random Partner Logo Highlight ---
    const partnerLogos = document.querySelectorAll('.partner-logo');
    if (partnerLogos.length > 0) {
        setInterval(() => {
            partnerLogos.forEach(logo => logo.classList.remove('highlight'));

            const randomIndex = Math.floor(Math.random() * partnerLogos.length);
            partnerLogos[randomIndex].classList.add('highlight');
        }, 2000);
    }

    // --- Magazine Carousel ---
    const carouselTrack = document.querySelector('.carousel-track');
    const prevBtn = document.querySelector('.carousel-btn.prev');
    const nextBtn = document.querySelector('.carousel-btn.next');

    if (carouselTrack && prevBtn && nextBtn) {
        let currentIndex = 0;
        const items = document.querySelectorAll('.magazine-item');
        let autoPlayInterval;

        function getItemsPerView() {
            if (window.innerWidth > 991) return 4;
            if (window.innerWidth > 768) return 3;
            if (window.innerWidth > 480) return 2;
            return 1;
        }

        function updateCarousel() {
            if (items.length === 0) return;

            const itemWidth = items[0].offsetWidth;
            const gap = 24;
            const offset = currentIndex * (itemWidth + gap);
            carouselTrack.style.transform = `translateX(-${offset}px)`;
        }

        function autoPlay() {
            const itemsPerView = getItemsPerView();
            const maxIndex = Math.max(0, items.length - itemsPerView);

            currentIndex++;

            // Loop back to beginning when reaching the end
            if (currentIndex > maxIndex) {
                currentIndex = 0;
            }

            updateCarousel();
        }

        function startAutoPlay() {
            stopAutoPlay(); // Clear any existing interval
            autoPlayInterval = setInterval(autoPlay, 3000); // Auto-advance every 3 seconds
        }

        function stopAutoPlay() {
            if (autoPlayInterval) {
                clearInterval(autoPlayInterval);
            }
        }

        prevBtn.addEventListener('click', () => {
            currentIndex = Math.max(0, currentIndex - 1);
            updateCarousel();
            startAutoPlay(); // Restart auto-play after manual navigation
        });

        nextBtn.addEventListener('click', () => {
            const itemsPerView = getItemsPerView();
            const maxIndex = Math.max(0, items.length - itemsPerView);
            currentIndex = Math.min(maxIndex, currentIndex + 1);
            updateCarousel();
            startAutoPlay(); // Restart auto-play after manual navigation
        });

        // Update on window resize
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                currentIndex = 0;
                updateCarousel();
                startAutoPlay(); // Restart auto-play after resize
            }, 250);
        });

        // Initial update and start auto-play
        updateCarousel();
        startAutoPlay();
    }

});
