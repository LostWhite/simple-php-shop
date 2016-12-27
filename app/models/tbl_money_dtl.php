<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Vokuro\Models\Users
 * All the users registered in the application
 */
class tbl_money_dtl extends Model
{
    /**
     *
     * @var integer
     */
    public $auto_id;
    /**
     *
     * @var string
     */
    public $user_id;
    /**
     *
     * @var string
     */
    public $site_id;
    /**
     *
     * @var string
     */
    public $order_id;
    /**
     *
     * @var string
     */
    public $property_dt;
    /**
     *
     * @var string
     */
    public $t_type;
    /**
     *
     * @var string
     */
    public $type_memo;
    /**
     *
     * @var string
     */
    public $money;
    /**
     *
     * @var string
     */
    public $account;
    /**
     *
     * @var string
     */
    public $memo;
}
