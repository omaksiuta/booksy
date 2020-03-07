$(document).ready(function () {
    $("#Reset_password").validate({
        rules: {
            password: {
                required: true,
                minlength: 8
            },
            cpassword: {
                required: true,
                equalTo: "#password"
            }
        },
        messages: {
            password: {
                required: please_enter_a_password_lng,
                minlength: please_enter_minimum_8_characters_lng
            },
            cpassword: {
                required: please_enter_confirm_password_lng,
                equalTo: password_confirm_password_valid_lng
            }
        },
        highlight: function (e) {
            $(e).closest('.validate').removeClass('has-success has-error').addClass('has-error');
        }
    });

    $("#frmStaff").validate({
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
            designation: {
                required: true,
            },
           
            phone: {
                required: true,
            }
        },
        messages: {
            first_name: {
                required: please_enter_your_firstname_lng
            },
            designation: {
                required: required_message_lng
            },
            last_name: {
                required: please_enter_your_lastname_lng
            },
            email: {
                required: please_enter_a_valid_email_lng,
                email: please_enter_a_valid_email_lng,
                remote: email_is_already_existing_lng
            },
            phone: {
                required: please_enter_your_phone_number_lng,
                remote: phone_already_exist,
                minlength: phone_minimum_lng,
                maxlength: phone_maximum_lng,
            }, profile_image: {
                required: required_message_lng,
            }
        }
    });
    $('#RecordDelete').on('click', function () {
        var id = $("#record_id").val();
        folder_name = $('#folder_name').val();
        $.ajax({
            url: site_url + folder_name + "/delete-staff/" + id,
            type: "post",
            data: {token_id: csrf_token_name},
            beforeSend: function () {
                $("body").preloader({
                    percent: 10,
                    duration: 15000
                });
            },
            success: function (data) {
                if (data == true) {
                    window.location.reload();
                } else {
                    window.location.reload();
                }
            }
        });
    });
});
