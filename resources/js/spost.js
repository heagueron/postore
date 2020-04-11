// Scheduled Post Spost Functions

$( document ).ready(function(e) {

    // Show New SPost Form
    $("#add_new_post").on('click', function (e) {
        //e.stopPropagation();
        e.preventDefault();
        $("#add_new_post").css("display","none");
        //$("#new-compose-title").css("display","block");
        $("#new-scheduled-post").css("display","block");
    });

    // Inmediate posting
    $("#post_now").on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        console.log("POST NOW!");
        $("#send-now-flag").val(true);
        setTimeout(() => {
            $("#submit-schedule").click();
        }, 500);
        
    });

    // Post character count
    $("#post_text").on("keyup", function(){
        let count = $(this).val().length
        //console.log(count)
        $("#post-character-count").html(count)
    })

    // Social account selector
    $(".social-selector").on('click', function(e){
        e.preventDefault
        e.stopImmediatePropagation
        if( $(e.target).hasClass('social-selector')){
            $(e.target).toggleClass('social-selector-inactive')
            $(e.target).find('i.social-selector-check').toggleClass('check-inactive')
        } else {
            $(e.target).parent().toggleClass('social-selector-inactive')
            $(e.target).parent().find('i.social-selector-check').toggleClass('check-inactive')
        }
    })

})