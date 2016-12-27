<?php
/**
 * Created by PhpStorm.
 * User: cp1
 * Date: 2015-05-09
 * Time: 14:55
 */
namespace Vokuro\Controllers;
class Redis1Controller  extends ControllerBase {
    public function indexAction(){
        $redis =$this->redis;
        //$redis = new Redis();
        //$redis->connect('127.0.0.1',6379);
        $redis->set('test','hello redis');
        echo $redis->get('test');

        /*
       $redis1->connect("127.0.0.1","6379");  //php客户端设置的ip及端口
//存储一个 值
       $redis1->set("say","Hello World");
       echo $redis1->get("say");     //应输出Hello World
       */

        echo "***************";
    }
} 