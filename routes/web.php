<?php

use Encore\WeChat\Http\Controllers\WeChatController;

Route::get('/wechat', WeChatController::class . '@index');
Route::resource('/wechat/events', \Encore\WeChat\Http\Controllers\EventController::class);
Route::get('/wechat/menus/sync', \Encore\WeChat\Http\Controllers\MenuController::class . '@sync');
Route::resource('/wechat/menus', \Encore\WeChat\Http\Controllers\MenuController::class);
Route::resource('/wechat/fans', \Encore\WeChat\Http\Controllers\FanController::class);
