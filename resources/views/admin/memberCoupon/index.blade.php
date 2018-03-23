@extends('admin.layouts.master')
@section('title', '会员优惠券管理')
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span>
        会员优惠券管理
        <span class="c-gray en">&gt;</span>
        列表
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
           href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="page-container">
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="r">共有数据：<strong>{{ $count ?? 0 }}</strong> 条</span>
        </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                <tr class="text-c">
                    <th width="80">ID</th>
                    <th>用户名</th>
                    <th>用户手机号</th>
                    <th>优惠券名称</th>
                    <th>订单金额</th>
                    <th>优惠金额</th>
                    <th>有效时间(开始)</th>
                    <th>有效时间(过期)</th>
                    <th width="80">状态</th>
                </tr>
                </thead>
                <tbody id="checked-box">
                @if(collect($lists)->count() > 0)
                    @foreach($lists as $k => $v)
                        <tr class="text-c">
                            <td>{{ $v->id }}</td>
                            <td>{{ $v->getOneMember->username }}</td>
                            <td>{{ $v->getOneMember->phone }}</td>
                            <td>{{ $v->coupon_name }}</td>
                            <td>{{ $v->buy_total }}</td>
                            <td>{{ $v->relief_price }}</td>
                            <td>{{ $v->start_time }}</td>
                            <td>{{ $v->end_time }}</td>
                            <td>
                                @if($v->status == 1)
                                    已启用
                                @elseif($v->status == 2)
                                    已禁用
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
            {!! $lists->links() !!}
        </div>
    </div>
@endsection
@section('javascript')

    <script type="text/javascript" src="{{ asset('/admin/js/member.js') }}"></script>

@endsection