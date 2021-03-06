<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Script;
use Script\Factory\ModelFactory;
class Module{
    public $service;
    public function __construct($service) {
        $this->service  =   $service;
    }
    public function getAutoloadConfig(){
        return array(
            'Library\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                    'xmpush' => realpath('./Library/Xmpush'),
                ),
            ),
        );
    }
    //获取指定service
    public function getServer($server,$useAlreadyExists=true){
        return $this->service->get($server,$useAlreadyExists);
    }
    public function init(){
        
    }
    public function getCustomService(){
        $model  =   function($name){
            $factory    =   new ModelFactory();
            $model      =   $factory->createModel($this->service,$name);
            return $model;
        };
        return $model;
    }
    public function getServiceConfig(){
        return array(
            'instancesService'=>array(
            ),
        );
    }
}
