<?php
/**
 * Created by PhpStorm.
 * User: Leafqun
 * Date: 2017/9/4
 * Time: 11:24
 */

namespace app\index\model;


use think\Model;

class Course extends Model
{
    protected $table = 'course';

    protected $pk = 'courseId';
}