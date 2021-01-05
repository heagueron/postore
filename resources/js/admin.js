// const { isUndefined } = require("lodash");

const companyControl = () => {

    /* GET THE OPTIONS ARRAY FROM THE SERVER */
    // const PATH = document.querySelector('#appURL').value == 'https://remjob.io' ? "https://remjob.io" : "http://127.0.0.1:8000";
    // console.log(`App URL From DOM: ${document.querySelector('#appURL').value}`);
    // console.log(`PATH: ${PATH}`)

    /* company_name */
    const companyNameElement = document.querySelector('input[name="company_name"]');

    /* logo */
    if (typeof(Storage) !== "undefined") {

        
    
        sessionStorage.logo = null;
        
        const logoInput = document.querySelector('input[name="company_logo"]');


        // logo event
        logoInput.addEventListener('change', function() {
            readURL(this);
        })

        const readURL = (input) => {

            if ( input.files && input.files[0] ){
                var reader = new FileReader();
                reader.onload = function(e){
                    // console.log('logo file already read.');
                    // console.log(`url(${e.target.result})`);
                    // show main logo
                    document.querySelector("#company-logo-container").style.backgroundImage = `url(${e.target.result})`;
                    
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


}
  
// Delay to allow for elements to appear before assigning event listeners.
setTimeout(() => {

    // Check if active url is the post a job page
    if ( window.location.href.indexOf("admin") > -1) {
        console.log("active url is: admin dashboard page");
        companyControl();
    } 


}, 500);