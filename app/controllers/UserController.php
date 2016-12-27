<?php
namespace Vokuro\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;
use Vokuro\Common\Online;
use Vokuro\Forms\IncreaseForm;
use Vokuro\Models\mst_user_service;
use Vokuro\Models\tbl_message;
use Vokuro\Forms\UserForm;
use Vokuro\Models\mst_user;
use Vokuro\Forms\ModipassForm;
use Vokuro\Models\mst_countries;
use Vokuro\Models\mst_regions;
use Vokuro\Models\tbl_pro_user_ban;
use Phalcon\Image\Adapter\GD as ImagePs;

/**
 * Vokuro\Controllers\UserController
 */
class UserController extends ControllerBase
{

    public function initialize()
    {
    	parent::initialize();
        $this->view->setTemplateBefore('private');
    }

    /**
     * Default action, shows the search form
     */
    public function indexAction()
    {
        $this->view->setVar('logged_in', $this->session->get("user_name"));
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $this->CheckMustLogin("user_index");

        $username = $this->session->get("user_name");
        $user_message = mst_user::findFirstBylogin_id($username);
        $this->view->setVar('user_message',$user_message);

        $user_id = $this->session->get("user_id");
        $sql = "call per_pro_record(". $user_id .",". DEFINE_SITE_ID .");";
        $services = $this->dbHelper->QueryAll($sql);

        $count = isset($services[0]['num'])?$services[0]['num']:0;
        $this->view->setVar('count',$count);
        $this->view->setVar('services',$services);

        $sql = "call bbs_index(". 0 .",". 4 .",". DEFINE_SITE_ID .");";
        $prophets = $this->dbHelper->QueryAll($sql);
        $this->view->setVar('prophets',$prophets);

        $this->view->setVar('user_id',$user_id);
    }

    /**
     * 申请成为专家
     * Apply to become an expert
     */
    public function applyAction()
    {
        $this->view->setVar('logged_in', $this->session->get("user_name"));
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $this->CheckMustLogin("user_apply");

        $sql = "SELECT distinct `t_r_id`, `t_r_name` FROM `mst_regions`";
        $data2 = $this->dbHelper->QueryAll($sql);
        $this->view->setVar('addr2',$data2);
        $sql = "SELECT distinct `t_r_id`, `t_s_id`, `t_s_name` FROM `mst_regions`";
        $data3 = $this->dbHelper->QueryAll($sql);
        $this->view->setVar('addr3',$data3);
        $sql = "SELECT `t_id`, `t_q_id`, `t_q_name` FROM `mst_regions`";
        $data4 = $this->dbHelper->QueryAll($sql);
        $this->view->setVar('addr4',$data4);

        // 画面初期控件表示设定
        $this->view->showFlg = true;
        $this->view->successFlg = false;
        $users = new mst_user_service();
        $this->view->teacherInfo = $users;
        $form = new UserForm();
        if ($this->session->get("user_id") != "") {
            //20150515
            $user_mes = mst_user::findFirstByuser_id($this->session->get("user_id"));
            $this->view->user_mes = $user_mes;

            $users = mst_user_service::findByps_user_id($this->session->get("user_id"));
            if (count($users) > 0) {
                $this->view->showFlg = false;
                $this->view->teacherInfo = $users[0];

                if ($users[0]->flg == 0) {
                    $this->flash->notice('您已经提交专家申请,在申请提交的 24 小时内，预约管理员会与您联系，进行视频考核认证。');
                } else {
                    $this->view->successFlg = true;
                }
            }
        }
        if ($this->request->isPost()) {
            $this->log->InfoLog("UserController","applyAction","申请预测师处理开始");
            $this->log->InfoLog("UserController","applyAction",$this->request->getPost());

            if ($form->isValid($this->request->getPost()) == false) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                    $this->log->InfoLog("UserController","applyAction","申请预测师画面.".$message);
                }
            } else {
                // 上传文件保存
                $arrayPath = array();
                if ($this->request->hasFiles() == true) {
                    // Print the real file names and sizes
                    foreach ($this->request->getUploadedFiles() as $file) {
                        if ($file->getSize() > 3145728) {
                            echo "<script>alert('文件的大小超过3M');</script>";
                            $this->log->InfoLog("UserController","applyAction",$file->getName()."文件的大小超过3M");
                        } else {
                            $docPath = $config["application"]["documentDir"] . $this->session->get('user_id') . "/";
                            if (!is_dir($docPath)) {
                                mkdir($docPath);
                            }
                            $file->moveTo($docPath . $file->getName());
                            array_push($arrayPath, $docPath . $file->getName());
                        }
                    }
                }
                // 画面入力项目保存
                //20150515
                $user = mst_user::findFirstByuser_id($this->session->get("user_id"));
                $user->user_name1 = $this->session->get("user_name1");
                $user->user_name2 = $this->session->get("user_name2");
                $user->mobile_number = $this->session->get("mobile_num");
                $user->addr_id2 = $this->session->get("addr_id2");
                $user->addr_id3 = $this->session->get("addr_id3");
                $user->addr_id4 = $this->session->get("addr_id4");
                $user->address5 = $this->session->get("address");
                $user->save();

                $teacher_detail = new mst_user_service();
                $teacher_detail->assign(array(
                    'ps_user_id' => $this->session->get("user_id"),
                    'user_name' => $this->session->get("user_name"),
                    'real_name' => $this->session->get("user_name1").$this->session->get("user_name2"),
                    'identif_id' => $this->request->getPost('identif_id', 'striptags'),
                    'identif_img_front' => isset($arrayPath[0]) ? $arrayPath[0] : "",
                    'identif_img_back' => isset($arrayPath[1]) ? $arrayPath[1] : "",
                    'expert_content' => $this->request->getPost('expert_content', 'striptags'),
                    'mobile_num' => $this->session->get("mobile_num"),
                    'address' => $this->session->get("address"),
                    'flg' => '0'
                ));
                if ($teacher_detail->save()) {
                    $this->log->InfoLog("UserController","applyAction","DB表【mst_user_service】数据保存成功");
                    $this->log->InfoLog("UserController","applyAction",$teacher_detail);

                    $message = new tbl_message();
                    $receiveid = $this->session->get("user_id");
                    $message->assign(array(
                        'send_id' => -1,
                        'receive_id' => $receiveid,
                        'message_status' => 1,
                        'message_content' => '您已经提交专家申请,等待管理员进行实名认证。认证考核通过后，' . date("Y-m-d H:i:s", strtotime("+1 day")) . ' 之前，预约管理员会与您联系，进行视频考核认证。',
                        'insert_time' => date("Y-m-d H:i:s"),
                        'insert_user_id' => -1,
                        'update_time' => date("Y-m-d H:i:s"),
                        'update_user' => -1,
                        'title'=> '系统消息'
                    ));

                    if (!$message->save()) {
                        $this->flash->error($message->getMessages());
                        $this->log->InfoLog("UserController","applyAction",$message->getMessages());
                    } else {
                        $this->redisHelper->getConnection() -> cmd ( 'HSET', "msg_{$receiveid}","org","0" )-> cmd ( 'HSET', "msg_{$receiveid}","new","1" ) -> set ();
                        $this->log->InfoLog("UserController","applyAction","DB表【tbl_message】数据保存成功");
                        $this->log->InfoLog("UserController","applyAction",$message);

                        return $this->response->redirect('user/apply');
                    }
                } else {
                    $this->flash->error($teacher_detail->getMessages());
                    $this->log->InfoLog("UserController","applyAction",$teacher_detail->getMessages());
                }
            }
            $this->log->InfoLog("UserController","applyAction","申请预测师处理结束");
        }

        $this->view->form = $form;
    }

    /**
     * 个人信息修改
     * update messages
     */
    public function increaseAction()
    {
        $form = new IncreaseForm();
        $this->view->setVar('logged_in', $this->session->get("user_name"));
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $countries = mst_countries::find();
        $this->view->setVar('countries',$countries);

        //$regions = new mst_regions();
        $sql = "SELECT distinct `t_r_id`, `t_r_name` FROM `mst_regions`";
        $data2 = $this->dbHelper->QueryAll($sql);
        $this->view->setVar('addr2',$data2);
        $sql = "SELECT distinct `t_r_id`, `t_s_id`, `t_s_name` FROM `mst_regions`";
        $data3 = $this->dbHelper->QueryAll($sql);
        $this->view->setVar('addr3',$data3);
        $sql = "SELECT `t_id`, `t_q_id`, `t_q_name` FROM `mst_regions`";
        $data4 = $this->dbHelper->QueryAll($sql);
        $this->view->setVar('addr4',$data4);

        $username = $this->session->get("user_name");
        if ($this->request->isPost()) {
            if($form->isValid($this->request->getPost()) == false){
                $messages = CheckTable::getMessage($form);
                foreach($messages as $key => $value){
                    $this->view->setVar($key,$value);
                }
            }else{
                $check = new CheckTable();
                $mess = $check->increaseCheck(array(
                    'email' => $this->request->getPost('email'),
                    //'login_id' => $this->request->getPost('login_id'),
                    'user_name1' => $this->request->getPost('name1'),
                    'user_name2' => $this->request->getPost('name2'),
                    'zipcode' => $this->request->getPost('zipcode'),
                    'addr_id1' => $this->request->getPost('addr_id1'),
                    'addr_id2' => $this->request->getPost('addr_id2'),
                    'addr_id3' => $this->request->getPost('addr_id3'),
                    'addr_id4' => $this->request->getPost('addr_id4'),
                    'address5' => $this->request->getPost('address5'),
                    'tel_number' => $this->request->getPost('tel_number'),
                    'mobile_number' => $this->request->getPost('mobile_number'),
                    'qqno' => $this->request->getPost('qqno'),
                    'birth' => $this->request->getPost('birth'),
                    'sex' => $this->request->getPost('sex'),
                ));
                if(!$mess){
                    $this->view->setVar('flg', '1');
                }else{
                    foreach($mess as $key => $value){
                        $this->view->setVar($key,$value);
                    }
                }
            }
        }
        $user = mst_user::findFirstBylogin_id($username);
        $this->view->setVar('user', $user);
        $this->view->form = $form;
    }

    /**
     * 申请修改密码
     * Apply to update password
     */
    public function modipassAction()
    {
        $form = new ModipassForm();
        $this->view->setVar('logged_in', $this->session->get("user_name"));
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $username = $this->session->get("user_name");
        if ($this->request->isPost()) {
            if($form->isValid($this->request->getPost()) == false){
                $messages = CheckTable::getMessage($form);
                foreach($messages as $key => $value){
                    $this->view->setVar($key,$value);
                }
            }else{
                $check = new CheckTable();
                $mess = $check->passwordCheck(array(
                    'password1' => $this->request->getPost('password1'),
                    'password2' => $this->request->getPost('password2'),
                    'name' => $username
                ));
                if(!$mess){
                    $this->view->setVar('flg', '1');
                }else{
                    foreach($mess as $key => $value){
                        $this->view->setVar($key,$value);
                    }
                }
            }
        }
        $user = mst_user::findFirstBylogin_id($username);
        $this->view->setVar('user', $user);
        $this->view->form = $form;
    }

    public function iconAction()
    {
        $this->view->setVar('logged_in', $this->session->get("user_name"));
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $img_name = $this->session->get('auth-identity')['id'];
        $this->view->setVar('img_name', $img_name);
        if($this->request->isPost()){
            if ($this->request->hasFiles() == true) {
                // Print the real file names and sizes
                foreach ($this->request->getUploadedFiles() as $file) {
                    if ($file->getSize() > 3145728) {
                        echo "<script>alert('文件的大小超过3M');</script>";
                        $this->log->InfoLog("UserController","applyAction",$file->getName()."文件的大小超过3M");
                    } else {
                        //$docPath = $config["application"]["documentDir"] . $this->session->get('user_id') . "/";
                        $docPath = BASE_DIR . "/public/img/per/" . $this->session->get('user_id') ."/";
                        
                        list($width, $height) = getimagesize($_FILES['icon']['tmp_name']);
                       
                        $new_width1 = 210;
                        $new_height1 = 210;
                        $image_p = imagecreatetruecolor($new_width1,$new_height1);
                        $image = imagecreatefromjpeg($_FILES['icon']['tmp_name']);
                        if(imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width1, $new_height1, $width, $height)){
                            if (!is_dir($docPath)) {
                                mkdir($docPath);
                            }
                            $file->moveTo($docPath . $file->getName());
                            $image_url = $docPath . 'b' . '.jpg';
                            imagejpeg($image_p,$image_url);
                            
                            $this->thumbnail($image_url,160,130,$docPath . 'm' . '.jpg');
                            $this->thumbnail($image_url,40,40,$docPath . 's' . '.jpg');
                        }
                        //array_push($arrayPath, $docPath . $file->getName());
                    }
                }
            }else{
                $this->view->setVar('file_err','请选择图片');
            }
        }
        //$this->view->setVar('image_url',$image_url);
    }

    public function collectAction()
    {
        $this->view->setVar('logged_in', $this->session->get("user_name"));
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $user_id = $this->session->get("user_id");
        $pages = array();
        $p = isset($_GET['p']) ? $_GET['p'] : 1;
        $this->doPages($pages ,$p);
        $sql = "call per_col(". $user_id .",". DEFINE_SITE_ID .",".$pages["begin"].",".$pages["rows"].");";
        $services = $this->dbHelper->QueryAll($sql);
        $count = $services[0]['num'];
        $end = ceil ($count/$pages["rows"]);

        $url_page = $this->getUrl().'/user/collect';
        $this->view->setVar('url_page',$url_page);
        $this->view->setVar('end',$end);
        $this->view->setVar('count',$count);
        $this->view->setVar('current',$pages['current']);
        $this->view->setVar('services',$services);
    }

    public function blacklistAction()
    {
        $this->view->setVar('logged_in', $this->session->get("user_name"));
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $user_id = $this->session->get("user_id");
        $pages = array();
        if(isset($_GET['p'])){
            $this->doPages($pages ,$_GET['p']);
        }else{
            $this->doPages($pages ,1);
        }
        $sql = "call user_blacklist(". $user_id .",". DEFINE_SITE_ID .",".$pages["begin"].",".$pages["rows"].");";
        $users = $this->dbHelper->QueryAll($sql);
        if(!empty($users)){
            $count = $users[0]['num'];
        }else{
            $count = 0;
        }
        if($pages["rows"] != 0 && isset($count)){
            $end = ceil ($count/$pages["rows"]);
        }else{
            $end = 0;
        }

        $this->view->setVar('end',$end);
        $this->view->setVar('count',$count);
        $this->view->setVar('current',$pages['current']);
        $this->view->setVar('users',$users);
    }

    public function addr_id1Action()
    {
        $t_c_id = $_GET['t_c_id'];
        //var_dump($t_c_id);exit;
        $sql = "SELECT distinct `t_r_id`, `t_r_name` FROM `mst_regions` WHERE t_c_id = ".$t_c_id;
        $data = $this->dbHelper->QueryAll($sql);
        $data2 = array();
        foreach($data as $rows){
            $data2[$rows['t_r_id']] = $rows['t_r_name'];
        }
        echo json_encode($data2);
        //var_dump($data2);
        exit;
    }

    public function addr_id2Action()
    {
        $t_r_id = $_GET['t_r_id'];
        $sql = "SELECT distinct `t_r_id`, `t_s_id`, `t_s_name` FROM `mst_regions` WHERE t_r_id = ".$t_r_id;
        $data = $this->dbHelper->QueryAll($sql);
        $data3 = array();
        foreach($data as $rows){
            $key = $rows['t_r_id'].$rows['t_s_id'];
            $data3[$key] = $rows['t_s_name'];
        }
        echo json_encode($data3);
        exit;
    }

    public function addr_id3Action()
    {
        $t_r_id = substr($_GET['t_s_id'],0,2);
        $t_s_id = substr($_GET['t_s_id'],2,2);
        $sql = "SELECT `t_id`, `t_q_id`, `t_q_name` FROM `mst_regions` WHERE t_r_id = ".$t_r_id." and t_s_id = ".$t_s_id;
        $data = $this->dbHelper->QueryAll($sql);
        $data4 = array();
        foreach($data as $rows){
            $key = $rows['t_id'].$rows['t_q_id'];
            $data4[$key] = $rows['t_q_name'];
        }
        echo json_encode($data4);
        exit;
    }
    
    public function thumbnail($path, $width, $height, $dstImgPath) {
		if (ImagePs::check ()) {
			$image = new ImagePs ( $path );
			$image->resize ( $width, $height );
			if ($image->save ( $dstImgPath )) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
