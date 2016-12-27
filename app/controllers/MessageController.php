<?php
namespace Vokuro\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;
use Vokuro\Models\t_teacher_detail;
use Vokuro\Models\tbl_message;
use Vokuro\Models\mst_user;
use Vokuro\Forms\UserForm;


/**
 * Vokuro\Controllers\MessageController
 * CRUD to manage messages
 */
class MessageController extends ControllerBase
{

    public function initialize()
    {
    	parent::initialize();
        $this->view->setTemplateBefore('public');
    }

    /**
     * Default action, shows the search form
     */
    public function indexAction()
    {
        $this->view->setVar('logged_in', $this->session->get("user_name"));
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';
    }

    public function informationAction()
    {
        include(APP_DIR."/config/link.php");
        $this->view->setVar('logged_in', $this->session->get("user_name"));
        $this->view->setVar('site_url', $site_url);
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $this->CheckMustLogin("message_information");

        /*
         * 判断给谁发送私信
         */
        if(isset($_GET['status'])){
            $this->view->setVar('status',$_GET['status']);
        }else{
            $this->view->setVar('status',0);
        }
        if(isset($_GET['ps_user_name'])){
            $this->view->setVar('ps_user_name',$_GET['ps_user_name']);
        }else{
            $this->view->setVar('ps_user_name',0);
        }

        if ($this->session->get("user_name") == null) {
            return;
        }
        $this->view->setTemplateBefore('public');
        $this->persistent->conditions = null;
        $userId = $this->session->get("user_id");

        //收件箱取得
        $phqlsend = "SELECT send_id as user_id,user_name,max(tbl_message.insert_time) as ins from tbl_message " .
            "inner join mst_user on  tbl_message.send_id = mst_user.user_id " .
            "where tbl_message.receive_id = '" . $userId . "' and tbl_message.skg_flg = 0 group by user_id,user_name order by ins desc";
        $this->view->sendmsg = $this->dbHelper->QueryAll($phqlsend);

        //发件箱取得
        $phqlreceive = "SELECT receive_id as user_id,user_name,max(tbl_message.insert_time) as ins from tbl_message " .
            "inner join mst_user on  tbl_message.receive_id = mst_user.user_id " .
            "where tbl_message.send_id = '" . $userId . "' and tbl_message.skg_flg = 0 group by user_id,user_name order by ins desc";
          
        $this->view->receivemsg = $this->dbHelper->QueryAll($phqlreceive);

        $phalname = "SELECT temp.user_id, temp.user_name, tbl_message.message_content, DATE_FORMAT(temp.insert_time,'%Y-%m-%d') AS ins_time " .
            "FROM (SELECT me.user_id,me.user_name, MAX(me.insert_time) AS insert_time FROM (SELECT u.user_id,u.user_name, MAX(m.insert_time) AS insert_time FROM tbl_message m INNER JOIN mst_user u " .
            "ON m.send_id = u.user_id WHERE m.receive_id = '" . $userId . "' AND m.send_id >= -1 AND m.skg_flg=0 GROUP BY u.user_id,u.user_name UNION SELECT u.user_id, u.user_name, " .
            " MAX(m.insert_time) AS insert_time FROM tbl_message m INNER JOIN mst_user u ON m.receive_id = u.user_id " .
            " WHERE m.send_id = '" . $userId . "' AND m.receive_id > -1  AND m.skg_flg=0 GROUP BY u.user_id,u.user_name ) me GROUP BY me.user_id,me.user_name ) temp INNER JOIN tbl_message ON tbl_message.insert_time = temp.insert_time " .
            "ORDER BY temp.insert_time";
           //echo $phalname;
        $this->view->namelist = $this->dbHelper->QueryAll($phalname);
    }

    //收件箱明细取得
    public function receiveAction()
    {
        $sendId = $this->request->getPost('id', 'striptags');
        $receiveId = $this->session->get("user_id");
        $this->view->setVar('logged_in', $this->session->get("user_name"));
        $this->view->setTemplateBefore('public');
        $this->persistent->conditions = null;

        $phal = "SELECT msg.`message_id` AS msg_id,title ,send_id, send.user_name AS send_name,receive_id,receive.user_name AS receive_name, date_format(msg.insert_time,'%Y-%m-%d') as insert_time" .
            " FROM tbl_message msg INNER JOIN mst_user send ON send.`user_id` = msg.`send_id` " .
            " INNER JOIN mst_user receive ON receive.`user_id` = msg.`receive_id` " .
            " WHERE msg.`send_id` = '" . $sendId . "' AND msg.`receive_id` = '" . $receiveId . "' AND message_status = 1" .
            " ORDER BY msg.insert_time DESC";

        $data = $this->dbHelper->QueryAll($phal);
        echo json_encode($data);
        exit;

    }

    //信息履历
    public function detailAction()
    {
        $userId = $this->session->get("user_id");
        $teacherId = $this->request->getPost('id', 'striptags');
        $this->view->setTemplateBefore('public');
        $phal = "SELECT CASE WHEN send_id = '" . $userId . "' THEN 0 ELSE 1 END AS flg, message_content, u.user_name, " .
            "u.head_pic_url, m.insert_time, m.message_id,m.send_id FROM " .
            "tbl_message m INNER JOIN mst_user u ON m.send_id = u.user_id AND skg_flg = 0 WHERE (send_id = '" . $userId .
            "' AND receive_id = '" . $teacherId . "') OR (send_id = '" . $teacherId . "' AND receive_id = '" . $userId . "')" .
            " ORDER BY m.insert_time ASC ";
        $data = $this->dbHelper->QueryAll($phal);
        echo json_encode($data);
        exit;
    }

    //发件箱明细取得
    public function sendAction()
    {
        $this->view->setVar('logged_in', $this->session->get("user_name"));
        $receiveId = $this->request->getPost('id', 'striptags');
        $sendId = $this->session->get("user_id");

        $this->view->setTemplateBefore('public');
        $this->persistent->conditions = null;

        $phal = "SELECT msg.`message_id` AS msg_id, title,send_id, send.user_name AS send_name,receive_id,receive.user_name AS receive_name, date_format(msg.insert_time,'%Y-%m-%d') as insert_time" .
            " FROM tbl_message msg INNER JOIN mst_user send ON send.`user_id` = msg.`send_id` " .
            " INNER JOIN mst_user receive ON receive.`user_id` = msg.`receive_id` " .
            " WHERE msg.`send_id` = " . $sendId . " AND msg.`receive_id` = " . $receiveId . " AND message_status = 1 and skg_flg = 0 " .
            " ORDER BY msg.insert_time DESC";

        $data = $this->dbHelper->QueryAll($phal);
        echo json_encode($data);
        exit;
    }

    public function deleteAction()
    {
        $msgId = $this->request->getPost('id', 'striptags');
        $msg = tbl_message::findFirstBymessage_id($msgId);
        $msg->assign(array(
            'skg_flg' => 1,
            'update_time' => date("Y-m-d H:i:s"),
            'update_user' => -1
        ));
        if (!$msg->save()) {
            $this->flash->error($msg->getMessages());
        }
        exit;
    }

    //信息明细取得
    public function searchAction()
    {
        $this->view->setVar('logged_in', $this->session->get("user_name"));
        $this->view->setTemplateBefore('public');
        $msgId = $this->request->getPost('id', 'striptags');
        $msg = tbl_message::findFirstBymessage_id($msgId);

        $redis =$this->redis;
        $userid = $this->session->get("user_id");
        $result=$redis ->HVALS("msg_{$userid}");
        
        if ($result[0] != $result[1]) {
            //$redis->cmd('HSET', "msg_{$userid}", "org", "0")->cmd('HSET', "msg_{$userid}", "new", "0")->set();
            $redis->HSET("msg_{$userid}", "org", "0");
            $redis->HSET("msg_{$userid}", "new", "0");
        }
        
        echo json_encode($msg);
        exit;
    }

    //发送信息
    public function createAction()
    {
    	
        $this->view->setVar('logged_in', $this->session->get("user_name"));
        //send_id
        $sendid = $this->session->get("user_id");
        //reveive_id
        $name = $this->request->getPost('name', 'striptags');

        $user = mst_user::findFirstByuser_name($name);
        $receiveid = $user->user_id;
        //信息取得
        $msgtitle = $this->request->getPost('title');
        $msgcontent = $this->request->getPost('content');
        $message = new tbl_message();
        $message->assign(array(
            'send_id' => $sendid,
            'receive_id' => $receiveid,
            'message_status' => 1,
            'title' => $msgtitle,
            'message_content' => $msgcontent,
            'insert_time' => date("Y-m-d H:i:s"),
            'insert_user_id' => -1,
            'update_time' => date("Y-m-d H:i:s"),
            'update_user' => -1,
            'skg_flg' => 0
        ));

        if (!$message->save()) {

            $this->flash->error($message->getMessages());
        } else {
            //$this->redisHelper->getConnection()->cmd('HSET', "msg_{$receiveid}", "org", "0")->cmd('HSET', "msg_{$receiveid}", "new", "1")->set();
            
            $redis =$this->redis;
             $redis->HSET("msg_{$receiveid}", "org", "0");
             $redis->HSET("msg_{$receiveid}", "new", "1");
            //print_R($redis->HGETALL("msg_{$receiveid}"));
            
            echo "发送成功。";
            exit;
            Tag::resetInput();
        }
    }

    public function realtimeAction()
    {
        $redis = $this->redisHelper->getConnection();
        $userid = $this->session->get("user_id");
        $comet = new novComet();
        //$result = $redis->cmd('HVALS', "msg_{$userid}")->get();
        
        $redis =$this->redis;
        $result=$redis ->HVALS("msg_{$userid}");

        if ($result[0] != $result[1]) {
        	
            //$redis->cmd('HSET', "msg_{$userid}", "org", "0")->cmd('HSET', "msg_{$userid}", "new", "0")->set();

            //$redis->HSET("msg_{$userid}", "org", "0");
            //$redis->HSET("msg_{$userid}", "new", "0");

            $out["customAlert"] = time();

            echo json_encode(array('s' => 1, 'k' => $out));

        } else {

            $comet->setVar("aaa", "ccee");
            echo $comet->run();
        }
        exit;
    }

    public function blursearchAction()
    {
        $this->view->setVar('logged_in', $this->session->get("user_name"));
        $userId = $this->session->get("user_id");
        $item = $this->request->getPost('item', 'striptags');
        $phal =  "SELECT temp.user_id, temp.user_name, tbl_message.message_content, DATE_FORMAT(temp.insert_time,'%Y-%m-%d') AS ins_time " .
            "FROM (SELECT me.user_id,me.user_name, MAX(me.insert_time) AS insert_time FROM (SELECT u.user_id,u.user_name,".
            " MAX(m.insert_time) AS insert_time FROM tbl_message m INNER JOIN mst_user u " .
            "ON m.send_id = u.user_id WHERE m.receive_id = '" . $userId . "' AND m.send_id > -1 AND m.skg_flg=0 and m.message_content like '%".$item.
            "%'GROUP BY u.user_id,u.user_name UNION SELECT u.user_id, u.user_name, " .
            " MAX(m.insert_time) AS insert_time FROM tbl_message m INNER JOIN mst_user u ON m.receive_id = u.user_id " .
            " WHERE m.send_id = '" . $userId . "' AND m.receive_id > -1  AND m.skg_flg=0 and m.message_content like '%".$item.
            "%'GROUP BY u.user_id,u.user_name ) me GROUP BY me.user_id,me.user_name ) temp INNER JOIN tbl_message ON tbl_message.insert_time = temp.insert_time " .
            "ORDER BY temp.insert_time";
        $data = $this->dbHelper->QueryAll($phal);
        echo json_encode($data);
        exit;
    }

}
