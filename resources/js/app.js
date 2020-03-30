/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

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

    // $('#post_now').on('click', function (e) {
    //     e.stopPropagation();
    //     e.preventDefault();

    //     $.ajax({
    //         url: path + "sposts/sendNow",
    //         type: "post",
    //         dataType: 'json',
    //         delay: 250,
    //         // data: function (params) {
    //         //   return {
    //         //     _token:     CSRF_TOKEN,
    //         //     mediaFiles: upload.cachedFileArray     
    //         //   };
    //         // },
    //         data: {
    //             _token      : CSRF_TOKEN,
    //             user_id     : $("#post-user-id").val(),
    //             text        : $("#post_text").html(),
    //         },
    //         processResults: function (response) {
    //             console.log(response)
    //         },
    //         cache: true
    //     }); 
    // })


    // New post form
    $("#add_new_post").on('click', function (e) {
        //e.stopPropagation();
        e.preventDefault();
        $("#add_new_post").css("display","none");
        $("#new-compose-title").css("display","block");
        $("#create_post_content").toggleClass('collapse');
    });

});

// Media files

$( document ).ready(function(e) {
    $("#add-media-button").on('click', function (e) {
        //e.stopPropagation();
        e.preventDefault();
        let mediaCount = parseInt( $("#media-files-count").val());
        let targetInput = $("#imageUpload"+mediaCount);
        targetInput.click();  
    });

    function readURL(input) {
        
        if (input.files && input.files[0]) {

            var reader = new FileReader();
            
            reader.onload = function(e) {

                $(".avatar-preview").css("display","none");

                let mediaCount = parseInt( $("#media-files-count").val());

                let spot = $('<div class="imagePreview"></div>');
                spot.css('background-image', 'url('+e.target.result +')');
                spot.appendTo('#image-preview-container');
                
                $(".avatar-preview").css("display","block");

                // Update media counter
                $("#media-files-count").val(mediaCount+1);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imageUpload0").change(function() {
        readURL(this);
    });
    $("#imageUpload1").change(function() {
        readURL(this);
    });
    $("#imageUpload2").change(function() {
        readURL(this);
    });
    $("#imageUpload3").change(function() {
        readURL(this);
    });
})


