/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Sposts globals and functions
 */
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var PATH = "http://127.0.0.1:8000";
//require('./spost');
require('./autocomplete');
require('./job-post');
require('./admin');
require('./summernote');
require('./jquery-nice-select');

window.Vue = require('vue');

/**
 * Handle events for flash messages
 */

window.events = new Vue();
 
window.flash = function (message) {
    window.events.$emit('flash', message)
};


// DatetimePicker (vue component);
import datetime from 'vuejs-datetimepicker';


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('flash', require('./components/Flash.vue').default);
Vue.component('fail', require('./components/Fail.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: {
        datetime
    }
});


/* Activate bootstrap tooltips */
$('[data-toggle="tooltip"]').tooltip()

/* nav background transparency */
function navBackgroundControl() {
  if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
    document.getElementById("app-nav").classList.remove('bg-transparent');
    document.getElementById("app-nav").classList.add('one-edge-shadow');
  } else {
    document.getElementById("app-nav").classList.add('bg-transparent');
    document.getElementById("app-nav").classList.remove('one-edge-shadow');
  }
}


/* Categories in Jquery Nice Selector */
// function categoryControl() {

//   console.log('executin categoryControl ... ')

//   $(document).ready(function() {
//     $('#selectCategory').niceSelect();
//   });

//   $('#selectCategory').change(function () {
    
    // const PATH = document.querySelector('#appURL').value == 'https://remjob.io' ? "https://remjob.io" : "http://127.0.0.1:8000";
    // console.log(`App URL From DOM: ${document.querySelector('#appURL').value}`);
    // console.log(`PATH: ${PATH}`)

    // console.log('SELECTION: '+this.value);

    // if( this.value != ''){
    //   window.location.href = `${PATH}/list/remote_${this.value}_jobs`
    // } else {
    //   window.location.href = `${PATH}`
    // }
//   })
// }


/* NICER SELECT W3 */
const rjCategoryControl = () => {
  
  console.log('starting rjCategoryControl ...');

  var x, i, j, l, ll, selElmnt, a, b, c;
  /*look for any elements with the class "rj-custom-select":*/
  x = document.getElementsByClassName("rj-custom-select");
  l = x.length;

  for (i = 0; i < l; i++) {
    selElmnt = x[i].getElementsByTagName("select")[0];
    ll = selElmnt.length;
    /*for each element, create a new DIV that will act as the selected item:*/
    a = document.createElement("DIV");
    a.setAttribute("class", "rj-select-selected");
    a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
    x[i].appendChild(a);
    /*for each element, create a new DIV that will contain the option list:*/
    b = document.createElement("DIV");
    b.setAttribute("class", "rj-select-items rj-select-hide");

    for (j = 1; j < ll; j++) {
      /*for each option in the original select element,
      create a new DIV that will act as an option item:*/
      c = document.createElement("DIV");
      c.innerHTML = selElmnt.options[j].innerHTML;
      c.setAttribute("data-tag", selElmnt.options[j].value);

      c.addEventListener("click", function(e) { 	
        /*when an item is clicked, update the original select box,
        and the selected item:*/
        var y, i, k, s, h, sl, yl;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        sl = s.length;
        h = this.parentNode.previousSibling;
        
        for (i = 0; i < sl; i++) {

          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            yl = y.length;

            for (k = 0; k < yl; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }//
          
        }

        const tag = this.getAttribute("data-tag");

        console.log(tag);
        
        h.click();

        console.log('right after hclick');

        // NAVIGATE TO SELECTED CATEGORY:
        const PATH = document.querySelector('#appURL').value == 'https://remjob.io' ? "https://remjob.io" : "http://127.0.0.1:8000";

        console.log(`PATH: ${PATH}`)

        console.log('SELECTION: '+tag);

        if( tag != ''){
          window.location.href = `${PATH}/list/remote_${tag}_jobs`
        } else {
          window.location.href = `${PATH}`
        }



    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
      /*when the select box is clicked, close any other select boxes,
      and open/close the current select box:*/
      e.stopPropagation();
      closeAllSelect(this);
      this.nextSibling.classList.toggle("rj-select-hide");
      this.classList.toggle("select-arrow-active");
    });
}
  function closeAllSelect(elmnt) {
    /*a function that will close all select boxes in the document,
    except the current select box:*/
    var x, y, i, xl, yl, arrNo = [];
    x = document.getElementsByClassName("rj-select-items");
    y = document.getElementsByClassName("rj-select-selected");
    xl = x.length;
    yl = y.length;
    for (i = 0; i < yl; i++) {
      if (elmnt == y[i]) {
        arrNo.push(i)
      } else {
        y[i].classList.remove("select-arrow-active");
      }
    }
    for (i = 0; i < xl; i++) {
      if (arrNo.indexOf(i)) {
        x[i].classList.add("rj-select-hide");
      }
    }
  }
  /*if the user clicks anywhere outside the select box,
  then close all select boxes:*/
  document.addEventListener("click", closeAllSelect);
}





if ( window.location.href.indexOf("admin") <= -1) {
  /* Not in admin routes */

  navBackgroundControl();
  window.onscroll = function() {navBackgroundControl()};

}

// if( document.getElementById("selectCategory") ){
//   categoryControl();
// }


// Delay to allow for elements to appear.
setTimeout(() => {

  const newLocal = "rj-hero";
  if( document.getElementById(newLocal) ){
    console.log('Detected presence of Hero ... ');
    rjCategoryControl();
  }

}, 50);










