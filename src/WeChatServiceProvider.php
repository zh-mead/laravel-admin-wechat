<?php

namespace Encore\WeChat;

use Encore\Admin\Facades\Admin;
use Encore\WeChat\Database\WeChatTablesSeeder;
use Encore\WeChat\Http\Controllers\WeChatServerController;
use Illuminate\Support\ServiceProvider;

class WeChatServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(WeChat $extension)
    {
        if (!WeChat::boot()) {
            return;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'laravel-admin-wechat');
        }

        if ($this->app->runningInConsole()) {
            if ($assets = $extension->assets()) {
                $this->publishes([$assets => public_path('vendor/laravel-admin-ext/wechat')], 'laravel-admin-wechat');
            }
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        }

        $this->app->booted(function () {
            WeChat::routes(__DIR__ . '/../routes/web.php');
            Admin::css('/vendor/laravel-admin-ext/wechat/wechat.css');
        });


        // 设置前台路由
        $this->app['router']->any('/wechat', WeChatServerController::class . '@serve');
    }
}