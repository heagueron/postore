/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Sposts globals and functions
 */
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var PATH = "http://127.0.0.1:8000";
//require('./spost');
require('./autocomplete');
require('./job-post');
require('./summernote');

window.Vue = require('vue');

/**
 * Handle events for flash messages
 */

window.events = new Vue();
 
window.flash = function (message) {
    window.events.$emit('flash', message)
};


// DatetimePicker (vue component);
import datetime from 'vuejs-datetimepicker';


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('flash', require('./components/Flash.vue').default);
Vue.component('fail', require('./components/Fail.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: {
        datetime
    }
});


/* Activate bootstrap tooltips */
$('[data-toggle="tooltip"]').tooltip()

/* Make sure nav background transparency is properly set */
navBackgroundControl();

window.onscroll = function() {navBackgroundControl()};

function navBackgroundControl() {
  if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
    document.getElementById("app-nav").classList.remove('bg-transparent');
  } else {
    document.getElementById("app-nav").classList.add('bg-transparent');
  }
}






