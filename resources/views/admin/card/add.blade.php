@extends('admin.layouts.master')
@section('title', '总库产品')
@section('css')
    <link href="{{ asset('/admin/lib/webuploader/0.1.5/webuploader.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span>
        总库产品管理
        <span class="c-gray en">&gt;</span>
        添加
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
           href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="page-container">
        <div class="Hui-article">
            <form method="post" class="form form-horizontal" id="form-add"
                  action="{{ route('admin.product.warehouse.store') }}" data-jump="{{ route('admin.product.warehouse.index') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
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
                        <input type="text" class="input-text w25"
                               onkeyup="this.value=this.value.replace(/\D/g,'')" value="" placeholder="" id=""
                               name="stock">
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
                                <div class="progress"><span class="text">0%</span> <span
                                            class="percentage"></span>
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

                <div class="row cl modal-footer">
                    <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                        <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                    </div>
                </div>


            </form>
        </div>
    </div>
@endsection
@section('javascript')

    <script type="text/javascript" src="{{ asset('/admin/lib/webuploader/0.1.5/webuploader.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/admin/js/productWarehouse.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/admin/js/uploads.js') }}"></script>
    <script>
        var ue = UE.getEditor('editor');
    </script>
@endsection