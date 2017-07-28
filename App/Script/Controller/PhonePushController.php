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
    
    public function pushMsgQueueAction(){
        while($data   =   $this->getServer('script.xmpush_queue')->where(['status'=>0])->offset($this->start)->limit($this->num)->getAll()->toArray()){
            $this->start  += $this->num;
            foreach ($data as $k=>$v){
                $this->getServer('Model\Xmpush')->push($v['title'],$v['desc'],$v['payload'],$v['id'],$v['user_type'],$v['sendTarget']);
            }
            $this->getServer('script.xmpush_queue')->update(['status'=>1],['id'=>array_column($data,'id')]);
            \Library\Application\Common::setTimeAnchor("更新了".count($data)."条数据");
        }
    }
    public function getPushMsgListAction(){
        while($data   =   $this->getServer('script.push_message_list')->where(['status'=>0,'(pushtime=0 or pushtime<"'.time().'")'])->offset($this->start)->limit($this->num)->getAll()->toArray()){
            $this->start  += $this->num;
            $pushlist   =   array_map(function($v){                
                $push['title'] =   $v['title'];
                $push['desc'] =   $v['desc'];
                $push['payload'] =   '#'.$v['type'].'#'.$v['cid'];
                $push['user_type'] =   $v['action'];
                $push['sendTarget'] =   $v['push_id'];
                return $push;
            },$data);
            $this->getServer('script.xmpush_queue')->batchInsert(['title','desc','payload','user_type','sendTarget'],$pushlist);
            $this->getServer('script.push_message_list')->update(['status'=>1],['id'=>array_column($data,'id')]);
            \Library\Application\Common::setTimeAnchor("更新了".count($data)."条数据");
        }
    }
}
