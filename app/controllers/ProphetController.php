<?php
namespace Vokuro\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;
use Vokuro\Forms\UploadForm;
use Vokuro\Models\mst_user_service;
use Vokuro\Models\mst_user;
use Vokuro\Forms\ModifyForm;
use Vokuro\Models\mst_site_services;
use Vokuro\Models\mst_services;
use Vokuro\Forms\SupdateForm;
use Vokuro\Models\tbl_title;

use Vokuro\DataBase\PdoController;
/**
 * Vokuro\Controllers\UsersController
 * CRUD to manage users
 */
class ProphetController extends ControllerBase
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
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $this->CheckMustLogin("prophet_index");

        $ps_user_id = $this->session->get('auth-identity')['id'];
        $service = mst_user_service::findFirstByps_user_id($ps_user_id);
        $user = mst_user::findFirstByuser_id($ps_user_id);
        $this->view->setVar('service',$service);
        $this->view->setVar('user',$user);
    }

    /**
     * 预测师随笔
     */
    public function browseAction()
    {
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        /*
        $where = "site_id = ".DEFINE_SITE_ID." and type = 1";
        $notes = tbl_title::find($where);
        $this->view->setVar('notes',$notes);
        */

        //分页
        $pages = array();
        $p = isset($_GET['p']) ? $_GET['p'] : 1;
        $this->doPages($pages ,$p,16);
        $sql = "call pro_article(". DEFINE_SITE_ID .",". 1 .",".$pages["begin"].",".$pages["rows"].");";
        $notes = $this->dbHelper->QueryAll($sql);
        $count = $notes[0]['num'];
        $end = ceil ($count/$pages["rows"]);

        $url_page = $this->getUrl().'/prophet/browse';
        $this->view->setVar('url_page',$url_page);
        $this->view->setVar('end',$end);
        $this->view->setVar('count',$count);
        $this->view->setVar('current',$pages['current']);
        $this->view->setVar('notes',$notes);

        /*
        preg_match_all("|<[^>]+>(.*)</[^>]+>|U",
            "<b>example: </b><div align=\"left\">this is a test</div>",
            $out, PREG_PATTERN_ORDER);
        var_dump($out);exit;
        */
    }

    public function modifyAction()
    {
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $form = new ModifyForm();
        $this->view->form=$form;

        $ps_user_id = $this->session->get('auth-identity')['id'];
        $service = mst_user_service::findFirstByps_user_id($ps_user_id);
        $this->view->setVar('service',$service);

        if($this->request->isPost()){
            if($form->isValid($this->request->getPost()) == false){
                $messages = CheckTable::getMessage($form);
                foreach($messages as $key => $value){
                    $this->view->setVar($key,$value);
                }
            }else{
                $check = new CheckTable();
                var_dump($this->request->get('expert_content'));
                $mess = $check->modifyCheck(array(
                    'login_id' => $this->request->getPost('login_id'),
                    'user_content' => $this->request->getPost('user_content'),
                    'user_type' => $this->request->getPost('user_type'),
                    'category_id' => $this->request->get('category_id'),
                    'expert_content' => $this->request->get('expert_content'),
                    'ps_user_id' => $this->session->get('auth-identity')['id'],
                ));
                if($mess){
                    foreach($mess as $key => $value){
                        $this->view->setVar($key,$value);
                    }
                }
            }
        }
    }

    public function sdetailAction()
    {
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $ps_user_id = $this->session->get("user_id");
        //$site_id = $this->session->get("g_site_id");
        //$where = "site_id = ". $site_id ." and ps_user_id = ".$ps_user_id;

        if(isset($_GET['ps_id']) && isset($_GET['ps_site_id'])){
            try{
                $pdo = new PdoController();
                $pdo->begin();

                $pdo->delByPK('mst_site_services','ps_site_id',(int)$_GET['ps_site_id']);
                $pdo->delByPK('mst_services','t_ps_id',(int)$_GET['ps_id']);

                $pdo->commit();
            }catch (\Exception $e){
                $pdo->rollback();
            }
            /*
            mst_site_services::find($_GET['ps_site_id'])->delete();
            mst_services::find($_GET['ps_id'])->delete();
            */
        }

        $pages = array();
        $this->doPages($pages ,$_GET['p'],16);
        $sql = "call service_detail(". DEFINE_SITE_ID .",". $ps_user_id .",".$pages["begin"].",".$pages["rows"].");";
        $services = $this->dbHelper->QueryAll($sql);
        $count = $services[0]['num'];
        $end = ceil ($count/$pages["rows"]);

        $url_page = $this->getUrl().'/prophet/sdetail';
        $this->view->setVar('url_page',$url_page);
        
        $this->view->setVar('end',$end);
        $this->view->setVar('count',$count);
        $this->view->setVar('current',$pages['current']);
        //$services = mst_site_services::find($where);
        $this->view->setVar('services',$services);
    }

    /*
     * 修改服务
     */
    public function supdateAction()
    {
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        if(isset($_GET['ps_id'])){
            $ps_id = $_GET['ps_id'];
        }else{
            $ps_id = $this->request->getPost('ps_id');
        }
        if(isset($_GET['ps_site_id'])){
            $ps_site_id = $_GET['ps_site_id'];
        }else{
            $ps_site_id = $this->request->getPost('ps_site_id');
        }

        $service = mst_services::findFirstByt_ps_id($ps_id);
        $site_service = mst_site_services::findFirstByps_site_id($ps_site_id);
        $this->view->setVar('service',$service);
        $this->view->setVar('site_service',$site_service);
        $this->view->setVar('ps_id',$ps_id);
        $this->view->setVar('ps_site_id',$ps_site_id);

        $form = new SupdateForm();
        $this->view->form = $form;

        if($this->request->isPost()){
            if($form->isValid($this->request->getPost()) == false){
                $messages = CheckTable::getMessage($form);
                foreach($messages as $key => $value){
                    $this->view->setVar($key,$value);
                }
            }else{
                $check = new CheckTable();
                $mess = $check->supdateCheck(array(
                    't_ps_id' => $this->request->getPost('ps_id'),
                    'ps_site_id' => $this->request->getPost('ps_site_id'),
                    't_ps_name' => $this->request->getPost('ps_name'),
                    'ps_name' => $this->request->get('ps_name'),
                    't_ps_type' => $this->request->get('t_ps_type'),
                    't_ps_content' => $this->request->get('t_ps_content'),
                    'ps_price' => $this->request->get('ps_price'),
                    't_ps_user_id' => $this->session->get('auth-identity')['id'],
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
    }

    public function suploadAction()
    {
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';
        $form = new UploadForm();
        $this->view->form = $form;

        //$img_name = $this->session->get('auth-identity')['id'] . '_' . $this->request->getPost('t_ps_name');
        if($this->request->isPost()){
            if($form->isValid($this->request->getPost()) == false){
                $messages = CheckTable::getMessage($form);
                foreach($messages as $key => $value){
                    $this->view->setVar($key,$value);
                }
            }else{
                $check = new CheckTable();
                $mess = $check->suploadCheck(array(
                    't_ps_name' => $this->request->getPost('t_ps_name'),
                    't_ps_content' => $this->request->getPost('t_ps_content'),
                    'ps_price' => $this->request->getPost('ps_price'),
                    't_ps_user_id' => $this->session->get('auth-identity')['id'],
                    't_ps_type' => $this->request->get('t_ps_type'),
                ));
                if(!$mess){
                    $this->view->setVar('flg', '1');
                }else{
                    foreach($mess as $key => $value){
                        $this->view->setVar($key,$value);
                    }
                }
            }
            /*
            if ($this->request->hasFiles() == true) {
                foreach ($this->request->getUploadedFiles() as $file) {
                    if ($file->getSize() > 3145728) {
                        echo "<script>alert('文件的大小超过3M');</script>";
                        $this->log->InfoLog("UserController","applyAction",$file->getName()."文件的大小超过3M");
                    } else {
                        //$docPath = $config["application"]["documentDir"] . $this->session->get('user_id') . "/";
                        $docPath = "E:/cui/www/bbs_new/public/img/pro/". $this->session->get('user_id') . "/";
                        list($width, $height) = getimagesize($file);
                        $new_width1 = 130;
                        $new_height1 = 130;
                        $image_p = imagecreatetruecolor($new_width1,$new_height1);
                        $image = imagecreatefromjpeg($file);
                        if(imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width1, $new_height1, $width, $height)){
                            if (!is_dir($docPath)) {
                                mkdir($docPath);
                            }
                            $file->moveTo($docPath . $file->getName());
                            $image_url = $docPath . 's_' . $img_name . '.jpg';
                            imagejpeg($image_p,$image_url);
                        }
                        //array_push($arrayPath, $docPath . $file->getName());
                    }
                }
            }else{
                $this->view->setVar('file_err','请选择图片');
            }
            */
        }
    }

    /**
     * （个人）预测师随笔
     */
    public function articleAction()
    {
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        /*
        $where = "site_id = ".DEFINE_SITE_ID." and type = 1";
        $notes = tbl_title::find($where);
        $this->view->setVar('notes',$notes);
        */

        $ps_user_id = $this->session->get("user_id");
        //分页
        //该预测师的随笔
        $pages = array();
        $this->doPages($pages ,$_GET['p']);
        $sql = "call pro_article_one(". DEFINE_SITE_ID .",". 1 .",".$pages["begin"].",".$pages["rows"].",". $ps_user_id .");";
        $notes = $this->dbHelper->QueryAll($sql);
        $count = $notes[0]['num'];
        $end = ceil ($count/$pages["rows"]);

        $url_page = $this->getUrl().'/prophet/article';
        $this->view->setVar('url_page',$url_page);
        $this->view->setVar('end',$end);
        $this->view->setVar('count',$count);
        $this->view->setVar('current',$pages['current']);
        $this->view->setVar('notes',$notes);

    }
}
