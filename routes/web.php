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
    Route::group(['prefix' => '/total/warehouse'], function () {
        // 数据列表
        Route::get('/index', 'TotalWarehouseController@index')->name('admin.total.warehouse.index');
        // 添加数据
        Route::post('/store', 'TotalWarehouseController@store')->name('admin.total.warehouse.store');
        // 查询指定ID数据(id)
        Route::get('/edit', 'TotalWarehouseController@edit')->name('admin.total.warehouse.edit');
        // 修改数据(id)
        Route::post('/update', 'TotalWarehouseController@update')->name('admin.total.warehouse.update');
        // 删除数据(id)
        Route::delete('/destroy', 'TotalWarehouseController@destroy')->name('admin.total.warehouse.destroy');
        // 批量删除
        Route::delete('/destroys', 'TotalWarehouseController@destroys')->name('admin.total.warehouse.destroys');
        // 修改状态
        Route::post('/status', 'TotalWarehouseController@status')->name('admin.total.warehouse.status');
        // 修改排序
        Route::post('/order', 'TotalWarehouseController@order')->name('admin.total.warehouse.order');

    });


    Route::get('/role/index', 'RoleController@index')->name('admin.role.index');
});
