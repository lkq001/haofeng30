<div class="modal fade" id="editModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">添加抢购</h4>
            </div>

            <form method="post" class="form form-horizontal" id="form-edit"
                  action="{{ route('admin.limit.buy.update') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id" />
                <div class="modal-body">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>抢购标题：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <input type="text" class="input-text" value="" placeholder=""  name="name">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>产品选择：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <span class="select-box">
                                <select name="product_warehouse_id" data-url="{{ route('admin.limit.buy.edit') }}" id="product_warehouse_id" class="select">

                                    @if($productLists)
                                        <option value="" disabled selected>请选择</option>
                                        @foreach($productLists as $key => $value)
                                            <option disabled="disabled" value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="">暂无分库,请添加</option>
                                    @endif

                                </select>
                            </span>
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>产品原价：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <input type="text" class="input-text" value="" placeholder="" readonly id="old_price"  name="old_price" >
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>抢购价格：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <input type="text" class="input-text" value="" placeholder="" onkeyup="onlyNumber(this)"  name="price">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>开始时间：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <input type="text" class="input-text" value="" placeholder="" id="start_edit_time" name="start_time">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>结束时间：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <input type="text" class="input-text" value="" placeholder="" id="end_edit_time" name="end_time">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">栏目排序：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <input type="text" class="input-text" value="0" placeholder="" id="" name="order_by">
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