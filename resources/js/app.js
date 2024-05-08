import jQuery from 'jquery';
import './bootstrap';
import './statistics-chart.js';

window.$ = jQuery;

jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});
