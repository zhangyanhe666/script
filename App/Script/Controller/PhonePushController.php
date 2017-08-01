<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Script\Controller;

use Script\Controller\ScriptBaseController;

class PhonePushController  extends ScriptBaseController{
    public $start   =   0;
    public $num     =   10;
    public $dbName  =   'script';
    
    public function init() {
        parent::init();
        if($this->getRequest()->getQuery('debug',0) == 1){
            //设置调试模式
            $this->dbName   =   'testScript';
            $this->getServer('Model\Xmpush')->iosTest();
        }
    }
    public function pushMsgQueueAction(){
        while($data   =   $this->xmpushdb()->where(['status'=>0])->offset($this->start)->limit($this->num)->getAll()->toArray()){
            $this->start  += $this->num;
            foreach ($data as $k=>$v){
                $this->getServer('Model\Xmpush')->push($v['title'],$v['desc'],$v['payload'],$v['id'],$v['user_type'],$v['sendTarget']);
            }
            $this->xmpushdb()->update(['status'=>1],['id'=>array_column($data,'id')]);
            \Library\Application\Common::setTimeAnchor("更新了".count($data)."条数据");
        }
    }
    public function getPushMsgListAction(){
        while($data   =   $this->messageListdb()->where(['status'=>0,'(pushtime=0 or pushtime<"'.time().'")'])->offset($this->start)->limit($this->num)->getAll()->toArray()){
            $this->start  += $this->num;
            $pushlist   =   array_map(function($v){                
                $push['title'] =   $v['title'];
                $push['desc'] =   $v['desc'];
                $push['payload'] =   '#'.$v['type'].'#'.$v['cid'];
                $push['user_type'] =   $v['action'];
                $push['sendTarget'] =   $v['push_id'];
                return $push;
            },$data);
            $this->xmpushdb()->batchInsert(['title','desc','payload','user_type','sendTarget'],$pushlist);
            $this->messageListdb()->update(['status'=>1],['id'=>array_column($data,'id')]);
            \Library\Application\Common::setTimeAnchor("更新了".count($data)."条数据");
        }
    }
    public function xmpushdb(){
        return $this->getServer($this->dbName.'.xmpush_queue');
    }
    public function messageListdb(){
        return $this->getServer($this->dbName.'.push_message_list');
    }
}
