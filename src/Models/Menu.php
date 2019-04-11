<?php
/**
 * Created by PhpStorm.
 * User: Mead
 * Date: 2019/1/21
 * Time: 8:09 PM
 */

namespace Encore\WeChat\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'wechat_menus';

    protected $guarded = [];

    const TYPE_CLICK = 'click';
    const TYPE_VIEW = 'view';
    const VIEW_LIMITED = 'view_limited';
    public static $typeMaps = [
        self::TYPE_CLICK => '点击',
        self::TYPE_VIEW => '跳转连接',
        self::VIEW_LIMITED => '图文信息',
    ];
}