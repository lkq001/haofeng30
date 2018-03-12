$(function () {
    $("#form-add").validate({
        rules: {
            username: {
                required: true,
                minlength: 2,
                maxlength: 200
            },
            phone: {
                required: true,
                minlength: 11,
                // 自定义方法：校验手机号在数据库中是否存在
                // checkPhoneExist : true,
                isMobile: true
            },
            password: {
                required: true,
                minlength: 6,
                maxlength: 200
            },
            password_confirmation: {
                required: true,
                minlength: 6,
                maxlength: 200
            },
            group_id: {
                required: true,
                minlength: 1,
                maxlength: 200
            },
            email: {
                email: true
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
        // ajax 提交
        statusSubmit(id, url, status, that, 1);
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
        console.log(info);

        // 数据指定
        $("#editModel input[name='id']").val(info.id);
        $("#editModel input[name='name']").val(info.name);
        $("#editModel input[name='username']").val(info.username);
        $("#editModel input[name='phone']").val(info.phone);
        $("#editModel input[name='email']").val(info.email);
        $("#editModel input[name='uuid']").val(info.uuid);
        $("#editModel input[name='balance']").val(info.balance);
        $("#editModel").find("option[value = '" + info.group_id + "']").attr("selected", "selected");

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

    // 执行修改状态
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
            username: {
                required: true,
                minlength: 2,
                maxlength: 200
            },
            phone: {
                required: true,
                minlength: 11,
                // 自定义方法：校验手机号在数据库中是否存在
                // checkPhoneExist : true,
                isMobile: true
            },
            password: {
                minlength: 6,
                maxlength: 200
            },
            password_confirmation: {
                minlength: 6,
                maxlength: 200
            },
            group_id: {
                required: true,
                minlength: 1,
                maxlength: 200
            },
            email: {
                email: true
            },
            balance: {
                isPrice: true
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

    // 批量删除
    $('body').on('click', '#destroy-all', function (i) {
        // 赋值
        var that = $(this);
        // 获取提交路径
        var url = that.attr('data-url');
        // 声明一个数组,存储选择的第几行
        var rows = [];
        // 声明一个数组,存储删除的ID
        var ids = [];
        $("input[name='check']:checked").each(function () {
            rows.push($(this).parents("tr").index());
            ids.push($(this).val());
        });

        // 判断操作
        destroyAll(rows, ids, url, 'checked-box');

    })

});