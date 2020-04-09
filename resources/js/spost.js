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
    $('#post_now').on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        console.log("POST NOW!");
        $("#send-now-flag").val(true);
        setTimeout(() => {
            $("#submit-schedule").click();
        }, 500);
        
    });

    $("#post_text").on("keyup", function(){
        let count = $(this).val().length
        //console.log(count)
        $("#post-character-count").html(count)
    })

})