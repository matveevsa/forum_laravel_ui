import Vue from 'vue';
import Flash from './components/Flash.vue';
import Thread from './pages/Thread.vue';
import Paginator from './components/Paginator.vue';

window._ = require('lodash');

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

window.axios = require('axios');

window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.App.csrfToken,
};

window.events = new Vue();

window.flash = (message) => {
    window.events.$emit('flash', message);
}

Vue.component('thread-view', Thread);
Vue.component('paginator', Paginator);

Vue.prototype.authorize = function (handler) {
    const user = window.App.user;

    return user ? handler(user) : false;
}

new Vue({
    el: '#app',
    components: {
        'flash': Flash,
    }
});
