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

    // Edit Scheduled post
    // Check if edit spost page is loaded
    if ( $(".edit-spost").length ) {

        // Grab the social profiles
        const spostId = $(".edit-spost").attr('id').slice(5);

        let PATH = "http://localhost:8000/";
        $.ajax({
            url : `${PATH}sposts/detail/${spostId}` ,
            type : "GET",
            data: {},
            dataType : 'json',
            beforeSend: function(){
            },
            success : function(response) {
                setTwitterProfilesInput(response.activeTwitterProfiles)
                // const imageArray = [];
                // if (response.strMedia1){ imageArray.push(response.strMedia1)}
                // if (response.strMedia2){ imageArray.push(response.strMedia2)}
                // if (response.strMedia3){ imageArray.push(response.strMedia3)}
                // if (response.strMedia4){ imageArray.push(response.strMedia4)}
                // //console.log(imageArray)
                // if(imageArray.length > 0) setMedia(imageArray) 
            },
            complete: function () {
            }
        });

        // Adjust text positioning and count
        const trimmedText = $("#post_text").html().trim();
        $("#post_text").html(trimmedText)
        $("#post-character-count").html(trimmedText.length)
    
    }

    // Activate Twitter Profiles Options
    const setTwitterProfilesInput = (activeTwitterProfiles) => {
        activeTwitterProfiles.forEach(atp => {
            $(`#tp-${atp}`).attr('checked', true)
            $(`#tp-${atp}`).next().toggleClass('social-selector-inactive')
            $(`#tp-${atp}`).next().find('i.social-selector-check').toggleClass('check-inactive')
        });
    }

    // Activate tooltips
    $(".social-selector").tooltip()
    $(".icon-menu-option").tooltip()
    $(".fa-cog").tooltip()
    $(".fa-ellipsis-h").tooltip()


    // Show spost options menu
    $(".show-post-options-trigger").on("click", function(e){
        e.stopPropagation()
        e.preventDefault()
        $(".show-post-options-menu").each(function(){
            $(this).addClass('hidden-options-menu')
        })
        $(".show-other-profiles").each(function(){
            $(this).addClass('hidden-other-profiles')
        });
        $(this).next().removeClass('hidden-options-menu')
    })

    // Show other profiles for a spost in index
    $(".show-other-profiles-trigger").on("click", function(e){
        e.stopPropagation()
        e.preventDefault()
        $(".show-other-profiles").each(function(){
            $(this).addClass('hidden-other-profiles')
        })
        $(".show-post-options-menu").each(function(){
            $(this).addClass('hidden-options-menu')
        });
        $(this).next().removeClass('hidden-other-profiles')
    })

    // Hide spost options menu on any click
    $(document).on("click", function(e){
        $(".show-post-options-menu").each(function(){
            $(this).addClass('hidden-options-menu')
        });
        $(".show-other-profiles").each(function(){
            $(this).addClass('hidden-other-profiles')
        });
    })

})