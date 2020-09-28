window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Content-Type'] = 'application/json';

if (window.location.href.indexOf(".test") !== -1) {

    console.log("%cYou are in development mode", 'background: green; color: white; display: block;')

    window.axios.defaults.baseURL = "http://jobs233.test:8000/api/";
    window.baseUrl = "http://jobs233.test:8000/api/"

} else if (window.location.href.indexOf("localhost") !== -1) {
    console.log("%cYou are in development mode", 'background: green; color: white; display: block;')
    window.axios.defaults.baseURL = "http://localhost:8000/api/";
    window.baseUrl = "http://localhost:8000/api/"
} else {
    window.axios.defaults.baseURL = "https://jobs233.com/api/";
    window.baseUrl = "https://jobs233.com/api/";
}

window.axios.defaults.withCredentials = true;

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

axios.defaults.withCredentials = true;


// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
