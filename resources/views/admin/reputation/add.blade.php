@extends('admin.layouts.master')
@section('title', '添加口碑')
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
        吃货口碑
        <span class="c-gray en">&gt;</span>
        添加
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
           href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="page-container">
        <div class="Hui-article">
            <form method="post" class="form form-horizontal" id="form-edit"
                  data-jump = "{{ route('admin.reputation.index') }}" action="{{ route('admin.reputation.store') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>口碑人：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <input type="text" class="input-text" value="" placeholder="" id="name" name="name">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>口碑标题：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <input type="text" class="input-text" value="" placeholder="" id="title" name="title">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>图片：</label>
                        <div class="formControls col-xs-8 col-sm-8" id="up-img-touch">
                            <img class="am-circle" alt="点击图片上传" data-width="1" data-height="1"
                                 src="{{ asset('admin/thumbJq/thumb.png') }}">
                            <input type="hidden" name="thumb" value=""/>
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>口碑内容：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <textarea name="content" id="content" class="input-text" id="" cols="30" rows="10"
                                      style="min-height: 100px;resize: vertical;"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <a href="{{ route('admin.reputation.index') }}" type="button" class="btn btn-default">返回列表</a>
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </form>
            </form>
        </div>
    </div>
    <input type="hidden" name="upload_url" value="{{ route('admin.reputation.upload') }}">
    @include('admin.layouts.thumb')
@endsection
@section('javascript')

    <script type="text/javascript" src="{{ asset('/admin/js/reputation.js') }}"></script>
    <script src="{{ asset('admin/thumbJq/js/amazeui.min.js') }}" charset="utf-8"></script>
    <script src="{{ asset('admin/thumbJq/js/cropper.min.js') }}" charset="utf-8"></script>
    <script src="{{ asset('admin/thumbJq/js/custom_up_img.js') }}" charset="utf-8"></script>
    <script type="text/javascript">
        uploadThumb();
    </script>
@endsection