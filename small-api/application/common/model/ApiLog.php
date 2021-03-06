<?php

/*
 * Author: PunkVv <punkv@qq.com>
 */

namespace app\common\model;

use app\common\VModel;
use think\Db;

class ApiLog extends VModel
{

    public static function getList($param)
    {
        $query = Db::view('ApiLog', 'id,create_time,router,router_name,params,method,ip')
            ->view('AdminUser', 'username', 'ApiLog.admin_id=AdminUser.id')
            ->where('ApiLog.is_del', 1)
            ->order('ApiLog.id', 'desc');
        if (!empty($param['username'])) {
            $query->whereLike('AdminUser.username', "%{$param['username']}%");
        }
        if (!empty($param['create_time']) && count($param['create_time']) == 2) {
            $query->whereBetween('ApiLog.create_time',
                [strtotime($param['create_time'][0]), strtotime($param['create_time'][1]) + 86400]);
        }

        return static::queryPaginate($query, $param);
    }

    public static function addData($adminId, $router, $routerName, $params, $methods)
    {
        unset($params['v_log']);
        unset($params['v_name']);
        unset($params['v_check']);
        unset($params['v_validate_class']);
        unset($params['v_validate_scene']);
        $ip = request()->ip();
        $data = static::create([
            'create_time' => time(),
            'router' => $router,
            'admin_id' => $adminId,
            'router_name' => $routerName,
            'params' => json_encode($params, JSON_UNESCAPED_UNICODE),
            'method' => $methods,
            'ip' => $ip,
        ]);

        return $data;
    }
}