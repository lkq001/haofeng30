<div class="modal fade" id="addModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">添加产品</h4>
            </div>

            <form method="post" class="form form-horizontal" id="form-add"
                  action="{{ route('admin.product.warehouse.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品名称：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text" value="" placeholder="" name="name">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品分类：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <div class="w25">
                                <span class="select-box">
                                    <select name="pid" class="select">

                                        @if($productCategoryLists[0])
                                            @foreach($productCategoryLists[0] as $key => $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @if(isset($productCategoryLists[$value->id]))
                                                    @foreach($productCategoryLists[$value->id] as $key => $val)
                                                        <option value="{{ $val->id }}">|--{{ $val->name }}</option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @else
                                            <option value="0">暂无分类,请添加分类!</option>
                                        @endif
                                    </select>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品价格：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text w25" value="" placeholder="" id="" name="price">
                            <span class="suggest">价格必须为数字</span>
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">商品描述：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text" value="" placeholder="" id="" name="description">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">规格排序：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text w25" value="" placeholder=""
                                   onkeyup="this.value=this.value.replace(/\D/g,'')" id="" name="order_by">
                            <span class="suggest">数值越大,越靠前,只能填写数字</span>
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">商品库存：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text w25" onkeyup="this.value=this.value.replace(/\D/g,'')" value="" placeholder="" id="" name="stock">
                            <span class="suggest">不填为默认 9999999</span>
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品图片：</label>
                        <div class="formControls col-xs-8 col-sm-9">

                            <div class="uploader-list-container">
                                <div class="queueList">
                                    <div id="dndArea" class="placeholder">
                                        <div id="filePicker-2"></div>
                                        <p>或将照片拖到这里，单次最多可选300张</p>
                                    </div>
                                </div>
                                <div class="statusBar" style="display:none;">
                                    <div class="progress"><span class="text">0%</span> <span class="percentage"></span>
                                    </div>
                                    <div class="info"></div>
                                    <div class="btns">
                                        <div id="filePicker2"></div>
                                        <div class="uploadBtn">开始上传</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">商品详情：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <script id="editor" type="text/plain" class="ue"></script>
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