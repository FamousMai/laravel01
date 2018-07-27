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

// 首页
Route::get('/', 'StaticPagesController@home')->name('home');
// 帮助
Route::get('/help', 'StaticPagesController@help')->name('help');
// 关于我们
Route::get('/about', 'StaticPagesController@help')->name('about');

// 注册
Route::get('signup', 'UsersController@create')->name('signup');
// 用户路由资源
Route::resource('users', 'UsersController');
// 上述代码等同于以下代码
//Route::get('/users', 'UsersController@index')->name('users.index');
//Route::get('/users/{user}', 'UsersController@show')->name('users.show');
//Route::get('/users/create', 'UsersController@create')->name('users.create');
//Route::post('/users', 'UsersController@store')->name('users.store');
//Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
//Route::patch('/users/{user}', 'UsersController@update')->name('users.update');
//Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy');

// 显示登录页面
Route::get('login', 'SessionsController@create')->name('login');
// 创建新会话（登录）
Route::post('login', 'SessionsController@store')->name('login');
// 销毁会话（退出登录）
Route::delete('logout', 'SessionsController@destroy')->name('logout');

// 注册邮件
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');
