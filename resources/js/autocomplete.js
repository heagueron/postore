function autocomplete(inp) {

    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    var currentFocus;

    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function(e) {

        var a, b, i, val = this.value; 
        
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) { return false;}

        // let PATH;
        // // Retrieve server
        // const server = document.querySelector('#appURL').value;
        // console.log(`server: ${server}`);
        // if( server == 'http://127.0.0.1:8000' || server == 'http://localhost'){
        //   PATH = "http://127.0.0.1:8000";
        // } else {
        //   PATH = "http://142.93.119.207";
        // }
        // console.log(`PATH: ${PATH}`);

        /* GET THE OPTIONS ARRAY FROM THE SERVER */
        const PATH = document.querySelector('#appURL').value == 'https://remjob.io' ? "https://remjob.io" : "http://127.0.0.1:8000";
        console.log(document.querySelector('#appURL').value);
        console.log(`path: ${PATH}`)

        arr = [];
        fetch(`${PATH}/job_tags/${val}`)
        .then( response => response.json() )
        .then( suggestions => {

          suggestions.filtered_job_tags.map( suggestion => arr.push( suggestion.name ) );


          currentFocus = -1;

          /*create a DIV element that will contain the items (values):*/
          a = document.createElement("DIV");
          a.setAttribute("id", this.id + "autocomplete-list");
          a.setAttribute("class", "autocomplete-items");

          /*append the DIV element as a child of the autocomplete container:*/
          this.parentNode.appendChild(a);

          /*for each item in the array...*/
          for (i = 0; i < arr.length; i++) {

            /*check if the item starts with the same letters as the text field value:*/
            //if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
              
              /*create a DIV element for each matching element:*/
              b = document.createElement("DIV");
              /*make the matching letters bold:*/
              b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
              b.innerHTML += arr[i].substr(val.length);
              /*insert a input field that will hold the current array item's value:*/
              b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
              /*execute a function when someone clicks on the item value (DIV element):*/
              b.addEventListener("click", function(e) {
                  /*insert the value for the autocomplete text field:*/
                  inp.value = this.getElementsByTagName("input")[0].value;
  
                  /*close the list of autocompleted values,
                  (or any other open lists of autocompleted values:*/
                  closeAllLists();

                  // Set selected tag in the search link 
                  document.getElementById("hero-search-link")
                  .setAttribute( "href", `${PATH}/list/remote-${inp.value}-jobs` );


              });
  
              /*append the new element as a child of the options list:*/
              a.appendChild(b);
            //}
          }

        });
  
    });

    /*execute a function when someone presses a key on the keyboard:*/
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");

        if (e.keyCode == 40) {
          /*If the arrow DOWN key is pressed,
          increase the currentFocus variable:*/
          currentFocus++;
          /*and and make the current item more visible:*/
          addActive(x);

        } else if (e.keyCode == 38) { //up
          /*If the arrow UP key is pressed,
          decrease the currentFocus variable:*/
          currentFocus--;
          /*and and make the current item more visible:*/
          addActive(x);

        } else if (e.keyCode == 13) {
          /*If the ENTER key is pressed, prevent the form from being submitted,*/
          e.preventDefault();
          if (currentFocus > -1) {
            /*and simulate a click on the "active" item:*/
            if (x) x[currentFocus].click();
          }
        }
    });

    function addActive(x) {
      /*a function to classify an item as "active":*/
      if (!x) return false;

      /*start by removing the "active" class on all items:*/
      removeActive(x);
      if (currentFocus >= x.length) currentFocus = 0;
      if (currentFocus < 0) currentFocus = (x.length - 1);

      /*add class "autocomplete-active":*/
      x[currentFocus].classList.add("autocomplete-active");

    }

    function removeActive(x) {
      /*a function to remove the "active" class from all autocomplete items:*/
      for (var i = 0; i < x.length; i++) {
        x[i].classList.remove("autocomplete-active");
      }
    }

    function closeAllLists(elmnt) {
      /*close all autocomplete lists in the document,
      except the one passed as an argument:*/
      var x = document.getElementsByClassName("autocomplete-items");
      for (var i = 0; i < x.length; i++) {
        if (elmnt != x[i] && elmnt != inp) {
          x[i].parentNode.removeChild(x[i]);
        }
      }
    }

    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });


  }

  // const collapseControl = () => {

  //   // Prevent presentation of job description when click on a tag
  //   const badges = document.querySelectorAll('.job-badget');
  //   badges.forEach(function(badge) {
  //     badge.addEventListener("click", function(event){
  //       event.stopPropagation()
  //     })
  //   });


  // }

  //console.log( `CSRF_TOKEN: ${window.CSRF_TOKEN}` )
  // Delay to allow for elements to appear before assigning event listeners.
  setTimeout(() => {
    /*initiate the autocomplete function on the "myInput" element, and pass along the remote job tags array as possible autocomplete values:*/
    const autocompleteInput = document.getElementById("myInput");
    if( autocompleteInput != null ){
      autocomplete( document.getElementById("myInput") );
    }
  }, 500);
