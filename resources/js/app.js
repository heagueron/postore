/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./media');

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

var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var path = "http://localhost:8000/";

$( document ).ready(function(e) {

    // Left sidebar navigation
    $('#sidebarCollapse').on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        if( $('#p-sidebar').css("display") == 'none'  ){
            $('#p-content').removeClass('col-12').addClass('col-md-10 col-sm-12');
            $('#p-sidebar').css("display", "block");
        }
        else{
            $('#p-sidebar').css("display", "none");
            $('#p-content').removeClass('col-md-10 col-sm-12').addClass('col-12');   
        }      
    });

    // Inmediate posting
    $('#post_now').on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        console.log("POST NOW!");
        $("#send-now-flag").val(true);
        setTimeout(() => {
            $("#submit-schedule").click();
        }, 500);
        
    });

    // New post form
    $("#add_new_post").on('click', function (e) {
        //e.stopPropagation();
        e.preventDefault();
        $("#add_new_post").css("display","none");
        //$("#new-compose-title").css("display","block");
        $("#new-scheduled-post").css("display","block");
    });


    // $( ".twitter-profile-option" ).on( "click", function(event) {
    //     event.stopPropagation();
    //     event.preventDefault();
    //     console.log( event.target );

    //     if( !$(event.target).first().prop('checked') ) {
    //         console.log("INPUT WAS FOUND NOT CHECKED")
    //         $(event.target).css('border', '3px solid blue')

    //     } else {
    //         console.log("INPUT WAS FOUND CHECKED")
    //         $(event.target).css('border', '1px solid blue')
    //     }    
    
    // } );

});

