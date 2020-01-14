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

//登录
Route::prefix('login')->group(function(){
    Route::get('login','Admin\LoginController@login');  //登录首页

});



Route::prefix('admin')->group(function(){
    Route::any('wx','Admin\WxController@wx');  //微信
    Route::any('test','Admin\WeiController@test');  //微信网页授权
    Route::any('auth','Admin\WeiController@auth');  //微信网页授权回调
    Route::any('wei','Admin\WeiController@wei');//微信
    Route::any('freshToken','Admin\WeiController@freshToken');//获取最新access_token 并换缓存
    Route::any('createMenu','Admin\WeiController@createMenu');//创建菜单
    Route::any('sendall','Admin\WeiController@sendall');//消息群发
    Route::get('login','Admin\LoginController@login');  //登录首页
    Route::post('add','Admin\LoginController@add');  //登录执行页面

    Route::get('index','Admin\IndexController@index');    //后台首页
    Route::any('index_v1','Admin\IndexController@index_v1');    //后台首页

});


//素材
Route::prefix('media')->group(function(){
    Route::get('add','Admin\MediaController@add');  //素材添加页面
    Route::post('add_show','Admin\MediaController@add_show');  //素材添加页面
    Route::get('list','Admin\MediaController@list');  //素材管理--展示页面
});

//二维码添加渠道
Route::prefix('ticket')->group(function(){
    Route::get('add','Admin\TicketController@add');//添加展示
    Route::any('add_do','Admin\TicketController@add_do');//添加执行
    Route::get('list','Admin\TicketController@list');//渠道展示
    Route::get('chart','Admin\TicketController@chart');//图表展示页

});


//新闻
Route::prefix('new')->group(function(){
    Route::get('index','News\NewsController@index');//新闻添加页面
    Route::post('add','News\NewsController@add');//新闻添加执行操作
    Route::get('list','News\NewsController@list');//新闻展示列表
    Route::get('delete/{id}','News\NewsController@delete');//新闻展示列表
});




