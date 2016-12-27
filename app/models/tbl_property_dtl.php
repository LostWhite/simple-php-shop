<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Vokuro\Models\Users
 * All the users registered in the application
 */
class tbl_property_dtl extends Model
{
    /**
     *
     * @var integer
     */
    public $account_id;

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     *
     * @var Date
     */
    public $site_id;

    /**
     *
     * @var string
     */
    public $t_order_id;

    /**
     *
     * @var string
     */
    public $coin;

    /**
     *
     * @var string
     */
    public $freeze_coin;

    /**
     *
     * @var string
     */
    public $remain_coin;

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
}
