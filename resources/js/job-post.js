// const { isUndefined } = require("lodash");

const formControl = () => {

    // let PATH;
    // // Retrieve server
    // const server = document.querySelector('#appURL').value;
    // if( server == 'http://127.0.0.1:8000' || server == 'http://localhost'){
    //   PATH = "http://127.0.0.1:8000";
    // } else {
    //   PATH = "http://142.93.119.207";
    // }

    /* GET THE OPTIONS ARRAY FROM THE SERVER */
    const PATH = document.querySelector('#appURL').value == 'https://remjob.io' ? "https://remjob.io" : "http://127.0.0.1:8000";
    console.log(document.querySelector('#appURL').value);
    console.log(`path: ${PATH}`)

    /* company_name */
    const companyNameElement = document.querySelector('input[name="company_name"]');

    // old company_name when returning from validation errors
    if( companyNameElement.value != '' ){
        document.querySelector('#preview_company_container').innerHTML = companyNameElement.value;
    }

    // company_name event
    companyNameElement.addEventListener('keyup', function (e) {

        if( e.target.value != '') {

            // Company name has data
            if( !document.querySelector('#company-logo-input').value ){
               document.querySelector('#preview_logo_container').innerHTML = ''; 
            } 
            document.querySelector('#preview_company_container').innerHTML = e.target.value;

        } else {
            // Company name empty
            if( !document.querySelector('#company-logo-input').value ){
                document.querySelector('#preview_logo_container').innerHTML = `<img src="${PATH}/storage/logos/logo1.png" alt="logo">`;
            }
            document.querySelector('#preview_company_container').innerHTML = 'Company';
        }

    });

    /* position */
    const positionElement = document.querySelector('input[name="position"]');

    // old position when returning from validation errors
    if( positionElement.value != '' ){
        document.querySelector('#preview_position_container').innerHTML = positionElement.value;
    }

    // position event
    positionElement.addEventListener('keyup', function (e) {

        if( e.target.value != '') {
            document.querySelector('#preview_position_container').innerHTML = e.target.value;
        } else {
            document.querySelector('#preview_position_container').innerHTML = 'Position';
        }

    });

    /* location */
    const locationsElement = document.querySelector('input[name="locations"]');

    // old locations when returning from validation errors
    if( locationsElement.value != '' ){
        document.querySelector('#preview_locations_container').innerHTML = locationsElement.value;
    }

    // position event
    locationsElement.addEventListener('keyup', function (e) {

        if( e.target.value != '') {
            document.querySelector('#preview_locations_container').innerHTML = e.target.value;
        } else {
            document.querySelector('#preview_locations_container').innerHTML = 'Worlwide';
        }

    });

    /* tags */
    if (typeof(Storage) !== "undefined") {

        // renders the tags array (from the Storage).
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
    
        if( [2,3,4,5,6].includes( Number( categoryElement.value ) ) ){
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
                // console.log(e.target.value)
                sessionStorage.previewTags = e.target.value;
            } else {
                // console.log('no tag entered')
                sessionStorage.previewTags = '';
            }

            renderTags();

        });


        /* logo */
    
        const logoInput = document.querySelector('input[name="company_logo"]');

        // old logo when returning from validation errors
        if( document.body.contains(document.querySelectorAll('.rp-group__error')[0]) && sessionStorage.logo.length > 100 ) {
            console.log('document has errors and got a logo');
            console.log(`sessionStorage.logo: ${sessionStorage.logo.length}`)
            document.querySelector("#company-logo-container").style.backgroundImage = `url(${sessionStorage.logo})`;
            const previewLogo = `<img src="${sessionStorage.logo}" alt="logo" id="preview-logo" class="w-100">`;
            document.querySelector("#preview_logo_container").innerHTML = previewLogo;
        } else {
            console.log('document doesnt have errors or doesnt get a logo');
            // If there are no errors, we must ensure to enter the form without logo image.
            logoInput.value = null;
            sessionStorage.logo = null;
            const previewLogo = `<img src="${PATH}/storage/logos/nologo.png" alt="logo" id="preview-logo" class="w-100">`;
            document.querySelector("#preview_logo_container").innerHTML = previewLogo;
        }

        // logo event
        logoInput.addEventListener('change', function() {
            readURL(this);
        })

        const readURL = (input) => {

            if ( input.files && input.files[0] ){
                var reader = new FileReader();
                reader.onload = function(e){
                    
                    // show main logo
                    document.querySelector("#company-logo-container").style.backgroundImage = `url(${e.target.result})`;

                    // show logo on preview row, if plan is not free
                    if( !document.querySelector('#plan-free').checked ){
                        const previewLogo = `<img src="${e.target.result}" alt="logo" id="preview-logo" class="w-100">`;
                        document.querySelector("#preview_logo_container").innerHTML = previewLogo;
                    }
                    
                    // store logo in session
                    sessionStorage.logo = e.target.result;
                    console.log(sessionStorage.logo.length)
                }
                reader.readAsDataURL(input.files[0]);
            }
        }


    } else {
        alert( `Sorry! No Web Storage support. Please use one of the following browsers and versions or a newer one:
                Chrome 4.0 | Explorer 8.0 | FireFox 3.5 | Safari 4.0 | Opera 11.5` );
    }


    // link or email to apply
    // make sure radio input and text input match
    if ( document.querySelector('#apply-link').checked == true ) {
        document.getElementById('apply-email-input').style.display="none";
        document.getElementById('apply-link-input').style.display="block";
        document.getElementById('apply-mode-info').innerHTML = 'The job apply link.'
    } else {
        document.getElementById('apply-link-input').style.display="none";
        document.getElementById('apply-email-input').style.display="block";
        document.getElementById('apply-mode-info').innerHTML = 'The job apply email.'
    }

    // apply_mode change event
    const applyRadios = document.querySelectorAll('input[name="apply_mode"]');

    for (let i = 0; i < applyRadios.length; i++) 
    {
        applyRadios[i].addEventListener('change', function() {
            console.log(`change!: ${this.value}`);
            if ( this.value == 'link') {
                document.getElementById('apply-email-input').style.display="none";
                document.getElementById('apply-link-input').style.display="block";
                document.getElementById('apply-mode-info').innerHTML = 'The job apply link.'
            } else {
                document.getElementById('apply-link-input').style.display="none";
                document.getElementById('apply-email-input').style.display="block";
                document.getElementById('apply-mode-info').innerHTML = 'The job apply email.'
            }
        });
    }

    // plan change event
    const planRadios = document.querySelectorAll('input[name="plan_id"]');

    for (let i = 0; i < planRadios.length; i++) 
    {
        planRadios[i].addEventListener('change', function() {
            // console.log(`change!: ${this.value}`);
            const cards = document.querySelectorAll('.card-price-element');
            for (let i = 0; i < cards.length; i++){
                cards[i].style.border = 'none';
            }
            if( this.checked ){
                this.parentElement.style.border = '4px solid yellow';
            }

            const jobPreviewContainer =  document.getElementById('job-preview-container');

            if(this.value == 1){ // Free Plan
                
                // Set preview nologo
                document.querySelector('#preview_logo_container').innerHTML = `<img src="${PATH}/storage/logos/nologo.png" alt="logo" id="preview-logo" class="w-100">`;
                
                // Set preview background standard
                console.log('bg grey')
                jobPreviewContainer.style.backgroundColor = '#f9f9f9';

            } else { // A Paid Plan

                if( sessionStorage.logo.length > 100 ) {

                    const previewLogo = `<img src="${sessionStorage.logo}" alt="logo" id="preview-logo" class="w-100">`;
                    document.querySelector("#preview_logo_container").innerHTML = previewLogo;
                    
                }

                // Set preview background highlight
                console.log('bg yellow')
                jobPreviewContainer.style.backgroundColor = '#ffffb3';

            }
        });
    }


    /*const getCompanyByEmail = ( ) => {
        
        email = companyEmailElement = document.querySelector('#companyEmailElement').value;
        console.log(`change! email entered: ${email}`);

        fetch(`${PATH}/companies/search_company_by_email/${email}`)
        .then( response => response.json() )
        .then( result => {
            console.log(result)
            if( result.company ) {
                console.log( 'company email already registered' );
                document.querySelector('#companyNameElement').value = result.company.name;
                document.querySelector('#companyIdElement').value = result.company.id;
                if( result.company.twitter ){
                   document.querySelector('#companyTwitterElement').value = result.company.twitter; 
                }
            } else {
                console.log( 'company email NOT registered yet' );
            }
        });
    }*/

    // Get company data from database
    /*companyEmailElement = document.querySelector('#companyEmailElement');
    companyEmailElement.addEventListener('change', getCompanyByEmail);*/

    /* SUMMERNOTE */
    $(function () {

        function getSummernotePalceholder(lang){
            const msg = {
                en: 'Enter your remote job description',
                es: 'Ingrese la descripcion del trabajo remoto'
            }
            return msg[lang];
        }
    
        $('#description').summernote({
            placeholder: `${getSummernotePalceholder(document.querySelector('#localeElement').value)}`,
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['help']]
              ]
          });
    
    })

}
  
// Delay to allow for elements to appear before assigning event listeners.
setTimeout(() => {

    // Check if active url is the post a job page
    if ( window.location.href.indexOf("post-a-job") > -1 ) {
        document.querySelector('#app-footer').style.display = "none";
        console.log("active url is: the post a job page");
        formControl();
    } 
    
    if( window.location.href.indexOf("checkout") > -1 ) {
        console.log('On checkout page ... ');
    }

}, 500);