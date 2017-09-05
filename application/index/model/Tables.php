<?php
/**
 * Created by PhpStorm.
 * User: Leafqun
 * Date: 2017/9/4
 * Time: 13:13
 */

namespace app\index\model;


use think\Model;

class Tables extends Model
{
    protected $table = 'tables';

    protected $pk = 'tableId';
}