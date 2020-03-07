// User Registration Form
$(document).ready(function () {
    $("#Register_user").validate({
        ignore: [],
        rules: {
            first_name: {
                required: true,
            },
            last_name: {
                required: true
            },
            email: {
                required: true,
                email: true,
                remote: {
                    url: base_url + "check-vendor-email",
                    type: "post",
                    data: {
                        title: function () {
                            return $("#email").val();
                        }, id: function () {
                            return $("#vendor_id").val();
                        }
                    }
                }
            },
            password: {
                required: true,
                minlength: 8
            },
            company: {
                required: true
            },
            address: {
                required: true
            },
            website: {
                url: true
            },
            phone: {
                required: true,
                remote: {
                    url: base_url + "check-vendor-phone",
                    type: "post",
                    data: {
                        title: function () {
                            return $("#phone").val();
                        }, id: function () {
                            return $("#vendor_id").val();
                        }
                    }
                }
            },
        },
        messages: {
            first_name: {
                required: please_enter_your_firstname_lng
            },
            last_name: {
                required: please_enter_your_lastname_lng
            },
            email: {
                required: please_enter_a_valid_email_lng,
                email: please_enter_a_valid_email_lng,
                remote: email_is_already_existing_lng
            },
            password: {
                required: please_enter_a_password_lng,
                minlength: please_enter_minimum_8_characters_lng
            },
            company: {
                required: please_enter_your_company_name_lng
            },
            website: {
                url: valid_website_lng
            },
            phone: {
                required: please_enter_your_phone_number_lng,
                remote: phone_already_exist
            },
            address: {
                required: please_enter_your_address_lng,
            }
        },
    });

});

$(document).ready(function () {
    $('[data-toggle="popover"]').popover({
        placement: 'top',
        trigger: 'hover'
    });
});


$(document).on('keydown', '.phone_integers', function (e) {
    console.log(e.keyCode);
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190, 107, 173]) !== -1 ||
            (e.keyCode == 65 && e.ctrlKey === true) ||
            (e.keyCode == 67 && e.ctrlKey === true) ||
            (e.keyCode == 88 && e.ctrlKey === true) ||
            (e.keyCode >= 35 && e.keyCode <= 39) || (e.keyCode == 107)) {
        return;
    }
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105) && e.keyCode != 107) {
        e.preventDefault();
    }
});