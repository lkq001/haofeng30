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

                    <span href="javascript:;" id="destroy-all" data-url="{{ route('admin.card.destroys') }}"
                          class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</span>
                <a class="btn btn-primary radius" href="{{ route('admin.card.add') }}"><i
                            class="Hui-iconfont">&#xe600;</i> 添加</a>
                </span>
                <span class="r">共有数据：<strong>{{ $count }}</strong> 条</span>
            </div>

            <div class="mt-20">
                <table class="table table-border table-bordered table-hover table-bg table-sort">
                    <thead>
                    <tr class="text-c">
                        <th width="25"><input type="checkbox" name="" value=""></th>
                        <th width="25">ID</th>
                        <th width="60">图片</th>
                        <th>宅配卡名称</th>
                        <th width="80">价格</th>
                        <th width="80">次数</th>
                        <th width="80">库存</th>
                        <th width="80">销量</th>
                        <th width="80">虚拟销量</th>
                        <th width="80">创建时间</th>
                        <th width="40">排序</th>
                        <th width="40">状态</th>
                        <th width="150">操作</th>
                    </tr>
                    </thead>
                    <tbody id="checked-box">
                    @if(collect($cardLists)->count() > 0)
                        @foreach($cardLists as $k => $v)
                            <tr class="text-c">
                                <td><input type="checkbox" name="check" value="{{ $v->id }}"></td>

                                <td>{{ $v->id }}</td>
                                <td class="text-l">
                                    <img src="{!! $v->thumb !!}" alt="" height="50px"/>
                                </td>
                                <td class="text-l">{{ $v->name }}</td>
                                <td>{{ $v->price }}</td>
                                <td>{{ $v->number }}</td>
                                <td>{{ $v->stock }}</td>
                                <td>{{ $v->sale }}</td>
                                <td>{{ $v->sale_virtual }}</td>
                                <td>{{ $v->created_at }}</td>
                                <td id="orderBy" data-id="{{ $v->id }}"
                                    data-url="{{ route('admin.card.order') }}"
                                    data-order="{{ $v->order_by }}">{{ $v->order_by }}</td>
                                <td>
                                    @if($v->status == 1)
                                        未上架
                                    @elseif($v->status == 2)
                                        已上架
                                    @elseif($v->status == 3)
                                        已下架
                                    @elseif($v->status == 4)
                                        已失效
                                    @elseif($v->status == 5)
                                        缺货
                                    @else
                                        其他
                                    @endif
                                </td>
                                <td class="f-14">
                                    <button id="editShowModel" class="btn btn-success size-S radius"
                                            data-id="{{ $v->id }}"
                                            data-url="{{ route('admin.card.edit') }}">编辑
                                    </button>
                                    @if($v->status == 2)
                                        <button id="changeStatus" class="btn btn-secondary size-S radius"
                                                data-id="{{ $v->id }}"
                                                data-url="{{ route('admin.card.status') }}"
                                                data-status="{{ $v->status }}">下架
                                        </button>
                                    @else
                                        <button id="changeStatus" class="btn btn-warning size-S radius"
                                                data-id="{{ $v->id }}"
                                                data-url="{{ route('admin.card.status') }}"
                                                data-status="{{ $v->status }}">上架
                                        </button>

                                    @endif
                                    <button id="destroy" class="btn btn-danger size-S radius" data-id="{{ $v->id }}"
                                            data-url="{{ route('admin.card.destroy') }}">删除
                                    </button>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>

                </table>
                <div class="pagination-left-button ">
                <span href="javascript:;" id="status-all" data-url="{{ route('admin.card.status.all') }}"
                      class="btn btn-primary-outline radius" data-status="2"><i
                            class="Hui-iconfont">&#xe6e2;</i> 批量上架</span>
                    <span href="javascript:;" id="status-all" data-url="{{ route('admin.card.status.all') }}"
                          class="btn btn-primary-outline radius" data-status="1"><i class="Hui-iconfont">&#xe6e2;</i> 批量下架</span>
                </div>

                {!! $cardLists->links() !!}
            </div>
        </div>
        @include('admin.layouts.bottom')
    </div>
@endsection
@section('javascript')

    <script type="text/javascript" src="{{ asset('/admin/js/card.js') }}"></script>

@endsection