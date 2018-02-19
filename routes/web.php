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
    // 菜单列表
    Route::get('/category/index', 'CategoryController@index')->name('admin.category.index');
    // 添加数据
    Route::post('/category/store', 'CategoryController@store')->name('admin.category.store');
    // 查询指定ID数据(id)
    Route::get('/category/edit', 'CategoryController@edit')->name('admin.category.edit');
    // 修改数据(id)
    Route::post('/category/update', 'CategoryController@update')->name('admin.category.update');
    // 删除数据(id)
    Route::delete('/category/destroy', 'CategoryController@destroy')->name('admin.category.destroy');
    // 修改状态
    Route::post('/category/status', 'CategoryController@status')->name('admin.category.status');
    // 修改排序
    Route::post('/category/order', 'CategoryController@order')->name('admin.category.order');

    /**
     * 产品组管理
     */
    // 数据列表
    Route::get('/product/group/index', 'ProductGroupController@index')->name('admin.product.group.index');
    // 添加数据
    Route::post('/product/group/store', 'ProductGroupController@store')->name('admin.product.group.store');
    // 查询指定ID数据(id)
    Route::get('/product/group/edit', 'ProductGroupController@edit')->name('admin.product.group.edit');
    // 修改数据(id)
    Route::post('/product/group/update', 'ProductGroupController@update')->name('admin.product.group.update');
    // 删除数据(id)
    Route::delete('/product/group/destroy', 'ProductGroupController@destroy')->name('admin.product.group.destroy');
    // 批量删除
    Route::delete('/product/group/destroys', 'ProductGroupController@destroys')->name('admin.product.group.destroys');
    // 修改状态
    Route::post('/product/group/status', 'ProductGroupController@status')->name('admin.product.group.status');
    // 修改排序
    Route::post('/product/group/order', 'ProductGroupController@order')->name('admin.product.group.order');

    /**
     * 产品规格分类
     */
    // 数据列表
    Route::get('/specifications/category/index', 'SpecificationsCategoryController@index')->name('admin.specifications.category.index');
    // 添加数据
    Route::post('/specifications/category/store', 'SpecificationsCategoryController@store')->name('admin.specifications.category.store');
    // 查询指定ID数据(id)
    Route::get('/specifications/category/edit', 'SpecificationsCategoryController@edit')->name('admin.specifications.category.edit');
    // 修改数据(id)
    Route::post('/specifications/category/update', 'SpecificationsCategoryController@update')->name('admin.specifications.category.update');
    // 删除数据(id)
    Route::delete('/specifications/category/destroy', 'SpecificationsCategoryController@destroy')->name('admin.specifications.category.destroy');
    // 批量删除
    Route::delete('/specifications/category/destroys', 'SpecificationsCategoryController@destroys')->name('admin.specifications.category.destroys');
    // 修改状态
    Route::post('/specifications/category/status', 'SpecificationsCategoryController@status')->name('admin.specifications.category.status');
    // 修改排序
    Route::post('/specifications/category/order', 'SpecificationsCategoryController@order')->name('admin.specifications.category.order');

    /**
     * 产品规格
     */
    // 数据列表
    Route::get('/specifications/index', 'SpecificationsController@index')->name('admin.specifications.index');
    // 添加数据
    Route::post('/specifications/store', 'SpecificationsController@store')->name('admin.specifications.store');
    // 查询指定ID数据(id)
    Route::get('/specifications/edit', 'SpecificationsController@edit')->name('admin.specifications.edit');
    // 修改数据(id)
    Route::post('/specifications/update', 'SpecificationsController@update')->name('admin.specifications.update');
    // 删除数据(id)
    Route::delete('/specifications/destroy', 'SpecificationsController@destroy')->name('admin.specifications.destroy');
    // 批量删除
    Route::delete('/specifications/destroys', 'SpecificationsController@destroys')->name('admin.specifications.destroys');
    // 修改状态
    Route::post('/specifications/status', 'SpecificationsController@status')->name('admin.specifications.status');
    // 修改排序
    Route::post('/specifications/order', 'SpecificationsController@order')->name('admin.specifications.order');



    Route::get('/role/index', 'RoleController@index')->name('admin.role.index');

});
