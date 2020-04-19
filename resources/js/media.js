// Media files

$( document ).ready(function(e) {

    var filesToRender   =   [];
    sessionStorage.clear();

    $("#add-media-button").on('click', function (e) {
        //e.stopPropagation()
        e.preventDefault()
        //console.log(e)
        let mediaCount = parseInt( $("#media_files_count").val())
        if( mediaCount < 4 ) {

            for(let i=1; i<5; i++){

                if( !sessionStorage.getItem(`bg${i}`) ) {
                    let targetInput = $(`#imageUpload${i-1}`)
                    targetInput.click()
                    break
                }  

            }

        } else {
            console.log("Maximum media file number reached.")
        }

    })

    function readURL(input) {
        
        if (input.files && input.files[0]) {

            var reader = new FileReader();

            let mediaCount = parseInt( $("#media_files_count").val());
            mediaCount +=1;

            reader.onload = function(e) {

                // Get sub index from input and store image in session
                let subIndex = input.name.slice(6,7);
                sessionStorage.setItem(`bg${subIndex}`, 'url('+e.target.result +')');

                // Build image preview node
                let bg = sessionStorage.getItem(`bg${subIndex}`);
                let spot = $(`<div class="imagePreview">
                                <i class="far fa-times-circle removeMedia"></i></span>
                            </div>`);
                spot.css('background-image', bg);
                spot.attr('data-session-key',`bg${subIndex}`);
                spot.attr('data-input',input.id);

                // Add to files array and render
                filesToRender.push(spot);
                renderFiles();

                // Update media counter
                $("#media_files_count").val(mediaCount);

                // Make sure schedule and post_now buttons get enabled
                $("#submit-schedule").removeClass('disabled')
                $("#post_now").removeClass('disabled')
            }
            reader.readAsDataURL(input.files[0]);
        }    
    }

    

    // When a image is removed, its input is re-created,
    // and looses its change handler. Here it is restored
    const activateInputEvent = ( targetInput ) => {
        targetInput.change(function() {
            readURL(this);
        })
    }


    // Input events
    $("#imageUpload0, #imageUpload1, #imageUpload2, #imageUpload3").change(function() {
        readURL(this);
    })

    // Show media file
    const showMedia = (element, position, heigth, width, column) => {
        if ( $(`*[data-preview-position=${position}]`).length ) {
            $(`*[data-preview-position=${position}]`).remove()
        }
        let spot = filesToRender[element]
        spot.attr("data-preview-position", position)
        spot.css('height',heigth).css('width',width)
        spot.appendTo(`#previewColumn${column}`);

        spot.children().on('click', function(e){ 
            e.preventDefault();
            e.stopImmediatePropagation();
            removeMedia(spot);
        })
    }

    // Organize grid for files preview
    const renderFiles = () => {



        const mediaCount = filesToRender.length;

        switch (mediaCount) {

            // showMedia signature: (element from filesToRender array, position, heigth, width, column)
            case 1:
                showMedia(0,1,240,240,1);         
            break;
            case 2:
                showMedia(0,1,240,115,1);
                showMedia(1,2,240,115,2);
            break;
            case 3:
                showMedia(0,1,240,115,1);
                showMedia(1,2,115,115,2);
                showMedia(2,4,115,115,2);
            break;
            case 4:
                showMedia(0,1,115,115,1);
                showMedia(1,3,115,115,1);
                showMedia(2,2,115,115,2);
                showMedia(3,4,115,115,2);
            break;
            case 0:
                console.log("No image to preview /1 !")
            break;
            default:
                console.log("Maximun image files count exceeded!")
            break;
        }
        $(".avatar-preview").css("display","block");
    }

    const removeMedia = ( element ) =>{

        element.remove();

        // Update media count
        let mediaCount = parseInt( $("#media_files_count").val())
        mediaCount -=1
        $("#media_files_count").val(mediaCount)

        if( mediaCount < 1 && ( $("#post_text").val().length < 1) ){ // Disable schedule and post_now buttons
            $("#submit-schedule").addClass('disabled')
            $("#post_now").addClass('disabled')
        }

        // Remove from session
        let key = element.attr("data-session-key");
        sessionStorage.removeItem(key);

        // Clean input set:
        let targetInputId = element.attr("data-input");
        $(`#${targetInputId}`).remove();

        let targetName=parseInt( targetInputId.substr(11,1) ) +1;
        targetName = `media_${targetName}`;
        let newInput = $(`<input type='file' 
            id="${targetInputId}" 
            name="${targetName}"
            style="display:none" 
            accept=".png, .jpg, .jpeg" />`)
        newInput.appendTo("#media-files-container");

        activateInputEvent( newInput )

        // Remove from filesToRender array
        const newArray = filesToRender.filter(function(element) {
            return element.attr("data-session-key") != key;
        })
        filesToRender = newArray
        renderFiles();
        
    }

    /**********************************************
     * Functions for editing media
     * 
     **********************************************/

    //filesToRender   =   [];
    var filesToShow = [];

    // Assign input and open local browser to select file
    $("#add-media-button2").on('click', function (e) {
        //e.stopPropagation()
        e.preventDefault()
        console.log('Lets edit!')

        for(let i=0; i<4; i++){
            let input = $(`#imageUpload${i}`)
            if( input.length && input.attr('data-assigned') == "false"){
                console.log(input)
                input.click()
                break
            } 
        }

    })

    // Remove media
    const removeMedia2 = ( element ) =>{
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
        activateInputEvent2( newInput )

        // Indicate change in media input:
        $(`#ck-${targetName}`).val(1)

        // Remove from filesToShow array
        const newArray = filesToShow.filter(function(element) {
            return element.attr("data-input") != targetInputId;
        })
        filesToShow = newArray

        renderFiles2();
        
    }

    // Append media
    const showMedia2 = (element, heigth, width, column) => {

        let spot = filesToShow[element].clone()

        spot.css('height',heigth).css('width',width)
        spot.addClass('imagePreview')

        if( spot.has('img') ) {
            spot.css('border-radius', '14px')
            spot.find('img').css('height',heigth).css('width',width).css('border-radius', '14px')
        }
        spot.appendTo(`#mediaColumn${column}`)

        spot.find('i').on('click', function(e){ 
            e.preventDefault()
            e.stopImmediatePropagation();
            removeMedia2(spot)
        })

    }

    // Organize grid for files preview
    const renderFiles2 = () => {

        // Empty preview columns
        $("#mediaColumn1").empty()
        $("#mediaColumn2").empty()

        console.log('Organize grid for files preview /2')

        const mediaCount = filesToShow.length;

        switch (mediaCount) {

            // showMedia2 signature: (element from filesToShow array, heigth, width, column)
            case 1:
                showMedia2(0,240,240,1);         
            break;
            case 2:
                showMedia2(0,240,110,1);
                showMedia2(1,240,110,2);
            break;
            case 3:
                showMedia2(0,240,110,1);
                showMedia2(1,110,110,2);
                showMedia2(2,110,110,2);
            break;
            case 4:
                showMedia2(0,110,110,1);
                showMedia2(1,110,110,1);
                showMedia2(2,110,110,2);
                showMedia2(3,110,110,2);
            break;
            case 0:
                console.log("No image to preview!")
            break;
            default:
                console.log("Maximun image files count exceeded!")
            break;
        }

        // Make sure submit-update button is enabled
        $("#submit-update").removeClass('disabled')

    }


    // File image read
    function readURL2(input) {
        console.log("Ready to Reading file when editing")
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
                filesToShow.push(spot);

                // Mark input as assigned
                $(`#imageUpload${subIndex-1}`).attr('data-assigned','true')

                // Signal media as 'changed'
                $(`#ck-media_${subIndex}`).val(1)

                // Update media counter
                let mediaCount = parseInt( $("#media_files_count").val());
                mediaCount +=1;
                $("#media_files_count").val(mediaCount);
                if( mediaCount > 3 ) $(`#add-media-button2`).css('display','none')

                renderFiles2();
                
            }
            reader.readAsDataURL(input.files[0]);
        }    
    }

    const activateInputEvent2 = ( targetInput ) => {
        targetInput.change(function() {
            readURL2(this);
        })
    }

    // Check if edit spost page is loaded
    if ( $(".edit-spost").length ) {

        // Adjust text positioning and count
        const trimmedText = $("#post_text").html().trim();
        $("#post_text").html(trimmedText)
        $("#post-character-count").html(trimmedText.length)


        // Check which media files we got when edit page loaded
        for(let i=1; i<5; i++){
            if( $(`#ck-media_${i}`).attr('data-media-present') ){ // Media present

                // Create a clone of that media
                let media   = `media_${i}`
                let element = $(`[data-name=${media}]`).clone(true)
                element.removeClass()
                element.find('img').removeClass()

                // Insert clone in filesToShow array
                filesToShow.push( element )

                // Activate remove event on shown media
                $(`[data-name=${media}]`).find('i').on('click', function(e){ 
                    e.preventDefault()
                    e.stopPropagation()
                    removeMedia2( $(`[data-name=${media}]`) )
                    renderFiles2()
                })

            } else{
                // Create an input for the available slot
                let newInput = $(`<input type='file' 
                    id="imageUpload${i-1}" 
                    name="media_${i}"
                    style="display:none"
                    data-assigned="false" 
                    accept=".png, .jpg, .jpeg" />`)
                newInput.appendTo("#media-files-container")
                activateInputEvent2( newInput )
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

})