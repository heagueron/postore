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
require('./admin');
require('./summernote');
require('./jquery-nice-select');

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

/* nav background transparency */
function navBackgroundControl() {
  if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
    document.getElementById("app-nav").classList.remove('bg-transparent');
    document.getElementById("app-nav").classList.add('one-edge-shadow');
  } else {
    document.getElementById("app-nav").classList.add('bg-transparent');
    document.getElementById("app-nav").classList.remove('one-edge-shadow');
  }
}


/* Categories in Jquery Nice Selector */
function categoryControl() {

  console.log('executin categoryControl ... ')

  $(document).ready(function() {
    $('#selectCategory').niceSelect();
  });

  $('#selectCategory').change(function () {
    
    const PATH = document.querySelector('#appURL').value == 'https://remjob.io' ? "https://remjob.io" : "http://127.0.0.1:8000";
    console.log(`App URL From DOM: ${document.querySelector('#appURL').value}`);
    console.log(`PATH: ${PATH}`)

    console.log('SELECTION: '+this.value);

    if( this.value != ''){
      window.location.href = `${PATH}/list/remote_${this.value}_jobs`
    } else {
      window.location.href = `${PATH}`
    }
  })
}





if ( window.location.href.indexOf("admin") <= -1) {
  /* Not in admin routes */

  navBackgroundControl();
  window.onscroll = function() {navBackgroundControl()};

}

if( document.getElementById("selectCategory") ){
  categoryControl();
}










