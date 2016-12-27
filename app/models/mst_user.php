<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;

use Vokuro\DataBase\PdoController;

/**
 * Vokuro\Models\Users
 * All the users registered in the application
 */
class mst_user extends Model
{
    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     *
     * @var string
     */
    public $login_id;

    /**
     *
     * @var string
     */
    public $user_name;

    /**
     *
     * @var integer
     */
    public $login_pwd;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var integer
     */
    public $coin;

    /**
     *
     * @var integer
     */
    public $level;

    /**
     *
     * @var integer
     */
    public $user_type;

    /**
     *
     * @var integer
     */
    public $c_time;

    /**
     *
     * @var integer
     */
    public $u_time;

    /**
     *
     * @var integer
     */
    public $c_user;

    /**
     *
     * @var integer
     */
    public $u_user;

    /**
     *
     * @var integer
     */
    public $site_id;

    public $head_pic_url;

    private $_db;

    public function getSource()
    {
        return "mst_user";
    }


    public function beforeValidationOnCreate()
    {

       // $this->user_id = 123 ;
    }

    public function initialize()
    {
        //$this->_db = new PdoController();
        /*
        $this->hasMany('user_id', 'Vokuro\Models\tbl_reward_task', 'user_id', array(
            'alias' => 'tbl_reward_task',
            'foreignKey' => array(
                'message' => 'User cannot be deleted because he/she has activity in the system'
            )
        ));
        */
    }
    public function validation()
    {

        return true;
    }

    public function getAll(){
        $sql = 'select * from mst_user';
        return $this->_db->query($sql);
    }
}
