$(document).ready(function () {
    folder_name = $('#folder_name').val();
    jQuery.validator.setDefaults({ignore: ":hidden:not(#summornote_div_id),.note-editable.panel-body"});
    folder_name = $('#folder_name').val();
    $("#ContentForm").validate({
        ignore: [],
        rules: {
            title: {
                required: true,
                remote: {
                    url: site_url + folder_name + "/check-page-title",
                    type: "post",
                    data: {
                        title: function () {
                            return $("#title").val();
                        },
                        id: function () {
                            return $("#id").val();
                        }
                    }
                }
            },
            description: {
                required: true
            }
        }, messages: {
            title: {
                remote: "Title is already existing."
            }
        }
    });
    $("#ContentForm").submit(function () {
        if ($("#ContentForm").valid()) {
            $('.loadingmessage').show();
        }
    });
    $('#RecordDelete').on('click', function () {
        var id = $("#record_id").val();
        $.ajax({
            url: site_url + "admin/delete-content/" + id,
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