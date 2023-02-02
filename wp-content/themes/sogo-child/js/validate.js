(function ($) {
    'use strict';
    $(document).ready(function () {

        /*
 * Translated default messages for the jQuery validation plugin.
 * Locale: HE (Hebrew; עברית)
 */
        $.extend($.validator.messages, {
            required: "השדה הזה הינו שדה חובה",
            remote: "נא לתקן שדה זה",
            email: "נא למלא כתובת דוא\"ל חוקית",
            url: "נא למלא כתובת אינטרנט חוקית",
            date: "נא למלא תאריך חוקי",
            dateISO: "נא למלא תאריך חוקי (ISO)",
            number: "נא למלא מספר",
            digits: "נא למלא רק מספרים",
            creditcard: "נא למלא מספר כרטיס אשראי חוקי",
            equalTo: "נא למלא את אותו ערך שוב",
            extension: "נא למלא ערך עם סיומת חוקית",
            maxlength: $.validator.format(".נא לא למלא לא יותר מ- {0} תווים"),
            minlength: $.validator.format("נא למלא לפחות {0} תווים"),
            rangelength: $.validator.format("נא למלא ערך בין {0} ל- {1} תווים"),
            range: $.validator.format("נא למלא ערך בין {0} ל- {1}"),
            max: $.validator.format("נא למלא ערך קטן או שווה ל- {0}"),
            min: $.validator.format("נא למלא ערך גדול או שווה ל- {0}"),
            eitan: "גיל הנהג פחות וותק חייב להיות מעל 17",
            checkVal2: "אינך יכול להמשיך אם היו לך 2 תביעות או יותר",
            checkCriminalRecords: "אינך יכול/ה להמשיך אם עבר פלילי",
            checkDenials: "אינך יכול/ה להמשיך אם היו לך 2 שלילות או אם הינך כרגע בשלילה",
            lettersonly: 'מותר רק אותיות',
            validateYear: 'נא למלא מס רישוי נכון',
            checkID: 'יש למלא מספר זהות תקין'
        });


        $("#form-1").validate({
            rules: {
                // simple rule, converted to {required:true}
                name: "required",
                // compound rule
                email: {
                    required: true,
                    checkEmail: true
                },
                city: 'required',
                'insurance_period': "required",
                'insurance-date-finish': "required",
                'vehicle-manufacturer': 'required',
                'vehicle-year': 'required',
                'vehicle-brand': 'required',
                'vehicle-sub-brand': 'required',
                'gears': 'required',
                'deviation-system': 'required',
                'stability-system': 'required',
                'keeping-distance-system': 'required',
                'ownership': 'required',
                'vehicle-ownership': 'required',
                "drive-on-saturday": "required",
                // 'youngest-driver': 'required',
                // 'lowest-seniority': 'required',
                'gender': 'required',
                'drive-allowed-number': 'required',
                'denials': 'required',
                'lawsuits': 'required',
                'youngest-driver': {
                    required: true,
                    eitan: true
                },
                'lowest-seniority': {
                    required: true,
                    eitan: true
                },
                'insurance-before': 'required',
                'insurance-1-year': 'required',
                'insurance-2-year': 'required',
                'insurance-3-year': 'required',
                'law-suite-what-year': 'required',
                'law-suites-3-year': {
                    required: true,
                    checkVal2: true
                },
                'body-claims': {
                    required: true,
                    checkVal2: false
                },
                'criminal-record': {
                    required: true,
                    checkCriminalRecords: false
                },
                'license-suspensions': {
                    required: true,
                    checkDenials: false
                },
                'tac': 'required'
            },
            errorPlacement: function (error, element) {
                // console.log(element[0].tagName);
                if (element[0].tagName === "SELECT") {
                    // console.log('after!!!');
                    error.insertAfter($(element).closest('.s-select-wrapper'));
                }
                else if (element.attr('type') === 'radio') {
                    error.insertAfter($(element).closest('.s-radio-wrapper'));
                }
                else if (element.hasClass('datepicker')) {
                    error.insertAfter($(element).closest('.date-picker'));
                }
                else if (element.hasClass('tac-1')) {
                    error.insertAfter($(element).next());
                }
                else {
                    // console.log('not!!!');
                    error.insertAfter(element);
                }
            }
        });

        $("#form-2").validate({

            rules: {
                // simple rule, converted to {required:true}
                'license-number': {
                    required: true,
                    digits: true,
                    validateYear: true,
                    minlength: 7,
                    maxlength: 8
                },
                'compare3-name': {
                    required: true,
                    lettersonly: true
                },
                'compare3-phone': {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                'ownership-date': 'required',
                'first-name': {
                    required: true,
                    lettersonly: true
                },
                'last-name': {
                    required: true,
                    lettersonly: true
                },
                'identical-number': {
                    required: true,
                    digits: true,
                    checkID: true
                },
                'driver-identical-number': {
                    required: true,
                    digits: true,
                    checkID: true,
                    maxlength: 8
                },
                'driver-identical-number[]': {
                    required: true,
                    digits: true,
                    checkID: true,
                    maxlength: 10
                },
                'driver-identical-number_0': {
                    required: true,
                    digits: true,
                    checkID: true,
                    maxlength: 10
                },
                'driver-identical-number_1': {
                    required: true,
                    digits: true,
                    checkID: true,
                    maxlength: 10
                },
                'driver-identical-number_2': {
                    required: true,
                    digits: true,
                    checkID: true,
                    maxlength: 10
                },
                'driver-identical-number_3': {
                    required: true,
                    digits: true,
                    checkID: true,
                    maxlength: 10
                },
                // compound rule
                // 'ownership-under-year': 'required',
                'ownership-under-year': {
                    required: true,
                    minlength: 4,
                },
                'birthday-date': 'required',
                'policy-send': 'required',
                'gender': "required",
                'driver-gender[0]': 'required',
                'driver-gender[1]': 'required',
                'driver-gender[2]': 'required',
                'drive-allowed': "required",
                'license-year': {
                    required: true,
                    digits: true,
                    maxlength: 4
                },
                'mobile-phone-number': {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                'email': {
                    required: true
                    //checkEmail: true
                },
                'additional-phone-number': {
                    digits: true,
                    maxlength: 10
                },
                'city': {
                    required: true
                },
                'city-another': {
                    required: true
                },
                'street': {
                    required: true
                    // lettersonly: true
                },
                'street-another': {
                    required: true
                    // lettersonly: true
                },

                'house-number': {
                    required: true,
                    //digits: true
                },
                'house-number-another': {
                    required: true,
                    //digits: true
                },
                'apartment-number': {
                    digits: true
                },
                'apartment-number-another': {
                    digits: true
                },
                //  'city-another': "required",
                // 'street-another': "required",
                // 'house-number-another': "required",
                'driver-first-name[]': {
                    required: true,
                    lettersonly: true
                },
                'driver-last-name[]': {
                    required: true,
                    lettersonly: true
                },
                'driver-birthday[]': "required",
                'driver-gender-1': "required",
                'driver-gender-2': "required",
                'driver-gender-3': "required",
                'driver-gender-4': "required",
                'driver-gender-5': "required",
                'driver-gender-6': "required",
                'years-issuing-license[]': {
                    required: true,
                    digits: true,
                    maxlength: 4
                },
                'cardholder-name': {
                    required: true,
                    lettersonly: true
                },
                'cardholder-id': {
                    required: true,
                    digits: true,
                    checkID: true
                },
                'card-type': "required",
                'card-number': {
                    required: true,
                    digits: true
                },
                'card-month': {
                    required: true,
                    digits: true,
                    maxlength: 2,
                    range: [1, 12]
                },
                'card-year': {
                    required: true,
                    digits: true
                },
                'tac-1': 'required',
                'cvv-number': "required",
                'mandat-num-payments': "required",
                'other-num-payments': "required"
            },
            errorPlacement: function (error, element) {
                // console.log(element[0].tagName);
                if (element[0].tagName === "SELECT") {
                    // console.log('after!!!');
                    error.insertAfter($(element).closest('.s-select-wrapper'));
                }
                else if (element.attr('type') === 'radio') {
                    error.insertAfter($(element).closest('.s-radio-wrapper'));
                }
                else if (element.hasClass('datepicker')) {
                    error.insertAfter($(element).closest('.date-picker'));
                }
                else if (element.hasClass('tac-1')) {
                    error.insertAfter($(element).next());
                }
                else {
                    // console.log('not!!!');
                    error.insertAfter(element);
                }
            }
        });

        jQuery.validator.addClassRules('required', {
            required: true
        });

        $('.contact-us-compare-form-email-1111').validate({
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

        $('.contact-us-compare-form-phone-1111').validate({
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

    });

    // add custom validations
    $.validator.addMethod("eitan", function (value, element, options) {
            //we need the validation error to appear on the correct element
            var youngest_age = $('#youngest-driver'),
                lowest_seniority = $('#lowest-seniority'),
                tooYoung = (parseInt(youngest_age.val()) - parseInt(lowest_seniority.val()) < 17);

            if (tooYoung) {
                youngest_age.addClass('error');
                lowest_seniority.addClass('error');
            }
            else {
                youngest_age.removeClass('error');
                lowest_seniority.removeClass('error');

                $(document).find('#form-1 #collapseThree #youngest-driver-error').remove();
                $(document).find('#form-1 #collapseThree #lowest-seniority-error').remove();
            }

            return !tooYoung;
        },
        "נא להזין גיל הנהג הצעיר ביותר"
    );

    jQuery.validator.addMethod("checkVal2", function (val) {

            var ins_type = jQuery('input[name="in_type"]').val();

            if (val == '3' && +ins_type !== 1) {
                return false;
            }
            return true;
        }, "לא ניתן להמשיך - עבר ביטוחי"
    );

    jQuery.validator.addMethod("checkCriminalRecords", function (val) {
            if (val == '1') {
                return false;
            }
            return true;
        }, "לא ניתן להמשיך - עבר פלילי"
    );

    jQuery.validator.addMethod("checkDenials", function (val) {
            if (val == '2' || val == '3') {
                return false;
            }
            return true;
        }, "לא ניתן להמשיך - כרגע בשלילה"
    );

    jQuery.validator.addMethod("validateYear", function (val, element, options) {
            var year = parseInt($(element).data('year'));
            console.log(year);
            if (year >= 2018) {
                if (val.length != 8) {
                    return false;
                }
            }

            if (year <= 2017) {
                if (val.length < 7 || val.lengt > 8) {
                    return false;
                }
            }

            return true;
        }, "נא להזין מספר רכב תקין"
    );

    jQuery.validator.addMethod("checkEmail", function (val) {
            var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;

            if (!pattern.test(val)) {
                return false;
            }
            return true;
        }, "נא להזין כתובת מייל חוקית"
    );

    //show only letters
    jQuery.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-z א-ת \' -]+$/i.test(value);
    }, "Letters only");

    jQuery.validator.addMethod("checkID", function (val, element) {
            // Just in case -> convert to string
            var IDnum = val;

            if (IDnum.length > 9) {
                IDnum = IDnum.substring(0, 9);
            }

            // Validate correct input
            if ((IDnum.length > 9) || (IDnum.length < 5))
                return false;
            if (isNaN(IDnum)) {
                return false;
            }


            // The number is too short - add leading 0000
            if (IDnum.length < 9) {
                while (IDnum.length < 9) {
                    IDnum = '0' + IDnum;
                }
            }

            // CHECK THE ID NUMBER
            var mone = 0, incNum;
            var tempIdNum = parseInt(IDnum);

            if (tempIdNum == 0) {
                return false;
            }

            for (var i = 0; i < 9; i++) {
                incNum = Number(IDnum.charAt(i));
                incNum *= (i % 2) + 1;
                if (incNum > 9)
                    incNum -= 9;
                mone += incNum;
            }

            if (mone % 10 == 0) {
                return true;
            }
            else {
                return false;
            }

        }, "נא להזין תעודת זהות תקינה"
    );

    jQuery.validator.addClassRules('driver-identical-number', {
        required: true /*,
        other rules */
    });

    //push options to select after refresh and if birth date already selected
    if ($(document).find('input[name="birthday-date"]').length > 0) {

        if ($(document).find('input[name="birthday-date"]').val() != '') {
            sogo_trigger_license_year();
        }
    }


    $(document).on('change', 'input[name="birthday-date"]', function () {

        sogo_trigger_license_year();
    });

})(jQuery);
