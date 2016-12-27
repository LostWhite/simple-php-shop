<?php
namespace Vokuro\Controllers;

use Vokuro\Models\db_mst_user;
use Vokuro\Models\mst_user_service;
use Vokuro\Models\mst_user_site;
use Phalcon\Paginator\Adapter\Model as Paginator;

use Vokuro\Common\Online;
/**
 * Display the default index page.
 */
class IndexController extends ControllerBase
{
    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
     
    public function initialize()
    {
    	parent::initialize();
        $this->view->setTemplateBefore('public');
    }
     
    public function indexAction()
    {
        //var_dump($this->auth->getIdentity());exit;
     //   
       // $this->session->set('site_id',1);
        if($this->request->isPost() && $this->request->getPost('q') != ''){
            $name = $this->request->getPost('q');
            if(isset($_GET['p'])){
                $current = $_GET['p'];
            }else{
                $current = 1;
            }
            $page_max_nums =3;
            $sql = "call bbs_index_search(". ($current-1)*$page_max_nums .",". $page_max_nums .",". DEFINE_SITE_ID .",'". $name ."');";
            $result = $this->dbHelper->QueryAll($sql);
            $uservices = array();
            $num = 0;
            $end = 0;
            foreach($result as $rows){
                //$rows["onlineimg"] =  Online::getOnLineJpgName($rows['ps_user_id'], $this->session->get('g_site_id'));
                $rows["onlineimg"] =  Online::getJpgNameByOnLineStatus($rows['status']);
                $uservices[$num] = $rows;
                $num += 1;
                $end = $rows['num'];
            }
            $end = ceil ($end/3);
        }else{
            if(isset($_GET['p'])){
                $current = $_GET['p'];
            }else{
                $current = 1;
            }
            $page_max_nums =3;
            $sql = "call bbs_index(". ($current-1)*$page_max_nums .",". $page_max_nums .",". DEFINE_SITE_ID .");";
            $result = $this->dbHelper->QueryAll($sql);
            $uservices = array();
            $num = 0;
            $end = 0;
            foreach($result as $rows){
                //$rows["onlineimg"] =  Online::getOnLineJpgName($rows['ps_user_id'], $this->session->get('g_site_id'));
                $rows["onlineimg"] =  Online::getJpgNameByOnLineStatus($rows['status']);
                $uservices[$num] = $rows;
                $num += 1;
                $end = $rows['num'];
            }
            $end = ceil ($end/3);
        }
     
        $url_page = $this->getUrl().'/index';

        $img_no = array(0,1,2,3,4);
        shuffle($img_no);
        $this->view->setVar('img_no', $img_no);
        $this->view->setVar('url_page',$url_page);
        $this->view->setVar('uservices',$uservices);
        $this->view->setVar('end',$end);
        $this->view->setVar('current',$current);
        $this->view->setVar('jpg','online.jpg');

        $this->view->setTemplateBefore('public');
    }

    public function testAction(){
        /*
        $dbp = new \PDO("mysql:host=localhost; dbname=bbs_db", "sub52846", "xg9KBPK6");
        var_dump(111);
        foreach( $dbp->query( "SELECT * FROM t_online" ) as $row )
        {
            print_r( $row );
            var_dump('</br>');
        }
        var_dump(222);
        */
        $sql = "SELECT * FROM t_online";
        //$db = new Pdo();
        /*
        foreach( $this->pdo->query($sql) as $row )
        {
            print_r( $row );
            var_dump('</br>');
        }
        var_dump($this->pdo->total('t_online'));
        */
        $users = new db_mst_user();
        $user = $users->getRow('mst_user','user_id = 1');
        var_dump($user['user_id']);
        exit;
    }

    public function liaotianAction(){

    }
}
