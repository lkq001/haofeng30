$(function () {
    // 填写分销价格之后鼠标离开时间
    $('body').on('blur', '#profit', function (i) {
        var that = $(this);
        var product_id = that.attr('data-product-id');
        var value = that.val();
        var url = that.attr('data-url');
    });
});
