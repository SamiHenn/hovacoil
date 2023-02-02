(function ($) {
    'use strict';

    $(document).ready(function () {
        $("#license_no").trigger('input');

        $('#license_no').keypress(function (e) {
            var key = e.which;
            if (key == 13) // the enter key code
            {
                $('.js_license_number_search').click();
                return false;
            }
        });

        let license_no = $('.vehicle_license_number_con').attr('data-hide');
        if (license_no) {
            $('.vehicle_license_number_con').hide();
            show_car_inputs();
            $('.research_link_con, .license_number_val').show();
            $('.license_number_val').html(license_no);
        }

        let show_details = parseInt($('.vehicle_license_number_con').attr('data-show-details'));
        if (show_details && !license_no) {
            $('.vehicle_license_number_con').hide();
            show_car_inputs();
            $('.research_link_con').show();
            $('.license_number_val, .license_dash').hide();
        }

        $(document).find('#tac-1').prop('checked', false);

        $('#insurance-accordion').collapse({
            toggle: false
        });


        function insurance_func(selected_date, datePickerMonth, datePickerDay, datePickerYear) {
            var startDate = selected_date.getDate() + '/' + (selected_date.getMonth() + 1) + '/' + selected_date.getFullYear();
            // format the date
            var year = selected_date.getFullYear() + 1;
            var month = selected_date.getMonth();

            if (month == 0) {
                year = year - 1;
                month = 12;
            }
            var lastDay = new Date(year, month, 0);
            var resetd_date = new Date();
            var current_month_last_day = new Date(resetd_date.getYear(), resetd_date.getMonth() + 1, 0);

            var startingDayWithSlashes = '';
            // var startingDayWithSlashes = $('#insurance_period').val();


            if (!startingDayWithSlashes) {
                startingDayWithSlashes = startDate;
            }

            var lastDayWithSlashes = (lastDay.getDate()) + '/' + (month) + '/' + (year);
            //check if the user chose the last day of the current month
            // var current_day = new Date().getDate();
            var current_month = new Date().getMonth();

            if (datePickerMonth == current_month) {

                //verify if checked last day of current month
                if (datePickerDay == current_month_last_day.getDate()) {
                    //reset fields
                    sogo_clear_model();

                    $('#insurance_choose_date').find('.modal-body .chosen_date span').append(datePickerDay + '/' + (datePickerMonth + 1) + '/' + datePickerYear);
                    $('#insurance_choose_date').find('.modal-footer .chosen_date span').append(datePickerDay + '/' + (datePickerMonth + 1) + '/' + datePickerYear);
                    $('#insurance_choose_date').find('.modal-footer .chosen_date').data('chosen', datePickerDay + '/' + (datePickerMonth + 1) + '/' + datePickerYear);
                    $('#insurance_choose_date').find('.modal-footer .chosen_date').data('exists', lastDayWithSlashes);

                    //add one day to chosen date
                    selected_date.setDate(selected_date.getDate() + 1);

                    $('#insurance_choose_date').find('.modal-body .must_choose span').append(selected_date.getDate() + '/' + (selected_date.getMonth() + 1) + '/' + selected_date.getFullYear());
                    $('#insurance_choose_date').find('.modal-footer .must_choose span').append(selected_date.getDate() + '/' + (selected_date.getMonth() + 1) + '/' + selected_date.getFullYear());
                    $('#insurance_choose_date').find('.modal-footer .must_choose').data('choose', selected_date.getDate() + '/' + (selected_date.getMonth() + 1) + '/' + selected_date.getFullYear());

                    $('#insurance_choose_date').modal('show');
                }

            }


            // print the estimated finish date for the insurance
            var insuranceDateStart = $('.insurance-date-start');
            var insuranceDateFinish = $('.insurance-date-finish');
            var insurancePeriod = $('#insurance_period');
            if (insurancePeriod.val() === 'תאריך תחילת ביטוח') {

                $('.insurance-date-finish-wrapper').addClass('d-none')

                return false;
            }
            if (startingDayWithSlashes) {
                insuranceDateStart.val(startingDayWithSlashes);
            }
            if (lastDayWithSlashes) {
                insuranceDateFinish.val(lastDayWithSlashes);
            }
            if (insurancePeriod.val().length == 0) {
                insurancePeriod.val(startingDayWithSlashes)
            }
            $('.insurance-date-finish-wrapper').removeClass('d-none').addClass('d-flex align-items-center');
            //show how many months and days the insurance period is *******************************
            var a = moment(insuranceDateStart.val(), 'DD/MM/YYYY');
            var b = moment(insuranceDateFinish.val(), 'DD/MM/YYYY');

            //got the months
            var monthsDiff = b.diff(a, 'months');

            //got the days
            var days = b.diff(a, 'days', true);
            var daysDiff = 365 - days;

            $('.diff-months').text(monthsDiff + ' חודשים');
            $('.diff-days').text('ו- ' + daysDiff + ' ימים');
            $('.js-seperator-line').removeClass('d-none');

            if ($('body').hasClass('mobile')) {
                var card = $(this).closest('.card');
                card.find('.btn-next').trigger('click');
            }
        }

        $('#insurance_select_period #insurance_current_date, #insurance_select_period #insurance_first_next').on('click', function () {

            // $('#insurance_select_period').on('change', function() {

            // get date from select-option
            var value = $(this).val();
            // set date to field #insurance_period
            $('#insurance_period').val(value);
            // convert select date from string to Date
            var selectedDateWithSlashes = $(this).val().split("/")
            var selected_date = new Date(selectedDateWithSlashes[2], selectedDateWithSlashes[1] - 1, selectedDateWithSlashes[0])
            var fix_month = selectedDateWithSlashes[1] - 1;

            insurance_func(selected_date, fix_month, selectedDateWithSlashes[0], selectedDateWithSlashes[2]);

            if (value === 'תאריך תחילת ביטוח') {
                $(this).datepicker('show');
            }
        });

        $('.datepicker').datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            changeYear: true,

            onSelect: function (str, obj) {

                $(this).removeClass('error');
                $(this).closest('.date-picker').next().addClass('d-none');

                // get date from datepicker
                var datePickerYear = obj.currentYear;
                var datePickerMonth = obj.currentMonth;
                var datePickerDay = obj.currentDay;

                // generate new Date
                var date = new Date(datePickerYear, datePickerMonth, datePickerDay);
                insurance_func(date, datePickerMonth, datePickerDay, datePickerYear);
            },
            changeMonth: true,
            // changeYear: true,
            minDate: sogoc.minDate,
            maxDate: '+' + countDaysShowDatePicker() + 'D'
        });
        // if(!sogoc.minDate){
        //     $('#insurance_current_date + label').hide()
        // }

        /**
         * Choose the date that you must to choose and update insurance date
         */
        $('#insurance_choose_date .modal-footer .must_choose').on('click', function (e) {

            // var newDateSelevted = $('#insurance_period').val();
            var splited_date = $(this).data('choose').split('/');
            console.log(splited_date);
            var newDay = parseInt(splited_date[0]);
            var newMonth = parseInt(splited_date[1]);
            var newYear = parseInt(splited_date[2]);

            var newDateSelected = new Date(newYear, newMonth, newDay);

            var month = parseInt(splited_date[1]) - 1;
            var year = parseInt(splited_date[2]) + 1;

            var date = new Date(year, parseInt(month), 0);
            var month = date.getMonth();

            if (month == 11) {
                year = year - 1;
                //   month = 12;
            }


            var lastDayWithSlashes = (date.getDate()) + '/' + (month + 1) + '/' + (year);
            var newDateSelectedFinish = newDay + '/' + newMonth + '/' + newYear;


            $('#insurance-date-start').val(newDateSelectedFinish);
            $('#insurance-date-finish').val(lastDayWithSlashes);

            $('.datepicker').datepicker("setDate", $(this).data('choose'));
            $('.js-seperator-line').removeClass('d-none');

            //$('.d-start').text(newDateSelectedFinish);
            $('#insurance_choose_date').modal('hide');

            sogo_clear_model();

        });

        /**
         * Choose the chosen date and update insurance date
         */
        $('#insurance_choose_date .modal-footer .chosen_date').on('click', function (e) {
            $('#insurance-date-start').val($(this).data('chosen'));

            $('.datepicker').datepicker("setDate", $(this).data('chosen'));

            $('#insurance_choose_date').modal('hide');

            sogo_clear_model();
        });


        /**
         * Clear warning modal about insurance start
         */
        function sogo_clear_model() {
            $('#insurance_choose_date').find('.modal-body .chosen_date span').html('');
            $('#insurance_choose_date').find('.modal-footer .chosen_date span').html('');
            $('#insurance_choose_date').find('.modal-footer .chosen_date').data('chosen', '');
            $('#insurance_choose_date').find('.modal-footer .chosen_date').data('exists', '');

            $('#insurance_choose_date').find('.modal-body .must_choose span').html('');
            $('#insurance_choose_date').find('.modal-footer .must_choose span').html('');
            $('#insurance_choose_date').find('.modal-footer .must_choose').data('choose', '');
        }

        //add scroll function to prototype of jQuery
        (function ($) {
            $.fn.goTo = function () {
                $('html, body').animate({
                    scrollTop: $(this).offset().top - 150 + 'px'
                }, 'fast');
                return this; // for chaining...
            };

            $.fn.detectMobile = function () {
                if ($.browser.device = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()))) {
                    return true;
                } else {
                    return false;
                }
            };
        })(jQuery);

        // $('.menu-item.menu-item-has-children').on('click', function (event) {
        //
        //     if ($(this).detectMobile()) {
        //         event.cancelable = true;
        //         event.stopPropagation();
        //         event.stopImmediatePropagation();
        //
        //     }
        //
        //
        // });

        $('.card-header.deprecated').on('click', function (e) {

            e.preventDefault();
            var collapse = $('.card-current');
            var errors = 0;

            collapse.find('input, select,textarea').each(function () {
                if (!$(this).valid()) {
                    errors++;
                }
            });
            if (errors) {
                return false;
            }
        });

        //add condition of calculation of total price to click event on tab of payment info to
        $('#headingSix').on('mouseover', function (e) {
            e.stopPropagation();

            if ($(this).parent().hasClass('card-visited')) {
                try {
                    totalSum($);
                } catch (e) {
                    console.log(e.message)
                }
            }

            $(".upsales-box input").each(function () {
                let id = $(this).attr("id");
                let sku = id.split("_")[1];
                if ($(this).is(":checked")) {
                    $("#upsales_payments_" + sku).removeClass("d-none");
                } else {
                    $("#upsales_payments_" + sku).addClass("d-none");
                }
            });
        });

        $('.btn-next').on('click', function (e) {

            e.stopPropagation();
            var button = $(this);
            //if the step is one before payment details,
            //we get the total price of all insurance and add it to the tab title
            try {

                if (button.hasClass('upsales-btn')) {
                    totalSum($);
                    $(".upsales-box input").each(function () {
                        let id = $(this).attr("id");
                        let sku = id.split("_")[1];
                        if ($(this).is(":checked")) {
                            $("#upsales_payments_" + sku).removeClass("d-none");
                        } else {
                            $("#upsales_payments_" + sku).addClass("d-none");
                        }
                    });
                }


            } catch (e) {
                console.log(e.message)
            }


            //prevent invalid insurance start date
            try {
                var today = new Date(),
                    day = today.getDate(),
                    month = today.getMonth() + 1,
                    year = today.getFullYear(),
                    insuranse_start_date = $('input[name="insurance-date-start"]').val(),
                    tmp_date = insuranse_start_date.split('/');


                // 0 - day , 1 - month, 2 - year
                var selected_date = tmp_date[1] + '/' + tmp_date[0] + '/' + tmp_date[2],
                    curdate = month + '/' + day + '/' + year;

                if (Date.parse(selected_date) < Date.parse(curdate)) {
                    alert('' +
                        'נא לבחור שוב תאריך תחילת ביטוח');
                    return false;
                }

                // return false;
            } catch (e) {
                console.log(e)
            }


            var card = $(this).closest('.card');
            var card_is_valid = true;

            card.find('input, select,textarea').each(function () {
                if (!$(this).valid()) {
                    console.log($(this));
                    $(this).goTo();
                    card_is_valid = false;
                    return false;
                }
            });


            var card_next = card;

            //var card_next =  card.next();

            if (card_is_valid && card_next) {
                //   if (card_next.hasClass('skip')){
                card_next = card_next.next();
                //   }
                card.removeClass('card-current').addClass('card-visited');
                card.find('.card-header a').find('i').removeClass('d-none');

                card_next.find('.collapsed').attr('data-toggle', 'collapse').trigger('click');
                card_next.addClass('card-current');
            }


            if (card_is_valid) {

                if (card.find('#insurance_period').length > 0) {
                    //get dates from inputs
                    var startDate;
                    if ($('body').hasClass('mobile')) {
                        startDate = $('.static-datepicker').val();

                    } else {
                        startDate = $('#insurance_period').val();
                    }

                    var endtDate = $('#insurance-date-finish').val();

                    startDate = startDate.split('/');
                    startDate = startDate[0] + '/' + startDate[1] + '/' + startDate[2];

                    endtDate = endtDate.split('/');
                    endtDate = endtDate[0] + '/' + endtDate[1] + '/' + endtDate[2];

                    //print dates on the card header
                    //$('.d-start').text(startDate);
                    //$('.d-end').text(endtDate);
                    //$('.d-middle-line').removeClass('d-none');
                    //$('.js-seperator-line').removeClass('d-none');

                }

                //rest the header selected text
                $(this).closest('.content-top').prev().find('.selected-header-box').html('');


                if ($('body').hasClass('mobile')) {
                    $('html, body').animate({
                        scrollTop: $('#insurance-accordion').offset().top - 75
                    }, 0);
                }
            }
        });
        $('.compare3-button .btn-next').on('click', function () {
            let compare3UserName = $('#form-2').find('#first-name').val() + ' ' + $('#form-2').find('#last-name').val();
            let compare3UserPhone = $('#form-2').find('#mobile-phone-number').val();
            $('#contact-compare-name-2-1.ins_send_name').val(compare3UserName);
            // $('#contact-compare-name-2-1').find('.ins_send_name').val(compare3UserName);
            $('#contact-us-compare-form-phone-1').find('.ins_send_phone').val(compare3UserPhone);
            $('.contact-us-compare-send-form').trigger('click');

        });

        $(document).on('keyup', '#street', function () {
            var street_string = $(this).val();
            var city = $('#city').val();

            $.ajax({
                type: "POST",
                dataType: "json",
                url: sogo.ajaxurl,
                data: {
                    'action': 'sogo_autocomplete_street',
                    'city': city,
                    'street_string': street_string
                },
                success: function (response) {

                    if (response.response != '0') {
                        console.log(response.street);
                    }
                }
            });
        });

        /**
         * click on SEND on insurance page 1
         */
        $('.insurance-submit-1').on('click', function (e) {
            e.preventDefault();

            var $this = $(this);
            var card = $(this).closest('.card');

            var card_is_valid = true;
            card.find('input, select, textarea').each(function () {
                if (!$(this).valid()) {
                    card_is_valid = false;
                }
            });

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

                var modiffiedText = '<p class="d-lg-inline normal mr-1">' + additionalInfo + ', ' + licenseRevocation + ', ' + 'מ' + city + '</p>';
                $(this).closest('.content-top').prev().find('.selected-header-box').append(modiffiedText);

                //show page loader
                $('.loader-wrapper').removeClass('d-none');

                if ($('.stability-box').hasClass('d-none')) {
                    $('.stability-box').find('input').prop('disabled', true);
                }

                var sendData = $('#form-1').serialize();

                //save insurance order to options
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: sogo.ajaxurl,
                    data: {
                        'action': 'sogo_store_insurance_params',
                        'insurance_data': sendData
                    },
                    success: function (response) {

                        console.log(response);

                        //   if (response.result) {
                        var formAction = $this.closest('form').attr('action');
                        if (formAction.indexOf("insurance-type") >= 0 || formAction.indexOf("iframe") >= 0) {
                            formAction = formAction + '&ins_order=' + response.insurance_order;
                        } else {
                            formAction = formAction + '?ins_order=' + response.insurance_order;
                        }

                        $this.closest('form').attr('action', formAction);

                        $this.closest('form').submit();
                        //     }
                    }
                });
            }
        });

        $(document).on('click', '.no-result-form', function (e) {
            e.preventDefault();

            var form = $(this).closest('form');

            //validate valid form
            form.validate({
                rules: {
                    'contact-compare-name-2-1': 'required',
                    'contact-compare-phone-1': {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10
                    }
                },
                errorPlacement: function (error, element) {

                    error.insertAfter(element);
                }
            });

            if (!form.valid()) {
                return;
            }

            var data = form.serialize();

            $.ajax({
                type: "POST",
                dataType: "json",
                url: sogo.ajaxurl,
                data: {
                    'action': 'sogo_send_insurance_no_results',
                    'params': data
                },
                success: function (response) {
                    // console.log(response.data.type);
                    // form.find('.row').hide();
                    // form.find('.thx').remove();
                    form.append('<div class="row thx"><div class="col bg-5 message py-2 color-white text-6 text-center">נשלח בהצלחה</div></div>');
                }
            });
        });

        $(document).on('click', '.contact-us-compare-send-form', function (e) {
            e.preventDefault();

            var form = $(this).closest('form');
            var typeOfForm = '';

            if (form.hasClass('one')) {
                typeOfForm = 'one';

                form.validate({
                    rules: {
                        'contact-compare-name-1': 'required',
                        'contact-compare-email-1': {
                            required: true,
                            checkEmail: true
                        }
                    },
                    errorPlacement: function (error, element) {
                        error.insertAfter(element);
                    }
                });
            } else {
                typeOfForm = 'two';

                form.validate({
                    rules: {
                        'contact-compare-name-2-1': 'required',
                        'contact-compare-phone-1': {
                            required: true,
                            digits: true,
                            minlength: 10,
                            maxlength: 10
                        }
                    },
                    errorPlacement: function (error, element) {
                        error.insertAfter(element);
                    }
                });
            }


            if (!form.valid()) {
                return;
            }

            form.append('<div class="row thx"><div class="col bg-5 thx-message py-2 color-white text-6 text-center">אנא המתן...</div></div>');

            var $this = $(this);
            var offer = $this.closest('.insurance-cube').find('.cube_for_mail').html();

            var insOrderNumber = $this.closest('form').find('.ins_order').val();
            var ins_link = $this.closest('form').find('.ins_link').val();

            if (!ins_link.match(/\?/)) {//if not set $_GET['ins_order'] , we add him to the link
                ins_link = ins_link + '?ins_order=' + encodeURIComponent(insOrderNumber);
            }
            var leadType = $this.closest('form').find('.leadType').val();

            let fullName = $this.closest('form').find('.ins_send_name').val();
            var email = $this.closest('form').find('.ins_send_email').val();
            let phoneNumber = form.find('.ins_send_phone').val();
            var subj = form.find('.subjectForLead').val();
            var licenseNumber = $('#form-2').find('#license-number').val();
            var firstName = $('#form-2').find('#first-name').val();
            var lastName = $('#form-2').find('#last-name').val();
            var insuranceDateStart = $('#form-2').find('[name="insurance-date-start"]').val();

            $.ajax({
                type: "POST",
                dataType: "json",
                url: sogo.ajaxurl,
                data: {
                    'action': 'sogo_send_insurance_offer',
                    'offer': offer,
                    'ins_link': ins_link,
                    'full_name': fullName,
                    'email': email,
                    'phone': phoneNumber,
                    'subjectForLead': subj,
                    'type_of_form': typeOfForm,
                    'licenseNumber': licenseNumber,
                    'insuranceDateStart': insuranceDateStart,
                    'first_name': firstName,
                    'last_name': lastName,
                    'leadType': leadType,
                },
                success: function (response) {

                    var insuranceCube = $this.closest('.insurance-cube');
                    form.find('.row').hide();
                    form.find('.thx').remove();
                    form.append('<div class="row thx"><div class="col bg-5 message py-2 color-white text-6 text-center">נשלח בהצלחה</div></div>');

                    setTimeout(function () {
                        if (response.data.type === 'one') {
                            insuranceCube.find('.receive-offer-by-email').trigger('click');
                        } else {
                            insuranceCube.find('.contact-us-by-phone').addClass('d-none');
                            // insuranceCube.find('.receive-offer-by-phone').trigger('click');
                        }
                        form.find('.row').show();
                        form.find('.thx').remove();
                    }, 2000);

                    //clear the inputs
                    insuranceCube.find('.contact-us-compare-form-email-1').find("input[type!='hidden']").each(function () {
                        $(this).val('');
                    });
                }
            });

        });

        // *********** mobile *********************
        if ($('body').hasClass('mobile')) {
            //hide next button
            // $('.btn-next').addClass('d-none');

        }

        //var cities_array = JSON.parse(sogoc.cities);
        function getCityFromArray(city) {
            return cities_array.filter(
                function (cities_array) {
                    return cities_array.city == city
                }
            );
        }

        //autocomplete city
        $("#city").autocomplete({
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
                $('#city').val(ui.item.value);
                return false;
            },
            change: function (event, ui) {
                let found = getCityFromArray($('#city').val());
                found = (found[0] && found[0].city !== null) ? found[0].city : '';
                if (found !== $('#city').val()) {
                    $('#city').val('');
                    $('#city').focus();
                }
            }
        });

        //autocomplete city
        $("#street").autocomplete({
            source: function (request, response) {

                // Fetch data
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: sogo.ajaxurl,
                    data: {
                        'action': 'sogo_autocomplete_street',
                        'street_string': request.term,
                        'city': $('#city').val()
                    },
                    success: function (data) {
                        response($.map(data, function (item) {
                            console.log(item);
                            return {
                                label: item.street_name,
                                value: item.street_name
                            }
                        }));
                    }
                });
            },
            select: function (event, ui) {
                // Set selection
                $('#street').val(ui.item.value);
                return false;
            }
        });
    });

    //outside document ready
    $(document).on('click', '.card-visited', function () {
        var card = $(this);
        var cards = $('.card');

        cards.each(function () {
            if ($(this).hasClass('card-current')) {
                $(this).removeClass('card-current').addClass('card-visited');
            }
        });

        card.removeClass('card-visited').addClass('card-current');
        card.find('.card-header a').find('i').addClass('d-none');

    });

    /**
     * select license number click
     */
    $(document).on('click', '.js_license_number_search', function () {
        let license_no = $('#license_no').val();
        let license_no_len = (license_no.toString()).length;
        if (license_no && license_no_len > 6 && license_no_len < 9) {
            $("#div1, #samiloader").show();
            $('.license_number_val').html(license_no).show();
            $('.license_dash').show();
            $.ajax({
                url: sogo.ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    'action': 'sogo_get_gov_car',
                    'license_num': license_no
                },
                success: function (result) {
                    console.log(result);
                    if (result.data.car) {
                        $('#carFound').show();
                        setTimeout(function () {
                            $('#carFound, #div1, #samiloader').hide();
                        }, 1000);
                        $('input[name="license_no"][type="hidden"]').val(license_no);
                        let data = result.data;
                        let shnat_yitzur = data.car.shnat_yitzur;
                        let shnat_yitzur_option_val = $("<option selected='selected'>" + shnat_yitzur + "</option>").attr('value', shnat_yitzur);
                        $("#vehicle-year").html(shnat_yitzur_option_val);

                        if (data.model_info) {
                            let bakarat_stiya_menativ = data.model_info.bakarat_stiya_menativ_ind;
                            let nitur_merhak_milfanim = data.model_info.nitur_merhak_milfanim_ind;
                            let nefah_manoa = data.model_info.nefah_manoa;
                            let bakarat_yatzivut_ind = data.model_info.bakarat_yatzivut_ind;
                            let delek_cd = data.model_info.delek_cd;
                            $("#delek_cd").val(delek_cd);
                            let koah_sus = data.model_info.koah_sus;
                            $("#koah_sus").val(koah_sus);
                            let abs_ind = data.model_info.abs_ind;
                            let mispar_kariot_avir = data.model_info.mispar_kariot_avir;
                            let ldw = 2;  // not active
                            let fcw = 2;  // not active
                            let tozar = data.model_info.tozar;
                            if (tozar) {
                                $("#vehicle-manufacturer").html("");
                                let tozar_option_val = $("<option>" + tozar + "</option>");
                                tozar_option_val.attr({'value': tozar, "selected": 'selected'});
                                $("#vehicle-manufacturer").append(tozar_option_val);
                            }
                            $('#abs').val(abs_ind);
                            $('#air_bags').val(mispar_kariot_avir);
                            if (nitur_merhak_milfanim === '1') {
                                $("#keeping-distance-system-1").attr('checked', true).trigger('click');
                                $("#keeping-distance-system-2").attr('checked', false);
                                fcw = 1;  //active
                            } else {
                                $("#keeping-distance-system-1").attr('checked', false);
                                $("#keeping-distance-system-2").attr('checked', true).trigger('click');
                            }
                            $("#fcw").val(fcw);
                            if (bakarat_stiya_menativ === '1') {
                                $("#deviation-system-1").attr('checked', true).trigger('click');
                                $("#deviation-system-2").attr('checked', false);
                                ldw = 1;  //active
                            } else {
                                $("#deviation-system-1").attr('checked', false);
                                $("#deviation-system-2").attr('checked', true).trigger('click');
                            }
                            $("#ldw").val(ldw);
                            $("input[name='engine_capacity']").val(nefah_manoa);
                            $("#esp").val(bakarat_yatzivut_ind);
                        }
                        show_car_inputs();
                        $('.research_link_con').show();
                        $('.vehicle_license_number_con').hide();

                        if (data.model_from_convert) {
                            let model = data.model_from_convert.model;
                            let sub_model = data.model_from_convert.sub_model;
                            let code_levi = data.model_from_convert.code_levi;
                            let model_option_val = $("<option selected='selected'>" + model + "</option>").attr('value', model);
                            let sub_model_option_val = $("<option selected='selected'>" + sub_model + "</option>").attr('value', sub_model);
                            $("#vehicle-brand").html(model_option_val);
                            $("#vehicle-sub-brand").html(sub_model_option_val);
                            $("#levi-code").val(code_levi);
                        } else {
                            $('#vehicle-year').trigger('change');
                        }

                    } else {
                        reset_vehicles_inputs($);
                        $('#samiloader').hide();
                        $('.vehicle_not_found_popup').show();
                    }
                }
            });
        } else {
            reset_vehicles_inputs($);
        }
    });

    $(document).on('input', '#license_no', function () {
        let license_no = $(this).val();
        let license_no_len = (license_no.toString()).length;
        if (license_no && license_no_len > 6 && license_no_len < 9) {
            $(".js_license_number_search").addClass('active').attr('disabled', false);
        } else {
            $(".js_license_number_search").removeClass('active').attr('disabled', true);
        }
    });

    /**
     * select manufacturers change
     */
    $(document).on('change', '#vehicle-manufacturer', function (e) {

        $(this).valid();

        var manufacturer = $(this).val();

        //check if event was a human event or automatic trigger
        // if (e.originalEvent !== undefined) {
        $('#vehicle-year option').not(':first').remove();
        $('#vehicle-brand option').not(':first').remove();
        $('#vehicle-sub-brand option').not(':first').remove();
        document.getElementById("div1").style.display = "block";
        document.getElementById("samiloader").style.display = "block";

        // }

        $.ajax({
            url: sogo.ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
                'action': 'sogo_get_manufacturer_years',
                'vehicle-manufacturer': manufacturer
            },
            success: function (result) {
                // console.log(result);
                var option = "<option value=''></option>";
                var index = 0;
                document.getElementById("div1").style.display = "none";
                document.getElementById("samiloader").style.display = "none";

                $(result).each(function () {
                    $('#vehicle-year').append($("<option>", {
                        value: result[index][0],
                        text: result[index][0]
                    }));

                    index++;
                });
            }
        });
    });

    /**
     * select year change
     */
    $(document).on('change', '#vehicle-year', function () {
        $('#vehicle-manufacturer').attr('data-selected', '');
        let manufacturer = $('#vehicle-manufacturer').val();
        let year = $('#vehicle-year').val();
// console.log(manufacturer);
// console.log(year);
        $('#vehicle-brand option').not(':first').remove();
        $('#vehicle-sub-brand option').not(':first').remove();
        document.getElementById("div1").style.display = "block";
        document.getElementById("samiloader").style.display = "block";
        $.ajax({
            url: sogo.ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
                'action': 'sogo_get_models',
                'vehicle-manufacturer': manufacturer,
                'vehicle-year': year
            },
            success: function (result) {
                console.log(result);
                var option = "<option value=''></option>";
                var index = 0;
                document.getElementById("div1").style.display = "none";
                document.getElementById("samiloader").style.display = "none";
                $(result).each(function () {
                    // let row = $("<option value="+ result[index][0] +">"+ result[index][0] +"</option>")
                    // $('#vehicle-brand').append(row);
                    $('#vehicle-brand').append($("<option>", {
                        value: result[index][0],
                        text: result[index][0]
                    }));

                    index++;
                });
                $('#vehicle-brand').change();
            }
        });
    });

    /**
     * select model change
     */
    $(document).on('change', '#vehicle-brand', function () {
        var manufacturer = $('#vehicle-manufacturer').val();
        var year = $('#vehicle-year').val();
        var brand = $(this).val();
        document.getElementById("div1").style.display = "block";
        document.getElementById("samiloader").style.display = "block";

        $('#vehicle-sub-brand option').not(':first').remove();

        $.ajax({
            url: sogo.ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
                'action': 'sogo_get_sub_models',
                'vehicle-manufacturer': manufacturer,
                'vehicle-year': year,
                'brand': brand
            },
            success: function (result) {
                var option = "<option value=''></option>";
                var index = 0;
                document.getElementById("div1").style.display = "none";
                document.getElementById("samiloader").style.display = "none";
                $(result).each(function () {
                    $('#vehicle-sub-brand').append($("<option>", {
                        value: result[index][0],
                        text: result[index][0]
                    }));

                    index++;
                });
            }
        });
    });


    $(document).on('change', 'input[name="keeping-distance-system"]', function () {
        $('input[name="fcw"]').val($(this).val());
    });
    $(document).on('change', 'input[name="deviation-system"]', function () {
        $('input[name="ldw"]').val($(this).val());
    });
    $(document).on('change', 'input[name="stability-system"]', function () {
        $('input[name="esp"]').val($(this).val());
    });
    //to set safety systems by car
    $(document).on('change', '#vehicle-sub-brand', function () {
        var manufacturer = $('#vehicle-manufacturer').val();
        var year = $('#vehicle-year').val();
        var brand = $('#vehicle-brand').val();
        var sub_brand = $(this).val();
        $.ajax({
            url: sogo.ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
                'action': 'sogo_get_safety_systems',
                'vehicle-manufacturer': manufacturer,
                'vehicle-year': year,
                'brand': brand,
                'sub_brand': sub_brand
            },
            success: function (result) {
                //verify that we get the data about safety systems of car
                if (result.status == '1') {
                    let fcw = (result.fcw == '1') ? 1 : 2;
                    let ldw = (result.ldw == '1') ? 1 : 2;
                    $('input[name="engine_capacity"]').val(result.engine_capacity);
                    $('input[name="fcw"]').val(fcw);
                    $('input[name="ldw"]').val(ldw);
                    $('input[name="esp"]').val(result.esp);
                    $('input[name="levi-code"]').val(result.code_levi);

                    //set
                    if (result.fcw == '1') {
                        //set it to yes
                        $('#keeping-distance-system-1').prop('checked', true);
                    } else {
                        $('#keeping-distance-system-2').prop('checked', true);
                    }

                    if (result.ldw == '1') {
                        //set it to yes
                        $('#deviation-system-1').prop('checked', true);
                    } else {
                        $('#deviation-system-2').prop('checked', true);
                    }

                    if (+result.esp === 2) {
                        $('.stability-box').removeClass('d-none');
                    } else {
                        if (!$('.stability-box').hasClass('d-none')) {
                            $('.stability-box').addClass('d-none');
                        }
                    }
                }
            }
        });
    });


    $(document).on('click', 'input[name=insurance-before]', function () {
        var had_insurance = $(this).val();
        var row = $(this).closest('.row');

        // console.log(had_insurance);

        if (had_insurance == '1') {
            row.next().removeClass('d-none');
        } else {
            //add class d-none
            row.next().addClass('d-none');
            row.next().next().addClass('d-none');
            row.next().next().next().addClass('d-none');

            //reset fields
            row.closest('#collapseFour').find('select').each(function () {
                $(this).val('');
            });

        }

    });
    //function that check number of payments and add interest of 3% if need
    //TODO popup modal with message that price is changed if chose number payments biggest that without interest(bli ribit)
    $(document).on('change', '#other-num-payments', function () {
        var interest = 0.03;
        var count_payments_no_interest = $('input[name="num-payments-no-percents"]').val();
        count_payments_no_interest = count_payments_no_interest == 0 ? 4 : count_payments_no_interest;
        // let price = $(this).closest('span.price-box').text();
        var priceBox = $('select[name="other-num-payments"]').closest('div.s-select-wrapper').prev().children('span.price-box'),
            priceInput = $('input[name="second-price"]'),
            newPrice,
            oldPrice = $('input[name="old-price"]').val();
        //price = priceBox.text();

        //add 1 because of zero 0 start.
        var selected_count_payments = (1 + parseInt($(this).val()));

        if ((+selected_count_payments > +count_payments_no_interest) || (+selected_count_payments === 10)) {

            newPrice = Math.ceil((oldPrice * interest) + +oldPrice);
            priceInput.val(newPrice);
            priceBox.text(newPrice);

            var message = "<p>לידיעתך, פריסת תשלומי ביטוח <strong>מקיף/צד ג':</strong><br /> עד " + count_payments_no_interest + " תשלומים ללא דמי אשראי <br /> מעל " + count_payments_no_interest + " תשלומים יתווספו דמי אשראי כ " + Math.ceil(oldPrice * interest) + " ש''ח</p>";


            $('#insurance_payments_message').html(
                message
            );
            $('#insurance_price_message').modal('show');
        } else {
            priceBox.text(oldPrice);
            priceInput.val(oldPrice);
        }


    });


    $(document).on('change', '#card-year', function () {
        var $this = $(this).val();
        var date = new Date();
        var curyear = date.getFullYear();
        var curmonth = date.getMonth();

        $('#card-month > option').each(function () {
            if ($this == curyear) {
                if ($(this).val() <= curmonth) {
                    $(this).attr('disabled', true);
                }
            } else {
                $(this).attr('disabled', false);

            }

        })

    });

    $(document).on('change', '#law-suites-3-year', function () {
        var had_law_suites = $(this).val();
        var row = $(this).closest('.row');

        switch (had_law_suites) {
            case '0':
                $('#law-suits').addClass('d-none');
                break;
            case '1':
                $('#law-suits').removeClass('d-none');
                break;
            case '2':
                $('#law-suits').addClass('d-none');
        }

        if ($('input[name=insurance-1-year]:checked').val() == '3') {
            document.getElementById("law-suite-what-year").options[1].disabled = true;
        }
        if ($('input[name=insurance-2-year]:checked').val() == '3') {
            document.getElementById("law-suite-what-year").options[2].disabled = true;
        }
        if ($('input[name=insurance-3-year]:checked').val() == '3') {
            document.getElementById("law-suite-what-year").options[3].disabled = true;
        }
        if ($('input[name=insurance-1-year]:checked').val() != '3') {
            document.getElementById("law-suite-what-year").options[1].disabled = false;
        }
        if ($('input[name=insurance-2-year]:checked').val() != '3') {
            document.getElementById("law-suite-what-year").options[2].disabled = false;
        }
        if ($('input[name=insurance-3-year]:checked').val() != '3') {
            document.getElementById("law-suite-what-year").options[3].disabled = false;
        }
        $("#law-suite-what-year").val("");
    });


    $(window).on('load', function () {
        $('#datesLoader').addClass('d-none')
        /**
         * check if insurance-before is true if so remove d-none from childrens
         */
        if ($('input[name=insurance-before]:checked').val() == '1') {
            var row = $('#insurance-before-1').closest('.row');
            row.next().removeClass('d-none');

            if ($('#law-suites-3-year').val() == '1') {
                row.next().removeClass('d-none');
            }
        }

        /* $('.card').each(function () {
             if($(this).hasClass('filled')){
                 var $this = $(this);
                 setTimeout(function () {
                     $this.find('.btn-next').trigger('click');
                 }, 500);
             }
         });*/
        return false;
        if ($('#vehicle-manufacturer1111111').val() !== '' || $('#vehicle-manufacturer222222').val() !== null) {

            $('#vehicle-manufacturer').trigger('change');

            setTimeout(function () {
                if ($('#vehicle-year').val() !== '' || $('#vehicle-year').val() !== null) {
                    var selected = $('#vehicle-year').data('selected');
                    $('#vehicle-year').val(selected);
                    $('#vehicle-year').trigger('change');

                    setTimeout(function () {
                        var selected2 = $('#vehicle-brand').data('selected');
                        $('#vehicle-brand').val(selected2);
                        $('#vehicle-brand').trigger('change');

                        setTimeout(function () {
                            var selected3 = $('#vehicle-sub-brand').data('selected');
                            $('#vehicle-sub-brand').val(selected3);
                            $('#vehicle-sub-brand').trigger('change');
                        }, 450);

                    }, 350);
                }
            }, 1000);
        }


    });

    function countDaysShowDatePicker() {
        var date = new Date();
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        var lastDayNextMonth = new Date(date.getFullYear(), date.getMonth() + 2, 0);

        var num_remaining_days_this_month = lastDay.getDate() - date.getDate();

        var daysToShowDatePicker = num_remaining_days_this_month + lastDayNextMonth.getDate();

        return daysToShowDatePicker;
    }


})(jQuery);

function totalSum($) {
    //The + mean is converted to the number
    var mandatory_price = +$('input[name="mandat-price"]').val(),
        second_price = +$('input[name="second-price"]').val(),
        upsales_price = +$('input[name="upsales-price"]').val(),
        package_price = +$('input[name="package-price"]').val(),
        total = 0,
        price_tab_title_elem = $('#headingSix > h5 > a'),


        total = mandatory_price + second_price + upsales_price + package_price;

    price_tab_title_elem.text("פרטי תשלום" + ": סה\"כ לתשלום " + total + " ₪ ");
    $('.total_val span').html(total + " ₪ ");
}

function sami_clear_insurance_before_years() {
    document.getElementById("insurance-1-year-1").checked = false;
    document.getElementById("insurance-2-year-1").checked = false;
    document.getElementById("insurance-3-year-1").checked = false;
    document.getElementById("insurance-1-year-2").checked = false;
    document.getElementById("insurance-2-year-2").checked = false;
    document.getElementById("insurance-3-year-2").checked = false;
    document.getElementById("insurance-1-year-3").checked = false;
    document.getElementById("insurance-2-year-3").checked = false;
    document.getElementById("insurance-3-year-3").checked = false;
}

// sami fixing bug that clears values while change claims number at last 3 years
function sami_claims_info() {
    document.getElementById("law-suites-3-year").selectedIndex = "0";
};

function self_choice_click() {
    jQuery("#license_no").val("").trigger('input');
    jQuery('.vehicle_license_number_con').hide();
    show_car_inputs();
    jQuery(".search_by_license_num_helper").show();
    jQuery(".research_link_con").hide();
    jQuery('.collapse_two_first_sec button.btn-next').show();
}

function show_car_inputs() {
    jQuery('.radio_box_con, .vehicle_sub_brand_con, .vehicle_brand_con, .vehicle_year_con, .vehicle_manufacturer_con').show();
    jQuery('.collapse_two_first_sec button.btn-next').show();
}

function hide_car_inputs() {
    jQuery('.radio_box_con, .vehicle_sub_brand_con, .vehicle_brand_con, .vehicle_year_con, .vehicle_manufacturer_con').hide();
}

function show_license_search() {
    jQuery(function ($) {
        $('.vehicle_license_number_con').show();
        $("#license_no").val("").trigger('input');
        $('input[name="license_no"][type="hidden"]').val("");
        reset_vehicles_inputs($);
        hide_car_inputs();
        $('label.error').hide();
        $('.license_no').removeClass('error');
        $('.collapse_two_first_sec button.btn-next').hide();
    });
}

function car_num_search() {
    jQuery("#div1, .vehicle_not_found_popup").hide();
    show_license_search();
    jQuery(".search_by_license_num_helper").hide();
}

function search_from_list() {
    jQuery('.vehicle_license_number_con').hide();
    jQuery("#div1, .vehicle_not_found_popup").hide();
    jQuery(".search_by_license_num_helper").show();
    jQuery(".research_link_con").hide();
    show_car_inputs();
    jQuery('.collapse_two_first_sec button.btn-next').show();
}

function reset_vehicles_inputs($) {

    $("#vehicle-manufacturer").html('').append("<option value=''>בחר</option>");
    $('#manufacturer_source option').each(function (i) {
        let option = '<option value=' + $(this).html() + '>' + $(this).html() + '</option>';
        $("#vehicle-manufacturer").append(option);
    });
    $('#vehicle-year, #vehicle-brand, #vehicle-sub-brand').html("<option value=''>בחר</option>");
    $('#keeping-distance-system-1, #keeping-distance-system-2, #deviation-system-1, #deviation-system-2').attr('checked', false);
    $('input[name="engine_capacity"], #levi-code, #esp, #fcw, #ldw, #abs, #koah_sus, #delek_cd').val("");
    $('input[name="air_bags"]').val("1");
}


