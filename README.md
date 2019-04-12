# Laravel-admin-wechat 安装手册

## 简介
> 测试版本为：laravel5.5 + laravel-admin1.6 **（安装前请先安装好 laravel-admin）**

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

* 安装 Wechat 扩展包

~~~bash
$ composer require laravel-admin-ext/wechat
~~~

* 发布静态资源

~~~bash
$ php artisan vendor:publish --tag=laravel-admin-wechat
~~~

* 创建数据表

~~~bash
$ php artisan migrate
~~~

* 添加菜单

~~~bash
$ php artisan admin:import wechat
~~~

* 安装完成，配置 env 文件

~~~
.....
WECHAT_DEBUG = false //线下配置，上线的话请配置
~~~



## 微信网页授权用法

* 添加中间件 Kernel.php

~~~php
// app/Http/Kernel.php
protected $routeMiddleware = [
	......
   'wechat.auth' => Encore\WeChat\Middleware\WeChatAuthenticate::class,
];
~~~

* 配置 config下的 auth.php 文件

~~~php
....
// config/auth.php
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

* 配置注册事件

~~~php
// app/Providers/EventServiceProvider.php
use Encore\WeChat\Events\Subscribe;
use Encore\WeChat\Events\WebAuthenticate;
use Encore\WeChat\Listeners\RegisterWeChatFan;
......
protected $listen = [
	.....
	Subscribe::class => [
		RegisterWeChatFan::class
	],
	WebAuthenticate::class => [
		RegisterWeChatFan::class
	],
	.....
];
~~~

* 路由的使用 web.php

~~~php
// routes/web.php
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

