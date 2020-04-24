// Scheduled Post Spost Functions

$( document ).ready(function(e) {

    // Global to handle image nodes array
    var filesToShow3 = [];

    // Show New SPost Form
    $("#add_new_post").on('click', function (e) {
        e.preventDefault();
        $("#add_new_post").css("display","none");
        $("#new-scheduled-post").css("display","block");
    });

    // Inmediate posting
    $("#post_now").on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("#send-now-flag").val(true); // Inform the server is an inmediate posting
        setTimeout(() => {
            $("#submit-schedule").click();
        }, 500);
    });

    // Post character count - Schedule/Send Now buttons
    $("#post_text").on("keyup", function(){
        let count = $(this).val().length
        $("#post-character-count").html(count)

        if( $(this).val().length > 0 || parseInt( $("#media_files_count").val() ) > 0) {
            $("#submit-schedule").removeClass('disabled')
            $("#post_now").removeClass('disabled')
        } else{
            $("#submit-schedule").addClass('disabled')
            $("#post_now").addClass('disabled')
        }
    })

    $(".show-post-options-item").hover(
        function(){
          $(this).find('button').css("background-color", "#edf3f5");
      }, 
      function(){
        $(this).find('button').css("background-color", "#ffffff");
    });

    // Activate social profiles selector
    if ( $("#create_post_content").length || $("#edit_post_content").length ) {
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
    }

    // Activate tooltips
    $(".social-selector").tooltip()
    $(".icon-menu-option").tooltip()
    $(".fa-cog").tooltip()
    $(".fa-ellipsis-h").tooltip()
    $(".fa-retweet").tooltip()
    $(".fa-heart").tooltip()
    $(".show-date-node").tooltip()
    $(".show-social-selector").tooltip()


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

    // Show full profiles for a spost in index
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

    // Hide spost options menu and full profiles list boxes on any click
    $(document).on("click", function(e){
        $(".show-post-options-menu").each(function(){
            $(this).addClass('hidden-options-menu')
        });
        $(".show-other-profiles").each(function(){
            $(this).addClass('hidden-other-profiles')
        });
    })


    // Assign input and open local browser to select file
    $("#add-media-button3").on('click', function (e) {
        e.stopPropagation()
        e.preventDefault()
        console.log('Lets add an image bro!')

        for(let i=0; i<4; i++){
            
            let input = $(`#imageUpload${i}`)

            if( input.length && input.attr('data-assigned') == "false"){
                console.log("SELECTED input:")
                console.log(input)
                input.click()
                break
            } 
        }
    })

    const activateInputEvent3 = ( targetInput ) => {
        targetInput.change(function() {
            readURL3(this);
        })
    }

    //Remove media
    const removeMedia3 = ( element ) =>{
        console.log('remove element:')
        console.log(element)
        element.remove();

        // Update media count
        let mediaCount = parseInt( $("#media_files_count").val())
        mediaCount -=1
        $("#media_files_count").val(mediaCount)
        $(`#add-media-button2`).css('display','block')

        // Clean input set, if present.
        let targetInputId = element.attr("data-input");
        if( $(`#${targetInputId}`).length ){
            $(`#${targetInputId}`).remove()
        }
        
        // Recreates the input
        let targetName=parseInt( targetInputId.substr(11,1) ) +1;
        targetName = `media_${targetName}`;

        // Create an input for the available slot
        let newInput = $(`<input type='file' 
            id="${targetInputId}" 
            name="${targetName}"
            style="display:none"
            data-assigned="false" 
            accept=".png, .jpg, .jpeg" />`)
        newInput.appendTo("#media-files-container")
        activateInputEvent3( newInput )

        // Indicate change in media input, if editing
        if( $("#ce-selector").val() == 'edit'){
            $(`#ck-${targetName}`).val(1)
        }

        // Remove from filesToShow3 array
        const newArray = filesToShow3.filter(function(element) {
            return element.attr("data-input") != targetInputId;
        })
        filesToShow3 = newArray

        renderFiles3();
        
    }

    // Append media
    const showMedia3 = (element, heigth, width, column) => {

        let spot = filesToShow3[element].clone()

        spot.addClass('imagePreview')
        spot.css('height',heigth).css('width',width)

        if( spot.has('img') ) {
            spot.css('border-radius', '14px')
            spot.find('img').css('height',heigth).css('width',width).css('border-radius', '14px')
        }
        spot.appendTo(`#mediaColumn${column}`)
        console.log('spot creado at showMedia3:')
        console.log(spot)

        // Add remove trigger
        spot.find('i').on('click', function(e){ 
            e.preventDefault()
            e.stopImmediatePropagation();
            removeMedia3(spot)
        })

        $('.image-preview-container').css('display', 'block').removeClass('hideElement')

    }

    // Organize grid for files preview
    const renderFiles3 = () => {

        // Empty preview columns
        $("#mediaColumn1").empty()
        $("#mediaColumn2").empty()

        console.log('Organize grid for files preview /3')

        const mediaCount = filesToShow3.length;

        switch (mediaCount) {

            // showMedia3 signature: (element from filesToShow array, heigth, width, column)
            case 1:
                showMedia3(0,240,240,1);         
            break;
            case 2:
                showMedia3(0,240,110,1);
                showMedia3(1,240,110,2);
            break;
            case 3:
                showMedia3(0,240,110,1);
                showMedia3(1,110,110,2);
                showMedia3(2,110,110,2);
            break;
            case 4:
                showMedia3(0,110,110,1);
                showMedia3(1,110,110,1);
                showMedia3(2,110,110,2);
                showMedia3(3,110,110,2);
            break;
            case 0:
                console.log("No image to preview!")
                $('.image-preview-container').addClass('hideElement')
            break;
            default:
                console.log("Maximun image files count exceeded!")
            break;
        }

        // Make sure submit-update button is enabled
        $("#submit-update").removeClass('disabled')

    }

    // File image read
    function readURL3(input) {
        console.log("Ready to Read a file ... ")
        if (input.files && input.files[0]) {
            console.log(`reading new file via input: ${input.name.slice(6,7)}`)
            var reader = new FileReader()

            reader.onload = function(e) {

                // Get sub index from input and store image in session
                let subIndex = input.name.slice(6,7)

                // Build image preview node
                let spot = $(`<div>
                                <i class="far fa-times-circle removeMedia2"></i></span>
                            </div>`);
                spot.attr('data-name',`media_${subIndex}`)
                spot.attr('data-input', `imageUpload${subIndex-1}`)            
                spot.css('background-image', `url(${e.target.result})`);
 
                spot.attr('data-input',input.id);

                // Add to files array and render
                filesToShow3.push(spot);

                // Mark input as assigned
                $(`#imageUpload${subIndex-1}`).attr('data-assigned','true')

                // Signal media as 'changed', if editing
                if( $("#ce-selector").val() == 'edit'){
                   $(`#ck-media_${subIndex}`).val(1) 
                }
                
                // Update media counter
                let mediaCount = parseInt( $("#media_files_count").val() );
                mediaCount +=1;
                $("#media_files_count").val(mediaCount)
                console.log( 'media file count: '+$("#media_files_count").val() )
                if( mediaCount > 3 ) $(`#add-media-button3`).css('display','none')
                console.log('calling render3 from readUrl3')
                renderFiles3();
                
            }
            reader.readAsDataURL(input.files[0]);
        }    
    }

    /************************************
     * Create Scheduled post
     * 
     ************************************/
    if ( $("#ce-selector").val() == 'schedule'){
        // Input events
        $("#imageUpload0, #imageUpload1, #imageUpload2, #imageUpload3").change(function() {
            readURL3(this);
        })
    }

    /************************************
     * Edit Scheduled post
     * 
     ************************************/
    // Check if edit spost page is loaded
    if ( $("#ce-selector").val() == 'edit' ) {

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
            },
            complete: function () {
            }
        });

        // Adjust text positioning and count
        const trimmedText = $("#post_text").html().trim();
        $("#post_text").html(trimmedText)
        $("#post-character-count").html(trimmedText.length)

        // Show media container when there are any
        if( $("#media_files_count").val() > 0){
            $('.image-preview-container').css('display', 'block')
        }

        // Check which media files we got when edit page gets loaded
        for(let i=1; i<5; i++){
            if( $(`#ck-media_${i}`).attr('data-media-present') ){ // Media present

                // Create a clone of that media
                let media   = `media_${i}`
                let element = $(`[data-name=${media}]`).clone(true)
                element.removeClass()
                element.find('img').removeClass()

                // Insert clone in filesToShow array
                filesToShow3.push( element )

                // Activate remove event on shown media
                $(`[data-name=${media}]`).find('i').on('click', function(e){ 
                    e.preventDefault()
                    e.stopPropagation()
                    removeMedia3( $(`[data-name=${media}]`) )
                    //renderFiles3()
                })
                console.log("received this image:")
                console.log(element)

            } else{
                // Create an input for the available slot
                let newInput = $(`<input type='file' 
                    id="imageUpload${i-1}" 
                    name="media_${i}"
                    style="display:none"
                    data-assigned="false" 
                    accept=".png, .jpg, .jpeg" />`)
                newInput.appendTo("#media-files-container")
                activateInputEvent3( newInput )
                console.log("created this input:")
                console.log(newInput)
            }
        }

        // Enable submit-update button on changes
        $("#post_text").on("keyup", function(){
            $("#submit-update").removeClass('disabled')
        })

        $("#post_date").on("change", function(){
            $("#submit-update").removeClass('disabled')
        })

        $(`[name="twitter_accounts[]"]`).on("change", function(){
            $("#submit-update").removeClass('disabled')
        })
    
    }

    // Activate Twitter Profiles Options
    const setTwitterProfilesInput = (activeTwitterProfiles) => {
        activeTwitterProfiles.forEach(atp => {
            $(`#tp-${atp}`).attr('checked', true)
            $(`#tp-${atp}`).next().toggleClass('social-selector-inactive')
            $(`#tp-${atp}`).next().find('i.social-selector-check').toggleClass('check-inactive')
        });
    }


})