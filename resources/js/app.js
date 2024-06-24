import './bootstrap';
import { createApp } from 'vue';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
import ChatComponent from './components/ChatComponent.vue';

app.component('example-component', ExampleComponent);
app.component('chat-component', ChatComponent);

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
    wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
    wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
    auth: {
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('api_token')
        }
    }

    
});


// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });

console.log('Echo initialized:', window.Echo);

window.Echo.connector.pusher.connection.bind('state_change', states => {
    console.log('Pusher connection state change:', states);
});

window.Echo.connector.pusher.connection.bind('connected', () => {
    console.log('Pusher connected successfully!');
});

window.Echo.connector.pusher.connection.bind('disconnected', () => {
    console.error('Pusher disconnected');
});

window.Echo.connector.pusher.connection.bind('error', error => {
    console.error('Pusher connection error:', error);
});

app.mount('#app');
