<div class="modal fade" id="addModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">添加会员</h4>
            </div>

            <form method="post" class="form form-horizontal" id="form-add"
                  action="{{ route('admin.member.store') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>手 机 号：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <input type="text" class="input-text w50" value="" placeholder="请填写手机号" id="phone" name="phone">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>会员账号：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <input type="text" class="input-text  w50" value="" placeholder="至少为2位" id="username" name="username">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>会员密码：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <input type="password" class="input-text w50" value="" placeholder="至少为6位" id="password" name="password">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>确认密码：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <input type="password" class="input-text w50" value="" placeholder="至少为6位" id="password_confirmation"
                                   name="password_confirmation">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>会员分组：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <span class="select-box w50">
                                <select name="group_id" class="select">

                                    @if($memberGroupLists)
                                        @foreach($memberGroupLists as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="">暂无分组,请添加</option>
                                    @endif
                                </select>
                            </span>
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">会员邮箱：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <input type="text" class="input-text w50" value="" placeholder="请填写邮箱" id="" name="email">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">会员排序：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <input type="text" class="input-text w50" value="0" placeholder="" id="" name="order_by">
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