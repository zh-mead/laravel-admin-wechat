<?php
/**
 *
 */

namespace ZhMead\WeChat\Services;

class Service
{
    public function re($re)
    {
        if (isset($re['errcode']) && $re['errcode'] == 0) {
            return true;
        }
        return false;
    }
}