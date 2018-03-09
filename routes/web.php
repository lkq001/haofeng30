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
    Route::group(['prefix' => 'admin/member/group'], function () {
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


    Route::get('/role/index', 'RoleController@index')->name('admin.role.index');

});

