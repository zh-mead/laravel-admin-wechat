<?php

use ZhMead\WeChat\Http\Controllers\WeChatController;

Route::get('/wechat', WeChatController::class . '@index');
Route::resource('/wechat/events', \ZhMead\WeChat\Http\Controllers\EventController::class);
Route::get('/wechat/menus/sync', \ZhMead\WeChat\Http\Controllers\MenuController::class . '@sync');
Route::resource('/wechat/menus', \ZhMead\WeChat\Http\Controllers\MenuController::class);
Route::resource('/wechat/fans', \ZhMead\WeChat\Http\Controllers\FanController::class);
