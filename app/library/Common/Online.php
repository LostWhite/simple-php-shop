<?php
namespace Vokuro\Common;
use Vokuro\Controllers\redis_cli;
use Phalcon\Mvc\User\Component;
use Vokuro\DataBase\DbController;
/**
 * Vokuro\DataBase\DbController
 */
class Online extends Component
{
	

	private  static  $myredis  ;

 //   $redis->connect($config->redis->host,  $config->redis->port );
	private  static  $mymsg ;
	/*
   function  __construct($redis)//欲取得的数据成员名称
   {
       //特殊函数，取得指定名称数据成员的值
            self::$myredis = $redis;
           //  $redis =$this->redis;
   }
   */
   static function getStatuesMsg(){
   	return  self::$mymsg;
   }
   //redis 
  static function  setRedis($redis){
  	self::$myredis = $redis;
   }
   
   
  static  function  getKey($key){
  	 	echo  self::$myredis->GET($key);
    }
   
   
   //交谈时状态取得
   //$isteacher=false 客户获取状态  true 服务者获取状态
   //$chatflg =1 试测聊天  2  订单交谈
	//return
   
   public function   getTeacherChatStatus($teacherid, $siteid=1)
   {
   /*
        服务者
       未登录状态	0
		登陆后没有试测和下单	1
		有1个以内客户交谈非本网	2
		有3个以上客户超忙碌	3
		黑名单客户	10
       */
        $teastatus=    self::$myredis ->HGET('_use', $teacherid);
        if  ($teastatus) {
        	if   ($teastatus==2){
        			 self::$mymsg = "预测师现在忙碌中，请稍后再试或者换别的预测师试试";
        			return  2;
        	}
        		else if   ($teastatus==3){
        			 self::$mymsg="预测师现在忙碌中，请稍后再试或者换别的预测师试试";
        			return 3;
        		}
        	else if   ($teastatus==100){
        			 self::$mymsg="预测师现在超忙碌不接受试测，请直接下单";
        			return  100;
        		}
        	else if   ($teastatus==10){
        			 self::$mymsg="预测师不愿意为你测试";
        			return 10;
        		}
        	
		 	else if   ($teastatus==0){
        			 self::$mymsg="预测师现在不在线，请稍后再试";
        			return 10;
        		}else{
        			 self::$mymsg="预测师现在忙碌中，请稍后再试或者换别的预测师试试";
        			 return 3;
        		}
        }else{
        	 self::$mymsg="预测师现在不在线，请稍后再试";
        	return   2;
        }
         self::$mymsg = "TESTTEST";
        return 2;
   }

   public function   getUseridChatStatus($userid,$siteid){
   	/*
   	 * 
	 客户
	 未登录状态	0
	登陆后没有试测和下单	1
	有3个以下试测忙碌	2
	有3个以上	3
   	 */
   	    $useridstatus=    self::$myredis ->GET('_use'  ,$userid);
        if  ($useridstatus ==0) {
        	 self::$mymsg="你已经掉线，请重新登录";
        	 return 0;
        } 
        else  if  ($useridstatus ==2) {
          	//如果是本网站 。。。
          	if  ($chatflg==1){ //试测聊天
        		 self::$mymsg="请结束你与预测师的对话，再来试测";
          	}
          	return 2;
        } 
        else  if  ($useridstatus ==3) {
          	//如果是本网站 。。。
        	 self::$mymsg="侦测到你会话打开太多，请先结束其他对话";
        	return 3;
        } 
   }


    static function query($sql)
    {
        $db = new DbController();
        $data = $db->QueryAll($sql);
        return $data;
    }

    static function queryDI($sql)
    {
        $db = new DbController();
        $db->Query($sql);
    }

    /**
     * 取得在线状态
     *
     * @param $user_id 用户ID
     * @param $site_id 网站ID
     * @return  0 不在线  1 在线空闲   2 在线忙碌  3在线超忙碌   4 结束预测
     *
     */
    static  function getUserStatues($user_id,$site_id)
    {

    	$user_status = self::$myredis ->HGET('_use',$user_id);
    
    	 if($user_status){
            //return ($data[0]['status']);
	         if ($user_status == 0){
	         
	           return  2; // 2 预测师不在线
	        } elseif($user_status == 2){
	        	
	            return  3 ; // 3 预测师忙碌
	        } elseif($user_status ==3){
	               return  3 ; // 2 预测师忙碌
	               	
	        }else { 
	        	return $user_status;
	        	}
        }else{
            return 0;
        }
    
      
    }


    static  function getUserName($user_id,$site_id =1)
    {
    	  $name=  self::$myredis ->HGET('_usename',$user_id);
    	if   ($name ){
    		return $name;
    	}else {
    		
    		
    		 $sql = "SELECT login_id FROM mst_user WHERE   user_id = {$user_id}  ";
    	

		      //执行SQL
		        $data = self::query($sql);
		     //如果存在 返回状态 值
		         if($data){
	            	return $data[0]['login_id'] ;
		     }
    	}
    }

    /**
     *在线状态更新
     *
     * @param $user_id 用户ID
     * @param $site_id 网站ID
     * @param $status   用户登录时 1在线空闲   ，试测或者订单测试时 2在线忙碌，订单测试，超过两个订单情况下 3在线超忙碌
     * @param $sessionid 用户会话ID
     * @return  0 失败  `1 成功
     */
    static   function  insUserStatues($user_id,$site_id,$status,$sessionid,$username)
    {
        if(self::getUserStatues($user_id,$site_id) == 0){
        	
     	$sql = "delete from  t_online where user_id = {$user_id} and  site_id  = {$site_id} ";
       		 self::queryDI($sql);
               
          $sql = "insert into  t_online(user_id,site_id,status,sessionid) values({$user_id}, {$site_id}, {$status}, {$sessionid})  ";
         // echo $sql;
            //执行SQL
          	self::queryDI($sql);

            self::$myredis ->HSET('_usename',$user_id,$username);
            self::$myredis ->HSET('_use',$user_id, $status);
            self::$myredis ->HSET('_usetime',$user_id, time());
           
        }
     //如果成功 返回1
        /*
        if(self::query($sql)){
            return 1;
        }else{
            return 0;
        }
        */
     //如果失败 返回0
      
    }

    /**
     * 在线状态删除
     *用户退出时 或者session超时 消失时  使用
     * @param $user_id 用户ID
     * @param $site_id 网站ID
     * @return  0 失败  1 成功
     */
    static   function delUserStatues($user_id,$site_id, $isteacher=false)
    {
        $sql = "delete from t_online where  user_id = {$user_id}  and  site_id =  {$site_id}  ";
 
        //执行SQL
        self::queryDI($sql);
        
        self::$myredis ->HDEL('_use',$user_id);
        self::$myredis ->HDEL('_usename',$user_id);
        self::$myredis ->HDEL('_usetime',$user_id);
        if  ($isteacher){
	          self::$myredis ->DEL("tc_".$user_id); //老师是否进入会谈窗
	          self::$myredis ->DEL("tn_".$user_id);//与老师交谈的名字
        }
        
        	 // self::$myredis ->HDEL("tc_".$teacherId;); 
    	 $uckey ="uc_".$user_id;
    	  $uKeys =  self::$myredis->HGETALL($uckey);
    	  foreach  ( $uKeys as  $key=> $val)
	       {
		       	  self::$myredis ->HDEL($uckey, $key);
	 		       $teachatKey = "tc_".$val;
	 		      self::$myredis ->HDEL($teachatKey ,  $user_id); 
	 		      self::$myredis ->HDEL( "tn_".$val ,  $user_id); 
	        }
        
       //如果成功 返回1
      //如果失败 返回0
    }
    
    
     /**
     * 取得在线状态
     *
     * @param $user_id 用户ID
     * @param $site_id 网站ID
     * @return  0 不在线  1 在线空闲   2 在线忙碌  3在线超忙碌
     *
     */
    static  function getOnLineJpgName($user_id,$site_id)
    {
    	$statues = self::$myredis ->HGET('_use',$user_id);
    	return   self::getJpgNameByOnLineStatus($statues);
    	}
    	/*
        $sql = "select status from  t_online where  user_id = {$user_id} and  site_id =  {$site_id} ";
   //  $sql = "select status from  t_online  where  site_id =  {$site_id} ";
      //执行SQL
        $data = self::query($sql);
     //如果存在 返回状态 值
      
        if($data){
        	if ($data[0]['status'] == 1) {
            	return "online.jpg";
            }
             	if ($data[0]['status'] == 2) {
            	return "busy.jpg";
            } 
             
        }else{
            return 'offline.jpg';
        }
        (/)
     //如果不存在，返回0
      
    }
         /**
     * 取得在线状态
     *
     * @param $statues 0 不在线  1 在线空闲   2 在线忙碌  3在线超忙碌
  
     * @return  
     *
     */
    static  function getJpgNameByOnLineStatus($statues){
    	if (empty($statues)){
    		return "offline.jpg";
    	}
    	if ($statues == 1) {
            	return "online.jpg";
            }
         elseif ($statues == 2) {
            	return "busy.jpg";
            } 
          else {
          	return "offline.jpg";
          }
    }
    
      /**
     * 取得在线状态
     *
     * @param $user_id 用户ID
     * @param $site_id 网站ID
     * @param $order_id 订单ID
     * @return  0 不在线   2 预测师不在线 3  预测师忙碌
     * 
     *
     */
    static  function getRoomrStatues($user_id,$site_id,$order_id = "")
    {
    	$user_status = self::$myredis ->HGET('_use',$user_id);
    
    	 if($user_status){
            //return ($data[0]['status']);
	         if ($user_status == 0){
	         
	           return  2; // 2 预测师不在线
	        } elseif($user_status == 2){
	        	
	            return  3 ; // 3 预测师忙碌
	        } elseif($user_status ==3){
	               return  3 ; // 2 预测师忙碌
	               	
	        }else { return 0;}
        }else{
            return 0;
        }

     //如果不存在，返回0
      
    }
      /**
     * 取得交谈数组
     *
     * @param $content 传入字符串行
     * $content格式
     * 时间||用户||文字内容
     * 
     * @return  解释后数组
     * 
     *
     */
    static  function getContentArr($content)
    {
    	       //echo $content;
        	if (strpos($content, "||") === false) {
        		return false;
            //echo "**".$content."**";;
        	}
        $arr = explode("||", $content);
        $t = intval($arr[0]);

       // $words = explode(":", $arr[1]);
        $item2["color"] = $arr[1]; //颜色
        $item2["userid"] = $arr[2]; //用户名
        $item2["word"] =$arr[3]; //交谈内容
        $item2["key"] = $t; 
        $item2["time"] = $t; //交谈时间
        return  $item2;
    }
    
}
