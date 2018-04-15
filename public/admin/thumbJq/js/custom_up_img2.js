$(document).ready(function () {
    $('body').on('click', '#up-img-touch', function () {
        $("#doc-modal-1").modal({width: '600px'});
    })
});
$(function () {
    'use strict';
    // 初始化
    var $image = $('#image');
    var $width = $('#up-img-touch img').attr('data-width');
    var $height = $('#up-img-touch img').attr('data-height');

    $image.cropper({
        // aspectRatio: $width ? $width : 1,
        // autoCropArea: $height ? $height : 1,
        preview: '.up-pre-after',

    });

    // 事件代理绑定事件
    $('.docs-buttons').on('click', '[data-method]', function () {

        var $this = $(this);
        var data = $this.data();
        var result = $image.cropper(data.method, data.option, data.secondOption);
        switch (data.method) {
            case 'getCroppedCanvas':
                if (result) {
                    // 显示 Modal
                    $('#cropped-modal').modal().find('.am-modal-bd').html(result);
                    $('#download').attr('href', result.toDataURL('image/jpeg'));
                }
                break;
        }
    });


    // 上传图片
    var $inputImage = $('#inputImage');
    var URL = window.URL || window.webkitURL;
    var blobURL;

    if (URL) {
        $inputImage.change(function () {
            var files = this.files;
            var file;

            if (files && files.length) {
                file = files[0];

                if (/^image\/\w+$/.test(file.type)) {
                    blobURL = URL.createObjectURL(file);
                    $image.one('built.cropper', function () {
                        // Revoke when load complete
                        URL.revokeObjectURL(blobURL);
                    }).cropper('reset').cropper('replace', blobURL);
                    $inputImage.val('');
                } else {
                    window.alert('Please choose an image file.');
                }
            }

            // Amazi UI 上传文件显示代码
            var fileNames = '';
            $.each(this.files, function () {
                fileNames += '<span class="am-badge">' + this.name + '</span> ';
            });
            $('#file-list').html(fileNames);
        });
    } else {
        $inputImage.prop('disabled', true).parent().addClass('disabled');
    }

    //绑定上传事件
    $('#up-btn-ok').on('click', function () {
        var $modal = $('#my-modal-loading');
        var $modal_alert = $('#my-alert');
        var img_src = $image.attr("src");
        if (img_src == "") {
            set_alert_info("没有选择上传的图片");
            $modal_alert.modal();
            return false;
        }

        $modal.modal();

        var url = $(this).attr("url");
        var canvas = $("#image").cropper('getCroppedCanvas');
        var data = canvas.toDataURL(); //转成base64

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            dataType: 'json',
            type: "POST",
            data: {"image": data.toString()},
            success: function (data, textStatus) {
                $modal.modal('close');
                set_alert_info(data.result);

                if (data.code == "SN200") {
                    $("#doc-modal-1").modal('close');
                    $("#up-img-touch img").attr("src", data.img);
                    $("input[name=thumb]").val(data.img);
                    layer.msg('图片上传成功', {icon: 1, time: 1500});
                    return false;
                } else {
                    $modal.modal('close');
                    set_alert_info("上传文件失败了！");
                    $modal_alert.modal();
                }
            },
            error: function () {
                $modal.modal('close');
                set_alert_info("上传文件失败了！");
                $modal_alert.modal();
                //console.log('Upload error');
            }
        });

    });

});

function rotateimgright() {
    $("#image").cropper('rotate', 90);
}

function rotateimgleft() {
    $("#image").cropper('rotate', -90);
}

function set_alert_info(content) {
    $("#alert_content").html(content);
}



 
