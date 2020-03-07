jQuery.extend(jQuery.validator.messages, {
    required:required_message_lng,
    remote: "Please fix this field.",
    email: please_enter_a_valid_email_lng,
    equalTo: password_confirm_password_valid_lng,
    maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
    minlength: jQuery.validator.format("Please enter at least {0} characters."),
    rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
    range: jQuery.validator.format("Please enter a value between {0} and {1}."),
    max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
    min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
});