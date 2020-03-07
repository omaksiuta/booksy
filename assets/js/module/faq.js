$(document).ready(function () {
    folder_name = $('#folder_name').val();
    $("#FaqForm").validate({
        ignore: [],
        rules: {
            title: {
                required: true,
            }, description: {
                required: true,
            },
        }
    });
    $("#FaqForm").submit(function () {
        if ($("#FaqForm").valid()) {
            $('.loadingmessage').show();
        }
    });
    $('#RecordDelete').on('click', function () {
        var id = $("#record_id").val();
        $.ajax({
            url: site_url + "admin/delete-faq/" + id,
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
function DeleteRecord(element) {
    var id = $(element).attr('data-id');
    var title = $(element).attr('title');
    $("#some_name").html(title);
    $("#confirm_msg").html(delete_confirm_lng);
    $("#record_id").val(id);
}