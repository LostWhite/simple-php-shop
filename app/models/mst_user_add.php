<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Vokuro\Models\Users
 * All the users registered in the application
 */
class mst_user_add extends Model
{
    /**
     *
     * @var integer
     */
    public $user_id;
    /**
     *
     * @var integer
     */
    public $birthtime;
    /**
     *
     * @var integer
     */
    public $accounid;
    /**
     *
     * @var integer
     */
    public $reg_route;
    /**
     *
     * @var integer
     */
    public $reg_site_id;
    /**
     *
     * @var integer
     */
    public $login_times;
    /**
     *
     * @var integer
     */
    public $laslogin_time;

    public function getSource()
    {
        return "mst_user_add";
    }

}
