<?php
/**
 * Created by PhpStorm.
 * User: Mead
 * Date: 2019/1/22
 * Time: 11:43 AM
 */

namespace ZhMead\WeChat\Listeners;

use ZhMead\WeChat\Events\WebAuthenticate;
use ZhMead\WeChat\Repositories\FanRepository;
use Illuminate\Support\Facades\Auth;

class RegisterWeChatFan
{
    public function handle($event)
    {
        $user = (new FanRepository())->register($event->getUser());

        if (get_class($event) === WebAuthenticate::class) {
            Auth::guard('wechat')->loginUsingId($user->id);
        }
        return $user;
    }
}