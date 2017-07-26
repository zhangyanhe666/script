<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Script\Controller;

use Script\Controller\ScriptBaseController;

class PhonePushController  extends ScriptBaseController{
    
    public function pushMsgQueueAction(){
        $start  =   0;
        $num    =   10;
        while($data   =   $this->getServer('script.xmpush_queue')->where(['status'=>0])->offset($start)->limit($num)->getAll()->toArray()){
            $start  +=  $num;
            foreach ($data as $k=>$v){
                $this->getServer('Model\Xmpush')->push($v['title'],$v['desc'],$v['payload'],$v['id'],$v['sendTarget'],$v['dev']);
            }
            $this->getServer('script.xmpush_queue')->update(['status'=>1],['id'=>array_column($data,'id')]);
            \Library\Application\Common::setTimeAnchor('更新了1000条数据');
        }
    }
}
