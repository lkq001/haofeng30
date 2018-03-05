@extends('admin.layouts.master')
@section('title', '后台栏目列表')
@section('content')
    @include('admin.category.add')
    @include('admin.category.edit')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span>
        系统管理
        <span class="c-gray en">&gt;</span>
        栏目管理
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
           href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="page-container">
        <div class="text-c">
            <input type="text" name="" id="" placeholder="栏目名称、id" style="width:250px" class="input-text">
            <button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
        </div>
        <div class="cl pd-5 bg-1 bk-gray mt-20">
		<span class="l">
		<span href="javascript:;" id="destory-all" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</span>
		<span class="btn btn-primary radius" data-toggle="modal" data-target="#addModel"><i class="Hui-iconfont">&#xe600;</i> 添加栏目</span>
		</span>
            <span class="r">共有数据：<strong>{{ $count ? $count : 0 }}</strong> 条</span>
        </div>

        <div class="mt-20">
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                <tr class="text-c">
                    <th width="25"><input type="checkbox" name="" value=""></th>
                    <th width="80">ID</th>
                    <th>栏目名称</th>
                    <th width="80">排序</th>
                    <th width="80">状态</th>
                    <th width="150">操作</th>
                </tr>
                </thead>
                <tbody>
                @if($categoryLists[0])
                    @foreach($categoryLists[0] as $k => $v)
                        <tr class="text-c">
                            <td><input type="checkbox" name="" value=""></td>
                            <td>{{ $v->id }}</td>
                            <td class="text-l">{{ $v->name }}</td>
                            <td id="orderBy" data-id="{{ $v->id }}"
                                data-url="{{ route('admin.category.order') }}"
                                data-order="{{ $v->order_by }}">{{ $v->order_by }}</td>
                            <td>
                                @if($v->status == 1)
                                    已启用
                                @elseif($v->status == 2)
                                    已禁用
                                @endif
                            </td>
                            <td class="f-14">
                                <button id="editShowModel" class="btn btn-success size-S radius" data-id="{{ $v->id }}"
                                        data-url="{{ route('admin.category.edit') }}">编辑
                                </button>
                                @if($v->status == 1)
                                    <button id="changeStatus" class="btn btn-warning size-S radius"
                                            data-id="{{ $v->id }}"
                                            data-url="{{ route('admin.category.status') }}"
                                            data-status="{{ $v->status }}">禁用
                                    </button>
                                @elseif($v->status == 2)
                                    <button id="changeStatus" class="btn btn-secondary size-S radius"
                                            data-id="{{ $v->id }}"
                                            data-url="{{ route('admin.category.status') }}"
                                            data-status="{{ $v->status }}">启用
                                    </button>
                                @endif
                                <button id="destroy" class="btn btn-danger size-S radius" data-id="{{ $v->id }}"
                                        data-url="{{ route('admin.category.destroy') }}">删除
                                </button>
                        </tr>
                        @if(isset($categoryLists[$v->id]))
                            @foreach($categoryLists[$v->id] as $key => $val)
                                <tr class="text-c">
                                    <td><input type="checkbox" name="" value=""></td>
                                    <td>{{ $val->id }}</td>
                                    <td class="text-l">|-- {{ $val->name }}</td>
                                    <td id="orderBy" data-id="{{ $val->id }}"
                                        data-url="{{ route('admin.category.order') }}"
                                        data-order="{{ $val->order_by }}">{{ $val->order_by }}</td>
                                    <td>
                                        @if($val->status == 1)
                                            已启用
                                        @elseif($val->status == 2)
                                            已禁用
                                        @endif
                                    </td>
                                    <td class="f-14">
                                        <button id="editShowModel" class="btn btn-success size-S radius"
                                                data-id="{{ $val->id }}"
                                                data-url="{{ route('admin.category.edit') }}">编辑
                                        </button>
                                        @if($val->status == 1)
                                            <button id="changeStatus" class="btn btn-warning size-S radius"
                                                    data-id="{{ $val->id }}"
                                                    data-url="{{ route('admin.category.status') }}"
                                                    data-status="{{ $val->status }}">禁用
                                            </button>
                                        @elseif($val->status == 2)
                                            <button id="changeStatus" class="btn btn-secondary size-S radius"
                                                    data-id="{{ $val->id }}"
                                                    data-url="{{ route('admin.category.status') }}"
                                                    data-status="{{ $val->status }}">启用
                                            </button>
                                        @endif
                                        <button id="destroy" class="btn btn-danger size-S radius"
                                                data-id="{{ $val->id }}"
                                                data-url="{{ route('admin.category.destroy') }}">删除
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('javascript')

    <script type="text/javascript" src="{{ asset('/admin/js/category.js') }}"></script>

@endsection