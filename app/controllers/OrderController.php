<?php
namespace Vokuro\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;
use Vokuro\Auth\Exception;
use Vokuro\Forms\UserForm;
use Vokuro\Models\tbl_order_dtl;
use Vokuro\Models\tbl_order_eva;
use Vokuro\Models\tbl_property_dtl;
use Vokuro\Models\tbl_money_dtl;
use Vokuro\DataBase\PdoController;
 
/**
 * Vokuro\Controllers\Us ersController
 * CRUD to manage users
 */
class OrderController extends ControllerBase
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

    public function assessAction()
    {
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $user_id = $this->session->get("user_id");
        /*
        $where = "user_id = ".$user_id." and site_id = ".$site_id;
        $evas = tbl_order_eva::find($where);
        */
        $pages = array();
        $p = isset($_GET['p']) ? $_GET['p'] : 1;
        $this->doPages($pages ,$p);
        $sql = "call order_ass(". DEFINE_SITE_ID .",". $user_id .",".$pages["begin"].",".$pages["rows"].");";
        $evas = $this->dbHelper->QueryAll($sql);
        $count = $evas[0]['num'];
        $end = ceil ($count/$pages["rows"]);
        $this->view->setVar('evas',$evas);

        $url_page = $this->getUrl().'/order/assess';
        $this->view->setVar('url_page',$url_page);
        $this->view->setVar('end',$end);
        $this->view->setVar('count',$count);
        $this->view->setVar('current',$pages['current']);
    }

    public function ordersAction()
    {
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $this->CheckMustLogin("order_orders");

        if(isset($_GET['flg']) && $_GET['flg'] == 0){
            $order = tbl_order_dtl::findFirstByt_order_id($_GET['t_order_id']);
            $order->delete_flg = 0;
            if($order->save()){

            }else{
                $this->db->rollback();
            }
        }
        $user_id = $this->session->get("user_id");

        $pages = array();

        $p = isset($_GET['p'])?$_GET['p']:1;
        $this->doPages($pages ,$p,10);

        $sql = "call order_per(". $user_id .",". DEFINE_SITE_ID .",".$pages["begin"].",".$pages["rows"].");";
        $orders = $this->dbHelper->QueryAll($sql);

        $count = $orders[0]['num'];
        $end = ceil ($count/$pages["rows"]);

        $url_page = $this->getUrl().'/order/orders';
        $this->view->setVar('url_page',$url_page);
        $this->view->setVar('orders',$orders);
        $this->view->setVar('end',$end);
        $this->view->setVar('count',$count);
        $this->view->setVar('current',$pages['current']);
        //$service = mst_user_service::findFirstByps_user_id($user_id);
        //$this->view->setVar('service',$service);

    }
    
    public function testAction()
    {
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
         $this->CheckMustLogin("order_orders");
         try{
                $pdo = new PdoController();
                $config = include APP_DIR . '/config/config.php';
                $user_id = $this->session->get("user_id");
                $page['item']  = $this->ROWS_PER_PAGES;
                $page['pageing_max']  = $this->PAGEINGS_MAX;
                
                $cueentpage =  $_GET['p'];
                if ($cueentpage){
                	$page['current'] = $cueentpage;
                 }else{
                 	$page['current'] = 1;
                }	
                // getAllByPage($tName, &$page = NULL , $fields='*', $condition='', $order='', $mycountsql ='')
                $sql = "select  a.id, a.start_time ,a.end_time,b.login_id" ;
                $sqlFrom=		" from  tbl_test  a inner join mst_user b on a.ps_user_id = b.user_id " .
                		"  where  a.site_id =".DEFINE_SITE_ID;
                $sqlFrom =$sqlFrom . " and  a.user_id= " .$user_id ;
                 $sqlFrom =$sqlFrom . " order by  a.start_time  desc " ;
                
                $data  = $pdo-> search($sql. $sqlFrom,  $sqlFrom,  $page) ;
                $page['url']  = $this->getUrl().'/order/test';
                
                 $this->view->setVar('count', count($data));
                $this->view->setVar('data',$data);
                 $this->view->setVar('page', $page);

                //$pdo->commit();
            }catch (\Exception $e){
                $pdo->rollback();
            }
        $this->view->setTemplateBefore('public');
      
    }
    public function testdelAction($id)
    {
    	
    	 $user_id = $this->session->get("user_id");
    	//$sql = "delete from  tbl_test where id  = $id  and  user_id= " .$user_id  ;
    	$condition = " id  = $id  and  user_id= " .$user_id  ;
    	$pdo = new PdoController();
    	$data  = $pdo-> del("tbl_test" , $condition) ;
 		return $this->dispatcher->forward(array(
                "action" => "test"
            ));            
     }	
    public function ptestAction()
    {
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';
    }
/*
     public function adetailAction($id)
     {
    			echo "ADETAIL";
    		
     }	
*/
    public function   testupdAction($id)
     {
     	   $pdo = new PdoController();
     	    //$testID= $this->pdo->insertHS( "tbl_test",  $vals,  TRUE  );
     	    
     	    $fieldVal ['eval_score']=5;
     	    $fieldVal ['eval_memo']=$_POST['eval_memo'];
     	  
     	    $condition=" id = ".$id ;
     	    
     	   $pdo->update("tbl_test", $fieldVal, $condition);

    			echo "ADETAIL";
    		
     }
     

}