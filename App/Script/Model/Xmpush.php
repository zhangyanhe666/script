<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Script\Model;
use Library\Db\Model;
use xmpush\Builder;
use xmpush\IOSBuilder;
use xmpush\Sender;
use xmpush\Constants;
use xmpush\TargetedMessage;
class Xmpush extends Model{
    const SECRET            =   'Rzunz/i4Jj63tNU6CbBD7g==';
    const APP_PACKAGENAME   =   'com.amili';
    const IOS_BUNDLE_ID     =   'com.haokan.amili';
    const IOS_SECRET        =   'QYRsppH+Kh/MvJV74uJ6eA==';
    public $message;
    public $sender;
    public $iosSender;
    public $targetMessage;
    public function androidSender(){
        if(!$this->sender){
            Constants::setPackage(self::APP_PACKAGENAME);
            Constants::setSecret(self::SECRET);
            $this->sender   =   new Sender();
        }
        return $this->sender;
    }
    public function iosSender(){        
        if(!$this->iosSender){
            Constants::setBundleId(self::IOS_BUNDLE_ID);
            Constants::setSecret(self::IOS_SECRET);
            Constants::useSandbox();
            $this->iosSender   =   new Sender();
        }
        return $this->iosSender;
    }
    public function push($title,$content,$payload,$id,$alias,$dev){
        if($dev == 'ios'){
            $message    =   $this->iosMessage($title, $content, $payload,$id);
            print_r($this->iosSender()->sendToAliases($message,array($alias))->getRaw());
        }else{
            $message    =   $this->message($alias,$title, $content, $payload,$id);
            print_r($this->androidSender()->multiSend(array($message),TargetedMessage::TARGET_TYPE_USER_ACCOUNT)->getRaw());
        }
    }
    
    public function message($alias,$title,$content,$payload,$id){
        $message  =   new Builder();
        $targetMessage = new TargetedMessage();
        $message->title($title);  // 通知栏的title
        $message->description($content); // 通知栏的descption
        $message->passThrough(0);  // 这是一条通知栏消息，如果需要透传，把这个参数设置成1,同时去掉title和descption两个参数
        $message->payload($payload); // 携带的数据，点击后将会通过客户端的receiver中的onReceiveMessage方法传入。
        $message->extra(Builder::notifyForeground, 1); // 应用在前台是否展示通知，如果不希望应用在前台时候弹出通知，则设置这个参数为0
        $message->extra('id', $id); // id
        $message->notifyId(0); // 通知类型。最多支持0-4 5个取值范围，同样的类型的通知会互相覆盖，不同类型可以在通知栏并存
        $message->build();
        $targetMessage->setTarget($alias, TargetedMessage::TARGET_TYPE_USER_ACCOUNT); // 设置发送目标。可通过regID,alias和topic三种方式发送
        $targetMessage->setMessage($message);
        return $targetMessage;
    }
    public function iosMessage($title,$content,$payload,$id){
        $message = new IOSBuilder();
        $message->title($title);  // 通知栏的title
        $message->description($content); // 通知栏的descption
        $message->extra('payload', $payload); // 携带的数据，点击后将会通过客户端的receiver中的onReceiveMessage方法传入。
      //  $message->badge('1');
        $message->extra('id', $id); // id
        $message->soundUrl('default');
        $message->build();
        return $message;
    }
}