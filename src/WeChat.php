<?php

namespace ZhMead\WeChat;

use Encore\Admin\Extension;
use Illuminate\Support\Facades\DB;

class WeChat extends Extension
{
    public $name = 'wechat';

    public $views = __DIR__ . '/../resources/views';

    public $assets = __DIR__ . '/../public';

    public $menu = [
        'title' => 'Wechat',
        'path' => 'wechat',
        'icon' => 'fa-gears',
    ];

    public static function import()
    {



        if (!DB::table('admin_menu')->where('title', '微信公众号管理')->count('id')) {
            parent::createMenu('微信公众号管理', '/wechat/fans', 'fa-weixin', 0);
            $pid = DB::table('admin_menu')->where('title', '微信公众号管理')->value('id');

            parent::createMenu('粉丝管理', '/wechat/fans', 'fa-users', $pid);
            parent::createMenu('自定义菜单', '/wechat/menus', 'fa-bars', $pid);
            parent::createMenu('自定义事件', '/wechat/events', 'fa-bolt', $pid);
//            parent::createMenu('素材中心', '/wechat/sources', 'fa-archive', $pid);
        }
    }
}