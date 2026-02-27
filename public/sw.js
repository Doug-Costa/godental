// DentalGo Service Worker - Performance Optimization
const CACHE_NAME = 'dentalgo-v1.0.0';
const STATIC_CACHE = 'dentalgo-static-v1.0.0';

// Assets to cache immediately
const STATIC_ASSETS = [
    '/',
    '/css/bootstrap.min.css',
    '/css/dentalgo.css',
    '/js/jquery-3.7.1.min.js',
    '/js/bootstrap.bundle.min.js',
    '/js/fontawesome.js',
    '/js/owl.carousel.min.js'
];

// Install event - cache static assets
self.addEventListener('install', event => {
    console.log('Service Worker installing...');
    event.waitUntil(
        caches.open(STATIC_CACHE)
            .then(cache => {
                console.log('Caching static assets');
                return cache.addAll(STATIC_ASSETS);
            })
            .then(() => self.skipWaiting())
    );
});

// Activate event - clean old caches
self.addEventListener('activate', event => {
    console.log('Service Worker activating...');
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheName !== CACHE_NAME && cacheName !== STATIC_CACHE) {
                        console.log('Deleting old cache:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

// Fetch event - serve from cache with network fallback
self.addEventListener('fetch', event => {
    const { request } = event;
    const url = new URL(request.url);

    // Skip non-GET requests
    if (request.method !== 'GET') return;

    // Skip external requests (except CDNs)
    if (url.origin !== location.origin && !isCDNRequest(url)) return;

    // Handle different types of requests
    if (isStaticAsset(url)) {
        event.respondWith(cacheFirst(request));
    } else if (isAPIRequest(url)) {
        event.respondWith(networkFirst(request));
    } else {
        event.respondWith(staleWhileRevalidate(request));
    }
});

// Cache strategies
async function cacheFirst(request) {
    const cached = await caches.match(request);
    if (cached) {
        return cached;
    }
    
    try {
        const response = await fetch(request);
        if (response.ok) {
            const cache = await caches.open(STATIC_CACHE);
            cache.put(request, response.clone());
        }
        return response;
    } catch (error) {
        console.error('Cache first failed:', error);
        return new Response('Offline', { status: 503 });
    }
}

async function networkFirst(request) {
    try {
        const response = await fetch(request);
        if (response.ok) {
            const cache = await caches.open(CACHE_NAME);
            cache.put(request, response.clone());
        }
        return response;
    } catch (error) {
        const cached = await caches.match(request);
        if (cached) {
            return cached;
        }
        return new Response('Offline', { status: 503 });
    }
}

async function staleWhileRevalidate(request) {
    const cached = await caches.match(request);
    
    const fetchPromise = fetch(request).then(response => {
        if (response.ok) {
            const cache = caches.open(CACHE_NAME);
            cache.then(c => c.put(request, response.clone()));
        }
        return response;
    }).catch(() => cached);

    return cached || fetchPromise;
}

// Helper functions
function isStaticAsset(url) {
    return /\.(css|js|png|jpg|jpeg|gif|svg|woff|woff2|ttf|eot)$/i.test(url.pathname);
}

function isAPIRequest(url) {
    return url.pathname.startsWith('/api/');
}

function isCDNRequest(url) {
    const cdnDomains = [
        'code.jquery.com',
        'cdn.jsdelivr.net',
        'cdnjs.cloudflare.com',
        'fonts.googleapis.com',
        'fonts.gstatic.com'
    ];
    return cdnDomains.some(domain => url.hostname.includes(domain));
}

// Background sync for offline actions
self.addEventListener('sync', event => {
    if (event.tag === 'background-sync') {
        event.waitUntil(doBackgroundSync());
    }
});

async function doBackgroundSync() {
    // Handle offline actions when back online
    console.log('Background sync triggered');
}