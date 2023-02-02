(function ($) {
    'use strict';
    var body = $('body');
    //show mobile menu on smaller than 1024 screen width
    function handleWindowResize() {
        var windowWidth = $(window).width();

        if (windowWidth <= 991) {
            $('.menu-desktop-manipulation').addClass('d-none');
            $('.menu-mobile-manipulation').removeClass('d-none');
            body.addClass('mobile-resized').removeClass('desktop');
        }

        if (windowWidth >= 991) {
            $('.menu-desktop-manipulation').removeClass('d-none');
            $('.menu-mobile-manipulation').addClass('d-none');
            if (!body.hasClass('mobile', 'mobile-resized')) {
                body.removeClass('mobile-resized').addClass('desktop').removeClass('opened-menu');
            }
        }
    }


    //page height
    function pagePadding() {
        //var headerHeight = $('.header-2').height() + 'px';
     //   $('#page').css('padding-top', headerHeight);
    }

    // mobile-menu height
    function mobileMenuHeight() {
        // return;
        // var body = $('body');
        // if (body.hasClass('mobile') || body.hasClass('mobile-resized')) {
        //     var headerHeight = $('.header-2').height() + 'px';
        //     $('.js-mobile-menu').css({
        //         'top': headerHeight,
        //         'height': 'calc(100vh - ' + headerHeight + ')'
        //     });
        // }
    }

    $(document).ready(function () {




        $(window).on('resize', function () {
            handleWindowResize();
            mobileMenuHeight();
            pagePadding();
        });

        handleWindowResize();
        mobileMenuHeight();
        pagePadding();


        //hamburger-menu
        $('.stripes-menu').click(function () {
            $('.primary-menu').toggleClass('primary-menu__hide');
            $(this).toggleClass('close-menu');
        });

        $('.js-open-menu').click(function () {
            $(this).parent().toggleClass('open');
        });


    })

    $(window).load(function(){
        pagePadding();
    });
})(jQuery);