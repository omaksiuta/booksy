$(document).ready(function () {
    jQuery.validator.setDefaults({ignore: ":hidden:not(#summornote_div_id),.note-editable.panel-body"});
    folder_name = $('#folder_name').val();
    $('#RecordAddonsDelete').on('click', function () {
        var id = $("#record_id").val();
        $.ajax({
            url: site_url + folder_name + "/delete-service-addons/" + id,
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

    // set default dates
    var start = new Date();
    // set end date to max one year period:
    var end = new Date(new Date().setYear(start.getFullYear() + 1));

    if($('#from_date').length>0){
        $('#from_date').datepicker({
            autoclose: true,
            startDate: start,
            endDate: end
            // update "toDate" defaults whenever "fromDate" changes
        }).on('changeDate', function () {
            // set the "toDate" start to not be later than "fromDate" ends:
            $('#to_date').datepicker('setStartDate', new Date($(this).val()));
        });
    }

    if($('#to_date').length>0){
        $('#to_date').datepicker({
            autoclose: true,
            startDate: start,
            endDate: end
        }).on('changeDate', function () {
            $('#from_date').datepicker('setEndDate', new Date($(this).val()));
        });
    }

    if($("#ServiceForm").length){
        $("#ServiceForm").submit(function (e) {
            if ($("#ServiceForm").valid()) {
                $("body").preloader({
                    percent: 10,
                    duration: 15000
                });
            } else {
                e.preventDefault();
            }
        });
    }

    $('#RecordDelete').on('click', function () {
        var id = $("#record_id").val();
        $.ajax({
            url: site_url + folder_name + "/delete-service/" + id,
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

    if($('#start_time').length>0){
        $('#start_time').timepicker({
            showMeridian: false,
            defaultTime: '07:00',
            minuteStep: 1,
        }).on('hide.timepicker', function (e) {
            openingHour = e.time.hours;
            openingMinutes = e.time.minutes;
            document.getElementById('end_time').value = "";
        });
    }



    if($('#end_time').length>0){
        $('#end_time').timepicker({
            showMeridian: false,
            defaultTime: '08:00',
            minuteStep: 1,
        }).on('hide.timepicker', function (e) {
            closingHour = e.time.hours;
            closingMinutes = e.time.minutes;

            if (typeof openingHour == 'undefined') {
                Old_openingHour = $("#event_starttime").val();
                openingHour_Arr = Old_openingHour.split(":");
                openingHour = openingHour_Arr[0];
                openingMinutes = openingHour_Arr[1];
            }

            if (closingHour < openingHour) {
                document.getElementById('end_time').value = "";
                toastr.error("End Time should be greater than Starting Time");
            }

            if (openingHour == closingHour && openingMinutes > closingMinutes) {
                document.getElementById('end_time').value = "";
                toastr.error("End Time should be greater than Starting Time");
            }
            if (openingHour == closingHour && openingMinutes == closingMinutes) {
                document.getElementById('end_time').value = "";
                toastr.error("End Time should be greater than Starting Time");
            }
        });
    }

});
function get_location(ci) {
    folder_name = $('#folder_name').val();
    if (ci > 0) {
        $.ajax({
            url: site_url + folder_name + "/get-location/" + ci,
            type: "post",
            data: {token_id: csrf_token_name},
            beforeSend: function () {
                $("#loadingmessage").show();
            },
            success: function (data) {
                    $("#location").html(data);
                $("#loadingmessage").hide();
            }
        });
    }
}
function get_more_image(e) {
    var count=$(".service_gallery_images").length+1;

    var html="";
    html+='<div class="col-sm-3 service_gallery_images image_cnt'+count+'">';
    html+='<div class="card">';
    html+='<img class="card-img-top" src="'+base_url+'/assets/images/no-image.png" height="150">';
    html+='<div class="card-body">';
    html+='<input tabindex="28" accept="image/*"  required onchange="readServiceImage(this)"  type="file" id="image" name="image[]" class="form-control">';
    html+='<a href="javascript:void(0)" data-id="'+count+'" onclick="remove_service_add_more_image(this)" class="btn btn-danger btn-sm mt-2"><i class="fe fe-trash"></i></a>';
    html+='</div>';
    html+='</div>';
    html+='</div>';

    $("#sortable").append(html);
}

function  remove_service_add_more_image($this) {
    var count=$($this).data('id');
    $(".image_cnt"+count).remove();
}
function delete_event_image(e) {
    folder_name = $('#folder_name').val();
    if (confirm("Want to delete?")) {
        i = $(e).data('url');
        id = $(e).data('id');
        h = $('#hidden_image').val();
        $.ajax({
            url: site_url + folder_name + "/delete-event-image",
            type: "post",
            data: {id: id, i: i, h: h, token_id: csrf_token_name},
            beforeSend: function () {
                $("#loadingmessage").show();
            },
            success: function (data) {
                if (data != false) {
                    $('#hidden_image').val(data);
                    $(e).parents('.service_gallery_images').remove();
                }
                var remain_image = $("#images_ul > li").length;
                if (remain_image <= 0) {
                    $("#image").attr("required", true);
                }
                $("#loadingmessage").hide();
            }
        });
    }
}
function delete_event_seo_image(e) {
    folder_name = $('#folder_name').val();
    if (confirm("Want to delete?")) {
        i = $(e).data('url');
        id = $(e).data('id');
        $.ajax({
            url: site_url + folder_name + "/delete-event-seo-image",
            type: "post",
            data: {id: id, i: i, token_id: csrf_token_name},
            beforeSend: function () {
                $("#loadingmessage").show();
            },
            success: function (data) {
                if (data != false) {
                    $(e).parents('li').remove();
                }
                $("#loadingmessage").hide();
            }
        });
    }
}
$("input[name='payment_type']").on('change', function () {
    if (this.value == 'P') {
        $("#price-box,.price-box").removeClass('d-none');
        $("#price").attr('required', true);
        $("#price, #discount").attr('min', '1');
        $("#discount").attr('max', '100');
    } else {
        $("#price-box,.price-box").addClass('d-none');
        $("#price").attr('required', false);
    }
});
$("input[name='is_display_address']").on('change', function () {
    if (this.value == 'Y') {
        $("#map_address").removeClass('d-none');
        $("#autocomplete").attr('required', true);
    } else {
        $("#map_address").addClass('d-none');
        $("#autocomplete").attr('required', false);
    }
});
$("input[name='multiple_slotbooking_allow']").on('change', function () {
    if (this.value == 'Y') {
        $("#book_limit").removeClass('d-none');
        $("#multiple_slotbooking_limit").attr('required', true);
    } else {
        $("#book_limit").addClass('d-none');
        $("#multiple_slotbooking_limit").attr('required', false);
    }
});
// Steppers                
$(document).ready(function () {
    var navListItems = $('div.setup-panel-2 div a'),
            allWells = $('.setup-content-2'),
            allNextBtn = $('.nextBtn-2'),
            allPrevBtn = $('.prevBtn-2');

    allWells.hide();

    navListItems.click(function (e) {
        if ($(".bootstrap-timepicker-widget").length) {
            $(".bootstrap-timepicker-widget").hide();
        }
        e.preventDefault();
        var $target = $($(this).attr('href')),
                $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-amber').addClass('btn-blue-grey');
            $item.addClass('btn-amber');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allPrevBtn.click(function () {
        var curStep = $(this).closest(".setup-content-2"),
                curStepBtn = curStep.attr("id"),
                prevStepSteps = $('div.setup-panel-2 div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

        prevStepSteps.removeAttr('disabled').trigger('click');
    });

    allNextBtn.click(function () {
        var curStep = $(this).closest(".setup-content-2"),
                curStepBtn = curStep.attr("id"),
                nextStepSteps = $('div.setup-panel-2 div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                curInputs = curStep.find("input[type='time'], input[type='number'], input[type='text'],input[type='url'],input[type='email'],input[type='file'], textarea ,select"),
                isValid = true;

        var form = $("#ServiceForm");
        form.validate({
            ignore: [],
            rules: {
                name: {
                    required: true
                },
                description: {
                    required: true
                },
                category_id: {
                    required: true
                },
                'days[]': {
                    required: true
                },
                start_time: {
                    required: true
                },
                end_time: {
                    required: true
                },
                slot_time: {
                    required: true
                },
                per_allow: {
                    required: true
                },
                city: {
                    required: true
                },
                location: {
                    required: true
                },
                status: {
                    required: true
                }
            },
            errorElement: 'div',
            errorPlacement: function (error, element) {
                element.parents(".form-group").append(error);
            }
        });
        if (!curInputs.valid()) {
            return false;
        }
        if (isValid)
            nextStepSteps.removeAttr('disabled').trigger('click');
    });

    $('div.setup-panel-2 div a.btn-amber').trigger('click');
});
function calc_final_price(element) {
    var discount = parseFloat($("#discount").val());
    var price = parseFloat($("#price").val());
    if (discount != '' && !isNaN(discount) && typeof discount != 'undefined' && discount > 0) {
        $("#from_date, #to_date").attr("required", true);
        cal_discount = parseFloat((price * discount) / 100);
        if (!isNaN(cal_discount)) {
            final_Price = parseFloat(price - cal_discount);
            if (!isNaN(final_Price)) {
                $("#discounted_price").val(final_Price.toFixed(2));
            }
        }

    } else {
        $("#from_date, #to_date").attr("required", false);
    }
}

function readServiceImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(input).closest('.card-body').parent().find('img').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}