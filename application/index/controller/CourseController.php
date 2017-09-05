<?php
/**
 * Created by PhpStorm.
 * User: Leafqun
 * Date: 2017/8/29
 * Time: 15:52
 */

namespace app\index\controller;

use app\index\common\url;
use app\index\model\Course;
use app\index\model\CourseFile;
use think\Request;

class CourseController
{
    public function getCourseList(){
        header('Access-Control-Allow-Origin:*');
        $courseList = Course::field('courseId, courseName, enName')->select();
        return array('courseList' => $courseList);
    }

    public function  getCourse(Request $request){
        header('Access-Control-Allow-Origin:*');
        $course = Course::get($request->param('courseId'));
        return array('course' => $course);
    }

    public function submitCourse(Request $request){
        header('Access-Control-Allow-Origin:*');
        $course = $request->param();
        if(empty($course['courseId'])){
            Course::create($course);
            $msg = '添加成功';
        }else{
            Course::where('courseId', $request -> courseId)->update($course);
            $msg = '更改成功';
        }
        return array('msg' => $msg);
    }

    public function deleteCourse(Request $request){
        header('Access-Control-Allow-Origin:*');
        $oldFile = CourseFile::where('courseId', $request -> param('courseId'))
            ->field('cfileName')->select();
        foreach ($oldFile as $file){
            if(!empty($file)){
                unlink(url::$fileURL . $file['cfileName']);
            }
        }
        Course::destroy($request->param('courseId'));
        CourseFile::where('courseId', $request->param('courseId')) -> delete();
        return array('msg'=> 'success');
    }

    public function getAllCourseFile(Request $request){
        header('Access-Control-Allow-Origin:*');
        $courseFileList = CourseFile::where('courseId', $request->param('courseId'))
            ->order('cfileId', 'desc') -> select();
        return array('courseFileList' => $courseFileList);
    }

    public function deleteCourseFile(Request $request){
        header('Access-Control-Allow-Origin:*');
        $cfile_id = $request->param()['cfileId'];
        if(is_array($cfile_id)) $cfileIds = $cfile_id;
        else $cfileIds = array($cfile_id);
        foreach ($cfileIds as $cfileId){
            $file = CourseFile::where('cfileId', $cfileId)
                -> field('cfileName')->find();
            if(!empty($file)){
                $fileurl = url::$fileURL . $file['cfileName'];
                if(file_exists($fileurl)) unlink($fileurl);
            }
            CourseFile::where('cfileId', $cfileId) -> delete();
        }
        return array('msg' => 'success');
    }

    public function insertCourseFile(Request $request){
        header('Access-Control-Allow-Origin:*');
        $courseFile = $request -> only(['courseId', 'ctype']);
        $file = $request->file('file');
        if($file) {
            $info = $file->move(url::$fileUrl, '');
            if ($info) {
                $filename = $info->getFilename();
                $courseFile['cfileName'] = $filename;
                CourseFile::create($courseFile);
            }
        }
        return array('msg' => 'success');

    }
}