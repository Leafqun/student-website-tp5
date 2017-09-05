<?php
/**
 * Created by PhpStorm.
 * User: Leafqun
 * Date: 2017/8/28
 * Time: 10:42
 */

namespace app\index\controller;

use app\index\common\url;
use app\index\model\Notice;
use think\Request;


class NoticeController
{
    //获取首页通知
    public function getHeadNotice(){
        header('Access-Control-Allow-Origin:*');
        $notice = Notice::order('noticeTime', 'desc')
            ->limit(6)
            ->field('noticeId, noticeName, noticeTime')
            ->select();
        return array('noticeList' => $notice);
    }
    //获取分页通知
    public function getNotice(Request $request){
        header('Access-Control-Allow-Origin:*');
        $notice = Notice::order('noticeTime', 'desc')
            ->field('noticeId,noticeName,noticeTime')
            ->paginate(15, false, [
                'page' => $request->param('pageNum'),
                'type'     => 'bootstrap',
                'var_page' => 'page'
            ]);
        return array('noticeList' => $notice);
    }
    //获取通知内容
    public function getNoticeContent(Request $request){
        header('Access-Control-Allow-Origin:*');
        $notice = Notice::get($request->param('noticeId'));
        return array('notice' => $notice);
    }
    //提交通知
    public function submitNotice(Request $request){
        header('Access-Control-Allow-Origin:*');
        $input = $request->except(["cfile"]);
        $tip = null;
        $input['noticeTime'] = date('Y-m-d H:i:s',time());
        $request->file('cfile');
        $file = $request->file('cfile');
        if($file) {
            $info = $file->move(url::$fileUrl, '');
            if ($info) {
                $filename = $info->getFilename();
                //删除旧文件
                if(!empty($input['file'])){
                    $fileurl = url::$fileURL . $input['file'];
                    if(file_exists($fileurl)) unlink($fileurl);
                }
                $input['file'] = $filename;
                $tip = '上传成功';

            }else{
                $tip = '本地存储失败';
            }
        }else $tip =  '文件未上传或上传失败';
        //存入数据库
        if(empty($input['noticeId'])){
            //插入
            $notice = Notice::create($input);
            $msg = null;
            if($notice) {
                $msg = '添加成功';
            }else{
                $msg = '添加失败';
            }
        }else{
            $g = Notice::where('noticeId', $input['noticeId']) -> update($input);
            if($g) {
                $msg = '更改成功';
            }else{
                $msg = '更改失败';
            }
        }
        return array('msg' => $msg, 'tip' => $tip);
    }
    //删除通知
    public function deleteNotice(Request $request)
    {
        header('Access-Control-Allow-Origin:*');
        if(is_array($request->param('noticeId'))) {
            $noticeId = $request->param('noticeId');
        }else{
            $noticeId = array($request->param('noticeId'));
        }
        foreach ($noticeId as $nid){
            if(!empty($nid)) {
                $filename = Notice::where('noticeId', $nid)
                    ->field('file')->find();
                if (!empty($filename->file)) {
                    $fileurl = url::$fileURL . $filename->file;
                    if (file_exists($fileurl)) unlink($fileurl);
                }
                Notice::where('noticeId', $nid)->delete();
            }
        }

        return array('msg' => '删除成功');
    }
}