<?php
/**
 * Created by PhpStorm.
 * User: Mead
 * Date: 2019/1/21
 * Time: 8:23 PM
 */

namespace ZhMead\WeChat\Http\Controllers;

use ZhMead\Admin\Controllers\HasResourceActions;
use ZhMead\Admin\Form;
use ZhMead\Admin\Grid;
use ZhMead\Admin\Layout\Content;
use ZhMead\WeChat\Models\Event;
use Illuminate\Routing\Controller;

class EventController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content->header('自定义事件管理')
            ->description('列表')
            ->body($this->grid());
    }

    public function create(Content $content)
    {
        return $content
            ->header('自定义事件管理')
            ->description('创建')
            ->body($this->form());
    }

    public function grid()
    {
        $grid = new Grid(new Event);
        $grid->id('编号');
        $grid->name('名称');
        $grid->key('事件标识');
        $grid->type('事件类型')->using(Event::$eventMap)->label('success');
        $grid->reply_type('消息类型')->using(Event::$replayTypeMap)->label('warning');
        $grid->body('消息内容');

        $grid->disableExport();

        return $grid;
    }

    public function form()
    {
        $form = new Form(new Event);

        $form->display('id', 'ID');

        $form->text('name', '事件名称');
        $form->text('key', '事件标识');
        $form->select('type', '事件类型')->options(Event::$eventMap);
        $form->select('reply_type', '回复类型')->options(Event::$replayTypeMap);
        $form->textarea('body', '事件内容');

        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');

        $form->disableCreatingCheck();
        $form->disableEditingCheck();
        $form->disableViewCheck();

        return $form;
    }
}