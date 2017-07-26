<?php

/* 
 * 项目配置文件
 * 
 */
return array(
    //项目配置; 注:数组第一个元素为默认项目,该项目可以不加项目名直接访问,其他项目需要加项目名进行访问
    'project'=>array(
        'Script',
    ),
    //项目地址配置
    'systemRoot'=>'App',
    //当前环境，false（开发环境），true（生产环境）
    'production'=>false,
    'config'=>'Config/application.php'

);
