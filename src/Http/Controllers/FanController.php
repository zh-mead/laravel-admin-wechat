<?php
/**
 * Created by PhpStorm.
 * User: Mead
 * Date: 2019/1/21
 * Time: 8:23 PM
 */

namespace ZhMead\WeChat\Http\Controllers;

use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use ZhMead\WeChat\Models\Event;
use ZhMead\WeChat\Models\Fan;
use Illuminate\Routing\Controller;

class FanController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content->header('粉丝管理')
            ->description('列表')
            ->body($this->grid());
    }

    public function create(Content $content)
    {
        return $content
            ->header('粉丝管理')
            ->description('创建')
            ->body($this->form());
    }

    public function grid()
    {
        $grid = new Grid(new Fan);
        $grid->id('编号');
        $grid->avatar('头像')->image(30, 30);
        $grid->openid('openid');
        $grid->nickname('昵称');
        $grid->name('姓名');
        $grid->sex('性别')->using(Fan::$sexMap);
        $grid->province('省份');
        $grid->city('城市');

        $grid->disableExport();
        $grid->disableCreateButton();

        return $grid;
    }

    public function form()
    {
        $form = new Form(new Fan);

        $form->display('id', 'ID');

        $form->text('name', '事件名称');
        $form->text('key', '事件标识');
        $form->select('type', '事件类型')->options(Event::$eventMap);
        $form->select('reply_type', '回复类型')->options(Event::$replayTypeMap);
        $form->textarea('body', '事件内容');
        $form->radio('body','编辑')->options(Event::$eventMap);

        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');

        $form->disableCreatingCheck();
        $form->disableEditingCheck();
        $form->disableViewCheck();

        return $form;
    }
}