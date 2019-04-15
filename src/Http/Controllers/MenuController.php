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
use Encore\Admin\Layout\Row;
use ZhMead\WeChat\Models\Event;
use ZhMead\WeChat\Models\Menu;
use ZhMead\WeChat\Services\MenuService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;

class MenuController extends Controller
{
    use HasResourceActions;

    public function index(Content $content, MenuService $menuService)
    {
        $menus = $menuService->menu();
        $events = Event::pluck('name', 'key')->toArray();
        $news = [];
        if (env('WECHAT_DEBUG', true)) {
            $lists = app('wechat.official_account')->material->list('news');
            $news = [];
            foreach ($lists['item'] as $list) {
                $news[] = [
                    'media_id' => $list['media_id'],
                    'name' => $list['content']['news_item'][0]['title'],
                ];
            }
        }

        $types = Menu::$typeMaps;

        return $content->header('自定义菜单管理')
            ->description('列表')
            ->body(view('laravel-admin-wechat::index', compact('menus', 'events', 'types', 'news'))->render());
    }

    public function store(Request $request)
    {
        $id = $request->get('id', false);
        $data = $request->get('type') === 'view' ? $request->get('data') : $request->get('key');
        if ($id) {
            Menu::where('id', $id)->update([
                'name' => $request->get('name'),
                'type' => $request->get('type'),
                'data' => $data
            ]);
        } else {
            Menu::create([
                'name' => $request->get('name'),
                'type' => $request->get('type'),
                'pid' => $request->get('pid', 0),
                'data' => $data
            ]);
        }

        admin_toastr('保存成功', 'success', ['timeOut' => 5000]);
        return back();
    }

    public function show(Menu $menu)
    {
        $menu->delete();
        admin_toastr('删除成功', 'success', ['timeOut' => 5000]);
        return back();
    }

    public function create(Content $content)
    {
        return $content
            ->header('自定义菜单管理')
            ->description('创建')
            ->body($this->form());
    }

    public function grid()
    {
        $grid = new Grid(new Menu);
        $grid->id('编号');
        $grid->name('菜单名');
        $grid->type('类型')->using(Menu::$typeMaps);
        $grid->data('内容');

        $grid->disableExport();

        return $grid;
    }

    public function form()
    {
        $form = new Form(new Menu);

        $form->display('id', 'ID');

        $form->select('pid', trans('admin.parent_id'))->options(array_prepend(Menu::where('pid', 0)->pluck('name', 'id')->toArray(), 'ROOT', 0))->default(0);
        $form->text('name', '菜单名')->rules('required');
        $form->radio('type', '类型')->options(Menu::$typeMaps);
        $form->text('data', '值');

        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');

        $form->disableCreatingCheck();
        $form->disableEditingCheck();
        $form->disableViewCheck();

        return $form;
    }

    public function sync(MenuService $menuService)
    {
        if (env('WECHAT_DEBUG', true)) {
            $re = $menuService->sync();
            if ($re) {
                admin_toastr('菜单发布成功！');
            } else {
                admin_toastr('菜单发布失败！', 'fail');
            }
        } else {
            admin_toastr('本地测试不能同步！', 'fail');
        }

        return app('redirect')->to('/admin/wechat/menus');
    }
}