<?php
/**
 * Created by PhpStorm.
 * User: Leafqun
 * Date: 2017/9/4
 * Time: 11:12
 */

namespace app\index\model;


use think\Model;

class Message extends Model
{
    protected $table = 'message';

    protected $pk = 'messageId';
}