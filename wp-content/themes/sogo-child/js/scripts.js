(function ($) {
    "use strict";


    $(document).ready(function () {

        document.addEventListener('wpcf7mailsent', function (event) {
             // console.log(event.detail.apiResponse);
            if(event.detail.apiResponse.redirect){
                $('.wpcf7-response-output').addClass('d-none');
                location.href = event.detail.apiResponse.redirect;
            }
        }, false);

        $(document).scroll(function() {
            if ($(document).scrollTop() > 0) {
                $('.header-2').css('position', 'fixed');
            } else {
                $('.header-2').css('position', 'absolute');
            }
        });

        // let header_height = $('.header-2').height() + 'px';
        // $('#page').css('padding-top', header_height);


        /**
         * custom select
         */
        var iconSize = $('body').hasClass('mobile') ? 'x2' : 'x3';

        $("select.ddl").selectBoxIt({

            downArrowIcon: "icon-arrowdown-01-color6 icon-" + iconSize

        });


        /**
         * levels slider
         */
        $('.js-level-slider').slick({
            infinite: true,
            rtl: true,
            slidesToShow: 5,
            slidesToScroll: 1,
            draggable: true,
            arrows: true,
            nextArrow: '<i class="slick-arrow slick-next icon icon-arrowright color-6 icon-x3 y-align cursor-pointer"></i>',
            prevArrow: '<i class="slick-arrow slick-prev icon icon-arrowleft color-6 icon-x3 y-align cursor-pointer"></i>',
            dots: false,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 993,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 568,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });


        /**
         * levels slider
         */
        $('.js-members-slider').slick({
            rows: 3,
            infinite: true,
            rtl: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            draggable: true,
            arrows: true,
            nextArrow: '<i class="slick-arrow slick-next icon icon-arrowright color-6 icon-x3 y-align cursor-pointer"></i>',
            prevArrow: '<i class="slick-arrow slick-prev icon icon-arrowleft color-6 icon-x3 y-align cursor-pointer"></i>',
            dots: false,
            responsive: [
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 569,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });

        /**
         * insurance page 2 logos slider
         */
        $('.js-insurance-logos-slider').slick({
            infinite: true,
            rtl: true,
            slidesToShow: 10,
            slidesToScroll: 1,
            autoplay: true,
            draggable: true,
            arrows: false,
            // nextArrow: '<i class="slick-arrow slick-next icon icon-arrowright color-6 icon-x3 y-align cursor-pointer"></i>',
            // prevArrow: '<i class="slick-arrow slick-prev icon icon-arrowleft color-6 icon-x3 y-align cursor-pointer"></i>',
            dots: false,
            responsive: [
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 569,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });

        /**
         * page loader logos slider
         */
        $('.js-page-loader-slider').slick({
            infinite: true,
            speed: 300,
            autoplaySpeed: 500,
            rtl: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            draggable: true,
            arrows: false,
            // nextArrow: '<i class="slick-arrow slick-next icon icon-arrowright color-6 icon-x3 y-align cursor-pointer"></i>',
            // prevArrow: '<i class="slick-arrow slick-prev icon icon-arrowleft color-6 icon-x3 y-align cursor-pointer"></i>',
            dots: false,
            responsive: [
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 1
                    }
                },
                {
                    breakpoint: 569,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });

        /**
         * nav slider
         */
        // var navSlider = $('.nav-slider');
        //
        // navSlider.slick({
        //     slide: 'li',
        //     // infinite: true,
        //     rtl: true,
        //     // slidesToShow: 5,
        //     // slidesToScroll: 3,
        //     arrows: false,
        //     nextArrow: '<i class="right-arrow"></i>',
        //     prevArrow: '<i class="left-arrow"></i>',
        //     dots: false
        // });


        /**
         * facebook
         */
        // (function (d, s, id) {
        //     var js, fjs = d.getElementsByTagName(s)[0];
        //     if (d.getElementById(id)) return;
        //     js = d.createElement(s);
        //     js.id = id;
        //     js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10";
        //     fjs.parentNode.insertBefore(js, fjs);
        // }(document, 'script', 'facebook-jssdk'));


        /**
         * back to top
         */
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('#scrollToTop').removeClass('hide');
            } else {
                $('#scrollToTop').addClass('hide');
            }
        });

        $('#scrollToTop').click(function () {
            $('html, body').animate({scrollTop: 0}, 300);
        });


        /**
         * back to top
         */
        // $('#scrollToTop').on('click', function (e) {
        //     var obj = $($(this).attr('href'));
        //     if (obj.length > 0) {
        //         $('html, body').animate({
        //             scrollTop: obj.offset().top - $('header').height()
        //         }, 500);
        //     }
        //     e.preventDefault();
        // });

        // Product comment form
        $('.product-comment-form').on('click', function (e) {
            e.preventDefault();
            $('#review_form_wrapper').find('#review_form').removeClass('hidden-xl-down');
        });


        //remove add from wonder plugin 3d carousel
        $('.wonderplugin3dcarousel-item').find('.wonderplugin3dcarousel-item-container').next().find('div').remove();

        $('.wonderplugin3dcarousel-item').on('click', function () {
            $('#threedcarousel-html5-lightbox').find('#html5-watermark').remove();

        });


        // $("#carousel").waterwheelCarousel({
        // include options like this:
        // (use quotes only for string values, and no trailing comma after last option)
        // option: value,
        // option: value
        // });


        /**
         *
         */
        function animationClick(element, animation) {
            element = $(element);
            element.click(
                function () {
                    element.addClass('animated ' + animation);
                    //wait for animation to finish before removing classes
                    window.setTimeout(function () {
                        element.removeClass('animated ' + animation);
                    }, 2000);

                });
        }

        function animationHover(element, animation) {
            element = $(element);
            element.hover(
                function () {
                    element.addClass('animated ' + animation);
                },
                function () {
                    //wait for animation to finish before removing classes
                    window.setTimeout(function () {
                        element.removeClass('animated ' + animation);
                    }, 2000);
                });
        }

        var byMail = $('.receive-offer-by-email');
        byMail.on('click', function () {
            var cube_wrapper = $(this).closest('.insurance-cube-wrapper');

            if (!cube_wrapper.find($('.contact-us-by-mail')).hasClass('d-none')) {
                cube_wrapper.find($('.contact-us-by-mail')).addClass('d-none');
            }
            else {
                cube_wrapper.find($('.contact-us-by-mail')).removeClass('d-none').addClass('animated fadeInRight');
            }

            if (!cube_wrapper.find($('.contact-us-by-phone')).hasClass('d-none')) {
                cube_wrapper.find($('.contact-us-by-phone')).addClass('d-none');
            }
        });

        var byPhone = $('.receive-offer-by-phone');
        byPhone.on('click', function () {
            var cube_wrapper = $(this).closest('.insurance-cube-wrapper');

            if (!cube_wrapper.find($('.contact-us-by-phone')).hasClass('d-none')) {
                cube_wrapper.find($('.contact-us-by-phone')).addClass('d-none');
            }
            else {
                cube_wrapper.find($('.contact-us-by-phone')).removeClass('d-none').addClass('animated fadeInRight');
                if($('body').hasClass('mobile')){
                    $('html, body').animate({
                        scrollTop: cube_wrapper.find('.contact-us-by-phone').offset().top - 300 + 'px'
                    }, 'slow');
                }
            }

            if (!cube_wrapper.find($('.contact-us-by-mail')).hasClass('d-none')) {
                cube_wrapper.find($('.contact-us-by-mail')).addClass('d-none');
            }
        });

        /**
         * show more details on a card
         */
        var showMoreDetails = $('.compare-show-more-details-a');
        showMoreDetails.on('click', function () {
            $(this).find('.custom-circle i').toggleClass('icon-plus-01-colorwhite');
            $(this).find('.custom-circle i').toggleClass('icon-minus-01-colorwhite');

        });

        /**
         * waypoint
         */
        var waypoints1 =
            $('.data-animation-1').waypoint({
                handler: function () {
                    var obj = this.element;
                    $(obj).addClass('car-animate carFromSide1');
                },
                offset: '90%'
            });

        var waypoints2 =
            $('.data-animation-2').waypoint({
                handler: function () {
                    var obj = this.element;
                    $(obj).addClass('car-animate carFromSide2');
                },
                offset: '90%'
            });

        var waypoints3 =
            $('.data-animation-3').waypoint({
                handler: function () {
                    var obj = this.element;
                    $(obj).addClass('car-animate carFromSide3');
                },
                offset: '90%'
            });

        var waypoints4 =
            $('.data-animation-4').waypoint({
                handler: function () {
                    var obj = this.element;
                    $(obj).addClass('car-animate carFromSide4');
                },
                offset: '90%'
            });

        // $('[data-animation]').waypoint(function () {
        //     var obj = this.element;
        //     console.log(obj);
        //     $(obj).addClass('car-animate');
        //
        // }, {offset: '50%'});

        // if ($('#use-another-address').prop("checked")) {
        //    // var extra_fields = $(document).find('.another-address').html();
        //     $(document).find('.another-address').removeClass('d-none');
        //     $(document).find('#collapseThree .justify-content-between .extra-field-box').append(extra_fields);
        //     $(document).find('#collapseThree .justify-content-between .extra-field-box').find('.city-another').attr('id', 'city-another');
        // }

        $("#use-another-address").on("click", function () {
            var additionalInfo = $('.another-address');
            if ($(this).is(':checked')) {
                additionalInfo.removeClass('d-none');
                additionalInfo.find('input').attr('disabled', false);
            } else {
                additionalInfo.find('input').attr('disabled', true);
                additionalInfo.addClass('d-none');
            }
        });

        // $("#use-another-address").on("change", function () {
        //     if ($('#use-another-address').prop("checked")) {
        //         var extra_fields = $(document).find('.another-address').html();
        //         $(document).find('#collapseThree .justify-content-between .extra-field-box').append(extra_fields);
        //         $(document).find('#collapseThree .justify-content-between .extra-field-box').find('.city-another').attr('id', 'city-another');
        //
        //     } else {
        //         $(document).find('#collapseThree .justify-content-between .extra-field-box').html('');
        //     }
        // });

        $(document).on("focus", "#city-another", function () {
            var $this = $(this);
            $this.autocomplete({
                source: function (request, response) {
                    // Fetch data
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: sogo.ajaxurl,
                        data: {
                            'action': 'sogo_get_cities',
                            'search': request.term
                        },
                        success: function (data) {
                            response($.map(data, function (item) {
                                return {
                                    label: item.city,
                                    value: item.city
                                }
                            }));
                        }
                    });
                },
                select: function (event, ui) {
                    // Set selection
                    $this.val(ui.item.value);
                    return false;
                }
            });
        });

        var $driver_details = '';

        function get_relevant_drivers_tab_title(count_drivers, insurance_owner_driving_to) {

            var title           = '',
                count_drivers   = count_drivers,
                ins_owner_drive = insurance_owner_driving_to,
                tab_header      = $('#tab4-drivers .card-header').find('a'),
                tab_header_icon = '<i class="icon-check-01-colorwhite icon-x2 ml-1 d-none"></i>';
            console.log(count_drivers + '_' + ins_owner_drive)
            switch (count_drivers + '_' + ins_owner_drive) {
                case '1_2':
                    title   = 'פרטי הנהג היחיד';
                    break;
                case '2_2':
                    title   = 'פרטי הנהגים';
                    break;
                case '2_1':
                    title   = 'פרטי הנהג הנוסף';
                    break;
                case '3_2':
                    title   = 'פרטי הנהגים';
                    break;
                case '3_1':
                    title   = 'פרטי הנהגים הנוספים';
                    break;
                case '4_2':
                    title   = 'פרטי הנהג הצעיר ביותר';
                    break;
            }

            tab_header.html(tab_header_icon + title);


            //return title;
        }

        //when chose if policy owner is drive on car or not
        $(document).on('click', '.drive-allowed', function () {


            if ($(this).is(':checked')) {
                var result                    = $(this).val(),//if insurance owner is driving on the car to
                    allowed_drivers_in_car    = $('#allowed_to_drive').data('allowed'),//how many drivers can drive on car
                    $drivers_tab_message_elem = $('#drivers_tab_message');//with $ means is an element

                //tab messages

                get_relevant_drivers_tab_title(allowed_drivers_in_car, result);
                $drivers_tab_message_elem.addClass('d-none');//hide drivers tab message if there is another drivers in car


                // if (+result === 2) {
                //     get_relevant_drivers_tab_title(allowed_drivers_in_car, result);
                //     $drivers_tab_message_elem.addClass('d-none');//hide drivers tab message if there is another drivers in car
                //
                // } else
                    if (+result === 1) {

                   var  message         = '',
                        lowest_seniority = $('#drivers_tab_message').data('lowest-seniority'),
                        youngest_driver_age = $('#drivers_tab_message').data('youngest-driver-age');

                    if (+allowed_drivers_in_car === 4) {
                        message = 'כל נהג מגיל ' + youngest_driver_age + ' , וותק נהיגה החל מ '+ lowest_seniority  +' שנים';
                    } else if (+allowed_drivers_in_car === 1) {
                        message = 'בעל הפוליסה הינו הנהג היחיד ברכב';
                    }

                    if ($drivers_tab_message_elem.hasClass('d-none')) {
                        $drivers_tab_message_elem.removeClass('d-none')
                    }

                    $drivers_tab_message_elem.html('<p class="text-4 color-3 text-center">' + message +'</p>');

                }

                var driverBoxes            = $('#allowed_to_drive .driver-box');//all drivers info boxes elements
                allowed_drivers_in_car     = (+allowed_drivers_in_car === 4) ? 1 : allowed_drivers_in_car;//check if chose that is any driver can drive in car
                console.log(result)
                if (+result === 1) {//yes insurance owner is one of the drivers

                    //show chose license year box if policy owner is driving to
                    $(document).find('#form-2 .license-box').removeClass('d-none');
                    $(document).find('#form-2 #license-year').attr('disabled', false);

                    //if there is more than one driver or max 3 drivers
                    if (+allowed_drivers_in_car !== 1) {
                        $(document).find('.driver-box').last().addClass('d-none');// we hide last driver box from extra drivers tab
                        $(document).find('.driver-box').last().find('input, select').attr('disabled', true);//avoid wrong count extra drivers info, with disable the all inputs of hidden driver box
                    } else if (+allowed_drivers_in_car === 1) {
                        $(document).find('.driver-box').addClass('d-none');//hide extra trivers boxes if chose that insurance owner is drivimg in car
                        $(document).find('.driver-box').find('input, select').attr('disabled', true);//avoid wrong drivers info parameters
                    }
                    sogo_trigger_license_year();

                } else if (result === '2') {//yes insurance owner is not one of the drivers

                    //hide license year box and disable his inputs if choose that policy owner is not drivivng
                   $(document).find('#form-2 .license-box').addClass('d-none');
                   $(document).find('#form-2 #license-year').attr('disabled', true);
                   $(document).find('.driver-box').removeClass('d-none');//showing last driver box
                   $(document).find('.driver-box').last().find('input, select').attr('disabled', false);//enable his inputs
                   $('#tab4-drivers').removeClass('d-none');//showing
                }
            }
            // return false;
            $('.single-driver-js').toggleClass('d-none');
            $('.multi-driver-js').toggleClass('d-none');

        });


        var isEqual = function (arg1, arg2) {
            //   var message =  "אי אפשר להזין תעודת זהות זהה";
            var message = '<label id="driver-identical-number-error" class="error" for="driver-identical-number">אי אפשר להזין תאודת זהות זהה</label>'

            if (arg1 == arg2) {
                return message;
            } else {
                return false;
            }
        };
        $.validator.addMethod('isEqual', function (arg1, arg2) {
            return arg1 == arg2;
        }, "אי אפשר להזין תעודת זהות זהה");


        $(document).on('blur', 'input[name*="identical-number"]', function () {
            var current = $(this);
            if (current.parent().find('.driver-identical-number-error').length > 0) {
                current.parent().find('.driver-identical-number-error').remove();
            }

            var arr = [];
            var message = '<label class="error driver-identical-number-error" for="driver-identical-number">אי אפשר להזין תעודת זהות זהה</label>';
            $('input[name*="identical-number"]').each(function () {
                $(this).removeClass('error');
                if ($(this).val() !== '') {
                    if (arr.indexOf($(this).val()) === -1) {
                        arr.push($(this).val());
                    } else {

                        current.addClass('error');
                        current.parent().append(message);
                        return false;
                    }
                }



            });
            //
            // current.removeClass('error');
            // $('.driver-identical-number-error').remove();

            // var values       =  $('input[name="driver-identical-number_*"]').val();
            // alert(currentValue);
        });
		
        //UpSales function that show number of payments without clicks
        let total_price = 0;
        $('.upsale-checkbox').each(function(){
            if($(this).is(":checked")) {
                total_price += parseInt($(this).attr('data-price'));
            }
        });
        $("#upsales_price").val(total_price);
		
        //UpSales function that show number of payments and do logic to add upsale to the order
        $('.upsale-checkbox').on('click', function () {
            let total_price = 0;
            $('.upsale-checkbox').each(function(){ //kobi
                if($(this).is(":checked")) {
                    total_price += parseInt($(this).attr('data-price'));
                }
            });
            $("#upsales_price").val(total_price);
            $('#headingSix').trigger('mouseover');

            // var current = $(this),//current clicked checkbox
            //
            //
            //     allCheckboxes = $('.upsale-checkbox'),//all checkboxes
            //     upsaleId = current.data('id'),//current clicked checkbox id
            //     parent = $('#upsales_box_' + upsaleId),//wrapper div of all upsale info
            //     payments = $('#upsales_number_payments'),//hidden number payment block
            //     // paymentsSelect = $('#upsale_number_payments'),
            //     priceInfo = $('.upsales-price-info'),
            //     price = current.data('price'),
            //     priceInput = $('#upsales_price'),
            //     newPrice;
            //
            //
            //
            // //if customer want upsale
            // if (current.is(':checked')) {
            //     parent.children('div.upsale-info').children('input').removeAttr('readonly');
            //     payments.removeClass('d-none');
            //
            //     //check if selected upsale is first or not
            //     // if (!priceInput.val()) {
            //     //     priceInput.val(price);
            //     //     priceInfo.text(price);
            //     //     //if not first we bind another price to existing
            //     // } else {
            //     //     newPrice = +priceInput.val() + +price;
            //     //     priceInput.val(newPrice);
            //     //     priceInfo.text(newPrice);
            //     // }
            //
            //     //if don't want
            // } else {
            //
            //     allCheckboxes.each(function (index) {
            //         if ($(this).attr('id') !== current.attr('id')) {
            //             //if there is no chosen upsale we hide payments block
            //             //and disable price input
            //             // if (!$(this).is(':checked')) {
            //             //     payments.addClass('d-none');
            //             //     priceInput.val('');
            //             //     priceInput.attr('readonly')
            //             //     //if there is still upsale exists we change price
            //             // } else {
            //             //     newPrice = +priceInput.val() - +price;
            //             //     priceInput.val(newPrice);
            //             //     priceInfo.text(newPrice);
            //             // }
            //         }
            //     });
            //     parent.children('div.upsale-info').children('input').attr('readonly', true);
            // }
        });

        $('.insurance-submit-payment').on('click', function (e) {
            e.preventDefault();

            console.log($('input[name="driver-birthday[]"]').val())
            var form = $('#form-2');


            var $this = $(this);
            var card = $(this).closest('.card');
            var licenseNumber = $('#license-number').val();
            var firstName = $('#first-name').val();
            var email = $('#email').val();



            var card_is_valid = true;
            card.find('input, select, textarea').each(function () {
                if (!$(this).valid()) {

                    card_is_valid = false;
                }
            });



                // if (!form.valid()) {
            //     console.log('here');
            //     card_is_valid = false;
            // }

            var link = $(this).data('link');

            if (card_is_valid) {
                //reset text on header
                $(this).closest('.content-top').prev().find('.selected-header-box').html('');

                card.removeClass('card-current').addClass('card-visited-2');
                card.find('.card-header a').find('i').removeClass('d-none');

                card.find('a').attr('data-toggle', 'collapse').trigger('click');

                //print text beside the card header
                var additionalInfo = 'ללא עבר פלילי';
                var licenseRevocation = '';
                var city = $('#city').val();

                if ($('#license-suspensions option:selected').val() === '0') {
                    licenseRevocation = 'ללא שלילות';
                }

                if ($('#license-suspensions option:selected').val() === '1') {
                    licenseRevocation = 'שלילה אחת';
                }

                //show page loader
               // $('.loader-wrapper').removeClass('d-none');

                var sendData = $(document).find('#form-2').serialize();

                //save insurance order to options
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: sogo.ajaxurl,
                    data: {
                        'action': 'sogo_send_order_data',
                        'order_data': sendData
                        //'d': 1
                    },
                    success: function (response) {
                        console.log(response)
                        var redirect_url = response.link;

                        if(response.ins_order !== 'false'){
                             redirect_url +=  '?ins_order=' + response.ins_order + '&order_id=' + response.order_id;
                        }else{
                            alert('פג תוקף ההזמנה, יש להתחיל מהתחלה או חייג 03-7200500 ונשמח לעזור לך.');
                        }
                       // $('.loader-wrapper').addClass('d-none');
                     //   console.log(redirect_url  );

                        window.location.replace(redirect_url);
                    }
                });
            } else {
                console.log('error');
            }
        });

        //Take current offer and update it in option
        $(document).on('click', '.buy-ins', function (e) {
            e.preventDefault();

            var $this = $(this);
            var linkToPage = $(this).attr('href');
            var insOrder = $(this).data('order');
            var companyID = $(this).data('company');
            var havila = $(this).data('package');
            var in_type = $(this).data('in-type');
            var src     = $(this).data('src');
            var aff     = $(this).data('aff');
            var add_info = $(this).data('add-info');
            // var companySlug = $(this).data('slug');
            var insType = $(this).data('type');
            var insCompany = $.trim($(this).closest('.insurance-cube').find('.cube_for_mail .ins-company').text());

            if (+in_type === 1) {
                var mandatPrice = $(this).closest('.insurance-cube').find('.cube_for_mail .total').text();

                var secondPrice = '';
            } else {
                var mandatPrice = $(this).closest('.insurance-cube').find('.cube_for_mail .mandat-price').find('span').text();
                var secondPrice = $(this).closest('.insurance-cube').find('.cube_for_mail .second-price').find('span').text();
            }

            $.ajax({
                type: "POST",
                dataType: "json",
                url: sogo.ajaxurl,
                data: {
                    'action': 'sogo_update_insurance_params',
                    'link_page': linkToPage,
                    'aff': aff,
                    'src': src,
                    'ins_order': insOrder,
                    'company_id': companyID,
                    'package': havila,
                    'add_info': add_info,
                    'ins_company': insCompany,
                    'mandat_price': mandatPrice,
                    'second_price': secondPrice,
                    'in_type': in_type
                },
                success: function (response) {
                    window.location.href = response.link;
                }
            });
        });

        $(document).on('click', 'input[name=ownership-date]', function () {
            if ($(this).is(':checked')) {
                if (+$(this).val() === 1) {

                    $('input[name="ownership-under-year"]').val('');
                    $('.under-year').datepicker({
                        changeMonth: true,
                        changeYear: true,
                        defaultDate: null,
                        minDate: '-31D',
                        maxDate: 'TODAY',
                        onSelect: function() {
                            var selectedDate = $(this).val();
                            $('input[name="ownership-under-year"]').val(selectedDate);
                        }
                    });

                    $(document).find('.under').removeClass('d-none');
                } else {
                    $(document).find('.under').addClass('d-none');
                   // $('.under-year').removeAttr('value');
                    $('input[name="ownership-under-year"]').val('');
                }
            }
        });

        var birthPeriod = sogo_max_date_birthday('birthday-date', false);

        var driverBirthPeriod = sogo_max_date_birthday('driver-birthday', true);

        //console.log('birth: ' + birthPeriod);
        $('.birthday-date').datepicker({
            changeMonth: true,
            changeYear: true,
            maxDate: birthPeriod,
            yearRange: (new Date().getFullYear() - 90) + ':' + (new Date().getFullYear() - parseInt(birthPeriod / 365)),
            onSelect: function () {

                //check if there is only one driver on car , else hide SELECT of car licence year
                var driversAllowed = document.querySelector('input[name=drive-allowed]:checked');

                if (driversAllowed === null || +driversAllowed.value === 1) {
                    var selectedDate = $(this).val();
                    var birthDayInput = $('input[name="birthday-date"]');
                    birthDayInput.val(selectedDate);
                    sogo_trigger_license_year();
                }


            }

        });

        $('.driver-birthday').datepicker({
            changeMonth: true,
            changeYear: true,
            maxDate: birthPeriod,
            yearRange: (new Date().getFullYear() - 90) + ':' + (new Date().getFullYear() - parseInt(birthPeriod / 365)),
            onSelect: function() {

                var selectedDate = $(this).val();
                var index = $(this).data('index');

                $('#driver-birthday-' + index).val(selectedDate);

                sogo_driver_trigger_license_year($(this));
            }
        });

        //removing default selected date of current day, to avoid bugs.
        $('.birthday-date .ui-datepicker-calendar').find(".ui-state-default").removeClass("ui-state-active");
        $('.driver-birthday .ui-datepicker-calendar').find(".ui-state-default").removeClass("ui-state-active");

        $("#use-phone-payment").on("change", function () {
            var paymentBox = $('.payment-box');
            if ($('#use-phone-payment').prop("checked")) {

                $('.card-current').each(function () {
                    paymentBox.find('input').attr('disabled', true).attr('readonly', true);
                    paymentBox.find('select').attr('disabled', true).attr('readonly', true);
                    paymentBox.addClass('d-none');
                });

                //   $(document).find('#collapseFive .card-current').remove();
            } else {
                $('.card-current').each(function () {
                    paymentBox.find('input').attr('disabled', false).attr('readonly', false);
                    paymentBox.find('select').attr('disabled', false).attr('readonly', false);
                    paymentBox.removeClass('d-none');
                });
                
                // var payment_fields = $(document).find('.example-payment-box').html();
                // $(document).find('#collapseFive .payment-default').append(payment_fields);
            }
        });

        //push options to select after refresh and if birth date already selected
        /*if($(document).find('.extra-driver-info').length > 0){

            if($(document).find('.extra-driver-info').val() != ''){
                sogo_driver_trigger_license_year($(document).find('.extra-driver-info'));
            }
        }*/

       // $(document).on('touchstart', '.extra-driver-info', function () {
           // alert('fgfgf');
           // sogo_driver_trigger_license_year($(this));
       // });

        /**
         * activate tooltip everywhere
         */
        $('[data-toggle="tooltip"]').tooltip({
            html: true
        });

        /**
         * prevent sending form on enter!
         */
        $(document).on("keypress", "form", function (event) {
            return event.keyCode != 13;
        });
        /**
         * front-page select product to compare
         */
        $(document).on('change', '#insurance-products', function () {

            var url = $(this).find('option:selected').data('url');
            $('#go-to-product').attr('href', url);
        })

    });
})(jQuery);

function sogo_driver_trigger_license_year(elem) {
    elem.closest('.driver-box').find('.driver-license-box select').html('');
    elem.closest('.driver-box').find('.driver-license-box select').append('<option value="">בחר</option>');
    var birthDate = elem.val();

    var maxYear = elem.closest('.driver-box').find('.driver-license-box select').data('max-year');
    // var maxYear = jQuery(document).find('#license-year').data('max-year');

    var birthDateSplit = birthDate.split('/');

    var year = parseInt(birthDateSplit[2]);

    var minYearLicense = year + 17;

    var selectOptions = '';

    for (var i = minYearLicense; i <= maxYear; i++) {
        selectOptions += '<option value="' + i + '">' + i + '</option>';
    }

    elem.closest('.driver-box').find('.driver-license-box select').append(selectOptions);
}

function sogo_trigger_license_year() {
    var birthDate = jQuery(document).find('.birthday-date').val();

    var maxYear = jQuery(document).find('#license-year').data('max-year');

    var birthDateSplit = birthDate.split('/');

    var year = parseInt(birthDateSplit[2]);

    var minYearLicense = year + 17;

    var selectOptions = '<option disabled selected>' + 'בחר' + '</option>';

    /* checking if there is selected license year when came to edit order from crm */
    var selectedYear = document.getElementById('tmp_license_year').value,//check if input hidden has value if returned to edit insurance order
         selected = '';
     if (typeof selectedYear !== undefined) {
         selected = selectedYear;
     }

    for (var i = minYearLicense; i <= maxYear; i++) {

        if (+selected === +i ) {
            selectOptions += '<option selected value="' + i + '">' + i + '</option>';
        } else {
            selectOptions += '<option value="' + i + '">' + i + '</option>';

        }
    }

    jQuery(document).find('#license-year').html('');
    jQuery(document).find('#license-year').append(selectOptions);
    /* end of checking if there is selected license year when came to edit order from crm */
}

function sogo_max_date_birthday(name, with_array) {
    if (with_array) {
        var startPeriod = jQuery(document).find('input.' + name).data('start');
    } else {
        var startPeriod = jQuery(document).find('input[name=' + name + ']').data('start');
    }

    var period = '-' + startPeriod + 'D';
    return period;
}

function sogoPlayVideo() {
    jQuery('.js-play-video').on('click', function () {
        var url = jQuery(this).data('url');
        var src = jQuery(url).attr('src');
        jQuery('#sogo_simple_iframe').attr('src', src);
    });
}

sogoPlayVideo();


/*
function updateFields(element, num) {
    var count = element.length;
    for(i = 0; i < count; i++){
        jQuery(document).find('.extra-drivers').find('#' + element[i]).attr('name', element[i] + '-' + num);
        jQuery(document).find('.extra-drivers').find('#' + element[i]).prev('label').attr('for', element[i] + '-' + num);
    }
}*/

//reload page when click back on browser button
// window.addEventListener( "pageshow", function ( event ) {
//     var historyTraversal = event.persisted ||
//         ( typeof window.performance != "undefined" &&
//             window.performance.navigation.type === 2 );
//     if ( historyTraversal ) {
//         // Handle page restore.
//         window.location.reload();
//     }
// });
