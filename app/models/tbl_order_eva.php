<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Vokuro\Models\Users
 * All the users registered in the application
 */
class tbl_order_eva extends Model
{
    /**
     *
     * @var integer
     */
    public $eval_id;

    /**
     *
     * @var integer
     */
    public $order_id;

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     *
     * @var integer
     */
    public $ps_id;

    /**
     *
     * @var integer
     */
    public $ps_user_id;

    /**
     *
     * @var integer
     */
    public $site_id;

    /**
     *
     * @var Date
     */
    public $tdate;

    /**
     *
     * @var string
     */
    public $eval_memo;

    /**
     *
     * @var string
     */
    public $eval_score;

    /**
     *
     * @var string
     */
    public $status;
}
