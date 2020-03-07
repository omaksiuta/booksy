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
                email: true
            },
            password: {
                required: true,
                minlength: 8
            }
        },
        messages: {
            first_name: {
                required: please_enter_your_firstname_lng,
            },
            last_name: {
                required: please_enter_your_lastname_lng,
            },
            email: {
                required: please_enter_a_valid_email_lng,
                email: please_enter_a_valid_email_lng
            },
            password: {
                required: please_enter_a_password_lng,
                minlength: please_enter_minimum_8_characters_lng
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