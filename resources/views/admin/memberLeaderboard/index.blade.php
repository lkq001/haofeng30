@extends('admin.layouts.master')
@section('title', '排行榜管理')
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span>
        排行榜
        <span class="c-gray en">&gt;</span>
        列表
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
           href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="page-container">
        <div class="row">

            <div class="col-xs-4">
                <div class="cl pd-5 bg-1 bk-gray mt-20"><span class="text-c">消费排行榜</span></div>

                <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="80">ID</th>
                            <th>用户名</th>
                            <th>手机号</th>
                            <th>金额</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($memberListsByConsumptionPrice) && collect($memberListsByConsumptionPrice)->count() > 0)
                            @foreach($memberListsByConsumptionPrice as $k => $v)
                                <tr class="text-c">
                                    <td>{{ $v->id }}</td>
                                    <td>{{ $v->name }}</td>
                                    <td>{{ $v->phone }}</td>
                                    <td>{{ $v->consumption_price }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="text-c">
                                <td colspan="4">暂无排行信息</td>
                            </tr>
                        @endif

                        </tbody>
                    </table>
                    {!! $memberListsByConsumptionPrice->links() !!}
                </div>
            </div>
            <div class="col-xs-4">
                <div class="cl pd-5 bg-1 bk-gray mt-20"><span class="text-c">充值排行榜</span></div>
                <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="80">ID</th>
                            <th>用户名</th>
                            <th>手机号</th>
                            <th>金额</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($memberListsByRechargePrice) && collect($memberListsByRechargePrice)->count() > 0)
                            @foreach($memberListsByRechargePrice as $k => $v)
                                <tr class="text-c">
                                    <td>{{ $v->id }}</td>
                                    <td>{{ $v->name }}</td>
                                    <td>{{ $v->phone }}</td>
                                    <td>{{ $v->consumption_price }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="text-c">
                                <td colspan="4">暂无排行信息</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    {!! $memberListsByRechargePrice->links() !!}
                </div>
            </div>
            <div class="col-xs-4">
                <div class="cl pd-5 bg-1 bk-gray mt-20"><span class="text-c">积分排行榜</span></div>
                <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="80">ID</th>
                            <th>用户名</th>
                            <th>手机号</th>
                            <th>积分</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($memberListsByIntegral) && collect($memberListsByIntegral)->count() > 0)
                            @foreach($memberListsByIntegral as $k => $v)
                                <tr class="text-c">
                                    <td>{{ $v->id }}</td>
                                    <td>{{ $v->name }}</td>
                                    <td>{{ $v->phone }}</td>
                                    <td>{{ $v->consumption_price }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="text-c">
                                <td colspan="4">暂无排行信息</td>
                            </tr>
                        @endif

                        </tbody>
                    </table>
                    {!! $memberListsByIntegral->links() !!}
                </div>
            </div>
        </div>

    </div>
@endsection
@section('javascript')

    <script type="text/javascript" src="{{ asset('/admin/js/member.js') }}"></script>

@endsection