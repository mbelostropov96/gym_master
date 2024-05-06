import './bootstrap';
import jQuery from 'jquery';


window.$ = jQuery;

jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
    $(".rating").rating({min:1, max:10, step:2, size:'lg', showCaption: false});
});
