<?php

namespace Encore\WeChat\Http\Controllers;

use Encore\WeChat\Events\Subscribe;
use Encore\WeChat\Models\Event;
use Illuminate\Routing\Controller;

class WeChatServerController extends Controller
{
    public function serve()
    {
        $app = app('wechat.official_account');
        $app->server->push(function ($message) use ($app) {
            switch (array_get($message, 'MsgType', '')) {
                case 'event':
                    return $this->event($message);
                    break;
                case 'text':
                    return '收到文本消息';
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                case 'file':
                    return '收到文件消息';
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
        });
        return $app->server->serve();
    }

    public function reply($type, $key = false)
    {
        list('reply_type' => $reply_type, 'body' => $body) = Event::where('type', $type)->orderBy('id', 'desc')->select('reply_type', 'body')->first();

        switch ($reply_type) {
            case Event::REPLAY_TEXT:
                return $this->reply_text($body);
                break;
        }
    }

    public function reply_text($value)
    {
        return $value;
    }

    public function event($message)
    {
        $event = $message['Event'];
        switch ($event) {
            case Event::EVENT_SUBSCRIBE:
                event(new Subscribe($message));
                return $this->reply(Event::EVENT_SUBSCRIBE);
                break;
            case Event::EVENT_UNSUBSCRIBE:
                return $this->reply(Event::EVENT_SUBSCRIBE);
                break;
        }
    }
}