@extends('admin.layouts.master')
@section('title', '积分管理')
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span>
        积分排行榜
        <span class="c-gray en">&gt;</span>
        列表
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
           href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="page-container">
        <div class="row">

            <div class="cl pd-5 bg-1 bk-gray mt-20"><span class="text-c">积分排行榜</span></div>

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
                    @if(isset($memberLists) && collect($memberLists)->count() > 0)
                        @foreach($memberLists as $k => $v)
                            <tr class="text-c">
                                <td>{{ $v->id }}</td>
                                <td>{{ $v->name }}</td>
                                <td>{{ $v->phone }}</td>
                                <td>{{ $v->integral }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-c">
                            <td colspan="4">暂无排行信息</td>
                        </tr>
                    @endif

                    </tbody>
                </table>
                {!! $memberLists->links() !!}
            </div>

        </div>

    </div>
@endsection
@section('javascript')

    <script type="text/javascript" src="{{ asset('/admin/js/member.js') }}"></script>

@endsection