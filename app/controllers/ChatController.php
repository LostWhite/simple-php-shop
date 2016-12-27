<?php
namespace Vokuro\Controllers;
use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Vokuro\Forms\ChangePasswordForm;
use Vokuro\Forms\UsersForm;
use Vokuro\Models\tbl_order_eva;
use Vokuro\Models\tbl_reward_task;
use Vokuro\Models\tbl_message;
use Vokuro\Models\tbl_order_dtl;
use Vokuro\Models\mst_user;
use Vokuro\Models\Users;
use Vokuro\Models\PasswordChanges;
use Vokuro\Models\mst_user_service;
use Vokuro\Common\Online;
use Vokuro\Common\Comchat;
use Vokuro\Common\FileOp;
use Workerman\Worker;
use Workerman\WebServer;
use Workerman\Lib\Timer;
use PHPSocketIO\SocketIO;
/**
 * Vokuro\Controllers\ChatController
 * CRUD to manage users
 *
 */
class ChatController extends ControllerBase
{
    public function initialize()
    {
    	
    	parent::initialize();
        //  include_once __DIR__."../../../vendor/redis.php";
        global $leastnum;
        global $disonline;
        global $room;
        global $roomdir;
        global $charset;
        global $maxdisplay;
        global $lang;
        global $get_past_sec;
        global $touchs;
		
		/*
		echo $this->session->getid();
		echo "<br>";
	
		echo session_id();
		exit;
		*/
//显示在线用户
        $disonline = true;
//新登陆时显示最近内容的条数(默认为30条)
        $leastnum = 30;
//默认的房间名
        $room = date("Y-m-d");
        
//房间保存路径,必须以/结尾
        $roomdir = "rooms/";
//编码方式
        $charset = "UTF-8";
//客户端最大显示内容条数
        $maxdisplay = 300;

        global $redis;
        //$redis = new redis_cli ('192.168.1.43', 6379);
        $redis =$this->redis;
		Online::setRedis($redis);
///////////////////////
        global $room_onlines;
        $room_onlines = "room_online_";
///////////////////////
//语言
        $lang = array(
//聊天室描述
            "description" => "",
//聊天室标题
            "title" => "",
//第一个到聊天室的欢迎
            "firstone" => "<span style='color:#16a5e9;'>请等待预测师</span>",
//当信息有禁止内容时显示
            "ban" => "xxxxx",
//发言提示
            "hereyourwords" => "我要咨询"
        );
  		$this->view->setVar('ischat', "1");
        error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
        header("content-type:text/html; charset=utf-8");

        $get_past_sec = 3; //如果发现丢话，可以适当调大这个值
        $touchs = 10; //检查在线人数的时间间隔
/*
        if (!function_exists("file_get_contents")) {
            function file_get_contents($path)
            {
                if (!file_exists($path)) return false;
                $fp = @fopen($path, "r");
                $all = fread($fp, filesize($path));
                fclose($fp);
                return $all;
            }
        }

        if (!function_exists("file_put_contents")) {
            function file_put_contents($path, $val)
            {
                $fp = @fopen($path, "w");
                fputs($fp, $val);
                fclose($fp);
                return true;
            }
        }
        */
        global $title;
        $title = $lang["title"];
        global $earlier;
        $earlier = 10;
        global $description;
        $description = $lang["description"];

        $origroom = $room;
        global $least;
        $least = ($_GET["dis"]) ? intval($_GET["dis"]) : $leastnum;
        global $touchme;
        $touchme = $_POST['touchme'];
//        if (!is_dir($roomdir)) @mkdir($roomdir) or die("error when creating folder $roomdir");
        $room = $_GET['room'];
        if (!$room) $room = $_POST["room"];
       
        $room = $this->commonFunction->checkfilename($room);
   
        if (!$room) $room = $origroom;
 
        global $action;
        $action = $_POST["action"];
        $this->view->setTemplateBefore('public');
    }

    function keeponline($_redis, $_room_onlines, $_room)
    {
       /*
        global $disonline, $datafile;
        if (!$disonline) return;
        $name = $_POST['name'];
        $ip = $this->commonFunction->get_ip();

       // $onlines = $_redis->cmd('HVALS', $_room_onlines . $_room)->get();
        $onlines = $_redis->HVALS($_room_onlines, $_room);

        $onlines = implode("|", $onlines);

        $s1 = "|{$name}|{$ip}|";

        if (strpos($onlines, $s1) === false) {
            if (strpos($onlines, "|" . $name . "|") === false) {

              //  $_redis->cmd('HSET', $_room_onlines . $_room, "room_{$name}", time() . "|" . time() . $s1)->set();
                $_redis->HSET($_room_onlines,$_room,"room_{$name}", time() . "|" . time() . $s1);
            } else {
                echo "NAME";
            }
        }
       */
        return ;
    }


    /**
     * Default action, shows the search form
     */
    public function indexAction()
    {
    	$this->log->InfoLog("ChatController"," indexAction","开始");
    	$this->CheckMustLogin("chat_index");
        //$this->log->InfoLog("ChatController","indexAction","聊天画面取得开始");
        global  $redis, $room_onlines, $room, $lang, $earlier, $touchs, $maxdisplay, $least;
             //   print_r($_SESSION);
               // exit;
        $this->view->setVar('title', "试测");
        $room =  $this->request->get('room_id');
        $isTeacherManager = false;
        if  (empty($room)) {
	        $teacherId = $this->request->get('sid');   
	           $isTeacherManager = true;
	        if (empty($teacherId)){
	        	 if(isset($_SESSION['prophet_flg'])&&$_SESSION['prophet_flg']==1){
	        	$teacherId = $this->session->get("user_id");
	        	 } else {
	        	 	$teacherId = 0;
	        	 }
	        }
	        $userId = $this->session->get("user_id");
	        $room = $teacherId.'_'.$userId.'_'.DEFINE_SITE_ID;
        }else {
        	$idArray = explode("_", $room);
	        $teacherId = $idArray[0];
	        $userId = $idArray[1];
        }
        
     
     $key_room = 'room_' . $room;
   
    
	// Instantiate the Query
      $username =    Online:: getUserName ($userId,DEFINE_SITE_ID);
      $teachername =    Online:: getUserName ($teacherId,DEFINE_SITE_ID);
        //预测师的名字
       $this->view->setVar('name_teacher', $teachername);
       $curUserId = $this->session->get("user_id");
       $teacherKey = "tn_".$teacherId;
       
         //1 禁止同用户 2 预测师不在线 3`预测师忙碌 4 预测师拒绝与你交谈
        $user_status = Online::getUserStatues($teacherId,DEFINE_SITE_ID);
       	$this->view->setVar('teacherId',  $teacherId);
       if ($user_status == 0){
         $this->view->setVar('roomstatus', 2); // 2 预测师不在线
           $this->dispatcher->forward(array(
            "controller" => "chat",
            "action" => "nochat"
        ));
           return ;
   /*  } elseif($user_status == 1){
           $this->view->setVar('roomstatus', 1); //禁止同用户
           $this->dispatcher->forward(array(
            "controller" => "chat",
            "action" => "nochat"
        ));
           return ;
*/
       } elseif($user_status == 2){
           $this->view->setVar('roomstatus', 3); // 2 预测师忙碌
           $this->dispatcher->forward(array(
            "controller" => "chat",
            "action" => "nochat"
        ));
           return ;

       } elseif($user_status ==3){
           $this->view->setVar('roomstatus', 3); // 2 预测师忙碌
          $this->dispatcher->forward(array(
               "controller" => "chat",
               "action" => "nochat"
           ));
           return ;
       }
       //$redis->HDEL($teacherKey,$userId );
         $teaKeys =  $redis->HGETALL($teacherKey);
      //  echo $teacherKey;

       	$t =time();
	
 $setkey =  $t;
   print_r($setkey);
   echo "<br>";
$content="abcde";
        echo   $redis->ZADD($key_room,"1".$content ,$setkey); //0 两方 1  用户 2预测师
        $content="efg";
           echo   $redis->ZADD($key_room,$setkey+1,"1".$content ); //0 两方 1  用户 2预测师
        echo "<br>";
		$chatContent = $redis->ZRANGE($key_room,0,-1,true);
		
        print_r( $chatContent);
        $redis->DEL($key_room);
        exit;
    if ($userId==$teacherId) {
    	/*
	              $this->view->setVar('roomstatus', 1); //禁止同用户
	             $this->dispatcher->forward(array(
	            "controller" => "chat",
	           "action" => "nochat"
             ));
             return ;
             */
              $chatTime=date("Y-m-d H:i:s",time());
			 $iipp=$_SERVER["REMOTE_ADDR"];
               $content=" 欢迎您来到 算卦街-算命一条街，进行咨询，希望能及时回应客户消息…
										<br>-----------------------------------------------
										<br>☯  预测师管理画面 ☯
										<br>日期：{$chatTime}
										<br> IP：{$iipp}
										<br>-----------------------------------------------";
				$t =time();
	
						$name="system";
						 $content =$t . "||0||" . $name . "||" . $content;
						  //$setkey = $name. $t;
						 $setkey =  $t;
						 echo "system";
        		 		 echo   $redis->ZADD($key_room,$setkey,"1".$content ); //0 两方 1  用户 2预测师
        		 		 echo "system";
        		 		 		$chatContent = $redis->ZRANGE($key_room,0,-1);
        		 		 		 print_r( $chatContent);
             
       }else{
        
        	if   (!isset($teaKeys[$userId])){
        		
        		$key_room_begin = "B".$key_room;
        		$redis->SET($key_room_begin, strtotime(date("Y-m-d H:i:s")) );
        		$redis->HSET($teacherKey,$userId,$username );
        		
        		$teaKeys[$userId] = $username;
        		
        	      $orderid=$this->request->get('orderid');
        	      $chatTime=date("Y-m-d H:i:s",time());
				  $iipp=$_SERVER["REMOTE_ADDR"];
				if (is_numeric($orderid)) {
        	        	  $this->view->setVar('orderid', $orderid); //禁止同用户
        	        	   $orderidtxt=sprintf("%08d", $orderid);
		        	        $content  =" 欢迎您来到 算卦街-算命一条街，请稍待预测师回应…
							<p>-----------------------------------------------
							<br>订单号：{$orderidtxt}
							<br>订单日期：{$chatTime}
							<br>客户 IP：{$iipp}
							<br>服务项目：直接付费
							<br>服务类别：预测类
							<br>订单金额：100 算卦币
							<br>-----------------------------------------------
							<br>为了保护您的利益，切勿站外交易，交谈过程中请勿留下您的任何联系方式，否则您的账户将永久关闭，预测师将被罚款或永久关闭预测室。
							";
		        	  }else {
								  $Content=" 欢迎您来到 算卦街-算命一条街，请稍待预测师回应…
								<br>-----------------------------------------------
								<br>☯  试测验证 ☯
								<br>试算日期：{$chatTime}
								<br>客户 IP：{$iipp}
								<br>-----------------------------------------------
								<br>温馨提示：预测师回应时间最多5分钟。如果超时无回应，请返回首页，选择其他预测师。
								<br>试测验证仅限于验证过去已发生的事情。预测未来需要付费，请参考右侧的服务项目。
								<br>为了保护您的利益，切勿站外交易，交谈过程中请勿留下您的任何联系方式，否则您的账户将永久关闭，预测师将被罚款或永久关闭预测室。
								
								";
		        	      }
						$t =time();
						$name="system";
						 $content =$t . "||0||" . $name . "||" . $content;
						  //$setkey = $name. $t;
						 $setkey =  $t;
        		 		 $redis->ZADD($key_room,$setkey,"1".$content ); //0 两方 1  用户 2预测师
        		}
	        
    }

     $usercount =$redis->HLEN($teacherKey);
   

   

 $this->view->setVar('user_list_arr', $teaKeys);
 $this->view->setVar('define_site_id', DEFINE_SITE_ID);
   //echo $usercount;
  //exit; 
         // 页面进行跳转
          include(APP_DIR."/config/link.php");
        if($curUserId !="$userId" && $curUserId !="$teacherId" )
        {
           
            $this->response->redirect("{$site_url}index/index");
        }
        
        //预测是登录的场合
        if($curUserId =="$teacherId"){
        	
        		$teachatKey = "tc_".$teacherId;
        		print_r($redis ->HGET($teachatKey,$userId));
        		

        	if   ( ! ($redis ->HGET($teachatKey,$userId))){
				//预测师跟哪个用户交谈
        		$redis ->HSET($teachatKey,$userId,DEFINE_SITE_ID);
        		//个人跟哪个预测师交谈
        		$redis ->HSET(  "uc_".$userId,DEFINE_SITE_ID, $teacherId);
        		
        		  $content  = "预测师".$teachername."加入对谈";
        	
            	self::system_chat($content );
        	}
        	
        	$teachername = $this->session->get("login_id");
        }else{
        	
        }
   
       	        //用户头像
	        $this->view->setVar('user_head_pic', $this->commonFunction->GetHeadUrl($userId));
	        //预测师头像
	        $this->view->setVar('teacher_head_pic', $this->commonFunction->GetHeadUrl($teacherId));
             if($curUserId ==$teacherId){
	      		  $this->view->setVar('isteacher',  1);
	         } else {
	       //用户的时候
			    $pages = array();
		        $this->doPages($pages ,1,100);
		        $sql = "call service_detail(". DEFINE_SITE_ID .",". $teacherId .",".$pages["begin"].",".$pages["rows"].");";
       			 $services = $this->dbHelper->QueryAll($sql);
                $this->view->setVar('services',$services);
	         }
	         
   		$this->view->setVar('curUserId',$curUserId );
        //用户名

        $this->view->setVar('name_user', $username);

    //
	        //当前用户的名字
	        $this->view->setVar('curUserid', $curUserId);
	      
 			$this->view->setVar('logged_in', $this->session->get("user_name"));
 			$this->view->setVar('teacherId',  $teacherId);
        //$hashcount = $redis->cmd('HLEN',$key_room)->get();
	        $hashcount =$redis->HLEN($key_room);
 
	        if (isset($_COOKIE['refresh']) && $_COOKIE['refresh']== $room) {
	        	  setcookie('refresh',null);

        } else{
	            setcookie('refresh',$room);
        }
        /*
	        $task_id = $this->request->get('task_id');
	        $this->view->setVar('room', $room);
	        $this->view->setVar('lang', $lang);
	        $this->view->setVar('lastmod', time() - $earlier * 60);
	
	        $this->view->setVar('touchs', $touchs);
	        $this->view->setVar('maxdisplay', $maxdisplay);
	        $this->view->setVar('least', $least);
	        $this->view->setVar('task_id', isset($task_id)==false?"-1":$task_id);
	        $this->view->setVar('ip', $this->commonFunction->get_ip());
	
	        $pay = new tbl_reward_task();
	        $pay = tbl_reward_task::findFirstBytask_id($task_id);
	        //聊天室title start
	        //根据任务ID获取订单ID
	        $order = tbl_order_dtl::findFirstByt_order_id($pay->order_id);
	        //订单ID
	        $this->view->setVar('order_id',sprintf("%08d", $pay->order_id));
	        //订单产生日期
	        $this->view->setVar('order_date', $order->trade_date);
	        //订单金额
	        $this->view->setVar('order_price', $order->ps_price);
	        //服务项目->任务名
	        $this->view->setVar('task_name', $pay->task_name);
	        //聊天室title end
	        $this->view->setVar('pay_reward', $pay->pay_reward);
	        $this->view->setVar('pay_to_user_id', $pay->tbl_order_dtl->pay_to_user_id);
         
        if ($task_id) {
            $this->view->setVar('taskTrue', true);
        } else {
            $this->view->setVar('taskTrue', false);
        }
        */
          $this->view->setVar('taskTrue', true);
          
          //---------------
          $json["roomstatus"] = Online::getRoomrStatues($teacherId,DEFINE_SITE_ID);
     
		$item =null;
		//$chatContent = $redis->HGETALL($key_room );
	
		$chatContent = $redis->zRange($key_room,0,-1);
		
	//	$redis->DELETE($key_room );
	//	$redis->DELETE($teacherKey );
		
  
	
		foreach ( $chatContent as  $key=> $content)
       {
       		 //分析行数据成为数组数据
       		 $item2  =   Online:: getContentArr($content);
       		 if  ($item2) {
       		 	$item[] = $item2;
       		 }else {
       		 	continue;
       		 }
        }
       
        $json["lines"] = $item;
  	
	
      // echo $this->commonFunction->array2json($json);
      //exit;
          $this->view->setVar('content', $this->commonFunction->array2json($json));      
    }
    
    
    
    public function nochatAction()
    {
    	

        if (isset ($_GET["roomstatus"])) {
            $this->view->setVar('roomstatus', $_GET["roomstatus"]);
              $this->view->setVar('teacherId', $_GET["tea"]);
        }
    }
    /**
     * Searches for users
     */
    public function writeAction()
    {
    	$this->log->InfoLog("ChatController"," writeAction","开始");
        global $redis, $room_onlines, $room;
    // $_POST = $_GET;
        $color = $_POST["color"];
        $color = "#" . $color;
        $size = intval($_POST["size"]);
        $name = htmlspecialchars(str_replace(array("\n", "\r"), "", $_POST['name']));
        if (!$name) die("No Name!!");
        $ip = $this->commonFunction->get_ip();


        $this->keeponline($redis, $room_onlines, $room);

        $s = "";

        $t = time();
        //$arr = explode("\n", $_POST['content']);

        $roomkey = 'room_' . $room ;
        //$setkey = $name. $t;
        $setkey = $t;
         $popuserroom  = 'u_' . $room;
        $popseverroom  = 's_' . $room;
        $content =  trim($_POST['content']);

        if (!$content) exit;
        
           $content = htmlspecialchars($content);
            $content = preg_replace("~\[img\](.*?)\[\/img\]~i", "<img style='width:300px' src='$1' />", $content);
            $content = preg_replace("~\[a href=(.*?)\](.*?)\[\/a\]~i", "<a href='#' onclick=\"downloadfile('$1')\"/>$2</a>", $content);
            $content = str_replace(":", "：", $content);
            //$name = "system";
            
            $Content =$t . "||3||" . $name . "||" . $content;
            $redis->ZADD($roomkey,$setkey,"0".$Content );  //0 两方 1  用户 2预测师
            
            $redis->LPUSH($popuserroom,$Content);
            $redis->LPUSH($popseverroom,$Content);
      //  }
        //禁言列表（可以放到配置文件）
    
        $illegal_words = '混蛋|滚蛋|MLGB|打到共产党|操你妈|傻逼|打到中国共产党|共匪';
        $word1 = preg_match('/'.$illegal_words.'/i',  $_POST['content']);
         if($word1>0){
         	  
                sleep(1);
                //self::system_chat("请注意言辞");
                self::system_chat("系统警告：请注意不要使用不文明语言",'warning' );
         }
        //echo $room;
        exit;

    }


/* system 系统消息
* warning 警告消息
* info 提示消息
* html 直接html形式
 */
    public function system_chat($sys_content, $username ='system' )
    {
    	$this->log->InfoLog("ChatController"," system_chat","开始");
        global $redis, $room_onlines, $room;
        $this->keeponline($redis, $room_onlines, $room);
        $t = time();
        //不能大于20行
       // $arr = explode("\n",$sys_content);

        //for ($i = 0; $i < count($arr); $i++) {
            $content =$sys_content;
            $content = trim($content);
          // $content = str_replace(array("\n", "\r"), "", $content);

            if (!$content) retrun;
            $content = htmlspecialchars($content);

            //  $content = preg_replace("~\[img\](.*?)\[\/img\]~i", "<img style='width:300px' src='$1' />", $content);
            // $content = preg_replace("~\[a href=(.*?)\](.*?)\[\/a\]~i", "<a href='#' onclick=\"downloadfile('$1')\"/>$2</a>", $content);
            $content = str_replace(":", "：", $content);

           // $redis->cmd('HSET', 'room_' . $room, $t, $t . "|".$username. ":" . $content)->set();
            //$redis->cmd('HSET', 'rooms_mod_time', 'room_' . $room, time())->set();

                $roomkey = 'room_' . $room ;
                //$setkey = 'system'. $t;
                $setkey =  $t;
                $popuserroom  = 'u_' . $room;
                $popseverroom  = 's_' . $room;
                $content = $t . "||1||".$username. "||" . $content;
                
	            $redis->ZADD($roomkey,$setkey,"0".$content ); //0 两方 1  用户 2预测师
	            $redis->LPUSH($popuserroom,$content);
	            $redis->LPUSH($popseverroom,$content);
            /*
             $redis->LPUSH($popuserroom,"aaaa");
                while ($redis->LLEN($popuserroom)>0) {


        $content = $redis->RPOP($popuserroom);
      echo $content."<br>";
            //echo "**".$content."**";;
        }
        */
      
   
        //}
    }

    public function readAction()
    {
       //echo "readAction";
        global $get_past_sec, $redis, $room, $least, $disonline, $touchme, $room_onlines;
       	$redis =$this->redis;
        $first = $_POST["first"];
        $key_room = 'room_' . $room;
        $idArray = explode("_", $room);
        $teacherId = $idArray[0];
//' roomstatus 0 不在线   2 预测师不在线 3  预测师忙碌
          $json = array();
        $json["roomstatus"] = Online::getRoomrStatues($teacherId,DEFINE_SITE_ID);
        $userId = $this->session->get("user_id");
        if ($userId==$teacherId) {
            $popuserroom  = 's_' . $room;
        }else{
            $popuserroom  = 'u_' . $room;
        }
		$item =null;
        while ($redis->LLEN($popuserroom)>0) {
       		 $content = $redis->RPOP($popuserroom);
       		 //分析行数据成为数组数据
       		 $item2  =   Online:: getContentArr($content);
       		 if  ($item2) {
       		 	$item[] = $item2;
       		 }else {
       		 	continue;
       		 }
    }
        /*
        $item2["word"] = addslashes("当你要往数据库中输入数据时");
        $item2["userid"] = "system";
        $item2["key"] = "12345";

        $item2["time"] = date("m-d H:i", time());
        $item[] =$item2;
*/



        $json["lines"] = $item;
        echo $this->commonFunction->array2json($json);
        exit;
    }

    public function enter_room_forteacher($teachername)
    {
        global $redis, $room_onlines, $room;
        
        $color = "#cccccc" ;
        $size = intval($_POST["size"]);
        $name = htmlspecialchars(str_replace(array("\n", "\r"), "",  $teachername));
        if (!$name) die("No Name!!");
        $ip = $this->commonFunction->get_ip();
        $this->keeponline($redis, $room_onlines, $room);
        $s = "";
        $style = "";
        $font = $_POST["font"];
        if ($font == "songti") $font = "宋体";
        else if ($font == "heiti") $font = "黑体";
        else if ($font == "kaiti") $font = "楷体_GB2312";
        else $font = "";
        $style .= (!$font) ? "" : "font-family:" . $font . ";";
        $style .= (!$_POST["bold"]) ? "" : "font-weight:bold;";
        $style .= (!$color || $color == "#") ? "" : "color:{$color};";
        $style .= (!$size || $size == "16") ? "" : "font-size:{$size}px;";
        $t = time();
        $arr = explode("\n", $_POST['content']);
      
        //不能大于20行
         $arr = explode("\n", $_POST['content']);
        for ($i = 0; $i < count($arr); $i++) {
            $content = $arr[$i];
            $content = trim($content);
            $content = str_replace(array("\n", "\r"), "", $content);

            if (!$content) continue;
            $content = htmlspecialchars($content);

          //  $content = preg_replace("~\[img\](.*?)\[\/img\]~i", "<img style='width:300px' src='$1' />", $content);
           // $content = preg_replace("~\[a href=(.*?)\](.*?)\[\/a\]~i", "<a href='#' onclick=\"downloadfile('$1')\"/>$2</a>", $content);
            $content = str_replace(":", "：", $content);
           
          //  $redis->cmd('HSET', 'room_' . $room, $t, $t . "|" . $name . ":" . $content)->set();
            //$redis->cmd('HSET', 'rooms_mod_time', 'room_' . $room, time())->set();
            
            $redis->ZADD('room_' . $room, $t, $t . "|" . $name . ":" . $content);
            
        }
    }




    public function keepAction()
    {
        global $room_onlines, $redis;
        $this-> keeponline($redis, $room_onlines, $_POST["room"]);
        echo "keep ok";
        exit;
    }

    public function quitAction()
    {
        global $disonline, $room_onlines, $room, $redis;
        $name = $_POST['name'];
        if ($disonline) {
            $users = $redis->cmd('HVALS', $room_onlines . $room)->get();
            foreach ($users as $l) {
                $l = str_replace(array("\r", "\n"), "", $l);
                if (strpos($l, "|") === false) {
                    $s .= $l . "\n";
                    continue;
                }
                $arr = explode("|", $l);
                if (trim($name) == trim($arr[2])) {
                    $redis->cmd('HDEL', $room_onlines . $room, "room_" . $name)->set();
                }
            }
            echo "OK";
        }
        die();
    }

    public function payAction($data)
    {
        $this->log->InfoLog("ChatController","payAction","支付开始");
        $teacherid =  $this->session->get("teacherid");


        $data = $this->commonFunction->getParam($_SERVER['HTTP_REFERER']);
        $room = $data['room_id'];
        $idArray = explode("_", $room);
        $tcherid = $idArray[0];
        if($teacherid == $tcherid)
        {
            $task_id = $this->request->getPost('task_id');
            $pay_reward = $this->request->getPost('pay_reward');
            $task = new tbl_reward_task();
            $order_id = tbl_reward_task::findFirstBytask_id($task_id);

            $order = new tbl_order_dtl();
            $order = tbl_order_dtl::findFirstByt_order_id($order_id->order_id);

            if($order->status == "0"){
                $user = new mst_user();
                $user = mst_user::findFirstByuser_id($teacherid);
                $order->assign(array(
                    'status' => 1,
                    'pay_to_user_id' => $teacherid,
                ));
                if (!$order->save()) {
                    $this->flash->error($order->getMessages());
                } else {
                    $user->assign(array(
                        'coin' => $user->coin + $order->ps_price,
                        'u_time' => date("Y-m-d H:i:s"),
                    ));
                    if (!$user->save()) {
                        $this->flash->error($user->getMessages());
                    } else {
                        $message = new tbl_message();
                        $userId = $this->session->get("user_id");
                        $message->assign(array(
                            'send_id' => -1,
                            'receive_id' => $userId,
                            'title' => "系统消息",
                            'message_status' => 1,
                            'message_content' => "你的订单" . $order_id->order_id . "已经交易成功",
                            'insert_time' => date("Y-m-d H:i:s"),
                            'insert_user_id' => -1,
                            'update_time' => date("Y-m-d H:i:s"),
                            'update_user' => -1
                        ));
                        if (!$message->save()) {
                            $this->flash->error($message->getMessages());
                        } else {
                            $this->redis -> cmd ( 'HSET', "msg_{$userId}","org","0" )-> cmd ( 'HSET', "msg_{$userId}","new","1" ) -> set ();
                            echo "ok";
                            exit;
                            Tag::resetInput();
                        }
                    }
                }
            }
        }
        else
        {
            echo "支付失败";
            exit;
        }
        $this->log->InfoLog("ChatController","payAction","支付结束");
    }

    public function evalAction($data)
    {
        $this->log->InfoLog("ChatController","evalAction","评价开始");
        $sorce = $this->request->getPost('sorce');
        $content = $this->request->getPost('content');
        $task_id = $this->request->getPost('task_id');

        $order_id = null;
        $reward_tasks = tbl_reward_task::findBytask_id($task_id);
        if (count($reward_tasks) > 0) {
            $order_id = $reward_tasks[0]->order_id;
        }

        $order = new tbl_order_dtl();
        $order = tbl_order_dtl::findFirstByt_order_id($order_id);
        $t_eval = new tbl_order_eva();
        $t_eval->assign(array(
            'order_id' => $order_id,
            'user_id'=> $order->user_id,
            'ps_id'=> $order->ps_id,
            'ps_user_id'=> $order->pay_to_user_id,
            'tdate' => date("Y-m-d H:i:s"),
            'eval_score' => $sorce,
            'eval_memo' => $content,
            'status' => '1'
        ));

        if ($t_eval->save()) {
            $message = new tbl_message();
            $userId = $this->session->get("user_id");
            $message->assign(array(
                'send_id' => -1,
                'receive_id' => $order->pay_to_user_id,
                'message_status' => 1,
                'message_content' => "顾客「" . $this->session->get("user_name") . "」已经对订单" . $order_id . "做出评价！(分数：" . $sorce . ")",
                'insert_time' => date("Y-m-d H:i:s"),
                'insert_user_id' => -1,
                'update_time' => date("Y-m-d H:i:s"),
                'update_user' => -1,
                'title' => '系统消息'
            ));

            if (!$message->save()) {
                $this->flash->error($message->getMessages());
            } else {
                $this->redis -> cmd ( 'HSET', "msg_{$order->pay_to_user_id}","org","0" )-> cmd ( 'HSET', "msg_{$order->pay_to_user_id}","new","1" ) -> set ();
                echo "ok";
                exit;
                Tag::resetInput();
            }
        } else {
            $this->flash->error($t_eval->getMessages());
        }
        $this->log->InfoLog("ChatController","evalAction","评价结束");
    }

    ///
    public function uploadAction()
    {
        $this->log->InfoLog("ChatController","uploadAction","上传开始");
        $config = include APP_DIR . '/config/config.php';

        $docPath = $config->application->uploadDir . $this->session->get('user_id') . "/";

        if ($this->request->isPost()) {
            if ($this->request->hasFiles() == true) {
                foreach ($this->request->getUploadedFiles() as $file) {
                    //Move the file into the application
                    if ($file->getSize() > 3145728) {
                        echo "<script>alert('文件的大小超过3M');</script>";
                    } else {
                        $type = array("gif", "jpg", "bmp", "png");
                        if (!in_array($file->getExtension(), $type)) {
                          //  $docPath = '../' . $config->application->docDir . $this->session->get('user_id') . "/";
                            $docPath = '../'.$config->application->docDir . $this->session->get('user_id') . "/";
                    }else
                        {

                        }
                        if (!is_dir($docPath)) {
                            mkdir($docPath, 777, true);
                        }
                        $rename = time() . "." . $file->getExtension();
                        $file->moveTo($docPath . $rename);
                        include APP_DIR . '/config/link.php';
                        if (in_array($file->getExtension(), $type)) {
                            echo json_encode(array("type" => "img", "path" => "[img]" . $site_url. $config->application->uploadPublic . $this->session->get('user_id') . "/" . $rename . "[/img]"));
                            exit;
                        } else {
                            echo json_encode(array("type" => "file", "filename" => $file->getName(), "path" => "$site_url/chat/download?path="  . $this->session->get('user_id') . "/" . $rename));
                            exit;
                        }
                    }
                }
            }
        }
        $this->log->InfoLog("ChatController","uploadAction","上传结束");
    }

    public function downloadAction($file_path)
    {
        $config = include APP_DIR . '/config/config.php';
        $this->log->InfoLog("ChatController","downloadAction","文件下载开始");
        $path = '../'.$config->application->docDir . $this->request->getPost('path', 'striptags');
        $this->commonFunction->downloadFile($path);
        $this->log->InfoLog("ChatController","downloadAction","文件下载结束");
    }

    public function teacherAction()
    {
    	 $this->CheckMustLogin("chat_teacher");
        $this->log->InfoLog("ChatController","teacherAction","预测师画面取得开始");
        $this->view->setVar('logged_in', $this->session->get("user_name"));
        setcookie('refresh',0);
        $teacherInfo = mst_user_service::find();
        $user_id = $this->session->get("user_id");
        $this->view->setVar('teacherInfo', $teacherInfo);
        $this->view->setVar('userId', $user_id);
        $this->log->InfoLog("ChatController","teacherAction","预测师画面取得结束");
    }
//--------------------------------------------------------------------------------------------------------------------//
    /**
     * 获取所有聊天室ID列表
     *
     */
    public function roomsAction()
    {
        global $redis;
        $alastmod = $redis->cmd('HKEYS', 'rooms_mod_time' )->get();
        echo  json_encode($alastmod);
        exit;
    }

    /**
     * 备份聊天记录（redis->file）
     */
    public function backupAction()
    {
        global $redis;
        //获取聊天室ID
        $current_room_id=$_GET["room_id"];
        $keyArray = $redis->cmd('HKEYS', $current_room_id)->get();
        sort($keyArray);
        //循环聊天记录，备份后删除该记录
        foreach ($keyArray as $key) {
            $chat_contents[] = $redis->cmd('HGET', $current_room_id, $key)->get();
            //删除聊天记录
            $redis->cmd('HDEL', $current_room_id,$key)->set();
        }
        //把聊天室的聊天记录，生成备份文件
        $file_name=$this->commonFunction->writefile($chat_contents,"当前聊天室ID:{$current_room_id}");
//-------------------------------------------------------------------------------------------------------------//
        //聊天记录下载
        $config = include APP_DIR . '/config/config.php';
        header('Content-type: application/txt');
        header("Content-Disposition: attachment; filename={$file_name}.txt");
        $this->log->InfoLog("ChatController","downloadAction","文件下载开始");
        //上一步备份的文件下载
        $path = $config->application->chat_backup.$file_name;
        $this->commonFunction->downloadFileForBackUp($path);
        $this->log->InfoLog("ChatController","downloadAction","文件下载结束");
        exit;
//-------------------------------------------------------------------------------------------------------------//
    }
//--------------------------------------------------------------------------------------------------------------------//

   public function adetailAction(){
	   	  global $redis, $room;
	       // $this->view->setVar('logged_in',$this->session->get("user_name") );
	        $this->view->setTemplateBefore('public');
	        $config = include APP_DIR . '/config/config.php';
	        if($this->request->isPost()){
	        	
	        }else{
	            $order_id = $_GET['order_id'];
	             if (!($order_id>0)){
	                $this->dispatcher->forward(array(
	                    "controller" => "chat",
	                    "action"       => "test"
	                ));
	                return ;
	            }else {
	            	 
	                //通过存储过程抽出评论和订单相关信息
	         $room = $_GET['room'];
	        
	         $roomkey = 'room_' . $room ;
	       // $setkey = $name. $t;
	        $setkey = $t;
	        $popuserroom  = 'u_' . $room;
	        $popseverroom  = 's_' . $room;
	        // $redis->HDEL($roomkey );
	         //  $redis->LPUSH($popuserroom,$Content);
	         // $redis->LPUSH($popseverroom,$Content);
	         // echo $room;
	                $idArray = explode("_", $room);
	                $teacherId = $idArray[0];
	                $userId = $idArray[1];
	                
	            }
	            //m需要么要讨论
	  
	  
	
	   $this->view->setVar('order',$order);
	//这块根据order_id 抽出所有评论
	 /*
	            if(isset($_GET['eval_id'])){
	                $ass = tbl_order_eva::findFirstByeval_id($_GET['eval_id']);
	                $this->view->setVar('ass',$ass);
	            }
	            */
	        }
    }

    /*
     * 测试评价
     */
    public function testAction(){
        global $redis;
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';
        $room = $_GET['room'];
        $comchat =  new Comchat();
        
        $idArray = explode("_", $room);
        $room_key ='room_'.$room;
        
        $teacherId = $idArray[0];
        $userId = $idArray[1];
        
        $teacherKey = "tn_".$teacherId;
       $arrvalus=$redis->HVALS( $room_key);
       foreach ( $arrvalus as $key => $value ) {
  			 $arrvalus[$key] = urlencode ( $value );
    	 }
      // echo urldecode ( json_encode ( $arrvalus ) );
       
        // $jsondata = json_encode($redis->HVALS( $room_key));
         $jsondata = urldecode ( json_encode ( $arrvalus ) );
        
      $jsondata = "\xEF\xBB\xBF".$jsondata;

         $key_room_begin = "B".$room_key;
         $begintime =  $redis->GET($key_room_begin );
         $begin_time =$begintime ? date("Y-m-d H:i:s",$begintime):date("Y-m-d H:i:s") ;

        
         $vals['user_id']        = $userId;
         $vals['ps_user_id']  = $teacherId;
         $vals['site_id']          = DEFINE_SITE_ID;
         $vals['start_time']    = $begin_time;
         
         $vals['end_time'] = date("Y-m-d H:i:s");
         $vals['eval_score'] = 5;
         $vals['status'] = 1; 
         $testID= $this->pdo->insertHS( "tbl_test",  $vals,  TRUE  );
         
        //$username = $this->pdo->getRow( "mst_user","user_id =$userId" ,"login_id"  );
       // $username = $redis->HGET('_usename', $user_id);
         $username =  Online:: getUserName ($userId,DEFINE_SITE_ID);
          $teachername =    Online:: getUserName ($teacherId,DEFINE_SITE_ID);
			   $fileobj = new FileOp();
			   $fileobj->OpenOrderFile($testID,  $userId,"test");
	   
   
		//	$chatContent = $redis->HGETALL($room_key );
			$chatContent = $redis->zRange($room_key,0,-1);
			$redis->DELETE($room_key );
			$redis->HDEL($teacherKey,$userId );
			
				
								echo "**";
				        		print_r($redis ->HGET($teacherKey,$userId));
			   echo "**";
				$teachatKey = "tc_".$teacherId;
				$redis->HDEL($teachatKey,$userId );
				echo "**";
				        		print_r($redis ->HGET($teachatKey,$userId));
			   echo "**";
		
		
		foreach ( $chatContent as  $key=> $content)
	       {
	       		 //分析行数据成为数组数据
	       		 $item2  =   Online:: getContentArr($content);
	       	/*	 
		       	 $item2["color"] = $arr[1]; //颜色
		        $item2["userid"] = $arr[2]; //用户名
		        $item2["word"] =$arr[3]; //交谈内容
		        $item2["key"] = $t; 
		        $item2["time"] = $t; //交谈时间
	        */
	        
	       		 if  ($item2) {
	       		 	 $dtime = date('Y-m-d H:i:s',  $item2["key"] );
	       		 	  $fileobj->WriteLineOrderFile($dtime."  ".  $item2["userid"] . " : ".$item2["word"]);
	       		 }else {
	       		 	continue;
	       		 }
	        }
	       
 
   
   $fileobj->CloseOrderFile();
   echo  "<br>".$testID;
   
/*
	$keypush = "zzstest";
	$redis->ZADD($keypush, 'A1', 'A1' );
	$redis->ZADD($keypush, 'C1', 'C1' );
	$redis->ZADD($keypush, 'B1', 'B1' );
	$redis->ZADD($keypush, 'D1', 'D1' );
   var_dump($redis->zRange($keypush,0,-1)); 
   */
 
        $this->view->setVar('chatid', $testID ); //测试号
	    $this->view->setVar('chatdate', $begin_time ); //测试时间
	    $this->view->setVar('chattea', $teachername ); //预测师名
	    $this->view->setVar('chatuser', $username ); //客户名
 
    }

    public function redisAction()
    {
        global $redis;
        print_r($redis->keys('*'));
    }

    public function listenAction($to_uid = ""){

        // 推送的url地址，上线时改成自己的服务器地址
        $push_api_url = "http://localhost:2121/";
        $post_data = array(
            "type" => "publish",
            "content" => "listcet",
            "to" => $to_uid,
        );
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $push_api_url );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
        curl_setopt ($ch, CURLOPT_HTTPHEADER, array("Expect:"));
        $return = curl_exec ( $ch );
        curl_close ( $ch );
        var_export($return);

        echo "ok";
    }

    public function socketAction(){

    }


}
