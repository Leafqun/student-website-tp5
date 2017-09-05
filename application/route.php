<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;


Route::get('/a','index/a');

Route::any('/login','LoginController/login');

Route::get('/notice/getHeadNotice','NoticeController/getHeadNotice');
Route::get('/notice/getNotice','NoticeController/getNotice');
Route::get('/notice/getNoticeContent','NoticeController/getNoticeContent');
Route::post('/notice/submitNotice','NoticeController/submitNotice');
Route::any('/notice/deleteNotice','NoticeController/deleteNotice');

Route::get('/message/getMessageList','MessageController/getMessageList');
Route::get('/message/getMessage','MessageController/getMessage');
Route::post('/message/insertMessage','MessageController/insertMessage');
Route::any('/message/deleteMessage','MessageController/deleteMessage');

Route::get('/course/getCourseList','CourseController/getCourseList');
Route::get('/course/getCourse','CourseController/getCourse');
Route::post('/course/submitCourse','CourseController/submitCourse');
Route::any('/course/deleteCourse','CourseController/deleteCourse');

Route::get('/course/getAllCourseFile','CourseController/getAllCourseFile');
Route::any('/course/deleteCourseFile','CourseController/deleteCourseFile');
Route::post('/course/insertCourseFile','CourseController/insertCourseFile');

Route::get('/tables/getTables','TablesController/getTables');
Route::any('/tables/deleteTables','TablesController/deleteTables');
Route::post('/tables/insertTables','TablesController/insertTables');

Route::get('/faculty/getFaculty','FacultyController/getFaculty');
Route::post('/faculty/updateFaculty','FacultyController/updateFaculty');

Route::get('/profile/getProfile', 'ProfileController/getProfile');
Route::post('/profile/updateProfile', 'ProfileController/updateProfile');

Route::get('/management/getManagement', 'ManagementController/getManagement');
Route::post('/management/updateManagement', 'ManagementController/updateManagement');


return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],


];

