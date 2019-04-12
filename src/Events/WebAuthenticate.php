<?php
/**
 * Created by PhpStorm.
 * User: Mead
 * Date: 2019/1/22
 * Time: 11:50 AM
 */

namespace ZhMead\WeChat\Events;

class WebAuthenticate
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user->getOriginal();
    }
}