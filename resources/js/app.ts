import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import axios from 'axios';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { initializeTheme } from './composables/useAppearance';

// Import offline storage for PWA support
import './lib/offline-storage';

// Configure axios defaults
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true; // Ensure cookies are sent with requests

// Set CSRF token from meta tag
const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
    console.log('CSRF token set:', token.substring(0, 10) + '...');
} else {
    console.error('CSRF token not found in meta tag');
}

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
    progress: {
        delay: 250,
        color: '#4F46E5',
        includeCSS: true,
        showSpinner: false,
    },
});

// This will set light / dark mode on page load...
initializeTheme();
