<?php
/**
 * Created by PhpStorm.
 * User: Leafqun
 * Date: 2017/9/4
 * Time: 14:01
 */

namespace app\index\controller;


use think\Db;
use think\Request;

class ManagementController
{
    public function getManagement(Request $request){
        header('Access-Control-Allow-Origin:*');
        $management = Db::table('management')->where('mId', 1)->find();
        return array('management' => $management);
    }

    public function updateManagement(Request $request){
        header('Access-Control-Allow-Origin:*');
        Db::table('management')->where('mId', 1)->update($request->param());
        return array('msg' => 'success');
    }
}