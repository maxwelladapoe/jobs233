window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    //window.Popper = require('popper.js').default;
    //window.$ = window.jQuery = require('jquery');

    //require('bootstrap');
} catch (e) {
}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

let version = 'v1';
window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Content-Type'] = 'application/json';

if (window.location.href.indexOf(".test") !== -1) {

    console.log("%cYou are in development mode", 'background: green; color: white; display: block;')

    window.axios.defaults.baseURL = "http://jobs233.test/api/" + version + "/";
    window.baseUrl = "http://jobs233.test/api/" + version + "/"

} else if (window.location.href.indexOf("localhost") !== -1) {
    console.log("%cYou are in development mode", 'background: green; color: white; display: block;')
    window.axios.defaults.baseURL = "http://localhost:8000/api/" + version + "/";
    window.baseUrl = "http://localhost:8000/api/" + version + "/"
} else if (window.location.href.indexOf("127.0.0.1") !== -1) {
    console.log("%cYou are in development mode", 'background: green; color: white; display: block;')
    window.axios.defaults.baseURL = "http://127.0.0.1:8000/api/" + version + "/";
    window.baseUrl = "http://127.0.0.1:8000/api/" + version + "/"
} else {
    window.axios.defaults.baseURL = "https://www.jobs233.com/api/" + version + "/";
    window.baseUrl = "https://www.jobs233.com/api/" + version + "/";
}

window.axios.defaults.withCredentials = true;

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

axios.defaults.withCredentials = true;


import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: true,
    disableStats: true,
});
