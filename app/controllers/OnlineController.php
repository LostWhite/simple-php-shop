<?php
namespace Vokuro\Controllers;

//use Phalcon\Tag;
//use Phalcon\Mvc\Model\Criteria;
use Vokuro\Common\Order;
//use Vokuro\Forms\UserForm;
use Vokuro\Models\mst_user_service;
use Vokuro\Models\mst_user;
use Vokuro\Models\tbl_collection;
use Vokuro\Models\tbl_order_dtl;
use Vokuro\DataBase\PdoController;
/**
 * Vokuro\Controllers\UsersController
 * CRUD to manage users
 */
class OnlineController extends ControllerBase
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
    }

    public function tab1Action($ps_user_id)
    {
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $service = mst_user_service::findFirstByps_user_id($ps_user_id);

        $user = mst_user::findFirstByuser_id($ps_user_id);
        $this->view->setVar('service',$service);
        $this->view->setVar('user',$user);

        $user_id = $this->session->get("user_id");

        //redis预留接口  从临时表获取进行中的订单id
        Order:: setPdo($this->pdo);
       
       $notOverOrderID = Order::getOrderNotOver($user_id,$ps_user_id,DEFINE_SITE_ID);

        //判断是否购买了服务并且为完成订单
        if($notOverOrderID) {
                $this->view->setVar('orderid',$notOverOrderID);
        }else {
	        	$this->view->setVar('orderid', 0);
        }
//echo "<br>";        
//echo $notOverOrderID;
//exit;
        //服务项目分页
        //$site_id = $this->session->get("g_site_id");
        $pages = array();
        $p = isset($_GET['p'])?$_GET['p']:1;
        $this->doPages($pages ,$p,16);
        $sql = "call service_detail(". DEFINE_SITE_ID .",". $ps_user_id .",".$pages["begin"].",".$pages["rows"].");";
        $services = $this->dbHelper->QueryAll($sql);
        $count = isset($services[0]['num'])?$services[0]['num']:0;
        $end = ceil ($count/$pages["rows"]);

        $url_page = $this->getUrl().'/online/tab1/'.$ps_user_id;
        $this->view->setVar('url_page',$url_page);
        $this->view->setVar('end',$end);
        $this->view->setVar('count',$count);
        $this->view->setVar('current',$pages['current']);
        $this->view->setVar('services',$services);

        $this->view->setVar('user_id',$user_id);
    }

    public function tab2Action($ps_user_id)
    {
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $service = mst_user_service::findFirstByps_user_id($ps_user_id);
        $this->view->setVar('service',$service);

        //判断是否购买了服务并且为完成订单
        $user_id = $this->session->get("user_id");
        if(isset($user_id)){
            $where = "user_id = ".$user_id." and pay_to_user_id = ".$ps_user_id." and status = 1 and site_id = ".DEFINE_SITE_ID;
            $order = tbl_order_dtl::find($where);
            $count_o = count($order);
            if($count_o){
                $this->view->setVar('count_o',$count_o);
            }
        }
        $this->view->setVar('user_id',$user_id);
    }

    public function tab3Action($ps_user_id)
    {
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $service = mst_user_service::findFirstByps_user_id($ps_user_id);
        $this->view->setVar('service',$service);

        //判断是否购买了服务并且为完成订单
        $user_id = $this->session->get("user_id");
        if(isset($user_id)){
            $where = "user_id = ".$user_id." and pay_to_user_id = ".$ps_user_id." and status = 1 and site_id = ".DEFINE_SITE_ID;
            $order = tbl_order_dtl::find($where);
            $count_o = count($order);
            if($count_o){
                $this->view->setVar('count_o',$count_o);
            }
        }

        //评论分页
        $pages = array();
        $p = isset($_GET['p'])?$_GET['p']:1;
        $this->doPages($pages ,$p,10);
        $sql = "call ser_evas(". $ps_user_id .",". DEFINE_SITE_ID .",".$pages["begin"].",".$pages["rows"].");";

        $evas = $this->dbHelper->QueryAll($sql);
        $count = $evas[0]['num'];
        $end = ceil ($count/$pages["rows"]);

        $url_page = $this->getUrl().'/online/tab3/'.$ps_user_id;
        $this->view->setVar('url_page',$url_page);
        $this->view->setVar('end',$end);
        $this->view->setVar('count',$count);
        $this->view->setVar('current',$pages['current']);

        $this->view->setVar('user_id',$user_id);

        $this->view->setVar('evas',$evas);
    }

    public function tab4Action($ps_user_id)
    {
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $service = mst_user_service::findFirstByps_user_id($ps_user_id);
        $this->view->setVar('service',$service);

        //判断是否购买了服务并且为完成订单
        $user_id = $this->session->get("user_id");
        if(isset($user_id)){
            $where = "user_id = ".$user_id." and pay_to_user_id = ".$ps_user_id." and status = 1 and site_id = ".DEFINE_SITE_ID;
            $order = tbl_order_dtl::find($where);
            $count_o = count($order);
            if($count_o){
                $this->view->setVar('count_o',$count_o);
            }
        }

        $this->view->setVar('user_id',$user_id);

        //分页
        //该预测师的随笔
        $pages = array();
        $p = isset($_GET['p'])?$_GET['p']:1;
        $this->doPages($pages ,$p,10);
        $sql = "call pro_article_one(". DEFINE_SITE_ID .",". 1 .",".$pages["begin"].",".$pages["rows"].",". $ps_user_id .");";
        $notes = $this->dbHelper->QueryAll($sql);
        $count = $notes[0]['num'];
        $end = ceil ($count/$pages["rows"]);

        $url_page = $this->getUrl().'/online/tab4/'.$ps_user_id;
        $this->view->setVar('url_page',$url_page);
        $this->view->setVar('end',$end);
        $this->view->setVar('count',$count);
        $this->view->setVar('current',$pages['current']);
        $this->view->setVar('notes',$notes);
    }

    /*
     * 收藏预测师
     * Ajax
     */
    public function collectAction($ps_user_id,$user_id)
    {
        $where = "user_id = ".$user_id." and ps_user_id = ".$ps_user_id." and site_id = ".DEFINE_SITE_ID;
        $collect = tbl_collection::findFirst($where);
        if($collect){
            echo "您已收藏该预测师!";
            exit;
        }


        //收藏预测师
        $collect = new PdoController();
        $tName = "tbl_collection";

        $saveData = array(
            'user_id' => $user_id,
            'ps_user_id' => $ps_user_id,
            'site_id' => DEFINE_SITE_ID,
        );
        $id = $collect->insertHS($tName,$saveData,true);
        if($id != ""){
            echo "您已成功收藏";
            exit;
        }

    }


}
