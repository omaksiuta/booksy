$(document).ready(function () {
    $("#Profile").validate({
        ignore: [],
        rules: {
            Firstname: {
                required: true,
            },
            Lastname: {
                required: true
            },
            Email: {
                required: true,
                email: true
            },
            Phone: {
                minlength: 10,
                maxlength: 14,
                required: true,
            },
            Pro_img: {
                extension: "jpg|jpeg|png|gif"
            }
        },
        messages: {
            Firstname: {
                required: please_enter_your_firstname_lng,
            },
            Lastname: {
                required: please_enter_your_lastname_lng,
            },
            Email: {
                required: please_enter_a_valid_email_lng,
                email: please_enter_a_valid_email_lng
            },
            Phone: {
                required: please_enter_your_phone_number_lng,
                minlength: phone_minimum_lng,
                maxlength: phone_maximum_lng
            },
            Pro_img: {
                extension: File_must_be_JPEG_or_PNG_lng
            }
        },
    });

});
// Profile Image On Click Function 
function readURL(input) {
    var id = $(input).attr("id");
    var image = '#' + id;
    //alert(image);
    var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
        var reader = new FileReader();
    reader.onload = function (e) {
        $('img' + image).attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
}