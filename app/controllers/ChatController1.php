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
        $redis =$this->redisHelper->getConnection();

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

        error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
        header("content-type:text/html; charset=utf-8");

        $get_past_sec = 3; //如果发现丢话，可以适当调大这个值
        $touchs = 10; //检查在线人数的时间间隔

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
        global $disonline, $datafile;
        if (!$disonline) return;
        $name = $_POST['name'];
        $ip = $this->commonFunction->get_ip();

        $onlines = $_redis->cmd('HVALS', $_room_onlines . $_room)->get();
        $onlines = implode("|", $onlines);

        $s1 = "|{$name}|{$ip}|";

        if (strpos($onlines, $s1) === false) {
            if (strpos($onlines, "|" . $name . "|") === false) {

                $_redis->cmd('HSET', $_room_onlines . $_room, "room_{$name}", time() . "|" . time() . $s1)->set();
            } else {
                echo "NAME";
            }
        }
    }


    /**
     * Default action, shows the search form
     */
    public function indexAction()
    {
        $message = new tbl_message();
        $receiveid = $this->request->getPost('user_id', 'striptags');

        $para = include APP_DIR . '/config/params.php';
        $tes = $para["publicMsg"];
        $message->assign(array(
            'send_id' => "-1",
            'title' => '系统消息',
            'receive_id' => 13,
            'message_status' => 1,
            //'message_content' => '你的预测任务,已经发布成功。预测任务名:<a href="/reward/detail/' . $taskPid . '">' . $taskName . '</a>',
            'message_content' =>"系统消息，预测师已进入交谈".date('y:m:d',time()),
            'insert_time' => date("Y-m-d H:i:s"),
            'insert_user_id' =>"2",
            'update_time' => date("Y-m-d H:i:s"),
            'update_user' => "2"
        ));

        $message->save();
        $this->redisHelper->getConnection() -> cmd ( 'HSET', "msg_13","org","0" )-> cmd ( 'HSET', "msg_13","new","1" ) -> set ();
    	
    	$this->CheckMustLogin("chat_index");

        $this->log->InfoLog("ChatController","indexAction","聊天画面取得开始");
        global $redis, $room_onlines, $room, $lang, $earlier, $touchs, $maxdisplay, $least;
        $this->view->setVar('logged_in', $this->session->get("user_name"));

        $this->view->setVar('title', "试测");
        
        $room =  $this->request->get('room_id');
        
        if  (empty($room)) {
	        $teacherId = $this->request->get('sid');
	        
	        if (empty($teacherId)){
	        	$teacherId = 0;
	        }
	        $userId = $this->session->get("user_id");

	         $room = $teacherId.'_'.$userId.'_'.DEFINE_SITE_ID;
        }else {
        	$idArray = explode("_", $room);
	        $teacherId = $idArray[0];
	        $userId = $idArray[1];
        }


	
        $userInfo = mst_user::findFirstByuser_id($userId);
        $teacherInfo = mst_user_service::findFirstByps_user_id($teacherId);
        $userteaInfo = mst_user::findFirstByuser_id($teacherId);
        $curUserId = $this->session->get("user_id");

        $this->view->setVar('curUserId',$curUserId );
        //预测师的名字
        $this->view->setVar('logged_teacher', $teacherInfo->user_name);
        if ($userId==$teacherId) {
            //echo "禁止同用户";
            $this->view->setVar('roomstatus', 1); //禁止同用户
           $this->dispatcher->forward(array(
            "controller" => "chat",
            "action" => "nochat"
         ));
            return ;

        }

         // 页面进行跳转
        if($curUserId !="$userId" && $curUserId !="$teacherId" )
        {
            include(APP_DIR."/config/link.php");
            $this->response->redirect("{$site_url}index/index");
        }
        
        //预测是登录的场合
        if($curUserId =="$teacherId"){
        	$teachername = $this->session->get("login_id");
            $_POST["color"]="gray";
            $_POST["size"]="12";
          //  $_POST['content']="预测师".$teachername."加入对谈";
            $content  = "预测师".$teachername."加入对谈";
            //self::enter_room_forteacher($teachername);
            self::system_chat($content );
        }
        //1 禁止同用户 2 预测师不在线 3`预测师忙碌 4 预测师拒绝与你交谈
        $user_status = Online::getUserStatues($teacherId,DEFINE_SITE_ID);
       if ($user_status == 0){
         $this->view->setVar('roomstatus', 2); // 2 预测师不在线
           $this->dispatcher->forward(array(
            "controller" => "chat",
            "action" => "nochat"
        ));
           return ;

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


        
         if($curUserId =="$teacherId"){
        //用户头像
        $this->view->setVar('user_head_pic', $this->commonFunction->GetHeadUrl($userId));
        //预测师头像
        $this->view->setVar('teacher_head_pic', $this->commonFunction->GetHeadUrl($teacherId));
         } else {
        //用户头像
        $this->view->setVar('teacher_head_pic', $this->commonFunction->GetHeadUrl($userId));
        //预测师头像
        $this->view->setVar('user_head_pic', $this->commonFunction->GetHeadUrl($teacherId));
         	
         }
         

        //当前用户的名字
        $this->view->setVar('curUser_name',  $this->session->get("login_id"));
        echo $this->session->get("login_id");
        
	  //  $this->view->setVar('curUser_name',  $this->session->get("user_name"));
      //  $para = include APP_DIR . '/config/params.php';
      //  $tes = $para["talkMsg"];
      //echo "000000000000";
      
        $tes = "{0}邀请你进入聊天室<a href= '/bbs_new/chat/index?room_id={1}_{2}_".DEFINE_SITE_ID .  " '>点击进入</a>";
        $tes   =  $this->commonFunction->format($tes,$this->session->get("user_name"),$teacherId,$userId);
        $msgtitle = "系统消息";
        $message = new tbl_message();
        $message->assign(array(
            'send_id' => -1,
            'receive_id' => $teacherId,
            'message_status' => 1,
            'title' => $msgtitle,
            'message_content' =>$tes,
            'insert_time' => date("Y-m-d H:i:s"),
            'insert_user_id' => -1,
            'update_time' => date("Y-m-d H:i:s"),
            'update_user' => -1
        ));
        $key_room = 'room_' . $room;
        $hashcount = $redis->cmd('HLEN',$key_room)->get();
        echo "##$hashcount#$key_room#";
        if (isset($_COOKIE['refresh']) && $_COOKIE['refresh']== $room) {
        	  setcookie('refresh',null);

        }
        else{

            setcookie('refresh',$room);
            if (!$message->save()) {
                $this->flash->error($message->getMessages());
                print_r($message->getMessages());
            } else {
                $this->redisHelper->getConnection() -> cmd ( 'HSET', "msg_{$teacherId}","org","0" )-> cmd ( 'HSET', "msg_{$teacherId}","new","1" ) -> set ();
                
                $this->log->InfoLog("ChatController","indexAction","DB表【tbl_message】数据保存成功");
                $this->flash->success("已经通知预测师，稍后为你服务。");
            }
        }
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
          $this->view->setVar('taskTrue', true);
        $this->log->InfoLog("ChatController","indexAction","聊天画面取得开始");
    }
    public function nochatAction()
    {
        if (isset ($_GET["roomstatus"])) {
            $this->view->setVar('roomstatus', $_GET["roomstatus"]);
        }
    }
    /**
     * Searches for users
     */
    public function writeAction()
    {
        global $redis, $room_onlines, $room;
       //  $_POST = $_GET;
        $color = $_POST["color"];
        $color = "#" . $color;
        $size = intval($_POST["size"]);
        $name = htmlspecialchars(str_replace(array("\n", "\r"), "", $_POST['name']));
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
        if (count($arr) > 20) die('error');
        for ($i = 0; $i < count($arr); $i++) {
            $content = $arr[$i];
            $content = trim($content);
            $content = str_replace(array("\n", "\r"), "", $content);

            if (!$content) continue;

            $content = htmlspecialchars($content);

            $content = preg_replace("~\[img\](.*?)\[\/img\]~i", "<img style='width:300px' src='$1' />", $content);
            $content = preg_replace("~\[a href=(.*?)\](.*?)\[\/a\]~i", "<a href='#' onclick=\"downloadfile('$1')\"/>$2</a>", $content);
            $content = str_replace(":", "：", $content);
            //$name = "system";
            $redis->cmd('HSET', 'room_' . $room, $t, $t . "|" . $name . ":" . $content)->set();
            $redis->cmd('HSET', 'rooms_mod_time', 'room_' . $room, time())->set();
        }
        //禁言列表（可以放到配置文件）

        $illegal_words = '混蛋|滚蛋|MLGB|打到共产党|操你妈|傻逼|打到中国共产党|共匪';
        $word1 = preg_match('/'.$illegal_words.'/i',  $_POST['content']);
         if($word1>0){
                sleep(1);
                //self::system_chat("请注意言辞");
                self::system_chat("系统警告：请注意不要使用不文明语言",'warning' );
         }
        echo $room;
        exit;
    }


/* system 系统消息
* warning 警告消息
* info 提示消息
* html 直接html形式
 */
    public function system_chat($sys_content, $username ='system' )
    {
        global $redis, $room_onlines, $room;
        $this->keeponline($redis, $room_onlines, $room);
        $t = time();
        //不能大于20行
        $arr = explode("\n",$sys_content);
        for ($i = 0; $i < count($arr); $i++) {
            $content = $arr[$i];
            $content = trim($content);
            $content = str_replace(array("\n", "\r"), "", $content);

            if (!$content) continue;
            $content = htmlspecialchars($content);

            //  $content = preg_replace("~\[img\](.*?)\[\/img\]~i", "<img style='width:300px' src='$1' />", $content);
            // $content = preg_replace("~\[a href=(.*?)\](.*?)\[\/a\]~i", "<a href='#' onclick=\"downloadfile('$1')\"/>$2</a>", $content);
            $content = str_replace(":", "：", $content);

            $redis->cmd('HSET', 'room_' . $room, $t, $t . "|".$username. ":" . $content)->set();
            $redis->cmd('HSET', 'rooms_mod_time', 'room_' . $room, time())->set();
        }
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
           
            $redis->cmd('HSET', 'room_' . $room, $t, $t . "|" . $name . ":" . $content)->set();
            $redis->cmd('HSET', 'rooms_mod_time', 'room_' . $room, time())->set();
        }
    }


    public function readAction()
    {
      //  echo "first";
        global $get_past_sec, $redis, $room, $least, $disonline, $touchme, $room_onlines;
        $first = $_POST["first"];
        $lastmod = intval($_POST["lastmod"]) - $get_past_sec; //得到两秒以内的所有发言，
        $key_room = 'room_' . $room;
        $alastmod = $redis->cmd('HGET', 'rooms_mod_time',$key_room)->get();

        $name = $_POST['name'];
        $name = str_replace("\n", "", $name);
//print_r($_POST);
  //      echo  "***************";
        $ip = $this->commonFunction->get_ip();

        $json = array();
        $json["lastmod"] = time();
       //1禁止同用户 2 预测师不在线 3预测师不愿意交谈
        $json["roomstatus"] =0;
        $idArray = explode("_", $room);
        $teacherId = $idArray[0];
        $user_status = Online::getUserStatues($teacherId,DEFINE_SITE_ID);
        if ($user_status == 0){
            $json["roomstatus"] =2; // 2 预测师不在线

        } elseif($user_status == 2){
            $json["roomstatus"] =3; // 2 预测师忙碌

        } elseif($user_status ==3){
            $json["roomstatus"] =3; // 2 预测师忙碌

        }

        $item = array();
        $color1 = "red";
        $color2 = "blue";

        $newonline = array();
        $offline = array();
        $keyArray = $redis->cmd('HKEYS', $key_room)->get();
        sort($keyArray);
        foreach ($keyArray as $key) {
            $lines[] = $redis->cmd('HGET', $key_room, $key)->get();
        }
        if ($alastmod >= $lastmod && !$first) {
            foreach ($lines as $l) {
                $item2 = array();
                $l = str_replace(array("\n", "\r"), "", $l);
                if (strpos($l, "|") === false) continue;
                $arr = explode("|", $l);
                $t = intval($arr[0]);
                if ($t >= $lastmod) {
                    //大于该时间段的留言取出
                    $item2["time"] = date("H:i:s", $t);
                    if ($arr[1]) {
                        $words = explode(":", $arr[1]);
                        $arr[1] = $words[1];
                        $item2["userid"] = $words[0];
                    }
                    $arr[1] = str_replace("：", ":", $arr[1]);
                    $item2["word"] = (addslashes($arr[1]));

                    $item[] = $item2;
                }
            }
        } else if ($first) {
            $item = array();
            $total = count($lines);
            for ($i = $total - 1; $i >= $total - $least; $i--) {
                if ($i <= 0) break;
                $item2 = array();
                $l = str_replace(array("\n", "\r"), "", $lines[$i]);
                if (strpos($l, "|") === false) continue;
                $arr = explode("|", $l);
                $t = intval($arr[0]);
                $item2["time"] = (date("m-d", time()) == date("m-d", $t)) ? date("H:i:s", $t) : date("m-d H:i", $t);
                if ($arr[1]) {
                    $words = explode(":", $arr[1]);
                    $arr[1] = $words[1];
                    $item2["userid"] = $words[0];
                }
                $arr[1] = str_replace("：", ":", $arr[1]);
                $item2["word"] = addslashes($arr[1]);
                $item[] = $item2;
            }
            $item = array_reverse($item);
        }

        $s = "";
        $nt = time();
        $onlines = array();
        if ($disonline && $touchme) {
            //读取用户数据
            $users = $redis->cmd('HVALS', $room_onlines . $room)->get();
            foreach ($users as $l) {
                $l = str_replace(array("\r", "\n"), "", $l);
                $arr = explode("|", $l);
                if ($nt - intval($arr[1]) < 60) {
                    if (trim($name) == trim($arr[2])) {
                        //如果是本人的话，时间更新
                        $s = $arr[0] . "|" . time() . "|" . $name . "|" . ($this->commonFunction->get_ip()) . "|";
                    } else {
                        //否则的话,原样输出另外人的时间
                        $s = $l;
                    }
                    if (empty($s) == false) {
                        $redis->cmd('HSET', $room_onlines . $room, 'room_' . $arr[2], $s)->set();
                    }
                    $onlines [] = htmlspecialchars($arr[2]);
                } else {
                    $redis->cmd('HDEL', $room_onlines . $room, 'room_' . $arr[2])->set();
                }
            }
            $json["onlines"] = $onlines;
        }
        $json["lines"] = $item;
        echo $this->commonFunction->array2json($json);
        exit;
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
                            $this->redisHelper->getConnection() -> cmd ( 'HSET', "msg_{$userId}","org","0" )-> cmd ( 'HSET', "msg_{$userId}","new","1" ) -> set ();
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
                $this->redisHelper->getConnection() -> cmd ( 'HSET', "msg_{$order->pay_to_user_id}","org","0" )-> cmd ( 'HSET', "msg_{$order->pay_to_user_id}","new","1" ) -> set ();
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
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        if($this->request->isPost()){

        }else{
            $order_id = $_GET['order_id'];
            if (!($order_id>0)){
                $this->dispatcher->forward(array(
                    "controller" => "chat",
                    "action" => "test"
                ));
                return ;
            }else {
                //通过存储过程抽出评论和订单相关信息
                $room = $_GET['room'];
                echo $room;
                $idArray = explode("_", $room);
                $teacherId = $idArray[0];
                $userId = $idArray[1];
            }


            //m需要么要讨论
            /*
            $this->view->setVar('m',$_GET['m']);
            if($_GET['m'] == 'first'){
                $order_first = tbl_order_dtl::findFirstByt_order_id($order_id);
                $order_first->status = 2;
                $order_first->save();

                $price = $order_first->ps_price;

            }
              */
            /*
if （isset($order_id)  && $order_id ）{
            $sql = "call ass_detail(".$order_id.");";
            $order = $this->dbHelper->QueryAll($sql);
            $this->view->setVar('order',$order);
}else {

}
*/
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
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';
        $room = $_GET['room'];
        echo $room;
        $idArray = explode("_", $room);
        $room_key ='room_'.$room;
        $teacherId = $idArray[0];
        $userId = $idArray[1];

        /*
        global $redis;
        $redis = $this->redisHelper->getConnection();
*/
        echo $room_key;

         $redis =$this->redis;;
        $redis->hset('test9999', 'key1', 'hello');
        $redis->delete('test9999');
        // $redis->delete($room_key);
      print_r($redis->keys('*'));
      // $redis->del('test');
        $ordertest =  array();
        $ordertest['t_order_id'] = 1;
        $ordertest['trade_date'] = date("Y-m-d H:i:s");;
        $ordertest['user_name'] = 1;
        $ordertest['ps_name'] = 1;
    }

}
