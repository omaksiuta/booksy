$(document).ready(function () {
    folder_name = $('#folder_name').val();
    $("#EventCategoryForm").validate({
        ignore: [],
        rules: {
            title: {
                required: true,
            },
        },
    });
    $("#EventCategoryForm").submit(function () {
        if ($("#EventCategoryForm").valid()) {
            $('.loadingmessage').show();
        }
    });
    $('#RecordDelete').on('click', function () {
        var id = $("#record_id").val();
        $.ajax({
            url: site_url + folder_name + "/delete-category/" + id,
            type: "post",
            data: {token_id: csrf_token_name},
            beforeSend: function () {
                $("body").preloader({
                    percent: 10,
                    duration: 15000
                });
            },
            success: function (data) {
                 window.location.reload();
            }
        });
    });
});

