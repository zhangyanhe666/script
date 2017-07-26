<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Script\Controller;
use Library\Application\Controller as LibController;
use Library\Application\Common;
class ScriptBaseController extends LibController{

    public function onDispatch() {
        set_time_limit(0);
        echo "脚本运行开始:".date('Y-m-d H:i:s')."\n";
        $onDispatch  =   parent::onDispatch();
        echo "相关耗时信息：\n";
        $times  =   Common::getTimeAnchor();
        foreach ($times as $v){
            foreach ($v as $k=>$vv){
                echo "{$k}:{$vv}\n";
            }
        }
        echo "脚本运行结束;\n";
        return $onDispatch;
    }
}