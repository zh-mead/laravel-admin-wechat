<?php
/**
 * Created by PhpStorm.
 * User: Mead
 * Date: 2019/1/21
 * Time: 8:07 PM
 */

namespace ZhMead\WeChat\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Fan extends Authenticatable
{
    protected $table = 'wechat_fans';
    protected $guarded = [];

    const SEX_NO = 0;
    const SEX_MAN = 1;
    const SEX_MEN = 2;
    public static $sexMap = [
        self::SEX_NO => '未知',
        self::SEX_MAN => '男',
        self::SEX_MEN => '女'
    ];

    public function setTagidListAttribute($val)
    {
        return serialize($val);
    }
}