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


    Route::get('/role/index', 'RoleController@index')->name('admin.role.index');

});

