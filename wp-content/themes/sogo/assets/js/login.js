/**
 * Created by oren on 25-Sep-16.
 */


(function ($) {
    'use strict';

    $(document).ready(function () {


        var register_form = $('#sogo_registration_form');

        console.log(register_form.length);
        var login_form = $('#sogo_login_form');
        var logout = $('#sogo_logout');
        if (login_form.length > 0) {

            // handle login submit form
            login_form.submit(function (e) {
                e.preventDefault();
                console.log('eeeeee');
                var f = $(this);

                if ($(this).valid()) {
                    var data = {
                        'action': 'sogo_login',
                        'data': $(this).serialize()
                    };

                    $.ajax({
                        type: "POST",
                        dataType: "json", // and this
                        url: sogo.ajaxurl,
                        data: data,
                        success: function (response) {
                            var error = f.find('.error');

                            error.html('');
                            error.removeClass('error-msg');

                            if (!response.error) {
                                f.find('.error').addClass('success').removeClass('error').html(response.message);
                                location.reload();
                            }
                            else {
                                error.addClass('error-msg');
                                $.each(response.message.errors, function (key, value) {
                                    error.append(value);
                                });
                            }
                        }
                    })

                }
            });

            // do form validation for login.
            login_form.validate({
                rules: {
                    username: "required",
                    password: "required"
                }
            });


        }


        if (register_form.length > 0) {
            // handle register submit form
            register_form.submit(function (e) {
                e.preventDefault();
                var f = $(this);
                if ($(this).valid()) {
                    var data = {
                        'action': 'sogo_register',
                        'data': $(this).serialize()
                    };

                    $.ajax({
                        type: "post",
                        dataType: "json",
                        url: sogo.ajaxurl,
                        data: data,
                        success: function (response) {
                            console.log(response);

                            if (!response.error) {
                                location.href = sogoc.dashboard_url;
                            }
                            else {
                                f.find('.error').html(response.message);
                            }
                        }
                    })

                }
            });


            // do form validation for registration.
            register_form.validate({
                rules: {
                    first_name: "required",
                    last_name: "required",
                    tac: {
                        required: true
                    },
                    username: {
                        required: true,
                        minlength: 2
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                    confirm_password: {
                        required: true,
                        minlength: 5,
                        equalTo: "#password"
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    'meta[tz]': 'required'
                },
                errorPlacement: function (error, element) {
                    if (element.attr("type") == "checkbox" || element.attr("type") == "radio") {
                        error.insertAfter($(element).next());
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        }


        logout.on('click', function () {

            $.ajax({
                type: "POST",
                dataType: "json", // and this
                url: sogo.ajaxurl,
                data: {
                    'action': 'sogo_logout'
                },
                success: function (response) {
                    console.log(response);
                    if (response === 1) {
                        window.location.href = sogoc.site_url;
                    }
                }
            })
        });
    });


}(jQuery));