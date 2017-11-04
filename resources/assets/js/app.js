
// /**
//  * First we will load all of this project's JavaScript dependencies which
//  * includes Vue and other libraries. It is a great starting point when
//  * building robust, powerful web applications using Vue and Laravel.
//  */

require('./bootstrap');

// window.Vue = require('vue');

// *
//  * Next, we will create a fresh Vue application instance and attach it to
//  * the page. Then, you may begin adding components to this application
//  * or customize the JavaScript scaffolding to fit your unique needs.
 

// Vue.component('example', require('./components/Example.vue'));

// const app = new Vue({
//     el: '#app',
//     created(){
//     	Echo.private(`testChannel`)
// 	    .listen('Remittance', (e) => {
// 	        console.log(e);
// 	    });
//     }
// });

// Appending the asset's base url for the background image 
var assetBaseUrl = "{{ asset('') }}";  

// Setup all AJAX requests to always pass the X-CSRF token
$.ajaxSetup({
   headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   }
});

$(function () {
    $(".preloader").fadeOut();
});

