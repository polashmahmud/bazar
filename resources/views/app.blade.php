<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Inline script to detect system dark mode preference and apply it immediately --}}
        <script>
            (function() {
                const appearance = '{{ $appearance ?? "system" }}';

                if (appearance === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            })();
        </script>

        {{-- Inline style to set the HTML background color based on our theme in app.css --}}
        <style>
            html {
                background-color: oklch(1 0 0);
            }

            html.dark {
                background-color: oklch(0.145 0 0);
            }
        </style>

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        {{-- PWA Manifest --}}
        <link rel="manifest" href="/manifest.json">
        <meta name="theme-color" content="#667eea">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="apple-mobile-web-app-title" content="Bazar">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @vite(['resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
        @inertiaHead
        @if(config('app.debug'))
            <script src="/debug.js"></script>
        @endif
    </head>
    <body class="font-sans antialiased">
        @inertia
        
        {{-- Service Worker Registration --}}
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('/sw.js')
                        .then(function(registration) {
                            console.log('SW registered: ', registration);
                            
                            // Check for updates
                            registration.addEventListener('updatefound', function() {
                                const newWorker = registration.installing;
                                newWorker.addEventListener('statechange', function() {
                                    if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                        // New service worker available
                                        if (confirm('নতুন আপডেট পাওয়া গেছে! পেজ রিলোড করবেন?')) {
                                            window.location.reload();
                                        }
                                    }
                                });
                            });
                        })
                        .catch(function(registrationError) {
                            console.log('SW registration failed: ', registrationError);
                        });
                });
                
                // Listen for messages from service worker
                navigator.serviceWorker.addEventListener('message', function(event) {
                    if (event.data && event.data.type === 'CACHE_UPDATED') {
                        console.log('Cache updated by service worker');
                    }
                });
            }
            
            // PWA Install prompt
            let deferredPrompt;
            
            window.addEventListener('beforeinstallprompt', function(e) {
                e.preventDefault();
                deferredPrompt = e;
                
                // Show install button or banner
                console.log('PWA install prompt available');
                
                // You can show a custom install button here
                showInstallPrompt();
            });
            
            function showInstallPrompt() {
                // Create install notification
                const installBanner = document.createElement('div');
                installBanner.innerHTML = `
                    <div style="position: fixed; top: 0; left: 0; right: 0; background: #667eea; color: white; padding: 12px; text-align: center; z-index: 9999; font-size: 14px;">
                        📱 Bazar অ্যাপ ইনস্টল করুন - আরও ভাল অভিজ্ঞতার জন্য
                        <button onclick="installPWA()" style="margin-left: 10px; background: white; color: #667eea; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-weight: bold;">
                            ইনস্টল করুন
                        </button>
                        <button onclick="dismissInstall()" style="margin-left: 5px; background: transparent; color: white; border: 1px solid white; padding: 6px 12px; border-radius: 4px; cursor: pointer;">
                            পরে
                        </button>
                    </div>
                `;
                document.body.appendChild(installBanner);
                
                // Auto hide after 10 seconds
                setTimeout(() => {
                    if (installBanner.parentNode) {
                        installBanner.parentNode.removeChild(installBanner);
                    }
                }, 10000);
            }
            
            function installPWA() {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then(function(choiceResult) {
                        if (choiceResult.outcome === 'accepted') {
                            console.log('User accepted the PWA install prompt');
                        }
                        deferredPrompt = null;
                    });
                }
                dismissInstall();
            }
            
            function dismissInstall() {
                const banner = document.querySelector('div[style*="position: fixed"]');
                if (banner) {
                    banner.parentNode.removeChild(banner);
                }
            }
            
            // Handle app installed event
            window.addEventListener('appinstalled', function() {
                console.log('PWA was installed');
                deferredPrompt = null;
            });
            
            // Background sync registration
            if ('serviceWorker' in navigator && 'sync' in window.ServiceWorkerRegistration.prototype) {
                // Register background sync for cart actions
                window.registerCartSync = function() {
                    navigator.serviceWorker.ready.then(function(registration) {
                        return registration.sync.register('cart-sync');
                    }).catch(function(error) {
                        console.log('Background sync registration failed:', error);
                    });
                };
                
                // Register background sync for items
                window.registerItemsSync = function() {
                    navigator.serviceWorker.ready.then(function(registration) {
                        return registration.sync.register('items-sync');
                    }).catch(function(error) {
                        console.log('Background sync registration failed:', error);
                    });
                };
            }
        </script>
    </body>
</html>
