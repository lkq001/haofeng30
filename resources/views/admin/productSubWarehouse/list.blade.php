@extends('admin.layouts.master')
@section('title', '产品分库添加产品')
@section('css')
    <link href="{{ asset('/admin/lib/webuploader/0.1.5/webuploader.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span>
        产品分库-添加产品
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

                <span class="r">共有数据：<strong>{{ $count ?? 0 }}</strong> 条</span>
            </div>

            <form action="{{ route('admin.product.sub.warehouse.product.store') }}" id="product-store" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $id }}">
                <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="25"><input type="checkbox" name="check" value=""></th>
                            <th width="25">ID</th>
                            <th width="60">商品</th>
                            <th>产品名称</th>
                            <th width="80">总库价格</th>
                            <th width="80">销售价格</th>
                            <th width="80">库存</th>
                            <th width="80">虚拟销量</th>
                            <th width="80">创建时间</th>
                        </tr>
                        </thead>
                        <tbody id="checked-box">
                        @if(collect($productWarehouseLists)->count() > 0)
                            @foreach($productWarehouseLists as $k => $v)
                                <tr class="text-c">
                                    <td><input type="checkbox" name="check" @if($v->check == 1) checked @endif value="{{ $v->id }}"></td>
                                    <td>{{ $v->id }}</td>
                                    <td class="text-l">
                                        <img src="{!! $v->thumb !!}" alt="" height="50px"/>
                                    </td>
                                    <td class="text-l">{{ $v->name }}</td>
                                    <td name="price">{{ $v->price }}</td>
                                    <td><input type="text" class="input-text" value="{{ $v->new_price ?? $v->price }}" placeholder=""
                                               onkeyup="onlyNumber(this)"
                                               name="price"></td>
                                    <td><input type="text" class="input-text" value="{{ $v->new_stock ?? '999999' }}" placeholder=""
                                               onkeyup="this.value=this.value.replace(/\D/g,'')"
                                               name="price"></td>
                                    <td><input type="text" class="input-text" value="{{ $v->new_sale }}" placeholder="0"
                                               onkeyup="this.value=this.value.replace(/\D/g,'')"
                                               name="sale_virtual"></td>
                                    <td>{{ $v->created_at }}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>

                    </table>

                </div>
                <div class="cl pd-5 bg-1 bk-gray mt-20">
                <span id="product-all" data-url="{{ route('admin.product.sub.warehouse.product.store') }}"
                      data-jump="{{ route('admin.product.sub.warehouse.index') }}"
                      class="r btn btn-success radius"><i class="icon Hui-iconfont">&#xe632;</i> 提交</span>
                </div>
            </form>
        </div>
        @include('admin.layouts.bottom')
    </div>
@endsection
@section('javascript')

    <script type="text/javascript" src="{{ asset('/admin/js/productSubWarehouse.js') }}"></script>

@endsection