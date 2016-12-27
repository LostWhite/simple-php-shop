<?php
namespace Vokuro\Controllers;

use Vokuro\Common\Online;
use Vokuro\Models\db_user_add;
use Vokuro\Models\mst_user_site;
use Vokuro\Models\mst_user_add;
use Vokuro\Models\mst_user;
use Vokuro\Models\mst_user_service;
use Vokuro\Models\mst_services;
use Vokuro\Models\mst_site_services;
use Phalcon\Mvc\User\Component;
use Vokuro\Models\tbl_property_dtl;

use Vokuro\DataBase\PdoController;

class CheckTable extends Component
{
    Static function getMessage($obj){
        $mess = array();
        foreach ($obj as $element) {
            $messages = $obj->getMessagesFor($element->getName());
            if (count($messages)) {
                foreach ($messages as $message) {
                    $mess[$element->getName().'_err'] = $message;
                }
            }else{
                $mess[$element->getName().'_err'] = '';
            }
        }
        return $mess;
    }

    /**
     * by cui,2015-03-04
     * 登录页面check
     */
    public function loginCheck($credentials)
    {
        $sql = "call bbs_login('".$credentials['name']."','".$credentials['password']."','".$credentials['site_id']."');";
        $myModel = new mst_user();
        $result = $myModel->getReadConnection()->query($sql)->fetch();
        
        
        
        $messages = array();
        if($result){
            try {
                $pdo = new PdoController();
                $pdo->begin();

				Online::setRedis($this->redis);
				//$sessionid=$this->session->getid()
				$sessionid=100;
				
           Online::insUserStatues($result['user_id'], DEFINE_SITE_ID, 1, $sessionid, $result['login_id']);
                /*
                $add = mst_user_add::findFirstByuser_id($result['user_id']);
                $add->login_times += 1;
                $add->laslogin_time = date('Y-m-d H:i:s',time());
                $add->save();
                */
                
                $condition = 'user_id = '.$result['user_id'];
                $user_add = $pdo->getRow('mst_user_add',$condition);
                
                $fieldVal = array(
                    'login_times' => $user_add['login_times'] + 1,
                    'laslogin_time' => date('Y-m-d H:i:s',time()),
                );
                
                $pdo->update('mst_user_add',$fieldVal,$condition);
                $pdo->commit();
                $this->session->set('login_id',$result['login_id']);
                $this->session->set('user_id',$result['user_id']);
                $this->session->set('user_name',$result['user_name']);
                $service = mst_user_service::findFirst("ps_user_id = ". $result['user_id'] ." and flg = 1");
                if(isset($service->ps_user_id)){
                    $this->session->set('prophet_flg',1);
                }else{
                    $this->session->set('prophet_flg',0);
                }
                $this->session->set('auth-identity', array(
                    'id' => $result['user_id'],
                    'login_id' => $result['login_id'],
                    'name' => $result['user_name']
                ));
            }catch(\Exception $e) {
                $pdo->rollback();
                 echo $e->getMessage();
                
                $messages['name_err'] = '系统异常';
                
            }
        }else{
            $messages['name_err'] = '用户名或密码错误';
        }
        return $messages;
    }

    /**
     * by cui,2015-03-04
     * 注册页面check
     */
    public function signupCheck($credentials)
    {
        $sys = array('system','warning','info','html','sys','sys0','sys1','sys2','sys3','sys4','sys5','sys6','sys7','sys8','sys9');
//        $user = mst_user::findFirstByuser_name($credentials['email']);
        $messages = array();

        $user = mst_user::findFirstByemail($credentials['email']);
        if ($user) {
            $messages['email_err'] = '邮箱已被使用';
        }
        $user = mst_user::findFirstBylogin_id($credentials['username']);
        if ($user) {
            $messages['username_err'] = '用户id已被使用';
        }else{
            for($i = 0; $i < count($sys); $i ++){
                if($credentials['username'] == $sys[$i]){
                    $messages['username_err'] = '用户id无法使用';
                }
            }
        }
        if(!$messages){
            try{
                $pdo = new PdoController();
                $pdo->begin();

                //$fields = array('login_id','email','login_pwd','c_time','u_time','c_user','u_user');
                //$vals = array($credentials['username'],$credentials['email'],$credentials['password'],date('Y-m-d H:i:s',time()),date('Y-m-d H:i:s',time()),11,11);
                //$user_id = $pdo->insert('mst_user',$fields,$vals,true);
                $saveData = array(
                    'login_id' => $credentials['username'],
                    'email' => $credentials['email'],
                    'login_pwd' => $credentials['password'],
                    'c_time' => date('Y-m-d H:i:s',time()),
                    'u_time' => date('Y-m-d H:i:s',time()),
                    'c_user' => 11,
                    'u_user' => 11,
                );
                $user_id = $pdo->insertHS('mst_user',$saveData,true);

                $this->session->set('user_name',$credentials['username']);
                //$fields = array('site_id','user_id');
                //$vals = array($credentials['site_id'],$user_id);
                //$pdo->insert('mst_user_site',$fields,$vals);
                $saveData = array(
                    'site_id' => DEFINE_SITE_ID,
                    'user_id' => $user_id,
                );
                $pdo->insertHS('mst_user_site',$saveData);

                //$fields = array('user_id','reg_route','reg_site_id','login_times','laslogin_time');
                //$vals = array($user_id,$credentials['reg_route'],DEFINE_SITE_ID,1,date('Y-m-d H:i:s',time()));
                //$pdo->insert('mst_user_add',$fields,$vals);
                $saveData = array(
                    'user_id' => $user_id,
                    'reg_route' => $credentials['reg_route'],
                    'reg_site_id' => DEFINE_SITE_ID,
                    'login_times' => 1,
                    'laslogin_time' => date('Y-m-d H:i:s',time()),
                );
                $pdo->insertHS('mst_user_add',$saveData);

                //$fields = array('user_id','site_id','coin','insert_time','insert_user_id');
                //$vals = array($user_id,DEFINE_SITE_ID,0,date('Y-m-d H:i:s',time()),$user_id);
                //$pdo->insert('tbl_property_dtl',$fields,$vals);
                $saveData = array(
                    'user_id' => $user_id,
                    'site_id' => DEFINE_SITE_ID,
                    'coin' => 0,
                    'insert_time' => date('Y-m-d H:i:s',time()),
                    'insert_user_id' => $user_id,
                );
                $pdo->insertHS('tbl_property_dtl',$saveData);

                $this->session->set('user_id',$user_id);
                	$sessionid=100;

                Online::setRedis($this->redis);
                Online::insUserStatues($user_id,DEFINE_SITE_ID,1,$sessionid, $credentials['username']);

//($user_id,$site_id,$status,$sessionid,$username)
                $pdo->commit();
            }catch (\Exception $e){
                $pdo->rollback();
                $messages['username_err'] = '注册失败！';
            }
        }
        return $messages;
    }

    /**
     * by cui,2015-03-06
     * 修改密码check
     */
    public function passwordCheck($credentials)
    {
//        $user = mst_user::findFirstByuser_name($credentials['email']);
        $user = mst_user::findFirstBylogin_id($credentials['name']);

        $messages = array();
        if($credentials['password1']!=$user->login_pwd){
            $messages['password1_err'] = '密码错误';
        }
        if(!$messages){
            $user->login_pwd = $credentials['password2'];
            if(!$user->save()){
                $messages['password1_err'] = '修改失败！';
            }
        }
        return $messages;
    }

    /**
     * by cui,2015-03-09
     * 修改个人资料check
     */
    public function increaseCheck($credentials)
    {

        $messages = array();

        $user_id = $this->session->get("user_id");
        $user = mst_user::findFirstByuser_id($user_id);
        $user1 = mst_user::findFirstByemail($credentials['email']);
        if ($user->email != $credentials['email'] && $user1) {
            $messages['email_err'] = '邮箱已被使用';
        }
        /*
        $user2 = mst_user::findFirstBylogin_id($credentials['login_id']);
        if ($user->login_id != $credentials['login_id'] && $user2) {
            $messages['username_err'] = '用户id已被使用';
        }
        */
        if(!$messages){
            $mess = array();
            foreach($credentials as $key => $value){
                $mess[$key] = $value;
            }
            if($credentials['sex'] == 1){
                $credentials['sex'] = '女';
            }elseif($credentials['sex'] == 2){
                $credentials['sex'] = '男';
            }
            $list=array(
                'email' => $credentials['email'],
                //'login_id' => $credentials['login_id'],
                'user_name1' => $credentials['user_name1'],
                'user_name2' => $credentials['user_name2'],
                'zipcode' => $credentials['zipcode'],
                'addr_id1' => $credentials['addr_id1'],
                'addr_id2' => $credentials['addr_id2'],
                'addr_id3' => $credentials['addr_id3'],
                'addr_id4' => $credentials['addr_id4'],
                'address5' => $credentials['address5'],
                'tel_number' => $credentials['tel_number'],
                'mobile_number' => $credentials['mobile_number'],
                'qqno' => $credentials['qqno'],
                'birth' => $credentials['birth'],
                'sex' => $credentials['sex'],
            );


            $conditions = "user_id = ".$user->user_id;

            $pdo = new PdoController();
            if($pdo->update("mst_user",$list,$conditions)){
                
            }else{
                $messages['email_err'] = '修改失败！';
            }
        }
        return $messages;
    }

    /**
     * by cui,2015-03-27
     * 上传服务check
     */
    public function suploadCheck($credentials)
    {
        $where = "t_ps_user_id = ". $credentials['t_ps_user_id'] ." and t_ps_name = '". $credentials['t_ps_name'] ."'";
        $service = mst_services::find($where);
        $flg = false;
        foreach($service as $ser){
            if($ser->t_ps_id){
                $flg = true;
            }
        }
        $messages = array();
        if($flg){
            $messages['t_ps_name_err'] = '服务名重复';
        }
        if(!$messages){
            try{
                $pdo = new PdoController();
                $pdo->begin();

                //$fields = array('t_ps_user_id','t_ps_name','t_ps_content','insert_time','insert_user_id','update_time','update_user','active_flag','t_ps_type');
                //$vals = array($credentials['t_ps_user_id'],$credentials['t_ps_name'],$credentials['t_ps_content'],date('Y-m-d H:i:s',time()),$credentials['t_ps_user_id'],date('Y-m-d H:i:s',time()),$credentials['t_ps_user_id'],1,$credentials['t_ps_type']);
                //$pdo->insert('mst_services',$fields,$vals);
                $saveData = array(
                    't_ps_user_id' => $credentials['t_ps_user_id'],
                    't_ps_name' => $credentials['t_ps_name'],
                    't_ps_content' => $credentials['t_ps_content'],
                    'insert_time' => date('Y-m-d H:i:s',time()),
                    'insert_user_id' => $credentials['t_ps_user_id'],
                    'update_time' => date('Y-m-d H:i:s',time()),
                    'update_user' => $credentials['t_ps_user_id'],
                    'active_flag' => 1,
                    't_ps_type' => $credentials['t_ps_type'],
                );
                $pdo->insertHS('mst_services',$saveData);

                $row = $pdo->getRow('mst_services',$where);
                //$fields = array('ps_user_id','ps_id','site_id','ps_name','ps_type','ps_price','ps_money','buy_total');
                //$vals = array($row['t_ps_user_id'],$row['t_ps_id'],DEFINE_SITE_ID,$row['t_ps_name'],$row['t_ps_type'],$credentials['ps_price'],$credentials['ps_price'],0);
                //$pdo->insert('mst_site_services',$fields,$vals);
                $saveData = array(
                    'ps_user_id' => $row['t_ps_user_id'],
                    'ps_id' => $row['t_ps_id'],
                    'site_id' => DEFINE_SITE_ID,
                    'ps_name' => $row['t_ps_name'],
                    'ps_type' => $row['t_ps_type'],
                    'ps_price' => $credentials['ps_price'],
                    'ps_money' => $credentials['ps_price'],
                    'buy_total' => 0,
                );
                $pdo->insertHS('mst_site_services',$saveData);

                $pdo->commit();
            }catch (\Exception $e){
                $pdo->rollback();
                $messages['t_ps_name_err'] = '上传失败！';
            }
            /*
            $service = new mst_services();
            $service->assign(array(
                't_ps_user_id' => $credentials['t_ps_user_id'],
                't_ps_name' => $credentials['t_ps_name'],
                't_ps_content' => $credentials['t_ps_content'],
                'insert_time' => date('Y-m-d H:i:s',time()),
                'insert_user_id' => $credentials['t_ps_user_id'],
                'update_time' => date('Y-m-d H:i:s',time()),
                'update_user' => $credentials['t_ps_user_id'],
                'active_flag' => 1,
                't_ps_type' => $credentials['t_ps_type'],
            ));
            $service->save();
            $service_r = mst_services::find($where);
            foreach($service_r as $service){
                $site_service = new mst_site_services();
                $site_service->assign(array(
                    'ps_user_id' => $service->t_ps_user_id,
                    'ps_id' => $service->t_ps_id,
                    'site_id' => $credentials['site_id'],
                    'ps_name' => $service->t_ps_name,
                    'ps_type' => $service->t_ps_type,
                    'ps_price' => $credentials['ps_price'],
                    'ps_money' => $credentials['ps_price'],
                    'buy_total' => 0,
                ));
                $site_service->save();
            }
            */
        }
        return $messages;
    }

    /**
     * by cui,2015-03-27
     * 修改服务check
     */
    public function supdateCheck($credentials)
    {
        $messages = array();
        if(!$messages){
            try{
                $pdo = new PdoController();
                $pdo->begin();

                $fieldVal = array(
                    't_ps_name' => $credentials['t_ps_name'],
                    't_ps_content' => $credentials['t_ps_content'],
                    'insert_time' => date('Y-m-d H:i:s',time()),
                    'insert_user_id' => $credentials['t_ps_user_id'],
                    'update_time' => date('Y-m-d H:i:s',time()),
                    'update_user' => $credentials['t_ps_user_id'],
                    't_ps_type' => $credentials['t_ps_type'],
                );
                $condition = 't_ps_id = '.$credentials['t_ps_id'];
                $pdo->update('mst_services',$fieldVal,$condition);

                $fieldVal = array(
                    'ps_name' => $credentials['ps_name'],
                    'ps_type' => $credentials['t_ps_type'],
                    'ps_price' => $credentials['ps_price'],
                    'ps_money' => $credentials['ps_price']
                );
                $condition = 'ps_site_id = '.$credentials['ps_site_id'];
                $pdo->update('mst_site_services',$fieldVal,$condition);

                $pdo->commit();
            }catch (\Exception $e){
                $messages['ps_name_err'] = '修改失败！';
                $pdo->rollback();
            }
            /*
            $service = mst_services::findFirstByt_ps_id($credentials['t_ps_id']);
            $service->t_ps_name = $credentials['t_ps_name'];
            $service->t_ps_content = $credentials['t_ps_content'];
            $service->insert_time = date('Y-m-d H:i:s',time());
            $service->insert_user_id = $credentials['t_ps_user_id'];
            $service->update_time = date('Y-m-d H:i:s',time());
            $service->update_user = $credentials['t_ps_user_id'];
            $service->t_ps_type = $credentials['t_ps_type'];
            $service->save();

            $site_service = mst_site_services::findFirstByps_site_id($credentials['ps_site_id']);
            $site_service->ps_name = $credentials['ps_name'];
            $site_service->ps_type = $credentials['t_ps_type'];
            $site_service->ps_price = $credentials['ps_price'];
            $site_service->ps_money = $credentials['ps_price'];
            $site_service->save();
            */
        }
        return $messages;
    }

    /**
     * by cui,2015-03-26
     * 修改预测师信息check
     */
    public function modifyCheck($credentials)
    {
        $messages = array();
        if(!$messages){
            $service = mst_user_service::findFirstByps_user_id($credentials['ps_user_id']);
            $service->login_id = $credentials['login_id'];
            $service->user_content = $credentials['user_content'];
            $service->user_type = $credentials['user_type'];
            $service->category_id = $credentials['category_id'];
            $service->expert_content = $credentials['expert_content'];
            var_dump($credentials['category_id']);
            if($service->save()){
                $messages['flg'] = 1;
            }else{
                $messages['flg'] = 2;
            }
        }
        return $messages;
    }

    /**
     * by cui,2015-03-26
     * 忘记密码check
     */
    public function forgetPasswordCheck($credentials)
    {
        $messages = array();
        $users = mst_user::findFirstBylogin_id($credentials['username']);
        if($users->email != $credentials['email']){
            $messages['email_err'] = '邮箱与用户名不匹配!';
        }
        return $messages;
    }
}