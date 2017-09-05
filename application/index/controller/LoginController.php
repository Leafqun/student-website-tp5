<?php
/**
 * Created by PhpStorm.
 * User: Leafqun
 * Date: 2017/9/4
 * Time: 13:39
 */

namespace app\index\controller;


use think\Db;
use think\Request;

class LoginController
{
    public function login(Request $request){
        header('Access-Control-Allow-Origin:*');
        $userName = $request->param('userName');
        $userPwd = $request->param('userPwd');
        $user = Db::table('user')->where('userName', $userName)->find();
        if($user){
            if($userPwd === $user['userPwd']){
                return array('msg' => 'success');
            }else{
                return array('msg' => '密码错误');
            }
        }else{
            return array('msg' => '用户名不存在');
        }
    }
}