@extends('admin.layouts.master')
@section('title', '会员组管理')
@section('content')
    @include('admin.memberGroup.add')
    @include('admin.memberGroup.edit')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span>
        会员组管理
        <span class="c-gray en">&gt;</span>
        列表
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
           href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="page-container">
        <div class="cl pd-5 bg-1 bk-gray mt-20">
		<span class="l">
		<span class="btn btn-primary radius" data-toggle="modal" data-target="#addModel"><i class="Hui-iconfont">&#xe600;</i> 添加会员组</span>
		</span>
            <span class="r">共有数据：<strong>{{ $count }}</strong> 条</span>
        </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                <tr class="text-c">
                    <th width="80">ID</th>
                    <th>名称</th>
                    <th width="80">排序</th>
                    <th width="80">状态</th>
                    <th width="250">操作</th>
                </tr>
                </thead>
                <tbody id="checked-box">
                @if(collect($memberGroupLists)->count() > 0)
                    @foreach($memberGroupLists as $k => $v)
                        <tr class="text-c">
                            <td>{{ $v->id }}</td>
                            <td class="text-l">{{ $v->name }}</td>
                            <td id="orderBy" data-id="{{ $v->id }}"
                                data-url="{{ route('admin.member.group.order') }}"
                                data-order="{{ $v->order_by }}">{{ $v->order_by }}</td>
                            <td>
                                @if($v->status == 1)
                                    已启用
                                @elseif($v->status == 2)
                                    已禁用
                                @endif
                            </td>
                            <td class="f-14">
                                @if($v->id != 1)
                                    <button id="editShowModel" class="btn btn-success size-S radius"
                                            data-id="{{ $v->id }}"
                                            data-url="{{ route('admin.member.group.edit') }}">编辑
                                    </button>
                                @endif
                                <button id="productShowModel" class="btn btn-success size-S radius"
                                        data-id="{{ $v->id }}"
                                        data-url="{{ route('admin.member.group.product.list') }}">产品配置
                                </button>
                                @if($v->id != 1)
                                    @if($v->status == 1)
                                        <button id="changeStatus" class="btn btn-warning size-S radius"
                                                data-id="{{ $v->id }}"
                                                data-url="{{ route('admin.member.group.status') }}"
                                                data-status="{{ $v->status }}">禁用
                                        </button>
                                    @elseif($v->status == 2)
                                        <button id="changeStatus" class="btn btn-secondary size-S radius"
                                                data-id="{{ $v->id }}"
                                                data-url="{{ route('admin.member.group.status') }}"
                                                data-status="{{ $v->status }}">启用
                                        </button>
                                    @endif
                                    <button id="destroy" class="btn btn-danger size-S radius" data-id="{{ $v->id }}"
                                            data-url="{{ route('admin.member.group.destroy') }}">删除
                                    </button>
                            @endif
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('javascript')

    <script type="text/javascript" src="{{ asset('/admin/js/memberGroup.js') }}"></script>

@endsection