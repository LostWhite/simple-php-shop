<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Vokuro\Models\Users
 * All the users registered in the application
 */
class tbl_order_dtl extends Model
{
    /**
     *
     * @var integer
     */
    public $t_order_id;
    /**
     *
     * @var string
     */
    public $ps_site_id;
    /**
     *
     * @var string
     */
    public $user_id;
    /**
     *
     * @var string
     */
    public $ps_id;
    /**
     *
     * @var string
     */
    public $site_id;
    /**
     *
     * @var string
     */
    public $ps_price;
    /**
     *
     * @var string
     */
    public $ps_nums;
    /**
     *
     * @var string
     */
    public $status;
    /**
     *
     * @var string
     */
    public $trade_date;
    /**
     *
     * @var string
     */
    public $pay_method;
    /**
     *
     * @var string
     */
    public $pay_date;
    /**
     *
     * @var string
     */
    public $is_freezed;
    /**
     *
     * @var string
     */
    public $flg;
    /**
     *
     * @var int
     */
    public $delete_flg;
    public function initialize()
    {
        $this->belongsTo('pay_to_user_id', 'Vokuro\Models\mst_user', 'user_id', array(
            'alias' => 't_user',
            'reusable' => true
        ));
    }
}
