<?php

/**
 * Created by PhpStorm.
 * User: Mead
 * Date: 2019/1/21
 * Time: 6:23 PM
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeChatTables extends Migration
{
    public function up()
    {
        $prefix = config('admin-wechat.database.prefix', 'wechat');
        // 创建微信粉丝表
        Schema::create("{$prefix}_fans", function (Blueprint $table) {
            $table->increments('id');
            $table->string('openid', 100)->unique()->comment('openid');
            $table->string('nickname')->comment('昵称');
            $table->string('name')->comment('姓名');
            $table->string('signature', 300)->nullable()->comment('签名');
            $table->tinyInteger('sex')->default(0)->comment('性别');
            $table->string('province')->comment('省份');
            $table->string('city')->comment('城市');
            $table->string('country')->comment('国家');
            $table->string('avatar')->comment('头像');
            $table->string('email')->nullable()->unique()->comment('邮箱');
            $table->text('remark')->nullable()->comment('备注');
            $table->string('language', 300)->comment('语言');

            $table->string('app_id')->nullable()->comment('所属公众号');
            $table->string('unionid', 100)->nullable()->unique()->comment('unionid');
            $table->string('group_id')->nullable()->comment('粉丝组group_id');
            $table->string('api_token', 64)->comment('api_token');

            $table->string('tagid_list')->nullable()->comment('标签ID列表');
            $table->string('subscribe_scene')->nullable()->comment('用户关注的渠道来源');
            $table->string('qr_scene')->nullable()->comment('二维码扫码场景');
            $table->string('qr_scene_str')->nullable()->comment('二维码扫码场景描述');

            $table->string('liveness')->nullable()->comment('用户活跃度');
            $table->timestamp('subscribed_at')->nullable()->comment('关注时间');
            $table->string('is_subscribe', 8)->default('F')->comment('是否关注');
            $table->tinyInteger('status')->default(1)->comment('状态');

            $table->rememberToken();
            $table->timestamps();
        });

        // 创建自定义菜单
        Schema::create("{$prefix}_menus", function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->comment('菜单名');
            $table->string('type')->default('view')->comment('菜单类型');
            $table->text('data')->nullable()->comment('数据');
            $table->integer('order')->default(0);
            $table->integer('pid')->default(0);
            $table->integer('gid')->default(0)->comment('用户组id');

            $table->tinyInteger('status')->default(1);

            $table->timestamps();
        });

        // 创建事件列表
        Schema::create("{$prefix}_events", function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->comment('名称');
            $table->string('type', 20)->comment('事件类型');
            $table->string('key')->comment('事件标识');
            $table->string('reply_type', 20)->comment('回复类型');
            $table->text('body')->comment('内容');

            $table->tinyInteger('status')->default(1);

            $table->timestamps();
        });

        // 创建资源表
        Schema::create("{$prefix}_sources", function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->comment('名称');
            $table->tinyInteger('type')->default(0)->comment('资源类型');
            $table->text('body')->comment('内容');

            $table->tinyInteger('status')->default(1);

            $table->timestamps();
        });
    }

    public function down()
    {
        $prefix = config('admin-wechat.database.prefix', 'wechat');
        Schema::dropIfExists("{$prefix}_fans");
        Schema::dropIfExists("{$prefix}_menus");
        Schema::dropIfExists("{$prefix}_events");
        Schema::dropIfExists("{$prefix}_sources");
    }
}