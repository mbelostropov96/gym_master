import './bootstrap';
import jQuery from 'jquery';


window.$ = jQuery;

jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});
