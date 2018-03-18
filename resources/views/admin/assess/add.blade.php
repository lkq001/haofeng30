@extends('admin.layouts.master')
@section('title', '添加评价')
@section('css')
    <link href="{{ asset('/admin/lib/webuploader/0.1.5/webuploader.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span>
        商品评价
        <span class="c-gray en">&gt;</span>
        添加
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
           href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="page-container">
        <div class="Hui-article">
            <form method="post" class="form form-horizontal" id="form-add"
                  data-jump = "{{ route('admin.assess.index') }}" action="{{ route('admin.assess.store') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>评价人：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <input type="text" class="input-text" value="" placeholder="" id="name" name="name">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>评价标题：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <input type="text" class="input-text" value="" placeholder="" id="title" name="title">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>评价图片：</label>
                        <div class="formControls col-xs-8 col-sm-8">

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
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>口碑内容：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <script id="editor" type="text/plain" class="ue"></script>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <a href="{{ route('admin.assess.index') }}" type="button" class="btn btn-default">返回列表</a>
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </form>
            </form>
        </div>
    </div>

@endsection
@section('javascript')
    <script type="text/javascript" src="{{ asset('/admin/js/assess.js') }}"></script>
    <<script type="text/javascript" src="{{ asset('/admin/lib/webuploader/0.1.5/webuploader.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/admin/js/uploads.js') }}"></script>
    <script>
        var ue = UE.getEditor('editor');
    </script>
@endsection