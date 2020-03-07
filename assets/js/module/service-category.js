$(document).ready(function () {
    folder_name = $('#folder_name').val();
    $("#ServiceCategoryForm").validate({
        ignore: [],
        rules: {
            title: {
                required: true,
            }
        },
    });
    $("#ServiceAddonsForm").validate({
        ignore: [],
        rules: {
            title: {
                required: true,
            },
            details: {
                required: true,
            }
        },
    });
    $("#ServiceCategoryForm").submit(function () {
        if ($("#ServiceCategoryForm").valid()) {
            $('.loadingmessage').show();
        }
    });
    $('#RecordDelete').on('click', function () {
        var id = $("#record_id").val();
        $.ajax({
            url: site_url + folder_name + "/delete-service-category/" + id,
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
