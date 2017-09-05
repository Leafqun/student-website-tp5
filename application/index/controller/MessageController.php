<?php
/**
 * Created by PhpStorm.
 * User: Leafqun
 * Date: 2017/8/28
 * Time: 16:57
 */

namespace app\index\controller;

use app\index\model\Message;
use think\Request;

class MessageController
{
    public function getMessageList(Request $request){
        header('Access-Control-Allow-Origin:*');
        $messageList = Message::order('mTime','desc')
            ->field('messageId,stuName,email,mTime')
            ->paginate(15, false, [
                'page' => $request->param('pageNum'),
                'type'     => 'bootstrap',
                'var_page' => 'page'
            ]);
        return array('messageList' => $messageList);
    }

    public function getMessage(Request $request){
        header('Access-Control-Allow-Origin:*');
        $message = Message::get($request->param('messageId'));
        return array('message' => $message);
    }

    public function insertMessage(Request $request){
        header('Access-Control-Allow-Origin:*');
        Message::create($request->param());
        return array('msg' => 'success');
    }

    public function deleteMessage(Request $request){
        header('Access-Control-Allow-Origin:*');
        Message::destroy($request->param('messageId'));
        return array('msg' => 'success');
    }
}