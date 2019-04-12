<?php
/**
 * Created by PhpStorm.
 * User: Mead
 * Date: 2019/1/22
 * Time: 11:43 AM
 */

namespace Encore\WeChat\Listeners;

use Encore\WeChat\Events\WebAuthenticate;
use Encore\WeChat\Repositories\FanRepository;
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