$(document).ready(function () {
    $("#PackageForm").validate({
        ignore: [],
        rules: {
            title: {
                required: true
            },
            description:{
                required:true
            },
            price: {
                required: true
            },
            max_event: {
                required: true
            }
        },
    });
    
    $("#PackageForm").submit(function () {
        if ($("#PackageForm").valid()) {
            $('.loadingmessage').show();
        }
    });
    
    $('#RecordDelete').on('click', function () {
        var id = $("#record_id").val();
        $.ajax({
            url: site_url + "admin/delete-package/" + id,
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