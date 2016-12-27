<?php
namespace Vokuro\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Vokuro\Forms\ChangePasswordForm;
use Vokuro\Forms\RewardForm;
use Vokuro\Models\db_reward_answer;
use Vokuro\Models\db_reward_task;
use Vokuro\Models\tbl_message;
use Vokuro\Models\mst_user_service;
use Vokuro\Models\tbl_apply_message;
use Vokuro\Models\tbl_order_dtl;
use Vokuro\Models\tbl_reward_task;
use Vokuro\Models\PasswordChanges;
use Phalcon\Session\Adapter;
use Vokuro\Models\m_common;
use Vokuro\Models\mst_user;
use Vokuro\Models\tbl_property_dtl;

/**
 * Vokuro\Controllers\RewardController
 * CRUD to manage task
 */
class RewardController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setVar('logged_in', $this->session->get("user_name"));
        $this->view->setTemplateBefore('private');
        include APP_DIR . '/config/link.php';
    }

    /**
     * Default action, shows the search form
     */
    public function indexAction()
    {
        $this->persistent->conditions = null;

        $this->view->form = new RewardForm();
    }

    /**
     * 发布任务一览取得
     */
    public function searchAction()
    {
        $this->view->setVar('logged_in', $this->session->get("user_name"));
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        if(isset($_GET['p'])){
            $this->doPages($pages ,$_GET['p'],15);
        }else{
            $this->doPages($pages ,1,15);
        }
        
        

        $tasks = new db_reward_task();
        $condition = 'site_id = '.DEFINE_SITE_ID;
        $order = 'insert_time';
        $limit = array($pages['begin'],$pages['rows']);
        $flg = 1;
        //分页
        $count = $tasks->count($condition);
        $end = ceil ($count/$pages["rows"]); //分页
        //$reward_task = $tasks->getAllUser('',$condition,$order,$limit,$flg);
        $reward_task = $tasks->searchAll($order,$limit,$flg); //获取task数据

        $condition = 'task_status = 0 and site_id = '.DEFINE_SITE_ID;
        $order = 'pay_reward';
        $limit = '9';
        $flg = 1;
        $reward_head = $tasks->getAllUser('',$condition,$order,$limit,$flg); //获取热门人物数据

        $line1 = array();
        $line2 = array();
        $line3 = array();
        $exist = 0;
        foreach($reward_head as $head){
            if($head['task_id'] && $exist < 3){
                $line1[] = $head;
            }elseif($head['task_id'] && $exist < 6){
                $line2[] = $head;
            }else{
                $line3[] = $head;
            }
            $exist++;
        }
        $reward_head = array($line1,$line2,$line3);

        $this->view->reward_head = $reward_head;
        $this->view->reward_task = $reward_task;

        $url_page = $this->getUrl().'/reward/search';
        $this->view->setVar('url_page',$url_page);
        $this->view->setVar('end',$end);
        $this->view->setVar('count',$count);
        $this->view->setVar('current',$pages['current']);
    }

    /**
     * 赏金任务详细信息
     */
    public function detailAction($task_id){
        $this->view->setVar('logged_in', $this->session->get("user_name"));
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $task = new db_reward_task();
        $task_mes = $task->searchOne($task_id);
        $pro = $task->getTaskPro($task_id);
        $this->view->setVar('task_mes',$task_mes);
        $this->view->setVar('pro',$pro);

        $user_id = $this->session->get("user_id");
        $this->view->user_id = $user_id;

        $answer = new db_reward_answer();

        $this->view->sucessFlg = 0;
        if($this->request->isPost()){
            try{
                $answer->begin();

                $status = $_POST['status'];
                if($status){
                    $answer_id1 = $_POST['answer_id1'];
                    $answer_id2 = $_POST['answer_id2'];
                    $answer_id3 = $_POST['answer_id3'];
                    $answer_id4 = $_POST['answer_id4'];
                    $answer_id5 = $_POST['answer_id5'];
                    $level = $_POST['level'];
                    $content = $_POST['content'];

                    $tName = "tbl_reward_answer";
                    //$fields = array('task_id','user_id','level','content','c_time','c_user','u_time','u_user','answer_id1','answer_id2','answer_id3','answer_id4','answer_id5');
                    //$vals = array($task_id,$user_id,$level,$content,date("Y-m-d H:i:s"),$user_id,date("Y-m-d H:i:s"),$user_id,$answer_id1,$answer_id2,$answer_id3,$answer_id4,$answer_id5);
                    //$id = $answer->insert($tName,$fields,$vals,true);
                    $saveData = array(
                        'task_id' => $task_id,
                        'user_id' => $user_id,
                        'level' => $level,
                        'content' => $content,
                        'c_time' => date("Y-m-d H:i:s"),
                        'c_user' => $user_id,
                        'u_time' => date("Y-m-d H:i:s"),
                        'u_user' => $user_id,
                        'answer_id1' => $answer_id1,
                        'answer_id2' => $answer_id2,
                        'answer_id3' => $answer_id3,
                        'answer_id4' => $answer_id4,
                        'answer_id5' => $answer_id5,
                    );
                    $id = $answer->insertHS($tName,$saveData,true);
                    switch($level){
                        case 1:
                            $answer->updateAnId($id,'answer_id2');
                            break;
                        case 2:
                            $answer->updateAnId($id,'answer_id3');
                            break;
                        case 3:
                            $answer->updateAnId($id,'answer_id4');
                            break;
                        case 4:
                            $answer->updateAnId($id,'answer_id5');
                            break;
                    }
                }else{
                    $content = $_POST['content'];
                    $tName = "tbl_reward_answer";
                    //$fields = array('task_id','user_id','level','content','c_time','c_user','u_time','u_user','answer_id1','answer_id2','answer_id3','answer_id4','answer_id5');
                    //$vals = array($task_id,$user_id,0,$content,date("Y-m-d H:i:s"),$user_id,date("Y-m-d H:i:s"),$user_id,0,0,0,0,0);
                    //$id = $answer->insert($tName,$fields,$vals,true);
                    $saveData = array(
                        'task_id' => $task_id,
                        'user_id' => $user_id,
                        'level' => 0,
                        'content' => $content,
                        'c_time' => date("Y-m-d H:i:s"),
                        'c_user' => $user_id,
                        'u_time' => date("Y-m-d H:i:s"),
                        'u_user' => $user_id,
                        'answer_id1' => 0,
                        'answer_id2' => 0,
                        'answer_id3' => 0,
                        'answer_id4' => 0,
                        'answer_id5' => 0,
                    );
                    $id = $answer->insertHS($tName,$saveData,true);
                    $answer->updateAnId($id,'answer_id1');
                }

                $answer->commit();
            }catch (\Exception $e){
                $answer->rollback();
            }
        }
        $conditiong = "level = 0 and task_id = ".$task_id;
        $count = $answer->countByTaskid($conditiong);
        $p=isset($_GET['p'])?$_GET['p']:1;
        $this->doPages($pages ,$p,5);



        $url_page = $this->getUrl().'/reward/detail/'.$task_id;
        $end = ceil ($count/$pages["rows"]);
        $this->view->setVar('url_page',$url_page);
        $this->view->setVar('end',$end);
        $this->view->setVar('count',$count);
        $this->view->setVar('current',$pages['current']);

        $answers = $answer->getByTaskId($task_id,$pages["begin"],$pages["rows"]);
        $i = 0;
        foreach($answers as $an){
            //$subAnswer = $answer->getAll('tbl_reward_answer','',$condition,$order);
            $subAnswer = $answer->getByLevel($task_id,$an['answer_id1']);
            $answers[$i]['subAnswer'] = $subAnswer;
            if($subAnswer){
                $answers[$i]['sub_flg'] = 1;
            }else{
                $answers[$i]['sub_flg'] = 0;
            }
            $i ++;
        }

		$this->view->setVar('task_id',$task_id);
        $this->view->setVar('answers',$answers);
        $span_style = "text-indent: 2em;";
        $this->view->setVar('span_style',$span_style);

        //管理员账号预留
        $flg = 0;
        $this->view->flg = $flg;
        //任务发布人
        $condition = "task_id = ".$task_id;
        $pUser_id = $task->getRow("tbl_reward_task",$condition,"user_id");
        if($user_id == $pUser_id){
            $pFlg = 1;
        }else{
            $pFlg = 0;
        }
        $this->view->pFlg = $pFlg;
    }

    /**
     * end任务结算
     */
    public function endAction($task_id){
        $this->view->setVar('logged_in', $this->session->get("user_name"));
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $task = new db_reward_task();
        $task_mes = $task->searchOne($task_id);

        $user_id = $this->session->get("user_id");
        //安全性预留，判断是否是任务发布人，是否有预测师回复，防止直接走url进入页面
        if($user_id != $task_mes[0]['user_id']){
            echo 'error';
            exit;
            //$user_id = $task_mes[0]['user_id'];
        }

        $answer = new db_reward_answer();
        $answers = $answer->getEnd($task_id);

        if($this->request->isPost()){
            try{
                $task->begin();

                $fieldVal = array(
                    'task_status' => 2
                );
                $condition = "task_id = ".$task_id;
                $task->update('tbl_reward_task',$fieldVal,$condition);

                $property = $task->getRow('tbl_property_dtl','user_id = '.$user_id);
                $fieldVal = array(
                    'remain_coin' => $property['remain_coin'] - $task_mes[0]['pay_reward'],
                    'freeze_coin' => $property['freeze_coin'] + $task_mes[0]['pay_reward']
                );
                $condition = 'user_id = '.$user_id;
                $task->update('tbl_property_dtl',$fieldVal,$condition);

                foreach($_POST as $k => $val){
                    //var_dump($k);
                    //var_dump($val);
                    $price = $task_mes[0]['pay_reward'] * $val / 100;
                    //$fields = array('task_id','ps_site_id','user_id','ps_id','site_id','ps_price','status','trade_date','flg','pay_to_user_id','delete_flg');
                    //$vals = array($task_id,0,$user_id,0,DEFINE_SITE_ID,$price,2,date('Y-m-d H:i:s',time()),1,$k,1);
                    //$task->insert('tbl_order_dtl',$fields,$vals);
                    $saveData = array(
                        'task_id' => $task_id,
                        'ps_site_id' => 0,
                        'user_id' => $user_id,
                        'ps_id' => 0,
                        'site_id' => DEFINE_SITE_ID,
                        'ps_price' => $price,
                        'status' => 2,
                        'trade_date' => date('Y-m-d H:i:s',time()),
                        'flg' => 1,
                        'pay_to_user_id' => $k,
                        'delete_flg' => 1,
                    );
                    $task->insertHS("tbl_order_dtl",$saveData);
                }

                $task->commit();
            }catch (\Exception $e){
                $task->rollback();
                echo 'error';
            }
        }

        if($task_mes[0]['task_status'] == 2){
            $answers = $answer->getEndPro($task_id);
        }

        $this->view->setVar('task_mes',$task_mes);
        $this->view->setVar('answers',$answers);
    }

    /**
     * Creates a User
     */
    public function createAction()
    {

    }

    /**
     * 发布任务受理
     */
    public function acceptAction($task_id)
    {
        $this->log->InfoLog("RewordController","acceptAction","赏金求测受理开始");
        $this->log->InfoLog("RewordController","acceptAction",$task_id);
        $para = include APP_DIR . '/config/params.php';
        $this->view->setTemplateBefore('public');
        $user = tbl_reward_task::findFirstBytask_id($task_id);
        if (!$user) {
            $this->flash->error("Task was not found");
            $this->log->InfoLog("RewordController","acceptAction","Task was not found");
            return $this->dispatcher->forward(array(
                'action' => 'index'
            ));
        }
        if ($this->request->isGet()) {
            $user->assign(array(
                'task_status' => 1,
                'update_time' => date("Y-m-d H:i:s"),
            ));

            if (!$user->save()) {
                $this->flash->error($user->getMessages());
                $this->log->InfoLog("RewordController","acceptAction",$user->getMessages());
            } else {
                $this->flash->success("Task was updated successfully");
                $this->log->InfoLog("RewordController","acceptAction","DB表【tbl_reward_task】数据保存成功");
                $this->log->InfoLog("RewordController","acceptAction",$user);
                Tag::resetInput();
            }

            $userId = $this->session->get("user_id");
            $userName = $this->session->get("user_name");
            $order = tbl_order_dtl::findFirstByt_order_id($user->order_id);
            $order->assign(array(
                'pay_to_user_id' => $userId,
            ));
            if (!$order->save()) {
                $this->log->InfoLog("RewordController","applyAction",$order->getMessages());
                $this->flash->error();
            } else {
                $this->log->InfoLog("RewordController","applyAction","DB表【tbl_order_dtl】数据保存成功");
                $this->log->InfoLog("RewordController","applyAction",$order);
                $this->flash->success("Order was created successfully");
                Tag::resetInput();
                $message = new tbl_message();

                $acceptMsg = $para["acceptMsg"];
                $receiveid = $user->user_id;
                $message->assign(array(
                    'send_id' => -1,
                    'receive_id' => $receiveid,
                    'message_status' => 1,
                    'title' => "系统消息",
//                    'message_content' => "你发布的任务：<a href=" . "\"/reward/detail/" . $user->user_id .
//                        "\">" . $user->task_name . "</a>已经被<a href=" . "\"/chat/index?room_id=" . $userId . "_".$user->user_id .
//                        "&task_id=".$task_id . "\">" . $userName . "</a>受理。",
                    'message_content' =>  $this->commonFunction->format($acceptMsg,$user->user_id,$user->task_name,$userId,$user->user_id,$task_id,$userName),
                    'insert_time' => date("Y-m-d H:i:s"),
                    'insert_user_id' => $userId,
                    'update_time' => date("Y-m-d H:i:s"),
                    'update_user' => $userName
                ));
                if (!$message->save()) {
                    $this->log->InfoLog("RewordController","applyAction",$order->getMessages());
                    $this->flash->error($message->getMessages());
                } else {
                    $this->log->InfoLog("RewordController","applyAction","DB表【tbl_message】数据保存成功");
                    $this->log->InfoLog("RewordController","applyAction",$message);
                    $this->redisHelper->getConnection() -> cmd ( 'HSET', "msg_{$receiveid}","org","0" )-> cmd ( 'HSET', "msg_{$receiveid}","new","1" ) -> set ();
                    $this->flash->success("Message was created successfully");
                    Tag::resetInput();
                    $messagetea = new tbl_message();
                    $msg = $para["accepMsgSys"];
                    $messagetea->assign(array(
                        'send_id' => -1,
                        'receive_id' => $userId,
                        'message_status' => 1,
                        'title' => "系统消息",
//                        'message_content' => "任务：<a href=" . "\"/reward/detail/" . $user->user_id .
//                            "\">" . $user->task_name . "</a>受理成功.<a href=" . "\"/chat/index?room_id=" . $userId . "_".$user->user_id .
//                             "\">" . "  点击进入聊天室" . "</a>。",
                        'message_content' =>  $this->commonFunction->format($msg,$user->user_id,$user->task_name,$userId,$user->user_id),
                            'insert_time' => date("Y-m-d H:i:s"),
                        'insert_user_id' => -1,
                        'update_time' => date("Y-m-d H:i:s"),
                        'update_user' => -1
                    ));
                    if (!$messagetea->save()) {
                        $this->log->InfoLog("RewordController","applyAction",$order->getMessages());
                        $this->flash->error($messagetea->getMessages());
                    }else{
                        $this->log->InfoLog("RewordController","applyAction","DB表【tbl_message】数据保存成功");
                        $this->log->InfoLog("RewordController","applyAction",$messagetea);
                        $this->redisHelper->getConnection() -> cmd ( 'HSET', "msg_{$userId}","org","0" )-> cmd ( 'HSET', "msg_{$userId}","new","1" ) -> set ();
                        $this->flash->success("Message was created successfully");
                        Tag::resetInput();
                    }
                }
            }
        }
        $this->flash->success("受理成功");
        $this->log->InfoLog("RewordController","acceptAction","赏金求测受理结束");
        include(APP_DIR."/config/link.php");
        return $this->response->redirect("{$site_url}reward/search");

    }

    /**
     * 资料下载
     *
     */
    public function downloadAction()
    {
        $this->log->InfoLog("RewordController","downloadAction","资料下载开始");
        $path = "";
        $taskid = $this->request->get("taskid");
        $file = $this->request->get("file");
        $task = new tbl_reward_task();
        $task = tbl_reward_task::findFirstBytask_id($taskid);

        if ($file == "1") {
            $path = $task->file1_path;
        } elseif ($file == "2") {
            $path = $task->file2_path;
        } elseif ($file == "3") {
            $path = $task->file3_path;
        }
        $this->commonFunction->downloadFile($path);
        $this->log->InfoLog("RewordController","downloadAction","资料下载结束");
    }
//
//    /**
//     * 任务明细
//     *
//     * @param int $task_id 任务ID
//     */
//    public function detailAction($task_id)
//    {
//        include APP_DIR . '/config/link.php';
//        $this->view->setVar('logged_in', $this->session->get("user_name"));
//        $this->view->setVar('site_url', $site_url);
//        $this->view->setTemplateBefore('public');
//        $user = tbl_reward_task::findFirstBytask_id($task_id);
//        if (isset($user->file1_path)) {
//            $user->file1_path = basename($user->file1_path);
//        }
//        if (isset($user->file2_path)) {
//            $user->file2_path = basename($user->file2_path);
//        }
//        if (isset($user->file3_path)) {
//            $user->file3_path = basename($user->file3_path);
//        }
//        if (!$user) {
//            $this->flash->error("Task was not found");
//            return $this->dispatcher->forward(array(
//                'action' => 'index'
//            ));
//        }
//        $this->view->reward = $user;
//        $teacher = mst_user_service::find("flg = 1 and user_name = '". $this->session->get("user_name")."'");
//        if (count($teacher) > 0) {
//            $this->view->tflg = $teacher;
//        }else{
//            $this->view->tflg = null;
//        }
//
//        // 任务发布者的场合，显示预测师申请情报
//        $numberPage = 1;
//        if ($this->request->isPost()) {
//            $query = Criteria::fromInput($this->di, 'Vokuro\Models\tbl_apply_message', $this->request->getPost());
//            $this->persistent->searchParams = $query->getParams();
//        } else {
//            $numberPage = $this->request->getQuery("page", "int");
//        }
//
//        $parameters = array();
//        if ($this->persistent->searchParams) {
//            $parameters = $this->persistent->searchParams;
//        }
//
//        $apply_message = new tbl_apply_message();
//        $userId = $this->session->get("user_id");
//       if($user->user_id == $userId){
//           $apply_message = tbl_apply_message::find("task_id = '".$task_id."' order by apply_time desc");
//           $this->view->userShow = true;
//           $this->view->apply_message = $apply_message;
//           if (count($apply_message) == 0) {
//               $this->view->page = null;
//           }
//       }else{
//           $this->view->userShow = false;
//           $this->view->apply_message = $apply_message;
//       }
//
//        $paginator = new Paginator(array(
//            "data" => $apply_message,
//            "limit" => 5,
//            "page" => $numberPage
//        ));
//        $this->view->form = new RewardForm($user, array(
//            'edit' => true
//        ));
//
//        $this->view->action = "{$site_url}reward/detail/".$task_id;
//        $this->view->page = $paginator->getPaginate();
//
//    }

    public function testAction()
    {
        $para = include APP_DIR . '/config/params.php';
        $task_id = $this->request->get("task_id");
        $ps_user_id = $this->request->get("ps_user_id");
        $this->session->set("teacherid",$ps_user_id);
        $userId = $this->session->get("user_id");
        $userName = $this->session->get("user_name");

        $messagetea = new tbl_message();
        $tes = $para["talkMsg"];
        $messagetea->assign(array(
            'send_id' => -1,
            'receive_id' => $ps_user_id,
            'message_status' => 1,
            'title' => "系统消息",
            'message_content' => $this->commonFunction->format($tes,$userName,$ps_user_id,$userId),
            'insert_time' => date("Y-m-d H:i:s"),
            'insert_user_id' => -1,
            'update_time' => date("Y-m-d H:i:s"),
            'update_user' => -1
        ));
        if (!$messagetea->save()) {
            $this->log->InfoLog("RewordController","testAction",$messagetea->getMessages());
            $this->flash->error($messagetea->getMessages());
        }else{
            $this->log->InfoLog("RewordController","testAction","DB表【tbl_message】数据保存成功");
            $this->log->InfoLog("RewordController","testAction",$messagetea);
            $this->redisHelper->getConnection() -> cmd ( 'HSET', "msg_{$ps_user_id}","org","0" )-> cmd ( 'HSET', "msg_{$ps_user_id}","new","1" ) -> set ();
            $this->flash->success("Message was created successfully");
            Tag::resetInput();
            include(APP_DIR."/config/link.php");
            return $this->response->redirect("{$site_url}chat/index?room_id=".$ps_user_id. "_". $userId. "&task_id=".$task_id);
         }
    }

    /*
     * 发布任务
     */
    public function publicAction()
    {
        $this->view->setVar('logged_in', $this->session->get("user_name"));
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $this->CheckMustLogin("reward_public");

        $form = new RewardForm();
        if ($this->request->isPost()) {
            $this->log->InfoLog("RewordController","publicAction","赏金任务发布开始");
            if ($form->isValid($this->request->getPost()) != false) {
                $arrayPath = array();
                if ($this->request->hasFiles() == true) {
                    foreach ($this->request->getUploadedFiles() as $file) {
                        if ($file->getSize() > 3145728) {
                            echo "<script>alert('文件的大小超过3M');</script>";
                            $this->log->InfoLog("RewordController","publicAction",$file->getName()."文件的大小超过3M");
                        } else {
                            $docPath = $config["application"]["documentDir"] . $this->session->get('user_id') . "/";
                            if (!is_dir($docPath)) mkdir($docPath);
                            $file->moveTo($docPath . $file->getName());
                            array_push($arrayPath, $docPath . $file->getName());
                        }
                    }
                }
                $money = $this->request->getPost('pay_reward');
                //$user = mst_user::findFirstByuser_id($this->session->get('user_id'));
				$task = new db_reward_task();
				
				try{
					$task->begin();
					
					$property = $task->getRow('tbl_property_dtl','user_id = '.$this->session->get('user_id'));
					$remain_coin = $property['remain_coin'];
					if($money > $remain_coin){
						$this->flash->error('帐号余额不足!');
						$this->log->InfoLog("RewordController","publicAction","帐号余额不足!");
						return $this->dispatcher->forward(array(
							'action' => 'public'
						));
					}else{
						$fieldVal = array(
							'remain_coin' => $property['remain_coin'] - $money,
							'freeze_coin' => $property['freeze_coin'] + $money
						);
						$condition = 'user_id = '.$this->session->get('user_id');
						$task->update('tbl_property_dtl',$fieldVal,$condition);
						$this->log->InfoLog("RewordController","publicAction","DB表【mst_user】数据保存成功");
					}
					
					$saveData = array(
                        'user_id' => $this->session->get('user_id'),
                        'big_catagory' => $this->request->getPost('big_catagory'),
                        'small_catagory' => $this->request->getPost('small_catagory'),
                        'task_name' => $this->request->getPost('task_name'),
                        'task_remark' => $this->request->getPost('task_remark'),
                        'reward_type' => $this->request->getPost('pay_type'),
                        'pay_reward' => $this->request->getPost('pay_reward'),
                        'other_remark' => $this->request->getPost('other_remark'),
                        'task_status' => 1,
                        'time_limit' => $this->request->getPost('time_limit'),
						'insert_time' => date('Y-m-d H:i:s',time()),
						'insert_user_id' => $this->session->get('user_id'),
						'site_id' => DEFINE_SITE_ID,
						'file1_path' => isset($arrayPath[0]) ? $arrayPath[0] : "",
						'file2_path' => isset($arrayPath[1]) ? $arrayPath[1] : "",
						'file3_path' => isset($arrayPath[2]) ? $arrayPath[2] : ""
                    );
                    $task_id = $task->insertHS("tbl_reward_task",$saveData,true);
					$this->log->InfoLog("RewordController","publicAction","DB表【tbl_reward_task】数据保存成功");
                    $this->log->InfoLog("RewordController","publicAction",$tasks);
					
					$task->commit();
					
					include APP_DIR . '/config/link.php';
                    $this->response->redirect("{$site_url}reward/detail/".$task_id);
					
				}catch (\Exception $e){
					$task->rollback();
					echo $e->getmessage();
				}
				/*
                $message = new tbl_message();
                $receiveid = $this->request->getPost('user_id', 'striptags');
                $para = include APP_DIR . '/config/params.php';
                $tes = $para["publicMsg"];
                $message->assign(array(
                    'send_id' => "-1",
                    'title' => '系统消息',
                    'receive_id' => $receiveid,
                    'message_status' => 1,
                    //'message_content' => '你的预测任务,已经发布成功。预测任务名:<a href="/reward/detail/' . $taskPid . '">' . $taskName . '</a>',
                    'message_content' => $this->commonFunction->format($tes,$taskPid,$taskName),
                    'insert_time' => date("Y-m-d H:i:s"),
                    'insert_user_id' => $this->request->getPost('user_id', 'striptags'),
                    'update_time' => date("Y-m-d H:i:s"),
                    'update_user' => $this->session->get("user_name")
                ));

                if (!$message->save()) {
                    $this->log->InfoLog("RewordController","publicAction",$user->getMessages());
                    $this->flash->error($message->getMessages());
                } else {
                    $this->log->InfoLog("RewordController","publicAction","DB表【tbl_message】数据保存成功");
                    $this->log->InfoLog("RewordController","publicAction",$message);
                    $this->redisHelper->getConnection() -> cmd ( 'HSET', "msg_{$receiveid}","org","0" )-> cmd ( 'HSET', "msg_{$receiveid}","new","1" ) -> set ();
                    $this->flash->success("Message was created successfully");
                    include APP_DIR . '/config/link.php';
                    $this->response->redirect("{$site_url}reward/search");
//                    Tag::resetInput();
                }
				*/
            }else{
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                    $this->log->InfoLog("RewardController","publicAction","赏金只能是数字");
                }
            }
            $this->log->InfoLog("RewordController","publicAction","赏金任务发布结束");
        }
        $this->view->form = $form;
    }

    //获取小分类
    public function  smallClassAction($pid)
    {
        $this->log->InfoLog("RewordController","smallClassAction","获取小分类开始");
        $result = m_common::find("type_pid = $pid AND type_id = '101'");
        $opt = "<option value=''>...</option>";
        for ($i = 0; $i < count($result); $i++) {
            $id = $result[$i]->id;
            $name = $result[$i]->item_name;
            $opt .= "<option value=" . $id . ">$name</option>";
        }
        $this->log->InfoLog("RewordController","smallClassAction","获取小分类结束");
        echo $opt;
        exit;
    }

    //上传文件
    public function uploadFileAction($form, $docPath)
    {
        $this->log->InfoLog("RewordController","smallClassAction","上传文件开始");
        if ($this->request->isPost()) {
            if ($form->isValid($this->request->getPost()) != false) {
                if ($this->request->hasFiles() == true) {
                    foreach ($this->request->getUploadedFiles() as $file) {
                        //Move the file into the application
                        if ($file->getSize() > 3145728) {
                            echo "<script>alert('文件的大小超过3M');</script>";
                        } else {
                            if (!is_dir($docPath)) mkdir($docPath);
                            $file->moveTo($docPath . $file->getName());
                        }
                    }
                }
            }
        }
        $this->log->InfoLog("RewordController","smallClassAction","上传文件结束");
    }

    //编辑 任务
    public function editAction($taskId)
    {
        $this->log->InfoLog("RewordController","editAction","编辑任务开始");
        $this->view->setVar('logged_in', $this->session->get("user_name"));
        include(APP_DIR."/config/link.php");
        $this->view->setVar('site_url',$site_url);
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';
        $taskInfo = tbl_reward_task::findFirstBytask_id($taskId);
        if (isset($taskInfo->file1_path)) {
            $taskInfo->file1_path = basename($taskInfo->file1_path);
        }
        if (isset($taskInfo->file2_path)) {
            $taskInfo->file2_path = basename($taskInfo->file2_path);
        }
        if (isset($taskInfo->file3_path)) {
            $taskInfo->file3_path = basename($taskInfo->file3_path);
        }
        $form = new RewardForm();
        $this->view->form = $form;
        $this->view->taskInfo = $taskInfo;
        $this->log->InfoLog("RewordController","editAction","编辑任务结束");
    }

    public function updateAction()
    {
        $this->view->setVar('logged_in', $this->session->get("user_name"));
        $taskId = $this->request->getPost('task_id', 'striptags');

        include(APP_DIR."/config/link.php");
        $this->view->setVar('site_url',$site_url);

        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $taskInfo = tbl_reward_task::findFirstBytask_id($taskId);

        $form = new RewardForm();
        $arrayPath = array();
        if ($this->request->isPost()) {
            $this->log->InfoLog("RewordController","updateAction","赏金任务保存开始");
            if ($form->isValid($this->request->getPost()) != false) {
                $arrayPath = array();
                if ($this->request->hasFiles() == true) {
                    // Print the real file names and sizes
                    foreach ($this->request->getUploadedFiles() as $file) {
                        if ($file->getSize() > 3145728) {
                            echo "<script>alert('文件的大小超过3M');</script>";
                            $this->log->InfoLog("RewordController","updateAction",$file->getName()."文件的大小超过3M");
                        } else {
                            $docPath = $config["application"]["documentDir"] . $this->session->get('user_id') . "/";
                            if (!is_dir($docPath)) mkdir($docPath);
                            $file->moveTo($docPath . $file->getName());
                            array_push($arrayPath, $docPath . $file->getName());
                        }
                    }
                }
            }
        }
        $taskInfo->assign(array(
            'big_catagory' => $this->request->getPost('big_catagory', 'striptags'),
            'small_catagory' => $this->request->getPost('small_catagory', 'striptags'),
            'task_name' => $this->request->getPost('task_name', 'striptags'),
            'task_remark' => $this->request->getPost('task_remark', 'striptags'),
            'reward_type' => $this->request->getPost('pay_type', 'striptags'),
            'other_remark' => $this->request->getPost('other_remark', 'striptags'),
            'pay_reward' => $this->request->getPost('pay_reward', 'striptags'),
            'file1_path' => isset($arrayPath[0]) ? $arrayPath[0] : $taskInfo->file1_path,
            'file2_path' => isset($arrayPath[1]) ? $arrayPath[1] : $taskInfo->file2_path,
            'file3_path' => isset($arrayPath[2]) ? $arrayPath[2] : $taskInfo->file3_path,
            'time_limit' => $this->request->getPost('time_limit', 'striptags')
        ));
        if (!$taskInfo->save()) {
            $this->flash->error($taskInfo->getMessages());
            $this->flash->success($taskInfo->getMessages());
        } else {
            $this->log->InfoLog("RewordController","updateAction","DB表【tbl_reward_task】数据保存成功");
            $this->log->InfoLog("RewordController","updateAction",$taskInfo);
            $this->flash->success("Task was updated successfully");
            $this->response->redirect("{$site_url}reward/search");
        }
        $this->log->InfoLog("RewordController","updateAction","赏金任务保存结束");
    }

    function  applyAction()
    {
        $appInfo = new tbl_apply_message ;

        $task_id = $this->request->getPost('task_id');
        $ps_user_id = $this->session->get("user_id");
        $apply_memo = $this->request->getPost('apply_memo');
        $apply_memo_br = nl2br($apply_memo);

        $appInfo->assign(array(

            'task_id' => $task_id,
            'ps_user_id' => $ps_user_id,
            'apply_memo' => $apply_memo_br,
            'apply_time' => date("Y-m-d H:i:s")

        ));

        if (!$appInfo->save()) {
            $this->flash->error($appInfo->getMessages());
            $this->flash->success($appInfo->getMessages());
        } else {
            $this->log->InfoLog("RewordController","applyAction","DB表【tbl_apply_message】数据保存成功");
            $this->log->InfoLog("RewordController","applyAction",$appInfo);
           // $this->flash->success("Apply Message was inserted successfully");
            include(APP_DIR."/config/link.php");
            $this->response->redirect("{$site_url}reward/search");

        }
        $this->log->InfoLog("RewordController","applyAction","参加保存结束");
        echo  "success" ;
        exit;
    }

}
