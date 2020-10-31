const previewControl = () => {

    var PATH = "http://127.0.0.1:8000";

    /* company_name and logo */
    const companyNameElement = document.querySelector('input[name="company_name"]');

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

    positionElement.addEventListener('keyup', function (e) {

        if( e.target.value != '') {
            document.querySelector('#preview_position_container').innerHTML = e.target.value;
        } else {
            document.querySelector('#preview_position_container').innerHTML = 'Worldwide';
        }

    });

    /* location */
    const locationsElement = document.querySelector('input[name="locations"]');

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
        localStorage.setItem("previewCategory", '');
        localStorage.setItem("previewTags", '');

    } else {
        console.log('Sorry! No Web Storage support');
    }

    const categoryElement =  document.querySelector("#categoryElement");

    // main category change event
    categoryElement.addEventListener('change', function (e) {

        if( document.querySelector(`#tag-${e.target.value}`) != null ){

            const categoryTag = document.querySelector(`#tag-${e.target.value}`).value;
            localStorage.setItem( "previewCategory", categoryTag );

        } else {
            localStorage.setItem( "previewCategory", '' );
        }
        
        renderTags();

    });

    // other tags change event 
    const tagsElement = document.querySelector('input[name="tags"]');

    tagsElement.addEventListener('keyup', function (e) {

        if( e.target.value != '') {
            console.log(e.target.value)
            localStorage.setItem( "previewTags", e.target.value );
        } else {
            console.log('no tag entered')
            localStorage.setItem("previewTags", '');
        }

        renderTags();

    });


    // render the tags array in the preview section
    const renderTags = () => {

        let tagsArray = [];

        const categoryTag = localStorage.getItem("previewCategory");
        const otherTags = localStorage.getItem("previewTags");

        if( otherTags != '') {
            tagsArray = otherTags.split(",").map( tag => tag.trim() );
        }

        if( categoryTag ) {
            tagsArray.unshift(categoryTag)
        }
        
        console.log(tagsArray)

        let previewTagsContainer = document.querySelector("#preview_tags_container");
        
        if( tagsArray.length > 0 ){            
            previewTagsContainer.innerHTML = '';
        }

        let tagsList = '';

        tagsArray.forEach( function(tag) {

            tagsList += `<span class="rp-tag-item">${tag}</span>&nbsp;&nbsp;`;

        });

        previewTagsContainer.innerHTML = tagsList;

              
    }

}
  
  // Delay to allow for elements to appear before assigning event listeners.
  setTimeout(() => {
    // Check if active url is the post a job page
    if (window.location.href.indexOf("post-a-job") > -1) {
        console.log("active url is the post a job page");
        previewControl();
    }
  }, 500);