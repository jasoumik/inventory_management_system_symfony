/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */




// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import './styles/date-picker.css';


// start the Stimulus application

// require jQuery normally
import $ from 'jquery';
import jquery from 'jquery';
 //const $ = require('jquery');
 global.$=$;
 // import './js/popper.js';
 // import '@popperjs/core';
import 'bootstrap';
import 'select2';
import "ag-grid";


import 'bootstrap-datepicker';

import './js/CustomDate';

$('#b').on('click',function ()
{
    swal({
        title: "Created Successfully!",
        text: "",
        icon: "success",
    })
})


// create global $ and jQuery variables

