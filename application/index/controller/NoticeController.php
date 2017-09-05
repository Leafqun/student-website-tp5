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
        $input = $request->except(['cfile']);
        $input['noticeTime'] = date('Y-m-d H:i:s',time());
        if($request->has('cfile')) {
            $file = $request->file('cfile');
            $info = $file->move(url::$fileUrl, '');
            if ($info) {
                $filename = $info->getFilename();
                $input['file'] = $filename;

            }
        }
        //存入数据库
        if(empty($input['noticeId'])){
            //插入
            $notice = Notice::create($input);
            if($notice) {
                return json(array('msg' => '添加成功'));
            }else{
                return json(array('msg' => '添加失败'));
            }
        }else{
            $g = Notice::where('noticeId', $input['noticeId']) -> update($input);
            if($g) {
                return json(array('msg' => '更改成功'));
            }else{
                return json(array('msg' => '更改失败'));
            }
        }
    }
    //删除通知
    public function deleteNotice(Request $request)
    {
        header('Access-Control-Allow-Origin:*');
        if(is_array($request->noticeId)) {
            $noticeId = $request->param('noticeId');
        }else{
            $noticeId = array($request->param('noticeId'));
        }
        foreach ($noticeId as $id){
            $filename = Notice::where('noticeId', $id)
                ->field('file')->find();
            if(empty($filename ->file)) continue;
            $path = ROOT_PATH . 'public' . DS . 'uploads' . DS;
            unlink($path . $filename->file);
            Notice::destroy($id);
        }
        return array('msg' => '删除成功');
    }
}