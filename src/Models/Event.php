<?php
/**
 * Created by PhpStorm.
 * User: Mead
 * Date: 2019/1/21
 * Time: 8:10 PM
 */

namespace ZhMead\WeChat\Models;

use ZhMead\Admin\Form\Field\Select;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'wechat_events';

    const MENU_EVENTS = [
        'CLICK', // 点击
        'VIEW', // 链接
//        'scancode_push', // 扫码推
//        'scancode_waitmsg', // 扫码推带提示信息
//        'pic_sysphoto', // 系统拍照
//        'pic_photo_or_album', // 拍照或相册
//        'pic_weixin', // 相册
//        'location_select', // 位置选择
    ];

    const EVENT_SUBSCRIBE = 'subscribe';
    const EVENT_UNSUBSCRIBE = 'unsubscribe';

    public static $eventMap = [
        self::EVENT_SUBSCRIBE => '关注事件',
        self::EVENT_UNSUBSCRIBE => '取消关注事件',
    ];

    // 订阅和取消订阅的 MsgType 为 event，单独处理一下
    // 其他则直接用 MsgType 判断
    const SUBSCRIBE_EVENTS = [
        'subscribe',
        'unsubscribe',
    ];

    const REPLAY_TEXT = 'text';
    const REPLAY_NEWS = 'news';
    const REPLAY_IMAGE = 'image';
    const REPLAY_VIDEO = 'video';
    const REPLAY_VOICE = 'voice';
    const REPLAY_MUSIC = 'music';
    public static $replayTypeMap = [
        self::REPLAY_TEXT => '文本',
//        self::REPLAY_NEWS => '图文',
//        self::REPLAY_IMAGE => '图片',
//        self::REPLAY_VIDEO => '视频',
//        self::REPLAY_VOICE => '语音',
//        self::REPLAY_MUSIC => '音乐'
    ];
    /**
     * 自动回复类型.
     */
    const AUTO_REPLY_TYPES = [
        'text',
        'news',
        'image',
        'video',
        'voice',
    ];
}