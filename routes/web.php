<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/**
 * 后台管理路由
 */

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'admin'], function () {

    /**
     * 后台菜单管理
     */
    Route::group(['prefix' => '/category'], function () {
        // 菜单列表
        Route::get('/index', 'CategoryController@index')->name('admin.category.index');
        // 添加数据
        Route::post('/store', 'CategoryController@store')->name('admin.category.store');
        // 查询指定ID数据(id)
        Route::get('/edit', 'CategoryController@edit')->name('admin.category.edit');
        // 修改数据(id)
        Route::post('/update', 'CategoryController@update')->name('admin.category.update');
        // 删除数据(id)
        Route::delete('/destroy', 'CategoryController@destroy')->name('admin.category.destroy');
        // 修改状态
        Route::post('/status', 'CategoryController@status')->name('admin.category.status');
        // 修改排序
        Route::post('/order', 'CategoryController@order')->name('admin.category.order');
    });

    /**
     * 产品组管理
     */
    Route::group(['prefix' => '/product/group'], function () {
        // 数据列表
        Route::get('/index', 'ProductGroupController@index')->name('admin.product.group.index');
        // 添加数据
        Route::post('/store', 'ProductGroupController@store')->name('admin.product.group.store');
        // 查询指定ID数据(id)
        Route::get('/edit', 'ProductGroupController@edit')->name('admin.product.group.edit');
        // 修改数据(id)
        Route::post('/update', 'ProductGroupController@update')->name('admin.product.group.update');
        // 删除数据(id)
        Route::delete('/destroy', 'ProductGroupController@destroy')->name('admin.product.group.destroy');
        // 批量删除
        Route::delete('/destroys', 'ProductGroupController@destroys')->name('admin.product.group.destroys');
        // 修改状态
        Route::post('/status', 'ProductGroupController@status')->name('admin.product.group.status');
        // 修改排序
        Route::post('/order', 'ProductGroupController@order')->name('admin.product.group.order');
    });

    /**
     * 产品规格分类
     */
    Route::group(['prefix' => '/specifications/category'], function () {
        // 数据列表
        Route::get('/index', 'SpecificationsCategoryController@index')->name('admin.specifications.category.index');
        // 添加数据
        Route::post('/store', 'SpecificationsCategoryController@store')->name('admin.specifications.category.store');
        // 查询指定ID数据(id)
        Route::get('/edit', 'SpecificationsCategoryController@edit')->name('admin.specifications.category.edit');
        // 修改数据(id)
        Route::post('/update', 'SpecificationsCategoryController@update')->name('admin.specifications.category.update');
        // 删除数据(id)
        Route::delete('/destroy', 'SpecificationsCategoryController@destroy')->name('admin.specifications.category.destroy');
        // 批量删除
        Route::delete('/destroys', 'SpecificationsCategoryController@destroys')->name('admin.specifications.category.destroys');
        // 修改状态
        Route::post('/status', 'SpecificationsCategoryController@status')->name('admin.specifications.category.status');
        // 修改排序
        Route::post('/order', 'SpecificationsCategoryController@order')->name('admin.specifications.category.order');
    });

    /**
     * 产品规格
     */
    Route::group(['prefix' => '/specifications'], function () {
        // 数据列表
        Route::get('/index', 'SpecificationsController@index')->name('admin.specifications.index');
        // 添加数据
        Route::post('/store', 'SpecificationsController@store')->name('admin.specifications.store');
        // 查询指定ID数据(id)
        Route::get('/edit', 'SpecificationsController@edit')->name('admin.specifications.edit');
        // 修改数据(id)
        Route::post('/update', 'SpecificationsController@update')->name('admin.specifications.update');
        // 删除数据(id)
        Route::delete('/destroy', 'SpecificationsController@destroy')->name('admin.specifications.destroy');
        // 批量删除
        Route::delete('/destroys', 'SpecificationsController@destroys')->name('admin.specifications.destroys');
        // 修改状态
        Route::post('/status', 'SpecificationsController@status')->name('admin.specifications.status');
        // 修改排序
        Route::post('/order', 'SpecificationsController@order')->name('admin.specifications.order');
    });

    /**
     * 产品分类
     */
    Route::group(['prefix' => '/product/category'], function () {

        Route::get('/index', 'ProductCategoryController@index')->name('admin.product.category.index');
        // 添加数据
        Route::post('/store', 'ProductCategoryController@store')->name('admin.product.category.store');
        // 查询指定ID数据(id)
        Route::get('/edit', 'ProductCategoryController@edit')->name('admin.product.category.edit');
        // 修改数据(id)
        Route::post('/update', 'ProductCategoryController@update')->name('admin.product.category.update');
        // 删除数据(id)
        Route::delete('/destroy', 'ProductCategoryController@destroy')->name('admin.product.category.destroy');
        // 批量删除
        Route::delete('/destroys', 'ProductCategoryController@destroys')->name('admin.product.category.destroys');
        // 修改状态
        Route::post('/status', 'ProductCategoryController@status')->name('admin.product.category.status');
        // 修改排序
        Route::post('/order', 'ProductCategoryController@order')->name('admin.product.category.order');
    });

    /**
     * 产品管理-总库
     */
    Route::group(['prefix' => '/product/warehouse'], function () {
        // 数据列表
        Route::get('/index', 'ProductWarehouseController@index')->name('admin.product.warehouse.index');
        // 添加页面
        Route::get('/add', 'ProductWarehouseController@add')->name('admin.product.warehouse.add');
        // 添加数据
        Route::post('/store', 'ProductWarehouseController@store')->name('admin.product.warehouse.store');
        // 查询指定ID数据(id)
        Route::get('/edit', 'ProductWarehouseController@edit')->name('admin.product.warehouse.edit');
        // 修改数据(id)
        Route::post('/update', 'ProductWarehouseController@update')->name('admin.product.warehouse.update');
        // 删除数据(id)
        Route::delete('/destroy', 'ProductWarehouseController@destroy')->name('admin.product.warehouse.destroy');
        // 批量删除
        Route::delete('/destroys', 'ProductWarehouseController@destroys')->name('admin.product.warehouse.destroys');
        // 修改状态
        Route::post('/status/all', 'ProductWarehouseController@statusAll')->name('admin.product.warehouse.status.all');
        // 批量修改状态
        Route::post('/status', 'ProductWarehouseController@status')->name('admin.product.warehouse.status');
        // 修改排序
        Route::post('/order', 'ProductWarehouseController@order')->name('admin.product.warehouse.order');
    });

    /**
     * 产品管理-分库
     */
    Route::group(['prefix' => '/product/sub/warehouse'], function () {
        // 数据列表
        Route::get('/index', 'ProductSubWarehouseController@index')->name('admin.product.sub.warehouse.index');
        // 添加页面
        Route::get('/add', 'ProductSubWarehouseController@add')->name('admin.product.sub.warehouse.add');
        // 添加数据
        Route::post('/store', 'ProductSubWarehouseController@store')->name('admin.product.sub.warehouse.store');
        // 查询指定ID数据(id)
        Route::get('/edit', 'ProductSubWarehouseController@edit')->name('admin.product.sub.warehouse.edit');
        // 产品分库产品管理
        Route::get('/product/list', 'ProductSubWarehouseController@productLists')->name('admin.product.sub.warehouse.product.list');
        // 产品分库产品管理添加
        Route::post('/product/store', 'ProductSubWarehouseController@productStore')->name('admin.product.sub.warehouse.product.store');
        // 修改数据(id)
        Route::post('/update', 'ProductSubWarehouseController@update')->name('admin.product.sub.warehouse.update');
        // 删除数据(id)
        Route::delete('/destroy', 'ProductSubWarehouseController@destroy')->name('admin.product.sub.warehouse.destroy');
        // 批量删除
        Route::delete('/destroys', 'ProductSubWarehouseController@destroys')->name('admin.product.sub.warehouse.destroys');
        // 修改状态
        Route::post('/status/all', 'ProductSubWarehouseController@statusAll')->name('admin.product.sub.warehouse.status.all');
        // 批量修改状态
        Route::post('/status', 'ProductSubWarehouseController@status')->name('admin.product.sub.warehouse.status');
        // 修改排序
        Route::post('/order', 'ProductSubWarehouseController@order')->name('admin.product.sub.warehouse.order');
    });

    /**
     * 宅配卡管理
     */
    Route::group(['prefix' => '/card'], function () {
        // 数据列表
        Route::get('/index', 'CardController@index')->name('admin.card.index');
        // 添加页面
        Route::get('/add', 'CardController@add')->name('admin.card.add');
        // 添加数据
        Route::post('/store', 'CardController@store')->name('admin.card.store');
        // 查询指定ID数据(id)
        Route::get('/edit', 'CardController@edit')->name('admin.card.edit');
        // 修改数据(id)
        Route::post('/update', 'CardController@update')->name('admin.card.update');
        // 删除数据(id)
        Route::delete('/destroy', 'CardController@destroy')->name('admin.card.destroy');
        // 批量删除
        Route::delete('/destroys', 'CardController@destroys')->name('admin.card.destroys');
        // 修改状态
        Route::post('/status/all', 'CardController@statusAll')->name('admin.card.status.all');
        // 批量修改状态
        Route::post('/status', 'CardController@status')->name('admin.card.status');
        // 修改排序
        Route::post('/order', 'CardController@order')->name('admin.card.order');
    });

    /**
     * 宅配卡分类管理
     */
    Route::group(['prefix' => '/card/category'], function () {
        // 数据列表
        Route::get('/index', 'CardCategoryController@index')->name('admin.card.category.index');
        // 添加页面
        Route::get('/add', 'CardCategoryController@add')->name('admin.card.category.add');
        // 添加数据
        Route::post('/store', 'CardCategoryController@store')->name('admin.card.category.store');
        // 查询指定ID数据(id)
        Route::get('/edit', 'CardCategoryController@edit')->name('admin.card.category.edit');
        // 修改数据(id)
        Route::post('/update', 'CardCategoryController@update')->name('admin.card.category.update');
        // 删除数据(id)
        Route::delete('/destroy', 'CardCategoryController@destroy')->name('admin.card.category.destroy');
        // 批量删除
        Route::delete('/destroys', 'CardCategoryController@destroys')->name('admin.card.category.destroys');
        // 修改状态
        Route::post('/status/all', 'CardCategoryController@statusAll')->name('admin.card.category.status.all');
        // 批量修改状态
        Route::post('/status', 'CardCategoryController@status')->name('admin.card.category.status');
        // 修改排序
        Route::post('/order', 'CardCategoryController@order')->name('admin.card.category.order');
    });

    /**
     * 用户组管理
     */
    Route::group(['prefix' => '/member/group'], function () {
        // 数据列表
        Route::get('/index', 'MemberGroupController@index')->name('admin.member.group.index');
        // 添加页面
        Route::get('/add', 'MemberGroupController@add')->name('admin.member.group.add');
        // 添加数据
        Route::post('/store', 'MemberGroupController@store')->name('admin.member.group.store');
        // 查询指定ID数据(id)
        Route::get('/edit', 'MemberGroupController@edit')->name('admin.member.group.edit');
        // 修改数据(id)
        Route::post('/update', 'MemberGroupController@update')->name('admin.member.group.update');
        // 删除数据(id)
        Route::delete('/destroy', 'MemberGroupController@destroy')->name('admin.member.group.destroy');
        // 批量删除
        Route::delete('/destroys', 'MemberGroupController@destroys')->name('admin.member.group.destroys');
        // 修改状态
        Route::post('/status/all', 'MemberGroupController@statusAll')->name('admin.member.group.status.all');
        // 批量修改状态
        Route::post('/status', 'MemberGroupController@status')->name('admin.member.group.status');
        // 修改排序
        Route::post('/order', 'MemberGroupController@order')->name('admin.member.group.order');
        // 产品分库产品管理
        Route::get('/product/list', 'MemberGroupController@productLists')->name('admin.member.group.product.list');
        // 产品分库产品管理添加
        Route::post('/product/store', 'MemberGroupController@productStore')->name('admin.member.group.product.store');
    });

    /**
     * 会员管理
     */
    Route::group(['prefix' => '/member'], function () {
        // 数据列表
        Route::get('/index', 'MemberController@index')->name('admin.member.index');
        // 添加页面
        Route::get('/add', 'MemberController@add')->name('admin.member.add');
        // 添加数据
        Route::post('/store', 'MemberController@store')->name('admin.member.store');
        // 查询指定ID数据(id)
        Route::get('/edit', 'MemberController@edit')->name('admin.member.edit');
        // 修改数据(id)
        Route::post('/update', 'MemberController@update')->name('admin.member.update');
        // 删除数据(id)
        Route::delete('/destroy', 'MemberController@destroy')->name('admin.member.destroy');
        // 批量删除
        Route::delete('/destroys', 'MemberController@destroys')->name('admin.member.destroys');
        // 修改状态
        Route::post('/status/all', 'MemberController@statusAll')->name('admin.member.status.all');
        // 批量修改状态
        Route::post('/status', 'MemberController@status')->name('admin.member.status');
        // 修改排序
        Route::post('/order', 'MemberController@order')->name('admin.member.order');
    });

    /**
     * 会员消费排行榜管理
     */
    Route::group(['prefix' => '/member/consumption'], function () {
        // 数据列表
        Route::get('/index', 'MemberConsumptionController@index')->name('admin.member.consumption.index');
        // 添加页面
        Route::get('/add', 'MemberConsumptionController@add')->name('admin.member.consumption.add');
        // 添加数据
        Route::post('/store', 'MemberConsumptionController@store')->name('admin.member.consumption.store');
        // 查询指定ID数据(id)
        Route::get('/edit', 'MemberConsumptionController@edit')->name('admin.member.consumption.edit');
        // 修改数据(id)
        Route::post('/update', 'MemberConsumptionController@update')->name('admin.member.consumption.update');
        // 删除数据(id)
        Route::delete('/destroy', 'MemberConsumptionController@destroy')->name('admin.member.consumption.destroy');
        // 批量删除
        Route::delete('/destroys', 'MemberConsumptionController@destroys')->name('admin.member.consumption.destroys');
        // 修改状态
        Route::post('/status/all', 'MemberConsumptionController@statusAll')->name('admin.member.consumption.status.all');
        // 批量修改状态
        Route::post('/status', 'MemberConsumptionController@status')->name('admin.member.consumption.status');
        // 修改排序
        Route::post('/order', 'MemberConsumptionController@order')->name('admin.member.consumption.order');
    });

    /**
     * 会员充值排行榜管理
     */
    Route::group(['prefix' => '/member/recharge'], function () {
        // 数据列表
        Route::get('/index', 'MemberRechargeController@index')->name('admin.member.recharge.index');
        // 添加页面
        Route::get('/add', 'MemberRechargeController@add')->name('admin.member.recharge.add');
        // 添加数据
        Route::post('/store', 'MemberRechargeController@store')->name('admin.member.recharge.store');
        // 查询指定ID数据(id)
        Route::get('/edit', 'MemberRechargeController@edit')->name('admin.member.recharge.edit');
        // 修改数据(id)
        Route::post('/update', 'MemberRechargeController@update')->name('admin.member.recharge.update');
        // 删除数据(id)
        Route::delete('/destroy', 'MemberRechargeController@destroy')->name('admin.member.recharge.destroy');
        // 批量删除
        Route::delete('/destroys', 'MemberRechargeController@destroys')->name('admin.member.recharge.destroys');
        // 修改状态
        Route::post('/status/all', 'MemberRechargeController@statusAll')->name('admin.member.recharge.status.all');
        // 批量修改状态
        Route::post('/status', 'MemberRechargeController@status')->name('admin.member.recharge.status');
        // 修改排序
        Route::post('/order', 'MemberRechargeController@order')->name('admin.member.recharge.order');
    });

    /**
     * 会员积分排行榜管理
     */
    Route::group(['prefix' => '/member/integral'], function () {
        // 数据列表
        Route::get('/index', 'MemberIntegralController@index')->name('admin.member.integral.index');
        // 添加页面
        Route::get('/add', 'MemberIntegralController@add')->name('admin.member.integral.add');
        // 添加数据
        Route::post('/store', 'MemberIntegralController@store')->name('admin.member.integral.store');
        // 查询指定ID数据(id)
        Route::get('/edit', 'MemberIntegralController@edit')->name('admin.member.integral.edit');
        // 修改数据(id)
        Route::post('/update', 'MemberIntegralController@update')->name('admin.member.integral.update');
        // 删除数据(id)
        Route::delete('/destroy', 'MemberIntegralController@destroy')->name('admin.member.integral.destroy');
        // 批量删除
        Route::delete('/destroys', 'MemberIntegralController@destroys')->name('admin.member.integral.destroys');
        // 修改状态
        Route::post('/status/all', 'MemberIntegralController@statusAll')->name('admin.member.integral.status.all');
        // 批量修改状态
        Route::post('/status', 'MemberIntegralController@status')->name('admin.member.integral.status');
        // 修改排序
        Route::post('/order', 'MemberIntegralController@order')->name('admin.member.integral.order');
    });

    /**
     * 会员积分排行榜管理
     */
    Route::group(['prefix' => '/warehouse'], function () {
        // 数据列表
        Route::get('/index', 'WarehouseController@index')->name('admin.warehouse.index');
        // 添加页面
        Route::get('/add', 'WarehouseController@add')->name('admin.warehouse.add');
        // 添加数据
        Route::post('/store', 'WarehouseController@store')->name('admin.warehouse.store');
        // 查询指定ID数据(id)
        Route::get('/edit', 'WarehouseController@edit')->name('admin.warehouse.edit');
        // 修改数据(id)
        Route::post('/update', 'WarehouseController@update')->name('admin.warehouse.update');
        // 删除数据(id)
        Route::delete('/destroy', 'WarehouseController@destroy')->name('admin.warehouse.destroy');
        // 批量删除
        Route::delete('/destroys', 'WarehouseController@destroys')->name('admin.warehouse.destroys');
        // 修改状态
        Route::post('/status/all', 'WarehouseController@statusAll')->name('admin.warehouse.status.all');
        // 批量修改状态
        Route::post('/status', 'WarehouseController@status')->name('admin.warehouse.status');
        // 修改排序
        Route::post('/order', 'WarehouseController@order')->name('admin.warehouse.order');
    });

    /**
     * 幻灯片管理
     */
    Route::group(['prefix' => '/banner/category'], function () {
        // 数据列表
        Route::get('/index', 'BannerCategoryController@index')->name('admin.banner.category.index');
        // 添加页面
        Route::get('/add', 'BannerCategoryController@add')->name('admin.banner.category.add');
        // 添加数据
        Route::post('/store', 'BannerCategoryController@store')->name('admin.banner.category.store');
        // 查询指定ID数据(id)
        Route::get('/edit', 'BannerCategoryController@edit')->name('admin.banner.category.edit');
        // 修改数据(id)
        Route::post('/update', 'BannerCategoryController@update')->name('admin.banner.category.update');
        // 删除数据(id)
        Route::delete('/destroy', 'BannerCategoryController@destroy')->name('admin.banner.category.destroy');
        // 批量删除
        Route::delete('/destroys', 'BannerCategoryController@destroys')->name('admin.banner.category.destroys');
        // 修改状态
        Route::post('/status/all', 'BannerCategoryController@statusAll')->name('admin.banner.category.status.all');
        // 批量修改状态
        Route::post('/status', 'BannerCategoryController@status')->name('admin.banner.category.status');
        // 修改排序
        Route::post('/order', 'BannerCategoryController@order')->name('admin.banner.category.order');
    });

    /**
     * 幻灯片管理
     */
    Route::group(['prefix' => '/banner'], function () {
        // 数据列表
        Route::get('/index', 'BannerController@index')->name('admin.banner.index');
        // 添加页面
        Route::get('/add', 'BannerController@add')->name('admin.banner.add');
        // 添加数据
        Route::post('/store', 'BannerController@store')->name('admin.banner.store');
        // 查询指定ID数据(id)
        Route::get('/edit', 'BannerController@edit')->name('admin.banner.edit');
        // 修改数据(id)
        Route::post('/update', 'BannerController@update')->name('admin.banner.update');
        // 删除数据(id)
        Route::delete('/destroy', 'BannerController@destroy')->name('admin.banner.destroy');
        // 批量删除
        Route::delete('/destroys', 'BannerController@destroys')->name('admin.banner.destroys');
        // 修改状态
        Route::post('/status/all', 'BannerController@statusAll')->name('admin.banner.status.all');
        // 批量修改状态
        Route::post('/status', 'BannerController@status')->name('admin.banner.status');
        // 修改排序
        Route::post('/order', 'BannerController@order')->name('admin.banner.order');
    });

    /**
     * 绿色主张
     */
    Route::group(['prefix' => '/article'], function () {
        // 数据列表
        Route::get('/index', 'ArticleController@index')->name('admin.article.index');
        // 添加页面
        Route::get('/add', 'ArticleController@add')->name('admin.article.add');
        // 添加数据
        Route::post('/store', 'ArticleController@store')->name('admin.article.store');
        // 查询指定ID数据(id)
        Route::get('/edit', 'ArticleController@edit')->name('admin.article.edit');
        // 修改数据(id)
        Route::post('/update', 'ArticleController@update')->name('admin.article.update');
        // 删除数据(id)
        Route::delete('/destroy', 'ArticleController@destroy')->name('admin.article.destroy');
        // 批量删除
        Route::delete('/destroys', 'ArticleController@destroys')->name('admin.article.destroys');
        // 修改状态
        Route::post('/status/all', 'ArticleController@statusAll')->name('admin.article.status.all');
        // 批量修改状态
        Route::post('/status', 'ArticleController@status')->name('admin.article.status');
        // 修改排序
        Route::post('/order', 'ArticleController@order')->name('admin.article.order');

        Route::post('/upload', 'ArticleController@postUpload')->name('admin.article.upload');

        Route::post('/crop', 'ArticleController@postCrop')->name('admin.article.crop');

    });

    /**
     * 吃货口碑
     */
    Route::group(['prefix' => '/reputation'], function () {
        // 数据列表
        Route::get('/index', 'ReputationController@index')->name('admin.reputation.index');
        // 添加页面
        Route::get('/add', 'ReputationController@add')->name('admin.reputation.add');
        // 添加数据
        Route::post('/store', 'ReputationController@store')->name('admin.reputation.store');
        // 查询指定ID数据(id)
        Route::get('/edit', 'ReputationController@edit')->name('admin.reputation.edit');
        // 修改数据(id)
        Route::post('/update', 'ReputationController@update')->name('admin.reputation.update');
        // 删除数据(id)
        Route::delete('/destroy', 'ReputationController@destroy')->name('admin.reputation.destroy');
        // 批量删除
        Route::delete('/destroys', 'ReputationController@destroys')->name('admin.reputation.destroys');
        // 修改状态
        Route::post('/status/all', 'ReputationController@statusAll')->name('admin.reputation.status.all');
        // 批量修改状态
        Route::post('/status', 'ReputationController@status')->name('admin.reputation.status');
        // 修改排序
        Route::post('/order', 'ReputationController@order')->name('admin.reputation.order');

        Route::post('/upload', 'ReputationController@postUpload')->name('admin.reputation.upload');

        Route::post('/crop', 'ReputationController@postCrop')->name('admin.reputation.crop');

    });

    /**
     * 评价管理
     */
    Route::group(['prefix' => '/assess'], function () {
        // 数据列表
        Route::get('/index', 'AssessController@index')->name('admin.assess.index');
        // 添加页面
        Route::get('/add', 'AssessController@add')->name('admin.assess.add');
        // 添加数据
        Route::post('/store', 'AssessController@store')->name('admin.assess.store');
        // 查询指定ID数据(id)
        Route::get('/edit', 'AssessController@edit')->name('admin.assess.edit');
        // 修改数据(id)
        Route::post('/update', 'AssessController@update')->name('admin.assess.update');
        // 删除数据(id)
        Route::delete('/destroy', 'AssessController@destroy')->name('admin.assess.destroy');
        // 批量删除
        Route::delete('/destroys', 'AssessController@destroys')->name('admin.assess.destroys');
        // 修改状态
        Route::post('/status/all', 'AssessController@statusAll')->name('admin.assess.status.all');
        // 批量修改状态
        Route::post('/status', 'AssessController@status')->name('admin.assess.status');
        // 修改排序
        Route::post('/order', 'AssessController@order')->name('admin.assess.order');

        Route::post('/upload', 'AssessController@postUpload')->name('admin.assess.upload');

        Route::post('/crop', 'AssessController@postCrop')->name('admin.assess.crop');

    });

    /**
     * 视频管理
     */
    Route::group(['prefix' => '/video'], function () {
        // 数据列表
        Route::get('/index', 'VideoController@index')->name('admin.video.index');
        // 添加页面
        Route::get('/add', 'VideoController@add')->name('admin.video.add');
        // 添加数据
        Route::post('/store', 'VideoController@store')->name('admin.video.store');
        // 查询指定ID数据(id)
        Route::get('/edit', 'VideoController@edit')->name('admin.video.edit');
        // 修改数据(id)
        Route::post('/update', 'VideoController@update')->name('admin.video.update');
        // 删除数据(id)
        Route::delete('/destroy', 'VideoController@destroy')->name('admin.video.destroy');
        // 批量删除
        Route::delete('/destroys', 'VideoController@destroys')->name('admin.video.destroys');
        // 修改状态
        Route::post('/status/all', 'VideoController@statusAll')->name('admin.video.status.all');
        // 批量修改状态
        Route::post('/status', 'VideoController@status')->name('admin.video.status');
        // 修改排序
        Route::post('/order', 'VideoController@order')->name('admin.video.order');

        Route::post('/upload', 'VideoController@postUpload')->name('admin.video.upload');

        Route::post('/crop', 'VideoController@postCrop')->name('admin.video.crop');

    });

    /**
     * 动图管理
     */
    Route::group(['prefix' => '/gif'], function () {
        // 数据列表
        Route::get('/index', 'GifController@index')->name('admin.gif.index');
        // 添加页面
        Route::get('/add', 'GifController@add')->name('admin.gif.add');
        // 添加数据
        Route::post('/store', 'GifController@store')->name('admin.gif.store');
        // 查询指定ID数据(id)
        Route::get('/edit', 'GifController@edit')->name('admin.gif.edit');
        // 修改数据(id)
        Route::post('/update', 'GifController@update')->name('admin.gif.update');
        // 删除数据(id)
        Route::delete('/destroy', 'GifController@destroy')->name('admin.gif.destroy');
        // 批量删除
        Route::delete('/destroys', 'GifController@destroys')->name('admin.gif.destroys');
        // 修改状态
        Route::post('/status/all', 'GifController@statusAll')->name('admin.gif.status.all');
        // 批量修改状态
        Route::post('/status', 'GifController@status')->name('admin.gif.status');
        // 修改排序
        Route::post('/order', 'GifController@order')->name('admin.gif.order');

        Route::post('/upload', 'GifController@postUpload')->name('admin.gif.upload');

        Route::post('/crop', 'GifController@postCrop')->name('admin.gif.crop');

    });

    Route::get('/role/index', 'RoleController@index')->name('admin.role.index');


});

