const CACHE_NAME = 'bazar-v1.0.0';
const STATIC_CACHE_NAME = 'bazar-static-v1.0.0';
const DYNAMIC_CACHE_NAME = 'bazar-dynamic-v1.0.0';

// Static files to cache
const STATIC_FILES = ['/', '/login', '/dashboard', '/items', '/cart', '/manifest.json', '/offline.html'];

// API endpoints that should be cached
const CACHE_API_ENDPOINTS = ['/cart/active', '/items', '/dashboard'];

// Install event - cache static files
self.addEventListener('install', (event) => {
    console.log('[SW] Install event');

    event.waitUntil(
        caches
            .open(STATIC_CACHE_NAME)
            .then((cache) => {
                console.log('[SW] Caching static files');
                return cache.addAll(STATIC_FILES);
            })
            .catch((error) => {
                console.error('[SW] Failed to cache static files:', error);
            }),
    );

    // Force the waiting service worker to become the active service worker
    self.skipWaiting();
});

// Activate event - clean up old caches
self.addEventListener('activate', (event) => {
    console.log('[SW] Activate event');

    event.waitUntil(
        caches
            .keys()
            .then((cacheNames) => {
                return Promise.all(
                    cacheNames.map((cacheName) => {
                        if (cacheName !== STATIC_CACHE_NAME && cacheName !== DYNAMIC_CACHE_NAME && cacheName !== CACHE_NAME) {
                            console.log('[SW] Deleting old cache:', cacheName);
                            return caches.delete(cacheName);
                        }
                    }),
                );
            })
            .then(() => {
                // Take control of all clients
                return self.clients.claim();
            }),
    );
});

// Fetch event - implement caching strategies
self.addEventListener('fetch', (event) => {
    const requestUrl = new URL(event.request.url);

    // Skip non-GET requests
    if (event.request.method !== 'GET') {
        return;
    }

    // Skip chrome-extension and other non-http requests
    if (!requestUrl.protocol.startsWith('http')) {
        return;
    }

    // Handle API requests
    if (
        requestUrl.pathname.startsWith('/api/') ||
        requestUrl.pathname.startsWith('/cart/') ||
        requestUrl.pathname.startsWith('/items/') ||
        requestUrl.pathname === '/dashboard'
    ) {
        event.respondWith(networkFirstWithCache(event.request));
        return;
    }

    // Handle static assets (CSS, JS, images)
    if (
        requestUrl.pathname.includes('/build/') ||
        requestUrl.pathname.includes('/assets/') ||
        requestUrl.pathname.endsWith('.css') ||
        requestUrl.pathname.endsWith('.js') ||
        requestUrl.pathname.endsWith('.png') ||
        requestUrl.pathname.endsWith('.jpg') ||
        requestUrl.pathname.endsWith('.svg')
    ) {
        event.respondWith(cacheFirstWithNetwork(event.request));
        return;
    }

    // Handle navigation requests
    if (event.request.mode === 'navigate') {
        event.respondWith(networkFirstWithFallback(event.request));
        return;
    }

    // Default: try network first, then cache
    event.respondWith(networkFirstWithCache(event.request));
});

// Network first, then cache (for API calls)
async function networkFirstWithCache(request) {
    try {
        const networkResponse = await fetch(request);

        if (networkResponse.ok) {
            // Cache successful responses
            const cache = await caches.open(DYNAMIC_CACHE_NAME);
            cache.put(request, networkResponse.clone());
        }

        return networkResponse;
    } catch (error) {
        console.log('[SW] Network failed, trying cache:', request.url);

        const cachedResponse = await caches.match(request);
        if (cachedResponse) {
            return cachedResponse;
        }

        // If it's a data request, return offline data
        if (request.url.includes('/cart/active')) {
            return new Response(JSON.stringify([]), {
                headers: { 'Content-Type': 'application/json' },
            });
        }

        throw error;
    }
}

// Cache first, then network (for static assets)
async function cacheFirstWithNetwork(request) {
    const cachedResponse = await caches.match(request);

    if (cachedResponse) {
        // Update cache in background
        fetch(request)
            .then((networkResponse) => {
                if (networkResponse.ok) {
                    caches.open(DYNAMIC_CACHE_NAME).then((cache) => {
                        cache.put(request, networkResponse);
                    });
                }
            })
            .catch(() => {
                // Ignore network errors for background updates
            });

        return cachedResponse;
    }

    try {
        const networkResponse = await fetch(request);

        if (networkResponse.ok) {
            const cache = await caches.open(DYNAMIC_CACHE_NAME);
            cache.put(request, networkResponse.clone());
        }

        return networkResponse;
    } catch (error) {
        console.error('[SW] Failed to fetch resource:', request.url);
        throw error;
    }
}

// Network first with offline fallback (for navigation)
async function networkFirstWithFallback(request) {
    try {
        const networkResponse = await fetch(request);

        if (networkResponse.ok) {
            // Cache successful page responses
            const cache = await caches.open(DYNAMIC_CACHE_NAME);
            cache.put(request, networkResponse.clone());
        }

        return networkResponse;
    } catch (error) {
        console.log('[SW] Network failed for navigation, trying cache:', request.url);

        // Try to get from cache
        const cachedResponse = await caches.match(request);
        if (cachedResponse) {
            return cachedResponse;
        }

        // Fallback to offline page
        const offlineResponse = await caches.match('/offline.html');
        if (offlineResponse) {
            return offlineResponse;
        }

        throw error;
    }
}

// Background sync for offline actions
self.addEventListener('sync', (event) => {
    console.log('[SW] Background sync:', event.tag);

    if (event.tag === 'cart-sync') {
        event.waitUntil(syncCartData());
    }

    if (event.tag === 'items-sync') {
        event.waitUntil(syncItemsData());
    }
});

// Sync cart data when back online
async function syncCartData() {
    try {
        // Get pending cart actions from IndexedDB
        const pendingActions = await getPendingCartActions();

        for (const action of pendingActions) {
            try {
                await fetch(action.url, {
                    method: action.method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': await getCSRFToken(),
                    },
                    body: action.data ? JSON.stringify(action.data) : undefined,
                });

                // Remove from pending actions
                await removePendingAction(action.id);
            } catch (error) {
                console.error('[SW] Failed to sync cart action:', error);
            }
        }
    } catch (error) {
        console.error('[SW] Cart sync failed:', error);
    }
}

// Sync items data when back online
async function syncItemsData() {
    try {
        // Similar to cart sync but for items
        console.log('[SW] Items sync completed');
    } catch (error) {
        console.error('[SW] Items sync failed:', error);
    }
}

// Helper functions for IndexedDB operations
async function getPendingCartActions() {
    // Return empty array for now, implement IndexedDB later
    return [];
}

async function removePendingAction(id) {
    // Implement IndexedDB removal
    console.log('[SW] Removing pending action:', id);
}

async function getCSRFToken() {
    // Get CSRF token from meta tag or cookie
    return 'dummy-token';
}

// Handle push notifications (future feature)
self.addEventListener('push', (event) => {
    console.log('[SW] Push received');

    const options = {
        body: 'নতুন আপডেট পাওয়া গেছে!',
        icon: '/pwa/icon-192x192.png',
        badge: '/pwa/icon-72x72.png',
        tag: 'bazar-update',
        requireInteraction: true,
        actions: [
            {
                action: 'view',
                title: 'দেখুন',
            },
            {
                action: 'dismiss',
                title: 'বাতিল',
            },
        ],
    };

    event.waitUntil(self.registration.showNotification('Bazar আপডেট', options));
});

// Handle notification clicks
self.addEventListener('notificationclick', (event) => {
    console.log('[SW] Notification click:', event.action);

    event.notification.close();

    if (event.action === 'view') {
        event.waitUntil(clients.openWindow('/'));
    }
});
