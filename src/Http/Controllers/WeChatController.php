<?php

namespace Encore\WeChat\Http\Controllers;

use Encore\Admin\Layout\Content;
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