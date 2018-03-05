// 添加
function storeSubmit(data, url, type, isPostData, jumpUrl) {
    // 声明数组,存储提交数据
    var typeData = {};

    if (isPostData == "undefined") {
        $.each(data, function (k, v) {
            typeData[this.name] = this.value
        });
    } else {
        typeData = data;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: url,
        data: typeData,
        type: type,
        success: function (res) {
            console.log(res);
            if (res.code == 'SN200') {

                if (jumpUrl == "undefined") {

                    layer.alert('添加成功,点击确定刷新页面!', {
                        closeBtn: 0
                    }, function () {
                        location.reload();
                    });
                } else {
                    layer.confirm('添加成功,是否跳转到列表页面？', {
                        btn: ['确定','取消'] //按钮
                    }, function(){
                        window.location.href = jumpUrl;
                    }, function(){
                        location.reload();
                    });
                }

            } else {
                layer.msg(res.message, {icon: 2, time: 1500});
                return false;
            }
        },
        error: function (res) {
            layer.msg('添加数据失败!', {icon: 2, time: 1500});
            return false;
        }
    });
}

// 状态修改
function statusSubmit(id, url, status, that, textMessage) {

    if (status == 1) {
        var changeMessage = '禁用';
        var statusCode = 2;
        var statusClass = 'btn btn-secondary size-S radius';
        var changeMessageChange = '启用';
    } else if (status == 2) {
        var changeMessage = '启用';
        var statusCode = 1;
        var statusClass = 'btn btn-warning size-S radius';
        var changeMessageChange = '禁用';
    } else {
        var changeMessage = '操作';
    }

    layer.confirm('确认要' + changeMessage + '吗？', function (index) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            data: {'id': id, 'status': status},
            type: 'POST',
            success: function (res) {
                console.log(res);
                if (res.code == 'SN200') {

                    if (textMessage) {
                        that.parent().prev().html('已' + changeMessage);
                    }

                    that.attr('data-status', statusCode);
                    that.attr('class', statusClass);
                    that.html(changeMessageChange);

                    layer.msg('已' + changeMessage + '!', {icon: 1, time: 1500});
                } else {
                    layer.msg(res.message, {icon: 2, time: 1500});
                    return false;
                }
            },
            error: function (res) {
                layer.msg(res.message, {icon: 2, time: 1500});
                return false;
            }
        });
    });

}

/**
 * 上下架
 * @param id
 * @param url
 * @param status
 * @param that
 * @param textMessage
 */
function statusProductSubmit(id, url, status, that, textMessage) {

    if (status == 2) {
        var changeMessage = '下架';
        var statusCode = 1;
        var statusClass = 'btn btn-warning size-S radius';
        var changeMessageChange = '上架';
    } else {
        var changeMessage = '上架';
        var statusCode = 2;
        var statusClass = 'btn btn-secondary size-S radius';
        var changeMessageChange = '下架';
    }

    layer.confirm('确认要' + changeMessage + '吗？', function (index) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            data: {'id': id, 'status': status},
            type: 'POST',
            success: function (res) {
                console.log(res);
                if (res.code == 'SN200') {

                    if (textMessage) {
                        that.parent().prev().html('已' + changeMessage);
                    }

                    that.attr('data-status', statusCode);
                    that.attr('class', statusClass);
                    that.html(changeMessageChange);

                    layer.msg('已' + changeMessage + '!', {icon: 1, time: 1500});
                } else {
                    layer.msg(res.message, {icon: 2, time: 1500});
                    return false;
                }
            },
            error: function (res) {
                layer.msg(res.message, {icon: 2, time: 1500});
                return false;
            }
        });
    });

}

// 获取修改信息
function editInfo(id, url) {
    var resultData = 1;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: url,
        data: {'id': id},
        type: 'GET',
        async: false,
        success: function (res) {
            console.log(res);
            if (res.code == 'SN200') {
                resultData = res.data;
            } else {
                layer.msg(res.message, {icon: 2, time: 1500});
                return false;
            }
        },
        error: function (res) {
            layer.msg(res.message, {icon: 2, time: 1500});
            return false;
        }
    });

    return resultData;
}

// 点击修改排序
function inputOrderBy(id, url, that, order) {
    that.html('<input name="order_by" class="input-text radius size-MINI" id="changeOrder" value="' + order + '" data-id="' + id + '" data-url="' + url + '" data-order="' + order + '" >');
    $("#changeOrder").css("display", "inline").val(order);//赋值
    moveEnd($("#changeOrder").get(0));//移动光标至末尾，且切换selection的位置

}

// 点击执行修改排序
function changeOrderBy(id, url, that, order) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: url,
        data: {'id': id, 'order_by': order},
        type: 'POST',
        success: function (res) {
            if (res.code == 'SN200') {
                that.parent().attr('data-order', order);
                that.parent().html(order);
                // layer.msg(res.message, {icon: 1, time: 1500});
                location.reload();
                return false;
            } else {
                that.parent().attr('data-order', that.attr('data-order'));
                that.parent().html(that.attr('data-order'));
                layer.msg(res.message, {icon: 2, time: 1500});
                return false;
            }
        },
        error: function (res) {
            layer.msg(res.message, {icon: 2, time: 1500});
            return false;
        }
    });

}

// 鼠标定位 末尾
function moveEnd(obj) {
    obj.focus();
    var len = obj.value.length;
    if (document.selection) {
        var sel = obj.createTextRange();
        sel.moveStart('character', len); //设置开头的位置
        sel.collapse();
        sel.select();
    } else if (typeof obj.selectionStart == 'number' && typeof obj.selectionEnd == 'number') {
        obj.selectionStart = obj.selectionEnd = len;
    }
}

// 数据修改
function updateSubmit(data, url, type) {
    // 声明数组,存储提交数据
    var typeData = {};
    $.each(data, function (k, v) {
        typeData[this.name] = this.value
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: url,
        data: typeData,
        type: type,
        success: function (res) {
            console.log(res);
            if (res.code == 'SN200') {
                layer.alert('修改成功,点击确定刷新页面!', {
                    closeBtn: 0
                }, function () {
                    location.reload();
                });

            } else {
                layer.msg(res.message, {icon: 2, time: 1500});
            }
        },
        error: function (res) {
            layer.msg('修改数据失败!', {icon: 2, time: 1500});
            return false;
        }
    });
}

// 数据删除
function destroy(id, url, that) {
    if (parseInt(id) < 1 || !url) {
        layer.msg('数据不合法!', {icon: 2, time: 1500});
        return false;
    }
    layer.confirm('确认要删除吗？', function (index) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            data: {'id': id},
            type: 'DELETE',
            success: function (res) {
                console.log(res);
                if (res.code == 'SN200') {
                    that.parent().parent().remove();

                    layer.msg(res.message, {icon: 1, time: 1500});
                    return false;
                } else {
                    layer.msg(res.message, {icon: 2, time: 1500});
                    return false;
                }
            },
            error: function (res) {
                layer.msg('添加数据失败!', {icon: 2, time: 1500});
                return false;
            }
        });
    });
}

// 批量数据删除
function destroyAll(rows, ids, url, idName) {

    if (ids.length < 1 || !url) {
        layer.msg('数据不合法!', {icon: 2, time: 1500});
        return false;
    }

    layer.confirm('确认要删除吗？', function (index) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            data: {'ids': ids},
            type: 'DELETE',
            success: function (res) {
                console.log(res);
                if (res.code == 'SN200') {
                    layer.alert('批量删除成功,点击确定刷新页面!', {
                        closeBtn: 0
                    }, function () {
                        location.reload();
                    });
                } else {
                    layer.msg(res.message, {icon: 2, time: 1500});
                }
            },
            error: function (res) {
                layer.msg('添加数据失败!', {icon: 2, time: 1500});
                return false;
            }
        });

    });

}

/**
 * 批量修改状态
 * @param rows
 * @param ids
 * @param url
 * @param idName
 */
function statusAll(rows, ids, url, idName, status) {

    if (ids.length < 1 || !url) {
        layer.msg('数据不合法!', {icon: 2, time: 1500});
        return false;
    }

    if (!status) {
        layer.msg('数据不合法!', {icon: 2, time: 1500});
        return false;
    }

    layer.confirm('确认要操作吗？', function (index) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            data: {'ids': ids, 'status': status},
            type: 'POST',
            success: function (res) {
                console.log(res);
                if (res.code == 'SN200') {
                    layer.alert('批量操作成功,点击确定刷新页面!', {
                        closeBtn: 0
                    }, function () {
                        location.reload();
                    });
                } else {
                    layer.msg(res.message, {icon: 2, time: 1500});
                }
            },
            error: function (res) {
                layer.msg('修改状态失败!', {icon: 2, time: 1500});
                return false;
            }
        });

    });

}

/**
 * 图片点击放大
 */

$('body').on('click', '#img', function () {
    $(this).toggleClass('min');
    $(this).toggleClass('max');
});