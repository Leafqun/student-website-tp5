<?php
/**
 * Created by PhpStorm.
 * User: Leafqun
 * Date: 2017/9/3
 * Time: 23:42
 */

namespace app\index\model;


use think\Model;

class Notice extends Model
{
    protected $table = 'notice';

    protected $pk = 'noticeId';
}