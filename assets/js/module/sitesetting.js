$('#spnCharLeft').css('display', 'none');
var maxLimit = 130;

$(document).ready(function () {
    $('#footer_text').keyup(function () {
        var lengthCount = this.value.length;
        if (lengthCount > maxLimit) {
            this.value = this.value.substring(0, maxLimit);
            var charactersLeft = maxLimit - lengthCount + 1;
        } else {
            var charactersLeft = maxLimit - lengthCount;
        }
        $('#spnCharLeft').css('display', 'block');
        $('#spnCharLeft').text(charactersLeft + ' Characters left');
    });
    if ($('.demo').length) {
        $(".demo").minicolors({
            control: $(this).attr('data-control') || 'hue',
            defaultValue: $(this).attr('data-defaultValue') || '',
            format: $(this).attr('data-format') || 'hex',
            keywords: $(this).attr('data-keywords') || '',
            inline: $(this).attr('data-inline') === 'true',
            letterCase: $(this).attr('data-letterCase') || 'lowercase',
            opacity: $(this).attr('data-opacity'),
            position: $(this).attr('data-position') || 'bottom left',
            swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
            change: function (value, opacity) {
                if (!value)
                    return;
                if (opacity)
                    value += ', ' + opacity;
                if (typeof console === 'object') {
                    console.log(value);
                }
            },
            theme: 'bootstrap'
        });
    }

    $("#site_form").submit(function (e) {
        if ($("#site_form").valid()) {
            $("body").preloader({
                percent: 10,
                duration: 15000
            });
        } else {
            e.preventDefault();
        }
    });
    $("#site_business_form").submit(function (e) {
        if ($("#site_business_form").valid()) {
            $("body").preloader({
                percent: 10,
                duration: 15000
            });
        } else {
            e.preventDefault();
        }
    });
    $("#site_business_form").validate({
        ignore: [],
        rules: {
            minimum_vendor_payout: {
                required: true
            }
        },
    });
    $("#site_email_form").validate({
        ignore: [],
        rules: {
            smtp_host: {
                required: true
            },
            smtp_password: {
                required: true
            },
            smtp_secure: {
                required: true
            },
            smtp_port: {
                required: true,
                number: true
            },
            smtp_username: {
                required: true
            },
        },
    });
    $("#site_email_form").submit(function (e) {
        if ($("#site_email_form").valid()) {
            $("body").preloader({
                percent: 10,
                duration: 15000
            });
        } else {
            e.preventDefault();
        }
    });
});
// Profile Image On Click Function 
function readURL(input) {
    var id = $(input).attr("id");
    var image = '#' + id;
    //alert(image);
    var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
        var reader = new FileReader();
    reader.onload = function (e) {
        $('img' + image).attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
}
// Profile Image On Click Function 
function readURLIcon(input) {
    var id = $(input).attr("id");
    var image = '#' + id;
    //alert(image);
    var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "ico"))
        var reader = new FileReader();
    reader.onload = function (e) {
        $('img' + image).attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
}

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

// Steppers                
$(document).ready(function () {
    var navListItems = $('div.setup-panel-2 div a'),
            allWells = $('.setup-content-2'),
            allNextBtn = $('.nextBtn-2'),
            allPrevBtn = $('.prevBtn-2');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
                $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('kb-color').addClass('btn-blue-grey');
            $item.addClass('kb-color');
            $item.removeClass('btn-blue-grey');
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
                curInputs = curStep.find("input[type='number'], input[type='text'],input[type='url'],input[type='email'],input[type='file'], textarea ,select"),
                isValid = true;

        var form = $("#site_form");
        form.validate({
            ignore: [],
            rules: {
                company_name: {
                    required: true
                },
                company_email1: {
                    required: true,
                    email: true
                },
                Pro_img: {
                    extension: "png|jpeg|jpg",
                },
                banner_img: {
                    extension: "png|jpeg|jpg",
                },
                fevicon_icon: {
                    extension: "png|jpeg|jpg",
                }
            },
            messages: {
                company_name: {
                    required: please_enter_your_company_name_lng
                },
                company_email1: {
                    required: please_enter_a_valid_email_lng,
                    email: please_enter_a_valid_email_lng
                },
                Pro_img: {
                    extension: File_must_be_JPEG_or_PNG_lng
                },
                banner_img: {
                    extension: File_must_be_JPEG_or_PNG_lng
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

    $('div.setup-panel-2 div a.kb-color').trigger('click');


});

function update_date_time(time_format) {
    $.ajax({
        url: site_url + "admin/update-display-setting",
        type: "post",
        data: {token_id: csrf_token_name, action: 'update_time', time_format: time_format},
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
function get_webpage(e) {
    var value = $(e).val();
    if (value != '') {
        $("#integration_form").submit();
    }
}
function copy_code(e) {
    var value = $("#webpage").val();
    if (value != '') {
        $("#content").select();
        document.execCommand('copy');
    } else {
        toastr.error("Please first select choice");
    }
}