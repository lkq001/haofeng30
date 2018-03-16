@extends('admin.layouts.master')
@section('title', '文章管理')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/thumbJq/css/font-awesome.4.6.0.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/thumbJq/css/amazeui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/thumbJq/css/amazeui.cropper.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/thumbJq/css/custom_up_img.css') }}">
    <style type="text/css">
        .up-img-cover {
            width: 100px;
            height: 100px;
        }

        .up-img-cover img {
            width: 100%;
        }

    </style>
@endsection

@section('content')

    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span>
        文章管理
        <span class="c-gray en">&gt;</span>
        添加
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
           href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="page-container">
        <div class="Hui-article">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="Huialert Huialert-danger text-c"><i class="Hui-iconfont">&#xe6a6;</i>{{ $error }}</div>
                @endforeach
            @endif
            <form method="post" class="form form-horizontal"
                  action="{{ route('admin.article.update') }}" >
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $info->id }}" />
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>文章名称：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <input type="text" class="input-text" value="{{ old('name') ?? $info->name }}" placeholder="" name="name"/>
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>文章分类：</label>
                        <div class="formControls col-xs-8 col-sm-4">
                            <span class="select-box">
                                <select name="pid" class="select">
                                    @if(isset($articleCategoryLists) && collect($articleCategoryLists)->count() > 0)
                                        @foreach($articleCategoryLists as $key => $value)
                                            <option @if( (old('pid') ?? $info->pid) == $value->id ) selected @endif value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </span>
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>图片：</label>
                        <div class="formControls col-xs-8 col-sm-8" id="up-img-touch">
                            <img class="am-circle" alt="点击图片上传" data-width="1" data-height="1"
                                 src="{{ old('image') ?? $info->thumb }}">
                            <input type="hidden" name="thumb" value="{{ old('image') ?? $info->thumb }}"/>
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">栏目排序：</label>
                        <div class="formControls col-xs-8 col-sm-4">
                            <input type="text" class="input-text" value="{{ old('order_by') ?? $info->order_by}}" placeholder=""
                                   id="" name="order_by">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">文章详情：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <script id="editor" type="text/plain" class="ue"></script>
                        </div>
                    </div>
                    <div id="content" style="display:none">{{  old('content') ?? $info->content }}</div>

                </div>
                <div class="modal-footer">
                    <a href="{{ route('admin.article.index') }}" class="btn btn-default">返回列表</a>
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </form>
        </div>
    </div>
    @include('admin.layouts.thumb')
@endsection
@section('javascript')
    <script type="text/javascript" src="{{ asset('admin/js/banner.js') }}"></script>
    <script src="{{ asset('admin/thumbJq/js/amazeui.min.js') }}" charset="utf-8"></script>
    <script src="{{ asset('admin/thumbJq/js/cropper.min.js') }}" charset="utf-8"></script>
    <script src="{{ asset('admin/thumbJq/js/custom_up_img.js') }}" charset="utf-8"></script>
    <script>
        var ue = UE.getEditor('editor');

        var proinfo = $("#content").text();

        ue.ready(function () {//编辑器初始化完成再赋值
            ue.setContent(proinfo);  //赋值给UEditor
        });
    </script>
@endsection