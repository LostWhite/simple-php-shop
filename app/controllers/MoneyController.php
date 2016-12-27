<?php
namespace Vokuro\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;
use Vokuro\Models\t_teacher_detail;
use Vokuro\Models\t_message;
use Vokuro\Forms\UserForm;
use Vokuro\Models\tbl_property_dtl;
use Vokuro\Models\tbl_order_dtl;
use Vokuro\Models\mst_user_service;
use Vokuro\Models\tbl_money_dtl;
use Vokuro\DataBase\PdoController;


/**
 * Vokuro\Controllers\UsersController
 * CRUD to manage users
 */
class MoneyController extends ControllerBase
{
    /**
     * Default action, shows the search form
     */
    public function indexAction()
    {
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';
    }

    public function detailAction($status)
    {
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $user_id = $this->session->get("user_id");
        $property = tbl_property_dtl::findFirstByuser_id($user_id);
        $money = tbl_order_dtl::findFirstByt_order_id($property->t_order_id);
        $this->view->setVar('property',$property);
        $this->view->setVar('money',$money);

        $this->view->setVar('status',$status);
        //分页
        $pages = array();
        $p=isset($_GET['p'])?$_GET['p']:1;
        $this->doPages($pages ,$p,10);
        switch($status){
            case 1:
                $where = "user_id = ".$user_id." and site_id = ".DEFINE_SITE_ID;

                $orders = tbl_money_dtl::find(array(
                    $where,
                    "limit" => $pages["rows"],
                    "offset" => $pages["begin"]
                ));
                $count = count(tbl_money_dtl::find($where));
                $end = ceil ($count/$pages["rows"]);
                $this->view->setVar('orders',$orders);
                break;
            case 2:
                $where = "user_id = ".$user_id." and site_id = ".DEFINE_SITE_ID." and t_type = 3";
                $orders = tbl_money_dtl::find(array(
                    $where,
                    "limit" => $pages["rows"],
                    "offset" => $pages["begin"]
                ));
                $count = count(tbl_money_dtl::find($where));
                $end = ceil ($count/$pages["rows"]);
                $this->view->setVar('orders',$orders);
                break;
            case 3:
                $where = "user_id = ".$user_id." and site_id = ".DEFINE_SITE_ID." and t_type = 4";
                $orders = tbl_money_dtl::find(array(
                    $where,
                    "limit" => $pages["rows"],
                    "offset" => $pages["begin"]
                ));
                $count = count(tbl_money_dtl::find($where));
                $end = ceil ($count/$pages["rows"]);
                $this->view->setVar('orders',$orders);
                break;
            case 4:
                $where = "user_id = ".$user_id." and site_id = ".DEFINE_SITE_ID." and t_type = 5";
                $orders = tbl_money_dtl::find(array(
                    $where,
                    "limit" => $pages["rows"],
                    "offset" => $pages["begin"]
                ));
                $count = count(tbl_money_dtl::find($where));
                $end = ceil ($count/$pages["rows"]);
                $this->view->setVar('orders',$orders);
                break;
            case 5:
                $where = "user_id = ".$user_id." and site_id = ".DEFINE_SITE_ID." and t_type = 1";
                $orders = tbl_money_dtl::find(array(
                    $where,
                    "limit" => $pages["rows"],
                    "offset" => $pages["begin"]
                ));
                $count = count(tbl_money_dtl::find($where));
                $end = ceil ($count/$pages["rows"]);
                $this->view->setVar('orders',$orders);
                break;
        }
        $url_page = $this->getUrl().'/money/detail/'.$status;
        $this->view->setVar('url_page',$url_page);
        $this->view->setVar('end',$end);
        $this->view->setVar('count',$count);
        $this->view->setVar('current',$pages['current']);
        //$where = "user_id = ".$user_id." and site_id = ".$site_id." and status = 2";
        //$orders = tbl_order_dtl::find($where);
        /*
        $sql = "call order_per(". $user_id .",". $site_id .");";
        $orders = $this->dbHelper->QueryAll($sql);
        $this->view->setVar('orders',$orders);

        $where = "user_id = ".$user_id." and site_id = ".$site_id." and status = 2 and flg = 2";
        $orders2 = tbl_order_dtl::find($where);
        $this->view->setVar('orders2',$orders2);

        $sql = "call order_pro(". $user_id .",". $site_id .");";
        $orders3 = $this->dbHelper->QueryAll($sql);
        $this->view->setVar('orders3',$orders3);

        $where = "user_id = ".$user_id." and site_id = ".$site_id." and status = 2 and flg = 3";
        $orders4 = tbl_order_dtl::find($where);
        $this->view->setVar('orders4',$orders4);
        */
    }

    public function pdetailAction($status)
    {
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $user_id = $this->session->get("user_id");
        $service = mst_user_service::findFirstByps_user_id($user_id);
        $this->view->setVar('service',$service);

        $property = tbl_property_dtl::findFirstByuser_id($user_id);
        $this->view->setVar('property',$property);

        $this->view->setVar('status',$status);
        //分页
        $pages = array();
        $this->doPages($pages ,$_GET['p']);
        switch($status){
            case 1:
                $where = "user_id = ".$user_id." and site_id = ".DEFINE_SITE_ID;
                $orders = tbl_money_dtl::find(array(
                    $where,
                    "limit" => $pages["rows"],
                    "offset" => $pages["begin"]
                ));
                $count = count(tbl_money_dtl::find($where));
                $end = ceil ($count/$pages["rows"]);
                $this->view->setVar('orders',$orders);
                break;
            case 2:
                $where = "user_id = ".$user_id." and site_id = ".DEFINE_SITE_ID." and t_type = 2";
                $orders = tbl_money_dtl::find(array(
                    $where,
                    "limit" => $pages["rows"],
                    "offset" => $pages["begin"]
                ));
                $count = count(tbl_money_dtl::find($where));
                $end = ceil ($count/$pages["rows"]);
                $this->view->setVar('orders',$orders);
                break;
            case 3:
                $where = "user_id = ".$user_id." and site_id = ".DEFINE_SITE_ID." and t_type = 4";
                $orders = tbl_money_dtl::find(array(
                    $where,
                    "limit" => $pages["rows"],
                    "offset" => $pages["begin"]
                ));
                $count = count(tbl_money_dtl::find($where));
                $end = ceil ($count/$pages["rows"]);
                $this->view->setVar('orders',$orders);
                break;
        }
        $url_page = $this->getUrl().'/money/pdetail/'.$status;
        $this->view->setVar('url_page',$url_page);
        $this->view->setVar('end',$end);
        $this->view->setVar('count',$count);
        $this->view->setVar('current',$pages['current']);
        /*
        $sql = "call order_pro(". $user_id .",". $site_id .");";
        $orders = $this->dbHelper->QueryAll($sql);
        $this->view->setVar('orders',$orders);

        $where = "user_id = ".$user_id." and site_id = ".$site_id." and status = 2 and flg = 3";
        $orders2 = tbl_order_dtl::find($where);
        $this->view->setVar('orders2',$orders2);
        */
    }

    public function precordAction($status)
    {
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        if(isset($_GET['flg']) && $_GET['flg'] == 0){
            $order = tbl_order_dtl::findFirstByt_order_id($_GET['t_order_id']);
            $order->delete_flg = 0;
            if($order->save()){

            }else{
                $this->db->rollback();
            }
        }

        $status--;
        $this->view->setVar('status',$status);
        $user_id = $this->session->get("user_id");
        /*
        if(isset($_GET['p'])){
            $current = $_GET['p'];
        }else{
            $current = 1;
        }
        $page_max_nums =10;
        $end = 1;
        $count = 0;
        */
        $pages = array();
        $this->doPages($pages ,$_GET['p']);

        if($status == 0){
            $sql = "call order_pro(". $user_id .",". DEFINE_SITE_ID .",".$pages["begin"].",".$pages["rows"].");";
            $orders = $this->dbHelper->QueryAll($sql);
            $count = $orders[0]['num'];
            $end = ceil ($count/$pages["rows"]);
            $this->view->setVar('orders',$orders);
        }else{
            $sql = "call order_per(". $user_id .",". DEFINE_SITE_ID .",".$pages["begin"].",".$pages["rows"].");";
            $orders = $this->dbHelper->QueryAll($sql);
            $count = $orders[0]['num'];
            $end = ceil ($count/$pages["rows"]);
            $this->view->setVar('orders',$orders);
        }

        $url_page = $this->getUrl().'/money/precord/'.$status;
        $this->view->setVar('url_page',$url_page);
        $this->view->setVar('count',$count);
        $this->view->setVar('end',$end);
        $this->view->setVar('current',$pages['current']);

        $service = mst_user_service::findFirstByps_user_id($user_id);
        $this->view->setVar('service',$service);
    }

    public function rechargeAction($status)
    {
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';
        $this->CheckMustLogin("money_recharge");
        $pdo = new PdoController();
        if(isset($_POST["amount"])){
            $money_add = $_POST["amount"];

            $user_id=$this->session->get("user_id");
            $fields=array();

            $PROPERTY_money=$pdo->getRow("tbl_property_dtl","user_id= '".$user_id."'","coin,remain_coin");

            $money_insert=array(
                'user_id'=>$user_id,
                'site_id'=>DEFINE_SITE_ID,
                'order_id'=>rand(111111111,999999999),
                'property_dt'=>date('Y-m-d H:i:s',time()),
                't_type'=>3,
                'type_memo'=>"充值支付宝",
                'money'=>$money_add,
                'account'=>$PROPERTY_money['coin']+$money_add,
                "memo"=>"n"
            );

            $call = new MoneyController();
            $call->aliPay($money_insert);

            $PROPERTY_update=array(
                'coin'=>$PROPERTY_money['coin']+$money_add,
                'remain_coin'=>$PROPERTY_money['remain_coin']+$money_add,
                'update_time'=>$money_insert['property_dt'],
                'update_user'=>$money_insert['user_id']
            );
        }else{
            $money_add = 0;
        }

     try{    
        if($money_add != "" && $money_add!=0 && $money_add>0){

            $pdo->begin();

            $money_sure=$pdo->insertHS("tbl_money_dtl",$money_insert);
            
            $where="user_id='".$user_id."'";
            $property_sure=$pdo->update("tbl_property_dtl",$PROPERTY_update,$where);
            $pdo->commit();
          }
          }catch(\Exception $e){
            	echo "充值失败";
            	$pdo->rollback();
            	//向txt写插入失败记录
            	$f_path = BASE_DIR."/logs/insert_money.txt";
            	$f_contents="time:".$money_insert['property_dt']."   money:".$money_add."   user_id:".$money_insert['user_id']."\r\n";
            	file_put_contents($f_path,$f_contents,FILE_APPEND);
            } 
        
        $this->view->setVar('status',$status);
    }

    private function aliPay($data){
        $config = include APP_DIR . '/config/config.php';

        require_once(APP_DIR."/library/zhifubao/alipay.config.php");
        require_once(APP_DIR."/library/zhifubao/lib/alipay_submit.class.php");
        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = $data['order_id'];

        //订单名称，必填
        $subject = $data['type_memo'];

        //付款金额，必填
        $total_fee = $data['money'];

        //商品描述，可空
        $body = "算卦币";

        $parameter = array(
            "service"       => $alipay_config['service'],
            "partner"       => $alipay_config['partner'],
            "seller_id"  => $alipay_config['seller_id'],
            "payment_type"	=> $alipay_config['payment_type'],
            "notify_url"	=> $alipay_config['notify_url'],
            "return_url"	=> $alipay_config['return_url'],

            "anti_phishing_key"=>$alipay_config['anti_phishing_key'],
            "exter_invoke_ip"=>$alipay_config['exter_invoke_ip'],
            "out_trade_no"	=> $out_trade_no,
            "subject"	=> $subject,
            "total_fee"	=> $total_fee,
            "body"	=> $body,
            "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
            //其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.kiX33I&treeId=62&articleId=103740&docType=1
            //如"参数名"=>"参数值"

        );

//建立请求
        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        echo $html_text;
    }

}