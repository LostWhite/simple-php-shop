<?php
namespace Vokuro\Common;
use Vokuro\Controllers\redis_cli;
use Phalcon\Mvc\User\Component;

/**
 * Vokuro\DataBase\DbController
 */
class Order extends Component
{

private  static  $mypdo  ;
private  static  $myredis  ;

   static function setPdo($pdo){
	   	if  (empty($mypdo)){
	   		self::$mypdo = $pdo;
	   	}
   }
   //redis 
  static function  setRedis($redis){
  	self::$myredis = $redis;
   }
   
      static  function getOrderNotOver($user_id,$ps_user_id,$site_id)
    {
    	
    	 $where = " user_id = ".$user_id." and pay_to_user_id = ".$ps_user_id." and status = 1 and site_id = ".$site_id;

    	$rec = self::$mypdo->getRow("tbl_order_dtl", $where, "t_order_id") ;
    	
    	if ($rec){
    		return   $rec[ "t_order_id"];
    	}else{
    		return 0;
    	}

    }
     static  function getOrderByID($orderid)
    {
    	
    	 $where = "select * t_order_id = ".$orderid ;

    	$rec = self::$mypdo->query("tbl_order_dtl", $where, "t_order_id") ;
    	
    	if ($rec){
    		return   $rec[ "t_order_id"];
    	}else{
    		return 0;
    	}

    }
   
   
    /**
     *
     *
     */
    static  function insTmpOrder($userid,$teacherid,$site_id,$order_id)
    {

    }

    static  function getTmpOrder($userid,$teacherid,$site_id)
    {

    }

    static  function delTmpOrder($userid,$teacherid,$site_id)
    {

    }

}
