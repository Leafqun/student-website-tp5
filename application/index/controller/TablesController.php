<?php
/**
 * Created by PhpStorm.
 * User: Leafqun
 * Date: 2017/8/29
 * Time: 21:04
 */

namespace app\index\controller;

use app\index\common\url;
use app\index\model\Tables;
use think\Request;

class TablesController
{
    public function getTables(Request $request){
        header('Access-Control-Allow-Origin:*');
        $tablesList = Tables::order('tableId', 'desc')
            ->paginate(15, false, [
                'page' => $request->param('pageNum'),
                'type'     => 'bootstrap',
                'var_page' => 'page'
            ]);
        return array('tablesList'=> $tablesList);
    }

    public function deleteTables(Request $request){
        header('Access-Control-Allow-Origin:*');
        if(is_array($request -> param('tableId'))){
            $tablesIds = $request -> param('tableId');
        }else{
            $tablesIds = array($request -> param('tableId'));
        }
        foreach ($tablesIds as $tablesId){
            $file = Tables::where('tableId', $tablesId)
                ->field('tableFile')->find();
            if(!empty($file->tableFile)) {
                $fileurl = url::$fileURL . $file['tableFile'];
                if (file_exists($fileurl)) unlink($fileurl);
            }
            Tables::destroy($tablesId);
        }
        return array('msg' => 'success');
    }

    public function insertTables(Request $request){
        header('Access-Control-Allow-Origin:*');
        $bool = null;
        $file = $request -> file('file');
        if($file){
            $info = $file->move(url::$fileUrl ,'');
            if($info){
                $filename = $info->getFilename();
                $tables['tableFile'] = $filename;
                $bool = Tables::create($tables);
            }
        }
        if($bool) return array('msg' => 'success');
        else return array('msg' => 'error');
    }
}