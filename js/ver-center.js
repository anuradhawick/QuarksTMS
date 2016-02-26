/*
 Coded by W.A. Anuradha Wickramarachchi
 
 to be only used for the first page which is the login page
 */
jQuery(document).ready(function ($) {
    var height = $(window).height();
    var divHeight = $('.ver-center').height();
    if (height > divHeight) {
        $('.ver-center').css('margin-top', (height - divHeight) / 2 - 50);
    }
    ;
    $(window).resize(function (event) {
        var height = $(window).height();
        var divHeight = $('.ver-center').height();
        if (height > divHeight + 90) {
            $('.ver-center').css('margin-top', (height - divHeight) / 2 - 50);
        } else {
            $('.ver-center').css('margin-top', 20);
            $('.ver-center').css('margin-bottom', 60);
        }
    });
});