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
$(function () {
    $('[data-toggle="tooltip"]').tooltip()

    $('#description').summernote({
        placeholder: 'Remote job description',
        tabsize: 2,
        height: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture']],
            ['view', ['help']]
          ]
      });

})

/* Prevent presentation of job description when click on a tag or company name */
const collapseControl = () => {

    const tagBadges = document.querySelectorAll('.job-badget');
    const companyBadges = document.querySelectorAll('.company-badge');
    
    tagBadges.forEach(function(tagbadge) {
        tagbadge.addEventListener("click", function(event){
        event.stopPropagation()
        })
    });

    companyBadges.forEach(function(companybadge) {
        companybadge.addEventListener("click", function(event){
        event.stopPropagation()
        })
    });

}

/* Controls presence of Apply Button */
const applyControl = () => {

    var x = document.getElementsByClassName("job-box");

    if( x.length == 0 ) return;

    for (var i = 0; i < x.length; i++) {

        let applyElement = x[i].querySelector('.rp-jobrow__apply');
        //console.log(applyElement);

        x[i].addEventListener('mouseenter', e => {
            //console.log("inside job row");  
            applyElement.style.display = "flex";
        });

        x[i].addEventListener('mouseleave', e => {
            //console.log("outside job row");
            applyElement.style.display = "none";
        });

    }
}



// Delay to allow for elements to appear before assigning event listeners.
  setTimeout(() => {
    
    collapseControl();

    let heroSearchInput = document.getElementById("myInput");
    if ( heroSearchInput != null ) {
        console.log("active url is the job list page");
        applyControl();
    }
    
}, 500);
