<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Vokuro\Models\Users
 * All the users registered in the application
 */
class mst_services extends Model
{

    /**
     *
     * @var integer
     */
    public $t_ps_user_id;

    /**
     *
     * @var integer
     */
    public $t_ps_id;

    /**
     *
     * @var integer
     */
    public $bcategory_id;

    /**
     *
     * @var integer
     */
    public $category_sub_id;

    /**
     *
     * @var integer
     */
    public $t_ps_name;

    /**
     *
     * @var integer
     */
    public $t_ps_content;

    /**
     *
     * @var integer
     */
    public $service_fee;

    /**
     *
     * @var integer
     */
    public $active_flag;

    /**
     *
     * @var string
     */
    public $insert_time;

    /**
     *
     * @var string
     */
    public $insert_user_id;

    /**
     *
     * @var string
     */
    public $update_time;

    /**
     *
     * @var string
     */
    public $update_user;

    /**
     *
     * @var string
     */
    public $site_id;

}
