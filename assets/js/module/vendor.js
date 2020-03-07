function payment_gateway_fee() {

    var payment_gateway_fee = $("#payment_gateway_fee").val();
    var other_charge = $("#other_charge").val();
    var amount = $("#main_request_price").val();

    var calcPrice = (amount - (amount * (payment_gateway_fee / 100)));
    $("#updated_amount").val(calcPrice - other_charge);

}

function UpdateStatus($this) {
    var record_id = ($($this).attr('data-id'));
    var gateway = ($($this).attr('data-cpayment'));
    var amount = ($($this).attr('data-amount'));
    $("#payment_gateway").val(gateway);
    $("#main_request_price").val(amount);
    $("#payment_gateway").attr("disabled", true);
    $("#record_id").val(record_id);
    $("#updated_amount").val(amount);
}

$(document).ready(function () {

    $("#Reset_password").validate({
        rules: {
            password: {
                required: true,
                minlength: 8
            },
            cpassword: {
                required: true,
                equalTo: "#password"
            }
        },
        messages: {
            password: {
                required: please_enter_a_password_lng,
                minlength: please_enter_minimum_8_characters_lng
            },
            cpassword: {
                required: please_enter_confirm_password_lng,
                equalTo: password_confirm_password_valid_lng
            }
        },
        highlight: function (e) {
            $(e).closest('.validate').removeClass('has-success has-error').addClass('has-error');
        }
    });

    if ($('.bookslide').length > 0) {
        $('.bookslide').slidePanel();
    }

    $("#other_charge").on("blur", function (e) {
        payment_gateway_fee();
    });
    $("#payment_gateway_fee").on("blur", function (e) {
        payment_gateway_fee();
    });
    $("#UpdateStatusBtn").on("click", function (e) {
        var UpdateRecordForm = $("#UpdateRecordForm").valid();
        var formData = $("#UpdateRecordForm").serialize();
        if (UpdateRecordForm == true) {
            var record_id = $("#record_id").val();
            $.ajax({
                url: base_url + "admin/payment_update/" + record_id,
                type: "post",
                data: formData,
                beforeSend: function () {
                    $("body").preloader({
                        percent: 10,
                        duration: 15000
                    });
                },
                success: function (responseJSON) {
                    window.location.reload();
                }
            });
        }

    });


    $('#RecordDelete').on('click', function () {
        var id = $("#record_id").val();
        $.ajax({
            url: site_url + "admin/delete-vendor/" + id,
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
    $('#CustomerChange').on('click', function () {
        var id = $("#CustomerIDVal").val();
        var status = $("#get_status").val();
        if ($('#StausForm').valid()) {
            $.ajax({
                url: site_url + "admin/change-vendor-status/" + id,
                type: "post",
                data: {status: status, token_id: csrf_token_name},
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
        }
    });
    $('#UpdateCustomerStatus').on('click', function () {
        var id = $("#CustomerIDVal").val();
        var status = $("#get_status").val();
        if ($('#StausForm').valid()) {
            $('#StausForm').submit();
        }
    });
});
