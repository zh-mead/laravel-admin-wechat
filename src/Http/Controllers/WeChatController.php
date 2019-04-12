<?php

namespace ZhMead\WeChat\Http\Controllers;

use ZhMead\Admin\Layout\Content;
use Illuminate\Routing\Controller;

class WeChatController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('Title')
            ->description('Description')
            ->body(view('wechat::index'));
    }
}