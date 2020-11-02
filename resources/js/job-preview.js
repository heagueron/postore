const previewControl = () => {

    var PATH = "http://127.0.0.1:8000";

    /* company_name */
    const companyNameElement = document.querySelector('input[name="company_name"]');

    // old values used when returning from validation errors
    if( companyNameElement.value != '' ){
        document.querySelector('#preview_company_container').innerHTML = companyNameElement.value;
        document.querySelector('#preview_logo_container').innerHTML = '';
    }

    companyNameElement.addEventListener('keyup', function (e) {
        
        if( e.target.value != '') {
            document.querySelector('#preview_logo_container').innerHTML = ''
            document.querySelector('#preview_company_container').innerHTML = e.target.value;
        } else {
            document.querySelector('#preview_logo_container').innerHTML = `<img src="${PATH}/storage/logos/logo1.png" alt="logo">`
            document.querySelector('#preview_company_container').innerHTML = 'Company';
        }

    });

    /* position */
    const positionElement = document.querySelector('input[name="position"]');

    // old values used when returning from validation errors
    if( positionElement.value != '' ){
        document.querySelector('#preview_position_container').innerHTML = positionElement.value;
    }

    positionElement.addEventListener('keyup', function (e) {

        if( e.target.value != '') {
            document.querySelector('#preview_position_container').innerHTML = e.target.value;
        } else {
            document.querySelector('#preview_position_container').innerHTML = 'Worldwide';
        }

    });

    /* location */
    const locationsElement = document.querySelector('input[name="locations"]');

    // old values used when returning from validation errors
    if( locationsElement.value != '' ){
        document.querySelector('#preview_locations_container').innerHTML = locationsElement.value;
    }

    locationsElement.addEventListener('keyup', function (e) {

        if( e.target.value != '') {
            document.querySelector('#preview_locations_container').innerHTML = e.target.value;
        } else {
            document.querySelector('#preview_locations_container').innerHTML = 'Worlwide';
        }

    });

    /* tags */

    if (typeof(Storage) !== "undefined") {

        // Code for localStorage/sessionStorage.

        // renders the tags array (from the Storage) in the preview section
        const renderTags = () => {

            let tagsArray = [];

            const categoryTag = sessionStorage.previewCategory;
            const otherTags = sessionStorage.previewTags;

            if( otherTags != '') {
                tagsArray = otherTags.split(",").map( tag => tag.trim() );
            }

            if( categoryTag ) {
                tagsArray.unshift(categoryTag)
            }
            
            // console.log(tagsArray)
            let previewTagsContainer = document.querySelector("#preview_tags_container");
            let tagsList = '';

            if( tagsArray.length == 0){

                [1,2,3].forEach( function(number) {
                    tagsList += `<span class="rp-tag-item">Tag${number}</span>&nbsp;&nbsp;`;  
                });

            } else {
                tagsArray.forEach( function(tag) {
                    if( tag != ''){
                    tagsList += `<span class="rp-tag-item">${tag}</span>&nbsp;&nbsp;`;  
                    }
                });
            }

            previewTagsContainer.innerHTML = tagsList;
 
        }

        const categoryElement =  document.querySelector("#categoryElement");
    
        if( [2,3,4,5,6].includes(Number(categoryElement.value)) ){
            // A category is selected
            sessionStorage.previewCategory = document.querySelector(`#tag-${categoryElement.value}`).value;
        } else {
            sessionStorage.previewCategory = '';
        }

        const tagsElement = document.querySelector('input[name="tags"]');
        sessionStorage.previewTags = tagsElement.value;

        renderTags();

        // main category change event

        categoryElement.addEventListener('change', function (e) {

            if( document.querySelector(`#tag-${e.target.value}`) != null ){

                const categoryTag = document.querySelector(`#tag-${e.target.value}`).value;
                sessionStorage.previewCategory = categoryTag;

            } else {
                sessionStorage.previewCategory = '';
            }
            
            renderTags();

        });

        // other tags change event 

        tagsElement.addEventListener('keyup', function (e) {

            if( e.target.value != '') {
                console.log(e.target.value)
                sessionStorage.previewTags = e.target.value;
            } else {
                console.log('no tag entered')
                sessionStorage.previewTags = '';
            }

            renderTags();

        });


    } else {
        console.log('Sorry! No Web Storage support');
    }

    /* logo */
    
    const logoInput = document.querySelector('input[name="company_logo"]');
    logoInput.addEventListener('change', function() {
        readURL(this);
    })

    const readURL = (input) => {

        if ( input.files && input.files[0] ){
            var reader = new FileReader();
            reader.onload = function(e){
                document.querySelector("#company-logo-container").style.backgroundImage = `url(${e.target.result})`;
                document.querySelector("#preview-logo").setAttribute("src", e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

}
  
// Delay to allow for elements to appear before assigning event listeners.
setTimeout(() => {
    // Check if active url is the post a job page
    if ( window.location.href.indexOf("post-a-job") > -1 ) {
        console.log("active url is: the post a job page");
        previewControl();
    }
}, 500);