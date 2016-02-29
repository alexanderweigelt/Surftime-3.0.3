// JavaScript Document

jQuery(document).ready(function($) {
    // Inside of this function, $() will work as an alias for $()
    // and other libraries also using $ will not be accessible under this shortcut

    // Scroll Top
    $(function() {
        if(window.innerWidth >= 768){
            //Check to see if the window is top if not then display button
            $(window).scroll(function(){
                if ($(this).scrollTop() > 100) {
                    $('.scrollToTop').fadeIn();
                }
                else {
                    $('.scrollToTop').fadeOut();
                }
            });
            //Click event to scroll to top
            $('.scrollToTop').click(function(e){
                e.preventDefault();
                $('html, body').animate({scrollTop : 0},800);
                return false;
            });
        }
    });

    // Wrap Elements for responsiv Table
    $("table").wrap('<div class="table-scrollable"></div>');
});