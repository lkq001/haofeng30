@extends('admin.layouts.master')
@section('title', '优惠券管理')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/thumbJq/css/font-awesome.4.6.0.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/thumbJq/css/amazeui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/thumbJq/css/amazeui.cropper.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/thumbJq/css/custom_up_img.css') }}">
    <style type="text/css">
        .up-img-cover {
            width: 100px;
            height: 100px;
        }

        .up-img-cover img {
            width: 100%;
        }
    </style>
@endsection

@section('content')

    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span>
        优惠券管理
        <span class="c-gray en">&gt;</span>
        添加
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
           href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="page-container">
        <div class="Hui-article">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="Huialert Huialert-danger text-c"><i class="Hui-iconfont">&#xe6a6;</i>{{ $error }}</div>
                @endforeach
            @endif
            <form method="post" class="form form-horizontal" id="form-add"
                  data-jump = "{{ route('admin.coupon.index') }}" action="{{ route('admin.coupon.store') }}" >
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>优惠券名称：</label>
                        <div class="formControls col-xs-8 col-sm-8">
                            <input type="text" class="input-text" value="{{ old('name') }}" placeholder="" name="name"/>
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>优惠券分类：</label>
                        <div class="formControls col-xs-8 col-sm-4">
                            <span class="select-box">
                                <select name="coupon_type" class="select">
                                    <option value="1">满减劵</option>
                                    <option value="2">满赠劵</option>
                                </select>
                            </span>
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>优惠券图片：</label>
                        <div class="formControls col-xs-8 col-sm-2" id="up-img-touch">
                            <img class="am-circle" alt="点击图片上传" data-width="1.5" data-height="1"
                                 src="{{ asset('admin/thumbJq/thumb.png') }}">
                            <input type="hidden" name="thumb" value=""/>
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>订单金额：</label>
                        <div class="formControls col-xs-8 col-sm-4">
                            <input type="text" class="input-text" value="{{ old('buy_total') ?? '' }}" placeholder=""
                                   id="" name="buy_total">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>减免金额：</label>
                        <div class="formControls col-xs-8 col-sm-4">
                            <input type="text" class="input-text" value="{{ old('relief_price') ?? '' }}" placeholder=""
                                   id="" name="relief_price">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>开始时间：</label>
                        <div class="formControls col-xs-8 col-sm-4">
                            <input type="text" class="input-text" value="" placeholder="" id="start_time" name="start_time">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>结束时间：</label>
                        <div class="formControls col-xs-8 col-sm-4">
                            <input type="text" class="input-text" value="" placeholder="" id="end_time" name="end_time">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>优惠券数量：</label>
                        <div class="formControls col-xs-8 col-sm-4">
                            <input type="text" class="input-text" value="" placeholder="" id="coupon_num" name="coupon_num">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>优惠券简介：</label>
                        <div class="formControls col-xs-8 col-sm-4">
                            <input type="text" class="input-text" value="" placeholder="" id="abstract" name="abstract">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">优惠券使用方式：</label>
                        <div class="formControls col-xs-8 col-sm-4">
                            <input type="text" class="input-text" value="" placeholder="" id="introduce" name="introduce">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">栏目排序：</label>
                        <div class="formControls col-xs-8 col-sm-4">
                            <input type="text" class="input-text" value="{{ old('order_by') ?? 0 }}" placeholder=""
                                   id="" name="order_by">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <a href="{{ route('admin.coupon.index') }}" class="btn btn-default">返回列表</a>
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </form>
        </div>
    </div>
    <input type="hidden" name="upload_url" value="{{ route('admin.coupon.upload') }}">
    @include('admin.layouts.thumb')
@endsection
@section('javascript')

    <script type="text/javascript" src="{{ asset('/admin/js/coupon.js') }}"></script>
    <script src="{{ asset('admin/thumbJq/js/amazeui.min.js') }}" charset="utf-8"></script>
    <script src="{{ asset('admin/thumbJq/js/cropper.min.js') }}" charset="utf-8"></script>
    <script src="{{ asset('admin/thumbJq/js/custom_up_img.js') }}" charset="utf-8"></script>
    <script type="text/javascript" src="{{ asset('/admin/layDate/laydate.js')}}"></script>
    <script type="text/javascript">
        uploadThumb();
    </script>
@endsection