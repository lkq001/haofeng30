<div class="modal fade" id="editModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">修改会员组</h4>
            </div>


            <form method="post" class="form form-horizontal" id="form-edit"
                  action="{{ route('admin.member.group.update') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="" />
                <div class="modal-body">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>会员组名称：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <input type="text" class="input-text" value="" placeholder="" id="name" name="name">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>产品分库：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <span class="select-box">
                                <select name="pid" class="select">

                                    @if($productSubWarehouseLists)
                                        @foreach($productSubWarehouseLists as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="">暂无分库,请添加</option>
                                    @endif
                                </select>
                            </span>
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