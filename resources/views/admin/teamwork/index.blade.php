@extends('admin.layouts.master')
@section('title', '拼团管理')

@section('content')
    @include('admin.teamwork.add')
    @include('admin.teamwork.edit')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span>
        拼团管理
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
                <span class="btn btn-primary radius" data-toggle="modal" data-target="#addModel"><i
                            class="Hui-iconfont">&#xe600;</i> 添加拼团</span>
                <span class="r">共有数据：<strong>{{ $count ? $count : 0 }}</strong> 条</span>
            </div>

            <div class="mt-20">

                <table class="table table-border table-bordered table-hover table-bg table-sort">
                    <thead>
                    <tr class="text-c">
                        <th width="80">ID</th>
                        <th>名称</th>
                        <th>图片缩略图</th>
                        <th width="80">价格</th>
                        <th width="80">人数</th>
                        <th width="80">排序</th>
                        <th width="80">开始时间</th>
                        <th width="80">结束时间</th>
                        <th width="80">状态</th>
                        <th width="150">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(collect($lists)->count() > 0)
                        @foreach($lists as $k => $v)
                            <tr class="text-c">

                                <td>{{ $v->id }}</td>
                                <td>{{ $v->name }}</td>
                                <td>
                                    <img src="{!! config('config.product_thumb') .'/'. $v->getOneProductThumb->thumb !!}"
                                         alt="" height="50px"/>
                                </td>

                                <td>{{ $v->price }}</td>
                                <td>{{ $v->people_number }}</td>

                                <td id="orderBy" data-id="{{ $v->id }}"
                                    data-url="{{ route('admin.teamwork.order') }}"
                                    data-order="{{ $v->order_by }}">{{ $v->order_by }}</td>

                                <td>{{ $v->start_time }}</td>
                                <td>{{ $v->end_time }}</td>
                                <td>
                                    @if($v->status == 1)
                                        进行中
                                    @elseif($v->status == 2)
                                        已结束
                                    @else
                                        未开始
                                    @endif
                                </td>
                                <td class="f-14">
                                    <button id="editShowModel" class="btn btn-success size-S radius"
                                            data-id="{{ $v->id }}"
                                            data-url="{{ route('admin.teamwork.edit') }}">编辑
                                    </button>
                                    @if($v->status == 1)
                                        <button id="changeStatus" class="btn btn-secondary size-S radius"
                                                data-id="{{ $v->id }}"
                                                data-url="{{ route('admin.teamwork.status') }}"
                                                data-status="{{ $v->status }}">结束
                                        </button>
                                    @endif
                                    <button id="destroy" class="btn btn-danger size-S radius" data-id="{{ $v->id }}"
                                            data-url="{{ route('admin.teamwork.destroy') }}">删除
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
    <script type="text/javascript" src="{{ asset('/admin/js/teamwork.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/admin/layDate/laydate.js')}}"></script>
@endsection