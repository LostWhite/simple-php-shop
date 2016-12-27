<?php
namespace Vokuro\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;
use Vokuro\Common\Order;
use Vokuro\Models\tbl_property_dtl;
use Vokuro\Models\tbl_order_dtl;

use Vokuro\DataBase\PdoController;

/**
 * Vokuro\Controllers\UsersController
 * CRUD to manage users
 */
class TransactionController extends ControllerBase
{
    /**
     * Default action, shows the search form
     */
    public function indexAction()
    {
        $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';
    }

    public function buyAction()
    {
        $config = include APP_DIR . '/config/config.php';
        $data = array();
        //购买服务
        $price = $_GET['ps_price'];
        $ps_site_id = $_GET['ps_site_id'];
        $ps_id = $_GET['ps_id'];
        $ps_user_id = $_GET['ps_user_id'];
        $user_id = $this->session->get("user_id");
        if   ($ps_user_id==$user_id){
        	    echo  "isself"; 
                exit;
         }
        $where = "user_id = ".$user_id." and site_id = ".DEFINE_SITE_ID;
        $property = tbl_property_dtl::find($where);
        $account_id = 0;
        foreach($property as $row){
            $account_id = $row->account_id;
            if($row->remain_coin < $price){
              //  $data[0] = 1; //余额不足标示
                //echo json_encode($data);
                echo  "nomoney"; 
                exit;
            }
        }

        //redis预留接口  从临时表获取进行中的订单id  判断是否能再次购买服务。
        //Order::getTmpOrder($user_id,$ps_user_id,DEFINE_SITE_ID);
	   //status = 1 表示是进行中的订单
//        $where = "user_id = ".$user_id." and pay_to_user_id = ".$ps_user_id." and status = 1 and site_id = ".DEFINE_SITE_ID;
       // $order = tbl_order_dtl::find($where);
          //$count_o = count($order);
         Order:: setPdo($this->pdo);
        $notOverOrderID= Order::getOrderNotOver($user_id,$ps_user_id,DEFINE_SITE_ID);
        if($notOverOrderID){
         //   $data[0] =  2; //购买服务标示
            //echo json_encode($data);
            echo  "haveorder"; 
            exit;
        }
$retid=0;
        try{
            $pdo = new PdoController();
            $pdo->begin();
            $property = $pdo->getRow('tbl_property_dtl','account_id = '.$account_id);
            $fieldVal = array(
                'remain_coin' => $property['remain_coin'] - $price,
                'freeze_coin' => $property['freeze_coin'] + $price
            );
            $condition = 'account_id = '.$account_id;
            $pdo->update('tbl_property_dtl',$fieldVal,$condition);

            //$fields = array('ps_site_id','user_id','ps_id','site_id','ps_price','ps_nums','status','trade_date','flg','pay_to_user_id','delete_flg');
            //$vals = array($ps_site_id,$user_id,$ps_id,DEFINE_SITE_ID,$price,1,1,date('Y-m-d H:i:s',time()),1,$ps_user_id,1);
            //$pdo->insert('tbl_order_dtl',$fields,$vals);
            $saveData = array(
                'ps_site_id' => $ps_site_id,
                'user_id' => $user_id,
                'ps_id' => $ps_id,
                'site_id' => DEFINE_SITE_ID,
                'ps_price' => $price,
                'ps_nums' => 1,
                'status' => 1,
                'trade_date' => date('Y-m-d H:i:s',time()),
                'flg' => 1,
                'pay_to_user_id' => $ps_user_id,
                'delete_flg' => 1,
            );
        $retid=    $pdo->insertHS("tbl_order_dtl",$saveData);

            $pdo->commit();
        }catch (\Exception $e){
            $pdo->rollback();
          // $data[0] = 3; //错误
            //echo json_encode($data);
              echo  "error"; 
            exit;
        }
     
        /*
         * 订单号：40678
            订单日期：2015-05-02 13:46:33
            服务项目：看卦，一事一問，
             服务类别：预测类
             订单金额：78 算卦币
         */
       // $where = "ps_site_id = ".$ps_site_id." and user_id = ".$user_id. " and trade_date = '".date('Y-m-d H:i:s',time())."'";
       // $order = tbl_order_dtl::findFirst($where);
     //   $data[0] = $retid;
        //$data[1] = date('Y-m-d H:i:s',time());
        //$data[2] = $ps_id;
        //$data[3] = $price;
        //echo json_encode($data);
        echo $retid;
        exit;
    }
}
