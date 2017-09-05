<?php
/**
 * Created by PhpStorm.
 * User: Leafqun
 * Date: 2017/9/4
 * Time: 13:48
 */

namespace app\index\controller;


use think\Db;
use think\Request;

class FacultyController
{
    public function getFaculty(Request $request){
        header('Access-Control-Allow-Origin:*');
        $faculty = Db::table('faculty')->where('facultyId', 1)->find();
        return array('faculty' => $faculty);
    }
    public function updateFaculty(Request $request){
        header('Access-Control-Allow-Origin:*');
        Db::table('faculty')->where('facultyId', 1)->update($request->param());
        return array('msg' => 'success');
    }
}