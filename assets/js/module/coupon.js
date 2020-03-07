$(document).ready(function () {
    if($('#coupon_event_box').length>0){
        $('#coupon_event_box').select2();
    }

    $("#CouponAddForm").validate({
        ignore: [],
        rules: {
            title: {
                required: true
            },
            date: {
                required: true
            },
            event_id: {
                required: true
            },
            code: {
                required: true
            },
            discount_type: {
                required: true
            },
            discount_value: {
                required: true
            }
        },
    });

    $("#CouponAddForm").submit(function () {
        if ($("#CouponAddForm").valid()) {
            $('.loadingmessage').show();
        }
    });

    $('#RecordDelete').on('click', function () {
        var id = $("#record_id").val();
        $.ajax({
            url: site_url + "admin/delete-coupon/" + id,
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
