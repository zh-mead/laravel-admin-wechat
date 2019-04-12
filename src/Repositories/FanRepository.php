<?php
/**
 * Created by PhpStorm.
 * User: Mead
 * Date: 2019/1/22
 * Time: 2:00 PM
 */

namespace ZhMead\WeChat\Repositories;

use ZhMead\WeChat\Models\Fan;

class FanRepository
{
    protected $fan;

    public function __construct()
    {
        $this->fan = (new Fan());
    }

    public function register($user)
    {
        if ($info = $this->byOpenId($user['openid'])) {
            // 存在
            $info->is_subscribe = 'T';
            $info->fillable([
                'app_id' => null,
                'nickname' => $user['nickname'],
                'sex' => $user['sex'],
                'city' => $user['city'],
                'country' => $user['country'],
                'province' => $user['province'],
                'language' => $user['language'],
                'avatar' => $user['headimgurl'],
                'subscribed_at' => date('Y-m-d H:i:s', array_get($user, 'subscribe_time', time())),
                'unionid' => array_get($user, 'unionid', null),
                'remark' => array_get($user, 'remark'),
                'group_id' => array_get($user, 'groupid'),
                'tagid_list' => array_get($user, 'tagid_list', []),
                'subscribe_scene' => array_get($user, 'subscribe_scene'),
            ]);
            $info->save();
            return $info;
        }
        // 不存在
        return $this->fan->create([
            'openid' => $user['openid'],
            'app_id' => null,
            'nickname' => $user['nickname'],
            'name' => $user['nickname'],
            'sex' => $user['sex'],
            'city' => $user['city'],
            'country' => $user['country'],
            'province' => $user['province'],
            'language' => $user['language'],
            'avatar' => $user['headimgurl'],
            'subscribed_at' => date('Y-m-d H:i:s', array_get($user, 'subscribe_time', time())),
            'unionid' => array_get($user, 'unionid', null),
            'remark' => array_get($user, 'remark'),
            'group_id' => array_get($user, 'groupid'),
            'tagid_list' => array_get($user, 'tagid_list', []),
            'subscribe_scene' => array_get($user, 'subscribe_scene'),
            'is_subscribe' => 'T',
            'api_token' => str_random(60)
        ]);
    }

    public function byOpenId($openid, $type = "openid")
    {
        return $this->fan->where($type, $openid)->first();
    }

    public function isExists($openid)
    {
        return $this->fan->where('openid', $openid)->exists();
    }
}