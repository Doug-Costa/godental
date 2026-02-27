{{-- Performance Optimized Scripts & Styles --}}

{{-- Preload Critical Resources --}}
<link rel="preload" href="https://code.jquery.com/jquery-3.7.1.min.js" as="script">
<link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" as="style">
<link rel="preload" href="{{ asset('css/dentalgo.css') }}" as="style">

{{-- Critical CSS Inline (Above the fold) --}}
<style>
/* Critical CSS for above-the-fold content */
.navbar, .hero-section, .main-content {
    /* Add critical styles here */
}
</style>

{{-- Non-critical CSS with media="print" trick for async loading --}}
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<link rel="preload" href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">

{{-- JavaScript Loading Strategy --}}
<script>
// Performance monitoring
window.performance.mark('scripts-start');

// Lazy load non-critical scripts
function loadScript(src, callback) {
    const script = document.createElement('script');
    script.src = src;
    script.async = true;
    if (callback) script.onload = callback;
    document.head.appendChild(script);
}

// Load critical scripts immediately
document.addEventListener('DOMContentLoaded', function() {
    // Load jQuery Validation after DOM is ready
    loadScript('https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js', function() {
        console.log('jQuery Validation loaded');
        // Initialize validation after loading
        if (typeof initializeValidation === 'function') {
            initializeValidation();
        }
    });
    
    // Load other non-critical scripts
    loadScript('{{ asset("js/owl.carousel.min.js") }}');
    loadScript('https://rawgit.com/RobinHerbots/Inputmask/5.x/dist/jquery.inputmask.js');
    loadScript('https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/noframework.waypoints.min.js');
    
    // DataTables - only load if needed
    if (document.querySelector('.datatable')) {
        loadScript('https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js', function() {
            loadScript('https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js');
            loadScript('https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js');
            loadScript('https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js');
        });
    }
    
    window.performance.mark('scripts-end');
    window.performance.measure('scripts-load-time', 'scripts-start', 'scripts-end');
});

// Image lazy loading
function lazyLoadImages() {
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}

// Initialize lazy loading when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', lazyLoadImages);
} else {
    lazyLoadImages();
}
</script>

{{-- Service Worker for Caching --}}
<script>
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js')
            .then(function(registration) {
                console.log('SW registered: ', registration);
            })
            .catch(function(registrationError) {
                console.log('SW registration failed: ', registrationError);
            });
    });
}
</script>