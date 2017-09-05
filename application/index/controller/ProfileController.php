<?php
/**
 * Created by PhpStorm.
 * User: Leafqun
 * Date: 2017/9/4
 * Time: 13:56
 */

namespace app\index\controller;


use think\Db;
use think\Request;

class ProfileController
{
    public function getProfile(Request $request){
        header('Access-Control-Allow-Origin:*');
        $profile = Db::table('profile')->where('profileId', 1)->find();
        return array('profile' => $profile);
    }
    public function updateProfile(Request $request){
        header('Access-Control-Allow-Origin:*');
        Db::table('profile')->where('profileId', 1)->update($request->param());
        return array('msg' => 'success');
    }
}