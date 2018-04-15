<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// qpi 接口 用于微信小程序
Route::group(['namespace' => 'Api\V1'], function () {
    // 获取轮播图
    Route::get('/getBannerData', 'BannerController@getBannerData');

    // 获取宅配卡列表
    Route::get('/getCardData', 'CardController@getCardData');

    // 获取宅配卡下广告位
    Route::get('/getCardAd', 'AdController@getCardAd');

    // 获取产品分类页面广告位
    Route::get('/getAdByCategory', 'AdController@getAdByCategory');

    // 获取产品列表
    Route::get('/getProductData', 'ProductController@getProductData');

    // 获取产品列表 (C端产品--通用)
    Route::get('/getMemberGroupProduct', 'ProductController@getMemberGroupProduct');

    // 获取产品分类信息
    Route::get('/getCategory', 'ProductCategoryController@getCategory');

    Route::post('/uploads', 'UploadController@uploadImage');

});