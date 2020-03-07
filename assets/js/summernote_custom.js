if($('#summornote_div_id').length>0){
    $('#summornote_div_id').summernote({
        minHeight: 300,
        callbacks: {
            onImageUpload: function (files, editor, welEditable) {
                sendFile(files[0], editor, welEditable);
            }
        }
    });
}

function sendFile(file, editor, welEditable) {
    data = new FormData();
    data.append("file", file);
    $.ajax({
        data: data,
        type: "POST",
        url: base_url+"upload-summernote-image",
        cache: false,
        contentType: false,
        processData: false,
        success: function (url) {
            $('#summornote_div_id').summernote("insertImage", url);
        }
    });
}
$('.note-video-clip').each(function () {
    var tmp = $(this).wrap('<p/>').parent().html();
    $(this).parent().html('<div class="embed-responsive embed-responsive-16by9">' + tmp + '</div>');
});