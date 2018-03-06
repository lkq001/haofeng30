@extends('admin.layouts.master')
@section('title', '宅配卡产品')
@section('css')
    <link href="{{ asset('/admin/lib/webuploader/0.1.5/webuploader.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span>
        宅配卡
        <span class="c-gray en">&gt;</span>
        修改
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
           href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="page-container">
        <div class="Hui-article">
            <form method="post" class="form form-horizontal" id="form-add"
                  action="{{ route('admin.card.update') }}"
                  data-jump="{{ route('admin.card.index') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $info->id }}">
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>宅配卡名称：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" value="{{  $info->name }}" placeholder=""
                               name="name">
                    </div>
                </div>

                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>宅配卡分类：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <div class="w25">
                                <span class="select-box">
                                    <select name="pid" class="select">

                                        @if($getCardCategoryLists)
                                            @foreach($getCardCategoryLists as $key => $value)
                                                <option value="{{ $value->id }}"
                                                        @if( $info->pid == $value->id) selected @endif >{{ $value->name }}</option>
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
                    <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>宅配卡价格：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text w25" value="{{  $info->price }}" placeholder=""
                               id="" name="price">
                        <span class="suggest">价格必须为数字</span>
                    </div>
                </div>

                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>可使用次数：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text w25" value="{{ $info->number }}" placeholder="" id="" name="number">
                        <span class="suggest">必须为数据,默认1次</span>
                    </div>
                </div>

                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">宅配卡描述：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" value="{{  $info->description }}"
                               placeholder="" id="" name="description">
                    </div>
                </div>

                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">宅配卡排序：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text w25" value="{{  $info->order_by }}"
                               placeholder=""
                               onkeyup="this.value=this.value.replace(/\D/g,'')" id="" name="order_by">
                        <span class="suggest">数值越大,越靠前,只能填写数字</span>
                    </div>
                </div>

                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">宅配卡库存：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text w25"
                               onkeyup="this.value=this.value.replace(/\D/g,'')" value="{{  $info->stock }}"
                               placeholder="" id=""
                               name="stock">
                        <span class="suggest">不填为默认 9999999</span>
                    </div>
                </div>

                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">虚拟销量：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text w25"
                               onkeyup="this.value=this.value.replace(/\D/g,'')" value="{{ $info->sale_virtual }}" placeholder="" id=""
                               name="sale_virtual">
                        <span class="suggest">不填为默认 0</span>
                    </div>
                </div>

                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>宅配卡图片：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="hidden" id="uploadOld" value="{{  $info->getToMany }}"/>
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
                    <label class="form-label col-xs-4 col-sm-2">宅配卡详情：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <script id="editor" type="text/plain" class="ue"></script>
                    </div>
                </div>

                <div id="content" style="display:none">{{  $info->getHasOneContent->content }}</div>

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
    <script type="text/javascript" src="{{ asset('/admin/js/card.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/admin/js/cardUploads.js') }}"></script>
    <script>
        var ue = UE.getEditor('editor');

        var proinfo = $("#content").text();

        ue.ready(function () {//编辑器初始化完成再赋值
            ue.setContent(proinfo);  //赋值给UEditor
        });
    </script>
@endsection