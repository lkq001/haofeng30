$(function () {
    $('.skin-minimal input').iCheck({
        checkboxClass: 'icheckbox-blue',
        radioClass: 'iradio-blue',
        increaseArea: '20%'
    });

    $list = $("#fileList"),
        $btn = $("#btn-star"),
        state = "pending",
        uploader;

    var uploader = WebUploader.create({
        auto: true,
        swf: '/admin/lib/webuploader/0.1.5/Uploader.swf',

        // 文件接收服务端。
        server: '/fileupload.php',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#filePicker',

        // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        resize: false,
        // 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });
    uploader.on('fileQueued', function (file) {
        var $li = $(
            '<div id="' + file.id + '" class="item">' +
            '<div class="pic-box"><img></div>' +
            '<div class="info">' + file.name + '</div>' +
            '<p class="state">等待上传...</p>' +
            '</div>'
            ),
            $img = $li.find('img');
        $list.append($li);

        // 创建缩略图
        // 如果为非图片文件，可以不用调用此方法。
        // thumbnailWidth x thumbnailHeight 为 100 x 100
        uploader.makeThumb(file, function (error, src) {
            if (error) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }

            $img.attr('src', src);
        }, thumbnailWidth, thumbnailHeight);
    });
    // 文件上传过程中创建进度条实时显示。
    uploader.on('uploadProgress', function (file, percentage) {
        var $li = $('#' + file.id),
            $percent = $li.find('.progress-box .sr-only');

        // 避免重复创建
        if (!$percent.length) {
            $percent = $('<div class="progress-box"><span class="progress-bar radius"><span class="sr-only" style="width:0%"></span></span></div>').appendTo($li).find('.sr-only');
        }
        $li.find(".state").text("上传中");
        $percent.css('width', percentage * 100 + '%');
    });

    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on('uploadSuccess', function (file) {
        $('#' + file.id).addClass('upload-state-success').find(".state").text("已上传");
    });

    // 文件上传失败，显示上传出错。
    uploader.on('uploadError', function (file) {
        $('#' + file.id).addClass('upload-state-error').find(".state").text("上传出错");
    });

    // 完成上传完了，成功或者失败，先删除进度条。
    uploader.on('uploadComplete', function (file) {
        $('#' + file.id).find('.progress-box').fadeOut();
    });
    uploader.on('all', function (type) {
        if (type === 'startUpload') {
            state = 'uploading';
        } else if (type === 'stopUpload') {
            state = 'paused';
        } else if (type === 'uploadFinished') {
            state = 'done';
        }

        if (state === 'uploading') {
            $btn.text('暂停上传');
        } else {
            $btn.text('开始上传');
        }
    });

    $btn.on('click', function () {
        if (state === 'uploading') {
            uploader.stop();
        } else {
            uploader.upload();
        }
    });

});