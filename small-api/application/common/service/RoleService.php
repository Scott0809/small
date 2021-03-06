<?php

/*
 * Author: PunkVv <punkv@qq.com>
 */

namespace app\common\service;

use app\common\model\Role;
use app\common\model\RoleMenu;
use app\common\VService;

class RoleService extends VService
{

    public function getList($param)
    {
        $this->data = Role::getList($param);

        return $this->result();
    }

    public function createData($param)
    {
        $data = Role::create([
            'role_name' => $param['role_name'],
            'remark' => $param['remark'],
        ]);
        $this->data = $data;

        return $this->result();
    }

    public function updateData($param)
    {
        $data = Role::update([
            'id' => $param['id'],
            'role_name' => $param['role_name'],
            'remark' => $param['remark'],
        ]);
        $this->data = $data;

        return $this->result();
    }

    public function deleteData($id)
    {
        Role::get($id)->delete();

        return $this->result();
    }

    public function getMenuList($id)
    {
        $this->data = Role::getMenuList($id);

        return $this->result();
    }

    public function createMenu($param)
    {
        $roleId = $param['id'];
        $items = $param['items'];
        $list = [];
        foreach ($items as $item) {
            $list[] = [
                'menu_id' => $item,
                'role_id' => $roleId,
            ];
        }
        RoleMenu::where('role_id', $roleId)->delete();
        $adminRoleMenu = new RoleMenu;
        $adminRoleMenu->saveAll($list);

        return $this->result();
    }
}