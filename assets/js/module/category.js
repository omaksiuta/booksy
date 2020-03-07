$(document).ready(function () {
    $("#AgentForm").validate({
        ignore: [],
        rules: {
            title: {
                required: true
            },
            status: {
                required: true
            }
        },
    });
    $("#CategoryForm").submit(function () {
        if ($("#AgentForm").valid()) {
            $('.loadingmessage').show();
        }
    });
    $('#RecordDelete').on('click', function () {
        var id = $("#record_id").val();
        $.ajax({
            url: site_url + "delete-category/" + id,
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