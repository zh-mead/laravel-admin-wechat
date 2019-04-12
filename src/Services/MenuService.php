<?php
/**
 * Created by PhpStorm.
 * User: Mead
 * Date: 2019/1/22
 * Time: 10:31 AM
 */

namespace ZhMead\WeChat\Services;

use ZhMead\WeChat\Models\Menu;

class MenuService extends Service
{
    private $menu;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    public function menu()
    {
        $buttons = [];
        $menus = $this->menu->get();
        foreach ($menus as $menu) {
            if ($menu->pid) {
                $subButton = [
                    'type' => $menu->type,
                    'name' => $menu->name,
                    'kid' => $menu->id,
                    'data' => $menu->data,
                    'media_id' => $menu->data
                ];
                if ($menu->type == 'view') {
                    $subButton['url'] = $menu->key;
                } elseif ($menu->type == 'click') {
                    $subButton['key'] = $menu->key;
                }
                if (!isset($buttons[$menu->pid])) {
                    $buttons[$menu->pid] = [];
                }
                if (!isset($buttons[$menu->pid]['sub_button'])) {
                    $buttons[$menu->pid]['sub_button'] = [];
                }

                $buttons[$menu->pid]['sub_button'][] = $subButton;

            } else {
                $buttons[$menu->id] = [
                    'type' => $menu->type,
                    'name' => $menu->name,
                ];
                if ($menu->type == 'view') {
                    $buttons[$menu->id]['url'] = $menu->data;
                } elseif ($menu->type === Menu::VIEW_LIMITED) {
                    $buttons[$menu->id]['media_id'] = $menu->data;
                } elseif ($menu->type == 'click') {
                    $buttons[$menu->id]['key'] = $menu->data;
                }
                $buttons[$menu->id]['data'] = $menu->data;
                $buttons[$menu->id]['kid'] = $menu->id;
                $buttons[$menu->id]['sub_button'] = [];
            }
        }
        return array_values($buttons);
    }

    public function sync($ids = NULL)
    {
        $app = app('wechat.official_account');
        try {
            $buttons = $this->menu();
            $result = $app->menu->create($buttons);
            return $this->re($result);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}