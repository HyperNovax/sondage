$(function () {

    // Active le menu de la page consulté.
    let url = window.location.pathname;
    $('ul.nav a[href="'+ url +'"]').parent().addClass('active');

});