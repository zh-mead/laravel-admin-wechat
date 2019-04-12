<?php
/**
 * Created by PhpStorm.
 * User: Mead
 * Date: 2019/1/22
 * Time: 11:50 AM
 */

namespace ZhMead\WeChat\Events;

class Subscribe
{
    protected $message;
    protected $app;

    public function __construct($message)
    {
        $this->message = $message;
        $this->app = app('wechat.official_account');
    }

    public function getMessage($key = false)
    {
        if ($key !== false) return array_get($this->message, $key);
        return $this->message;
    }

    public function getUser()
    {
        return $this->app->user->get($this->getMessage('FromUserName'));
    }
}