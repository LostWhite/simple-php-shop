<?php
namespace Vokuro\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

/**
 * ControllerBase
 * This is the base controller for all controllers in the application
 */
class ControllerBase extends Controller
{
	
	public   $ROWS_PER_PAGES =10; //ÿҳ�����ϸ����
	public   $PAGEINGS_MAX =10; //��ҳ���ӵ����ҳ����
	 public function initialize()
    {

       $use_id =  $this->session->get("user_id");
       if  (isset($use_id)) {
	       if (!empty($use_id)){
	       	      $this->redis->HSET('_usetime', $use_id, time());
	       	      $user_name = $this->redis->HGET('_usename', $use_id);
	       	      //echo $user_name ."**********";
	       	     // print_r();
	       	   //   exit;
	       	      if  (!empty($user_name)  ) {
	       	      		 $this->view->setVar('logged_in', $user_name);
	       	      }
	       	}
       }	
    }
    /**
     * Execute before the router so we can determine if this is a provate controller, and must be authenticated, or a
     * public controller that is open to all.
     *
     * @param Dispatcher $dispatcher
     * @return boolean
     */
    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        $controllerName = $dispatcher->getControllerName();

        // Only check permissions on private controllers
        if ($this->acl->isPrivate($controllerName)) {
            // Get the current identity
            $identity = $this->auth->getIdentity();

            // If there is no identity available the user is redirected to index/index
            if (!is_array($identity)) {

                $this->flash->notice('You don\'t have access to this module: private');

                $dispatcher->forward(array(
                    'controller' => 'index',
                    'action' => 'index'
                ));
                return false;
            }

            // Check if the user have permission to the current option
            $actionName = $dispatcher->getActionName();
            if (!$this->acl->isAllowed($identity['profile'], $controllerName, $actionName)) {

                $this->flash->notice('You don\'t have access to this module: ' . $controllerName . ':' . $actionName);

                if ($this->acl->isAllowed($identity['profile'], $controllerName, 'index')) {
                    $dispatcher->forward(array(
                        'controller' => $controllerName,
                        'action' => 'index'
                    ));
                } else {
                    $dispatcher->forward(array(
                        'controller' => 'user_control',
                        'action' => 'index'
                    ));
                }

                return false;
            }
        }
    }
    
    public function CheckMustLogin($action = "CheckMustLogin"){
    	$use_id =  $this->session->get("user_id");
    	
    	if (empty($use_id)){
    		
            $url = $this->getUrl();
    		//header("Location:/bbs_new/session/login?act=".$action);
            header("Location:".$url."/session/login?act=".$action);
    		exit;
    	}else {
    		$redisuserid=  $this->redis->HGET('_use',$use_id);

    		if (empty($redisuserid)){
	    		 $url = $this->getUrl();
	    		//header("Location:/bbs_new/session/login?act=".$action);
	            header("Location:".$url."/session/login?act=".$action);
	            exit;
    		}
    	}
    }

    public function doPages(&$pagearr,$nowpage,$page_max_nums =0) {
        if(isset($nowpage)){
            $current = $nowpage;
        }else{
            $current = 1;
        }
        $ever = $page_max_nums == 0 ? $this->ROWS_PER_PAGES  :  $page_max_nums;
        $pagearr["begin"] = ($current-1) *  $ever;
        $pagearr["rows"] = $ever;
        $pagearr['current'] = $current;
    }

    public function getUrl(){
        $r_url = $_SERVER["REQUEST_URI"];
        $find = "/";
        $num = strpos($r_url, $find, 1);
        $n_url = substr($r_url,0,$num);
        $url = "http://".$_SERVER['HTTP_HOST'].$n_url;
        return $url;
    }
    
}
