@extends('admin.layouts.master')
@section('title', '商品评价')

@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span>
        商品评价
        <span class="c-gray en">&gt;</span>
        列表
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
           href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="Hui-article">
        <div class="page-container">

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="Huialert Huialert-danger text-c"><i class="Hui-iconfont">&#xe6a6;</i>{{ $error }}</div>
                @endforeach
            @endif

            <div class="text-c">
                <input type="text" name="" id="" placeholder="栏目名称、id" style="width:250px" class="input-text">
                <button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜索
                </button>
            </div>
            <div class="cl pd-5 bg-1 bk-gray mt-20">
                <span class="l">
                    <a href="{{ route('admin.assess.add') }}" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加评价</a>
                </span>
                <span class="r">共有数据：<strong>{{ $count ? $count : 0 }}</strong> 条</span>
            </div>

            <div class="mt-20">

                <table class="table table-border table-bordered table-hover table-bg table-sort">
                    <thead>
                    <tr class="text-c">
                        <th width="80">ID</th>
                        <th>文章名称</th>
                        <th width="80">评论人</th>
                        <th width="80">排序</th>
                        <th width="80">状态</th>
                        <th width="180">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(collect($lists)->count() > 0)
                        @foreach($lists as $k => $v)
                            <tr class="text-c">

                                <td>{{ $v->id }}</td>
                                <td>{{ $v->title }}</td>
                                <td>{{ $v->name }}</td>
                                <td id="orderBy" data-id="{{ $v->id }}"
                                    data-url="{{ route('admin.assess.order') }}"
                                    data-order="{{ $v->order_by }}">{{ $v->order_by }}</td>
                                <td>
                                    @if($v->status == 1)
                                        已启用
                                    @else
                                        已禁用
                                    @endif
                                </td>
                                <td class="f-14">
                                    <button id="editShowModel"  class="btn btn-success size-S radius"
                                            data-id="{{ $v->id }}"
                                            data-url="{{ route('admin.assess.edit') }}">编辑
                                    </button>
                                    @if($v->status == 2)
                                        <button id="changeStatus" class="btn btn-secondary size-S radius"
                                                data-id="{{ $v->id }}"
                                                data-url="{{ route('admin.assess.status') }}"
                                                data-status="{{ $v->status }}">启用
                                        </button>
                                    @else
                                        <button id="changeStatus" class="btn btn-warning size-S radius"
                                                data-id="{{ $v->id }}"
                                                data-url="{{ route('admin.assess.status') }}"
                                                data-status="{{ $v->status }}">禁用
                                        </button>

                                    @endif
                                    <button id="destroy" class="btn btn-danger size-S radius" data-id="{{ $v->id }}"
                                            data-url="{{ route('admin.assess.destroy') }}">删除
                                    </button>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                {!! $lists->links() !!}
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script type="text/javascript" src="{{ asset('/admin/js/reputation.js') }}"></script>

@endsection