$(function () {

    laydate.render({
        elem: '#start_time',
        type: 'datetime',
        min: 0
    });
    laydate.render({
        elem: '#end_time', //指定元素\
        type: 'datetime',
        min: 0
    });

    laydate.render({
        elem: '#start_edit_time',
        type: 'datetime',
        min: 0
    });
    laydate.render({
        elem: '#end_edit_time', //指定元素\
        type: 'datetime',
        min: 0
    });


    $('#form-add #product_warehouse_id').change(function (i) {
        var id = $(this).val();

        var url = $(this).attr('data-url');
        // ajax 提交
        var info = showInfo(id, url);

        $('#form-add #old_price').val(info.price);
    })

    $("#form-add").validate({
        rules: {
            name: {
                required: true,
                minlength: 2,
                maxlength: 200
            },
            product_warehouse_id: {
                required: true,
                minlength: 1,
                maxlength: 16
            },
            old_price: {
                required: true,
                minlength: 1,
                maxlength: 16
            },
            price: {
                required: true,
                minlength: 1,
                maxlength: 16
            },
            people_number: {
                required: true,
                minlength: 1,
                maxlength: 16
            },
            start_time: {
                required: true,
            },
            end_time: {
                required: true,
            },

        },

        onkeyup: false,
        focusCleanup: true,
        success: "valid",
        submitHandler: function (form) {

            // 获取提交数据
            var data = $(form).serializeArray();

            // 获取提交路径
            var url = $(form).attr('action');
            // 获取提交方式
            var type = $(form).attr('method');
            // ajax 提交
            storeSubmit(data, url, type);
        }
    });

    // 修改状态
    $('body').on('click', '#changeStatus', function (i) {
        // 赋值
        var that = $(this);
        // 获取提交数据
        var id = that.attr('data-id');
        // 获取提交路径
        var url = that.attr('data-url');
        // 获取状态
        var status = that.attr('data-status');
        var textMessage = '结束';

        // ajax 提交
        statusActiveSubmit(id, url, status, that, textMessage);
    });

    // 获取修改数据
    $('body').on('click', '#editShowModel', function (i) {
        // 赋值
        var that = $(this);
        // 获取提交数据
        var id = that.attr('data-id');
        // 获取提交路径
        var url = that.attr('data-url');
        // 获取修改信息
        var info = editInfo(id, url);

        // 数据指定
        $("#editModel input[name='id']").val(info.id);
        $("#editModel input[name='name']").val(info.name);
        $("#editModel input[name='price']").val(info.price);
        $("#editModel input[name='old_price']").val(info.old_price);
        $("#editModel ").find("option[value = '" + info.product_warehouse_id + "']").attr("selected", "selected");
        $("#editModel input[name='people_number']").val(info.people_number);
        $("#editModel input[name='start_time']").val(info.start_time);
        $("#editModel input[name='end_time']").val(info.end_time);

        $('#editModel').modal('show');
    });

    // 修改排序
    $('body').on('click', '#orderBy', function (i) {
        // 赋值
        var that = $(this);
        // 获取提交数据
        var id = that.attr('data-id');
        // 获取提交路径
        var url = that.attr('data-url');
        // 获取提交路径
        var order = parseInt(that.attr('data-order'));

        // 获取修改信息
        inputOrderBy(id, url, that, order);
    })

    // 执行修改
    $('body').on('blur', '#changeOrder', function (i) {
        // 赋值
        var that = $(this);
        // 获取提交数据
        var id = that.attr('data-id');
        // 获取提交路径
        var url = that.attr('data-url');
        // 获取提交路径
        var order = parseInt($('#changeOrder').val());

        // 获取修改信息
        changeOrderBy(id, url, that, order);
    })

    // 执行修改
    $("#form-edit").validate({
        rules: {
            name: {
                required: true,
                minlength: 2,
                maxlength: 200
            },
            price: {
                required: true,
                minlength: 1,
                maxlength: 16
            },
            people_number: {
                required: true,
                minlength: 1,
                maxlength: 16
            },
            start_time: {
                required: true,
            },
            end_time: {
                required: true,
            },

        },
        onkeyup: false,
        focusCleanup: true,
        success: "valid",
        submitHandler: function (form) {
            // 获取提交数据
            var data = $(form).serializeArray();
            // 获取提交路径
            var url = $(form).attr('action');
            // 获取提交方式
            var type = $(form).attr('method');

            // ajax 提交
            updateSubmit(data, url, type);
        }
    });

    // 执行删除
    $('body').on('click', '#destroy', function (i) {
        // 赋值
        var that = $(this);
        // 获取提交数据
        var id = that.attr('data-id');
        // 获取提交路径
        var url = that.attr('data-url');
        // 获取修改信息
        destroy(id, url, that);
    })


});
