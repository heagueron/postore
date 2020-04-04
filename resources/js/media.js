// Media files

$( document ).ready(function(e) {

    $("#add-media-button").on('click', function (e) {
        e.stopPropagation()
        e.preventDefault()
        console.log("More media?")

        let mediaCount = parseInt( $("#media-files-count").val())
        console.log(`mediaCount when clicked: ${mediaCount}`)

        if( mediaCount < 4 ) {

            for(let i=1; i<5; i++){
                console.log(`bg${i}`, sessionStorage.getItem(`bg${i}`) )

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

    var filesToRender   =   [];
    sessionStorage.clear();

    function readURL(input) {
        
        if (input.files && input.files[0]) {

            var reader = new FileReader();

            let mediaCount = parseInt( $("#media-files-count").val());
            mediaCount +=1;

            reader.onload = function(e) {

                // Get sub index from input and store image in session
                let subIndex = input.name.slice(6,7);
                console.log(subIndex)
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
                $("#media-files-count").val(mediaCount);
            }
            reader.readAsDataURL(input.files[0]);
        }    
    }


    // Input events
    $("#imageUpload0").change(function() {
        console.log("Opening at input media 1")
        readURL(this);
    })
    $("#imageUpload1").change(function() {
        console.log("Opening at input media 2")
        readURL(this);
    })
    $("#imageUpload2").change(function() {
        console.log("Opening at input media 3")
        readURL(this);
    })
    $("#imageUpload3").change(function() {
        console.log("Opening at input media 4")
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
        //console.log(spot)
        spot.appendTo(`#previewColumn${column}`);
        console.log(`appended in position ${position} the media:`)
        console.log(spot)
        spot.children().on('click', function(e){ 
            e.preventDefault();
            e.stopImmediatePropagation();
            removeMedia(spot);
        })
    }

    // Organize grid for files preview
    const renderFiles = () => {

        const mediaCount = filesToRender.length;
        console.log("files to render: "+mediaCount)

        switch (mediaCount) {

            // showMedia signature: (element, position, heigth, width, column)
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
                console.log("No image to preview!")
            break;
            default:
                console.log("Maximun image files count exceeded!")
            break;
        }
        $(".avatar-preview").css("display","block");
    }

    const removeMedia = ( element ) =>{
        console.log("element to remove:")
        console.log(element)

        element.remove();

        // Update media count
        let mediaCount = parseInt( $("#media-files-count").val())
        mediaCount -=1
        $("#media-files-count").val(mediaCount)

        // Remove from session
        let key = element.attr("data-session-key");
        sessionStorage.removeItem(key);
        console.log(`Removed session key ${key}`)
        console.log(`Remains there: ${sessionStorage.getItem(key)}`)

        // Remove from filesToRender array
        const newArray = filesToRender.filter(function(element) {
            return element.attr("data-session-key") != key;
        })
        filesToRender = newArray
        renderFiles();
        
    }

})