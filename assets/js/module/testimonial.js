$(document).ready(function () {
    folder_name = $('#folder_name').val();
    $("#testimonial_form").validate({
        ignore: [],
        rules: {
            name: {
                required: true,
            },
            details: {
                required: true,
            },
        }
    });
    $("#testimonial_form").submit(function () {
        if ($("#testimonial_form").valid()) {
            $('.loadingmessage').show();
        }
    });
    $('#RecordDelete').on('click', function () {
        var id = $("#record_id").val();
        $.ajax({
            url: site_url + "admin/delete-testimonial/" + id,
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
