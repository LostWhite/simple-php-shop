<?php
namespace Vokuro\Controllers;

use Vokuro\Common\Common;
use Vokuro\Common\Online;
use Vokuro\Forms\LoginForm;
use Vokuro\Forms\SignUpForm;
use Vokuro\Forms\ForgetPasswordForm;
use Vokuro\Auth\Exception as AuthException;
use Vokuro\Models\t_user;
use Vokuro\Models\Users;
use Vokuro\Models\ResetPasswords;
use Vokuro\Models\mst_user;

/**
 * Controller used handle non-authenticated session actions like login/logout, user signup, and forgotten passwords
 */
class SessionController extends ControllerBase
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

    }

    /**
     * Allow a user to signup to the system
     */
    public function signupAction()
    {
        $form = new SignUpForm();
        if ($this->request->isPost()) {
            $code = $this->request->getPost('code');
            if ($form->isValid($this->request->getPost()) == false) {
                $messages = CheckTable::getMessage($form);
                foreach($messages as $key => $value){
                    $this->view->setVar($key,$value);
                }
            }else{
                if(!empty($code)){
                    if($code == $this->session->get('code')){
                        $check = new CheckTable();
                        $mess = $check->signupCheck(array(
                            'email' => $this->request->getPost('email'),
                            'password' => $this->request->getPost('password'),
                            'username' => $this->request->getPost('username'),
                            'password2' => $this->request->getPost('password2'),
                            'site_id' => $this->request->getPost('site_id'),
                            'reg_route' => $this->request->getPost('reg_route'),
                        ));

                        
                        if(!$mess){
                            return $this->dispatcher->forward(array(
                                'controller' => 'index',
                                'action' => 'index'
                            ));
                           
                        }else{
                            foreach($mess as $key => $value){
                                $this->view->setVar($key,$value);
                            }
                        }
                    }else{
                        $this->view->setVar('code_err','验证码填写不正确');
                    }
                }else{
                    $this->view->setVar('code_err','验证码不能为空');
                }

            }
        }
        $this->view->form = $form;
    }

    /**
     * Starts a session in the admin backend
     */
    public function loginAction()
    {
        $form = new LoginForm();
        if (!$this->request->isPost()) {
            $this->view->setVar('password_err','');
            
            if (!empty($_GET["act"])) {
            	$catpoin ="参数错误，请联系客服";
            	switch ($_GET["act"])
				{
					case "chat_teacher":
					    $catpoin="使用试测功能，请先登录或注册";
                        break;
                    case "chat_index":
					    $catpoin="使用试测功能，请先登录或注册";
					    break;
                    case "user_index":
                        $catpoin="使用个人管理功能，请先登录或注册";
                        break;
                    case "prophet_index":
                        $catpoin="使用预测师管理功能，请先登录或注册";
                        break;
                    case "user_apply":
                        $catpoin="使用申请预测师功能，请先登录或注册";
                        break;
                    case "money_recharge":
                        $catpoin="使用购买算卦币功能，请先登录或注册";
                        break;
                    case "reward_public":
                        $catpoin="使用发布赏金预测功能，请先登录或注册";
                        break;
                    case "order_orders":
                        $catpoin="使用我的订单功能，请先登录或注册";
                        break;
                    case "online_collect":
                        $catpoin="使用收藏预测师功能，请先登录或注册";
                        break;
                    case "online_chat":
                        $catpoin="使用聊天室功能，请先登录或注册";
                        break;
                    case "message_information":
                        $catpoin="使用意见反馈功能，请先登录或注册";
                        break;
                    case "transaction_buy":
                        $catpoin="使用购买服务功能，请先登录或注册";
                        break;
                     default:
                        $catpoin=$_GET["act"]."未設定，请先登录或注册";
                        break;
                     
				}
            	$this->view->setVar("frommsg",$catpoin);
            }
            if ($this->auth->hasRememberMe()) {
                return $this->auth->loginWithRememberMe();
            }
        } else {
            if ($form->isValid($this->request->getPost()) == false) {
                $messages = CheckTable::getMessage($form);
                foreach($messages as $key => $value){
                    $this->view->setVar($key,$value);
                }
            }else{
                $check = new CheckTable();
                $mess = $check->loginCheck(array(
                    'name' => $this->request->getPost('name'),
                    'password' => $this->request->getPost('password'),
                    'site_id' => $this->request->getPost('site_id')
                ));
                if(!$mess){
                    $this->session->set("user_name",$this->session->get("auth-identity")["login_id"]);

                    return $this->dispatcher->forward(array(
                        'controller' => 'index',
                        'action' => 'index'
                    ));
                }else{
                    foreach($mess as $key => $value){
                        $this->view->setVar($key,$value);
                    }
                }
            }
        }
        
        $this->view->form = $form;
    }

    /**
     * Shows the forgot password form
     */
    public function forgetPasswordAction()
    {
        $form = new ForgetPasswordForm();

        if ($this->request->isPost()) {
            $code = $this->request->getPost('code');
            if ($form->isValid($this->request->getPost()) == false) {
                $messages = CheckTable::getMessage($form);
                foreach($messages as $key => $value){
                    $this->view->setVar($key,$value);
                }
            } else {
                if(!empty($code)){
                    if($code == $this->session->get('code')){
                        $check = new CheckTable();
                        $mess = $check->forgetPasswordCheck(array(
                            'email' => $this->request->getPost('email'),
                            'username' => $this->request->getPost('username')
                        ));
                        if(!$mess){
                            //$com = new Common();
                            //$mes = $com->sendMail($this->request->getPost('email'));
                            //var_dump($mes);
                            $this->mail->ConfirmMail('','');
                        }else{
                            foreach($mess as $key => $value){
                                $this->view->setVar($key,$value);
                            }
                        }
                    }else{
                        $this->view->setVar('code_err','验证码填写不正确');
                    }
                }else{
                    $this->view->setVar('code_err','验证码不能为空');
                }
            }
        }
        $this->view->form = $form;
    }

    /**
     * Closes the session
     */
    public function logoutAction()
    {
        $user_id = $this->session->get("user_id");

        
		if    (empty($user_id)){
			$user_id =0;
		}
        $this->auth->remove();
        Online::setRedis($this->redis);
        Online::delUserStatues($user_id, DEFINE_SITE_ID);
        include(APP_DIR."/config/link.php");
        return $this->response->redirect("{$site_url}index");
    }


}
