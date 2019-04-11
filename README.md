# Laravel-admin-wechat 安装手册

## 简介
> 测试版本为：laravel5.5 + laravel-admin1.6

## 步骤

* 下载安装包，复制目录到 app/Admin/Extensions/laravel-admin-ext/wechat

* 配置 composer.json

~~~
"repositories": [
    {
        "type": "path",
        "url": "app/Admin/Extensions/laravel-admin-ext/wechat"
    }
]
~~~ 

* 安装 Wechat 依赖

~~~bash
$ composer require laravel-admin-ext/wechat
~~~

* 发布静态资源

~~~bash
$ php artisan vendor:publish --tag=laravel-admin-wechat
~~~

* 创建数据库

~~~bash
$ php artisan migrate
~~~

* 导入菜单

~~~bash
$ php artisan admin:import wechat
~~~

* 安装完成

## 微信网页授权用法

* 添加中间件

~~~php
protected $routeMiddleware = [
	......
   'wechat.auth' => Encore\WeChat\Middleware\WeChatAuthenticate::class,
];
~~~

* 配置 Auth.php

~~~php
....
'guards' => [
	......
	'wechat' => [
		'driver' => 'session',
		'provider' => 'fans',
	],
],
....
'providers' => [
	.....
	'fans' => [
		'driver' => 'eloquent',
		'model' => \Encore\WeChat\Models\Fan::class,
	],
],
~~~

* 路由 web.php

~~~php
Route::group(['middleware' => ['web', 'wechat.auth']], function () {
	//这里写需要微信网页授权的路由
});
~~~

* 获取登录用户

~~~php
use Illuminate\Support\Facades\Auth;
.....
Auth::guard('wechat')->user()//获取用户信息
~~~




