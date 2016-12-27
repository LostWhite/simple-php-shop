<?php
namespace Vokuro\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;
use Vokuro\Models\t_teacher_detail;
use Vokuro\Models\t_message;
use Vokuro\Forms\UserForm;


/**
 * Vokuro\Controllers\UsersController
 * CRUD to manage users
 */
class MallController extends ControllerBase
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

    public function goodsAction()
    {
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';
    }


}
