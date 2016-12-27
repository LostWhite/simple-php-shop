<?php
namespace Vokuro\Auth;

use Phalcon\Mvc\User\Component;
use Vokuro\Models\mst_user;
use Vokuro\Models\Users;
use Vokuro\Models\RememberTokens;
use Vokuro\Models\SuccessLogins;
use Vokuro\Models\FailedLogins;
use Vokuro\Models\mst_user_site;
use Vokuro\Models\mst_user_add;

/**
 * Vokuro\Auth\Auth
 * Manages Authentication/Identity Management in Vokuro
 */
class Auth extends Component
{

    /**
     * Checks the user credentials
     *
     * @param array $credentials
     * @return boolan
     */
    public function check($credentials)
    {

//        $user = mst_user::findFirstByuser_name($credentials['email']);
        $user = mst_user::findFirstBylogin_id($credentials['email']);

        if ($user == false) {
            $this->registerUserThrottling(0);
            throw new Exception('用户名或密码错误');
        }
        if ($credentials['password']!=$user->login_pwd) {
            $this->registerUserThrottling($user->user_id);
            throw new Exception('用户名或密码错误');
        }

        $add = mst_user_add::findFirstByuser_id($user->user_id);
        $add->login_times += 1;
        $add->laslogin_time = date('Y-m-d H:i:s',time());
        $add->save();

        $this->session->set('login_id',$user->login_id);
        $this->session->set('user_id',$user->user_id);
        $this->session->set('user_name',$user->user_name);
        $this->session->set('auth-identity', array(
            'id' => $user->user_id,
            'login_id' => $user->login_id,
            'name' => $user->user_name
        ));
    }

    /**
     * by cui,2015-02-26
     * 注册页面check
     * @param array $credentials
     * @return boolan
     */
    public function checkSignup($credentials)
    {
//        $user = mst_user::findFirstByuser_name($credentials['email']);
        $user = mst_user::findFirstByemail($credentials['email']);
        if ($user) {
            $this->registerUserThrottling(0);
            throw new Exception('邮箱已被使用');
        }

        $user = mst_user::findFirstBylogin_id($credentials['user_name']);
        if ($user) {
            $this->registerUserThrottling(0);
            throw new Exception('用户id已被使用');
        }

        if ($credentials['password']!=$credentials['password2']) {
            $this->registerUserThrottling(0);
            throw new Exception('两次密码填写不一致');
        }

        $user = new mst_user();
/*
        $user->assign(array(
            'email' => $credentials['email'],
            'login_id' => $credentials['user_name'],
            //'user_id' => 111,
            'login_pwd' => $credentials['password'],
            'c_time' => date('Y-m-d H:i:s',time()),
            'u_time' => date('Y-m-d H:i:s',time()),
            'c_user' => 11,
            'u_user' => 11,
        ));
*/
        $user->login_id = $credentials['user_name'];
        $user->email = $credentials['email'];
        $user->login_pwd = $credentials['password'];
        $user->c_time = date('Y-m-d H:i:s',time());
        $user->u_time = date('Y-m-d H:i:s',time());
        $user->c_user = 11;
        $user->u_user = 11;

        if($user->save()){
            $this->session->set('user_name',$credentials['user_name']);

            $user = mst_user::findFirstBylogin_id($credentials['user_name']);
            $site = new mst_user_site();
            $site->site_id = $credentials['site_id'];
            $site->user_id = $user->user_id;
            $site->save();

            $add = new mst_user_add();
            $add->user_id = $user->user_id;
            $add->reg_route = $credentials['reg_route'];
            $add->reg_site_id = $credentials['reg_site_id'];
            $add->login_times = 1;
            $add->laslogin_time = date('Y-m-d H:i:s',time());
            $add->save();
        }else{
            throw new Exception('注册失败');
        }
    }

    /**
     * Creates the remember me environment settings the related cookies and generating tokens
     *
     * @param Vokuro\Models\Users $user
     */
    public function saveSuccessLogin($user)
    {
        $successLogin = new SuccessLogins();
        $successLogin->usersId = $user->id;
        $successLogin->ipAddress = $this->request->getClientAddress();
        $successLogin->userAgent = $this->request->getUserAgent();
        if (!$successLogin->save()) {
            $messages = $successLogin->getMessages();
            throw new Exception($messages[0]);
        }
    }

    /**
     * Implements login throttling
     * Reduces the efectiveness of brute force attacks
     *
     * @param int $userId
     */
    public function registerUserThrottling($userId)
    {

    }

    /**
     * Creates the remember me environment settings the related cookies and generating tokens
     *
     * @param Vokuro\Models\Users $user
     */
    public function createRememberEnviroment(Users $user)
    {
        $userAgent = $this->request->getUserAgent();
        $token = md5($user->email . $user->password . $userAgent);

        $remember = new RememberTokens();
        $remember->usersId = $user->id;
        $remember->token = $token;
        $remember->userAgent = $userAgent;

        if ($remember->save() != false) {
            $expire = time() + 86400 * 8;
            $this->cookies->set('RMU', $user->id, $expire);
            $this->cookies->set('RMT', $token, $expire);
        }
    }

    /**
     * Check if the session has a remember me cookie
     *
     * @return boolean
     */
    public function hasRememberMe()
    {
        return $this->cookies->has('RMU');
    }

    /**
     * Logs on using the information in the coookies
     *
     * @return Phalcon\Http\Response
     */
    public function loginWithRememberMe()
    {
        $userId = $this->cookies->get('RMU')->getValue();
        $cookieToken = $this->cookies->get('RMT')->getValue();

        $user = Users::findFirstById($userId);
        if ($user) {

            $userAgent = $this->request->getUserAgent();
            $token = md5($user->email . $user->password . $userAgent);

            if ($cookieToken == $token) {

                $remember = RememberTokens::findFirst(array(
                    'usersId = ?0 AND token = ?1',
                    'bind' => array(
                        $user->id,
                        $token
                    )
                ));
                if ($remember) {

                    // Check if the cookie has not expired
                    if ((time() - (86400 * 8)) < $remember->createdAt) {

                        // Check if the user was flagged
                        $this->checkUserFlags($user);

                        // Register identity
                        $this->session->set('auth-identity', array(
                            'id' => $user->id,
                            'name' => $user->name,
                            'profile' => $user->profile->name
                        ));

                        // Register the successful login
                        $this->saveSuccessLogin($user);

                        return $this->response->redirect('users');
                    }
                }
            }
        }

        $this->cookies->get('RMU')->delete();
        $this->cookies->get('RMT')->delete();
        include(APP_DIR."/config/link.php");
        return $this->response->redirect("{$site_url}session/login");
    }

    /**
     * Checks if the user is banned/inactive/suspended
     *
     * @param Vokuro\Models\Users $user
     */
    public function checkUserFlags(Users $user)
    {
        if ($user->active != 'Y') {
            throw new Exception('The user is inactive');
        }

        if ($user->banned != 'N') {
            throw new Exception('The user is banned');
        }

        if ($user->suspended != 'N') {
            throw new Exception('The user is suspended');
        }
    }

    /**
     * Returns the current identity
     *
     * @return array
     */
    public function getIdentity()
    {
        return $this->session->get('auth-identity');
    }

    /**
     * Returns the current identity
     *
     * @return string
     */
    public function getName()
    {
        $identity = $this->session->get('auth-identity');
        return $identity['name'];
    }

    /**
     * Removes the user identity information from session
     */
    public function remove()
    {
        if ($this->cookies->has('RMU')) {
            $this->cookies->get('RMU')->delete();
        }
        if ($this->cookies->has('RMT')) {
            $this->cookies->get('RMT')->delete();
        }

        $this->session->remove('auth-identity');
        $this->session->remove('user_name');
        $this->session->remove('user_id');
    }


    /**
     * Auths the user by his/her id
     *
     * @param int $id
     */
    public function authUserById($id)
    {
        $user = Users::findFirstById($id);
        if ($user == false) {
            throw new Exception('The user does not exist');
        }

        $this->checkUserFlags($user);

        $this->session->set('auth-identity', array(
            'id' => $user->id,
            'name' => $user->name,
            'profile' => $user->profile->name
        ));
    }

    /**
     * Get the entity related to user in the active identity
     *
     * @return \Vokuro\Models\Users
     */
    public function getUser()
    {
        $identity = $this->session->get('auth-identity');
        if (isset($identity['id'])) {

            $user = Users::findFirstById($identity['id']);
            if ($user == false) {
                throw new Exception('The user does not exist');
            }

            return $user;
        }

        return false;
    }
}
