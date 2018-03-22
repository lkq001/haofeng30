<div class="modal fade" id="issueModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">发放优惠券</h4>
            </div>

            <form method="post" class="form form-horizontal" id="form-issue"
                  action="{{ route('admin.coupon.issue') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="" />
                <div class="modal-body">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>手机号：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <textarea name="phones" id="phones" class="input-text" placeholder="手机号以逗号(,)隔开" id="" cols="30" rows="10"
                                      style="min-height: 100px;resize: vertical;"></textarea>
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>每人发放数量：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <input type="text" class="input-text" value="1" placeholder="" id="coupon_number" name="coupon_number">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </form>


        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>