@extends('admin.layouts.master')
@section('title', '幻灯片产品')

@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span>
        幻灯片管理
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
                  action="{{ route('admin.banner.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>幻灯片名称：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <input type="text" class="input-text" value=" {{ old('name') }} " placeholder="" id="name" name="name">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>所属分类栏目：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <span class="select-box">
                                <select name="pid" class="select">
                                    @if(isset($bannerCategoryLists) && collect($bannerCategoryLists)->count() > 0)
                                        @foreach($bannerCategoryLists as $key => $value)
                                            <option @if(old('pid') == $value->id ) selected @endif value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </span>
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>图片：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <input type="file" name="thumb"/>
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">指向链接：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <input type="text" class="input-text" value="http://" placeholder="{{ old('url') }}" id="" name="url">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">栏目排序：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <input type="text" class="input-text" value="{{ old('order_by') ?? 0 }}" placeholder="" id="" name="order_by">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <a href="{{ route('admin.banner.index') }}" class="btn btn-default">返回列表</a>
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </form>
        </div>
    </div>
@endsection
@section('javascript')

    <script type="text/javascript" src="{{ asset('/admin/js/banner.js') }}"></script>

@endsection