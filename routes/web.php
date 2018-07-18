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
