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


    /* FOR COMPANY EDITION */
    // $('#editCompanyModal').on('show.bs.modal', function (event) {
    //     // Compose the update route
    //     const companyId = $(event.relatedTarget).data('company-id');
    //     console.log(companyId);
    //     $("#update-job-form").attr("action", `{{route('admin.companies.update',${companyId})}}`);
        
    //     // Company Name
    //     const companyName = $(event.relatedTarget).data('company-name');
    //     console.log(companyName);
    //     $(this).find("#companyNameElement").val(companyName);

    //     // Company Email
    //     const companyEmail = $(event.relatedTarget).data('company-email');
    //     console.log(companyEmail);
    //     $(this).find("#companyEmailElement").val(companyEmail);

    //     // Company Twitter
    //     const companyTwitter = $(event.relatedTarget).data('company-twitter');
    //     console.log(companTwitterl);
    //     $(this).find("#companyTwitterElement").val(companyTwitter);

    // });

    

}

const remjobControl = () => {
    /* SUMMERNOTE */
    $(function () {

        $('#description').summernote({
            placeholder: ``,
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

}

// const userControl = () => {
//     /* FOR USER DESTROY */
//     $('#destroyUserModal').on('show.bs.modal', function (event) {
//         // Compose the update route
//         const userId = $(event.relatedTarget).data('user-id');
//         console.log(userId);

//         // User Id
//         $("#user_id_to_destroy").val(userId);

//         $("#destroy-user-form").attr("action", `admin/users/${userId}`);
//         console.log($("#destroy-user-form"));
//     });
// }



  
// Delay to allow for elements to appear before assigning event listeners.
setTimeout(() => {

    // Check if active url is the post a job page
    if ( window.location.href.indexOf("admin/companies") > -1) {
        console.log("active url is: admin companies page");
        companyControl();
    }
    
    if ( window.location.href.indexOf("admin/remjobs") > -1) {
        console.log("active url is: admin remjobs page");
        if( document.getElementById("admin-update-remjob-form") ){
           document.querySelector('#app-footer').style.display = "none"; 
        }
        remjobControl();
    }

    // Check if active url is the admin users page
    // if ( window.location.href.indexOf("admin/users") > -1) {
    //     console.log("active url is: admin users page");
    //     userControl();
    // }

}, 500);