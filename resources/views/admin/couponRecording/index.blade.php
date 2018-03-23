@extends('admin.layouts.master')
@section('title', '优惠券发放记录管理')

@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span>
        优惠券发放记录管理
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
                <span class="r">共有数据：<strong>{{ $count ? $count : 0 }}</strong> 条</span>
            </div>

            <div class="mt-20">

                <table class="table table-border table-bordered table-hover table-bg table-sort">
                    <thead>
                    <tr class="text-c">
                        <th width="80">ID</th>
                        <th width="100">手机号</th>
                        <th>优惠券标题</th>
                        <th width="80">图片缩略图</th>
                        <th width="80">数量</th>
                        <th width="80">状态</th>
                        <th width="80">发放时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(collect($lists)->count() > 0)
                        @foreach($lists as $k => $v)
                            <tr class="text-c">

                                <td>{{ $v->id }}</td>
                                <td>{{ $v->phone }}</td>
                                <td>{{ $v->getOneCoupon->name }}</td>
                                <td>
                                    <img src="{!! $v->getOneCoupon->thumb !!}" alt="" height="50px"/>
                                </td>

                                <td>{{ $v->coupon_number }}</td>
                                <td>
                                    @if($v->status == 1)
                                        成功
                                    @else
                                        <span class="red">失败</span>
                                    @endif
                                </td>
                                <td>{{ $v->created_at }}</td>
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