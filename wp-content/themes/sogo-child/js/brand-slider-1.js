(function ($) {
    'use strict';
    $(document).ready(function () {


        /**
         * brand-slider-1
         */
        $('body.mobile .js-brand-slider-1').slick({
            infinite: true,
            rtl: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            draggable: true,
            arrows: false,
            dots: false,
            responsive: [
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 3
                    }
                }
            ]
        });

    });
})(jQuery);

