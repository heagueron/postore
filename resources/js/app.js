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

            let mediaCount = parseInt( $("#media-files-count").val());
            mediaCount +=1;

            reader.onload = function(e) {

                    let spot1 = $(`<div class="imagePreview" id="imagePreview1">
                                        <i class="far fa-times-circle removeMedia"></i>
                                    </div>`);
                    let spot2 = $(`<div class="imagePreview" id="imagePreview2">
                                        <i class="far fa-times-circle removeMedia"></i>
                                    </div>`);
                    let spot3 = $(`<div class="imagePreview" id="imagePreview3">
                                        <i class="far fa-times-circle removeMedia"></i>
                                    </div>`);
                    let spot4 = $(`<div class="imagePreview" id="imagePreview4">
                                        <i class="far fa-times-circle removeMedia"></i>
                                    </div>`);

                switch (mediaCount) {
                    case 1:                      
                        spot1.css('background-image', 'url('+e.target.result +')');
                        spot1.appendTo('#previewColumn1');                      
                    break;
                    case 2:
                        $( "#imagePreview1" ).remove();
                        let bg1 = sessionStorage.getItem("bg1");
                        spot1.css('background-image', bg1).css('width','115px');
                        spot1.appendTo('#previewColumn1'); 

                        spot2.css('background-image', 'url('+e.target.result +')');
                        spot2.css('width','115px');
                        spot2.appendTo('#previewColumn2');
                    break;
                    case 3:

                        $( "#imagePreview2" ).remove();
                        let bg2 = sessionStorage.getItem("bg2");
                        spot2.css('background-image', bg2).css('height','115px').css('width','115px');
                        spot2.appendTo('#previewColumn2');

                        spot3.css('background-image', 'url('+e.target.result +')');
                        spot3.css('width','115px').css('height','115px');
                        spot3.appendTo('#previewColumn2');

                        //column2.appendTo('#image-preview-container');
                    break;
                    case 4:
                        $( "#imagePreview1" ).remove();
                        bg1 = sessionStorage.getItem("bg1");
                        spot1.css('background-image', bg1).css('width','115px').css('height','115px');
                        spot1.appendTo('#previewColumn1');

                        $( "#imagePreview3" ).remove();
                        let bg3 = sessionStorage.getItem("bg3");
                        spot3.css('background-image', bg3).css('width','115px').css('height','115px');
                        spot3.appendTo('#previewColumn1');

                        spot4.css('background-image', 'url('+e.target.result +')');
                        spot4.css('width','115px').css('height','115px');
                        spot4.appendTo('#previewColumn2');
                    break;
                    default:
                        console.log("Maximun image files count exceeded!")
                        break;
                }

                
                $(".avatar-preview").css("display","block");
                

                // Update media counter
                //mediaCount +=1;
                $("#media-files-count").val(mediaCount);
    
                sessionStorage.setItem("bg"+mediaCount, 'url('+e.target.result +')');

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


