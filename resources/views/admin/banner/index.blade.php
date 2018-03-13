@extends('admin.layouts.master')
@section('title', '幻灯片管理')
@section('content')
    @include('admin.banner.add')
    {{--@include('admin.warehouse.edit')--}}
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span>
        幻灯片管理
        <span class="c-gray en">&gt;</span>
        列表
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
           href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="Hui-article">
        <div class="page-container">
            <div class="text-c">
                <input type="text" name="" id="" placeholder="栏目名称、id" style="width:250px" class="input-text">
                <button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜索
                </button>
            </div>
            <div class="cl pd-5 bg-1 bk-gray mt-20">
		<span class="l">
		<span class="btn btn-primary radius" data-toggle="modal" data-target="#addModel"><i class="Hui-iconfont">&#xe600;</i> 添加幻灯片</span>
		</span>
{{--                <span class="r">共有数据：<strong>{{ $count ? $count : 0 }}</strong> 条</span>--}}
            </div>

            <div class="mt-20">
                <table class="table table-border table-bordered table-hover table-bg table-sort">
                    <thead>
                    <tr class="text-c">
                        <th width="80">ID</th>
                        <th>仓库名称</th>
                        <th width="80">排序</th>
                        <th width="80">状态</th>
                        <th width="150">操作</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('javascript')

    <script type="text/javascript" src="{{ asset('/admin/js/banner.js') }}"></script>

@endsection