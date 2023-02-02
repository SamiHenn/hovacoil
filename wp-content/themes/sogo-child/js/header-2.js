(function ($) {
    'use strict';
    $(window).load(function () {
        /**
         * mobile-menu height
         */
        var headerHeight = $('.header-2').height() + 'px';
        $('#page').css({
            'padding-top': headerHeight
        });
        console.log(headerHeight)
        setTimeout(function(){
            if (!$('body').hasClass('mobile')) {
                (function () {

                    var headerHeight = $('.header-2').height() + 'px';
                    $('#page').css({
                        'padding-top': headerHeight
                    });
                })();
            }
            console.log(headerHeight)
        }, 2000);

    });
    $(document).ready(function () {


        

        /**
         * hamburger-menu
         */
        $('.stripes-menu').click(function () {
            $('.primary-menu').toggleClass('primary-menu__hide');
            $(this).toggleClass('close-menu');
        });



    })
})(jQuery);