(function ($) {
    'use strict';
    $(document).ready(function () {

        /**
         * footer-menu
         */
        $('.js-footer-arrow').closest('.widget').click(function () {
            $(this).find('.js-footer-arrow').toggleClass('footer-2__show-submenu icon-arrowdown-01 icon-arrowup-01');
        })

    });
})(jQuery);

