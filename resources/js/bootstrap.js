import Vue from 'vue';
import Flash from './components/Flash.vue';

window._ = require('lodash');

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.events = new Vue();

window.flash = (message) => {
    window.events.$emit('flash', message);
}

const app = new Vue({
    el: '#app',
    components: {
        'flash': Flash
    }
});

