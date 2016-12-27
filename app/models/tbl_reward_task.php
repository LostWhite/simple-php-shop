<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Vokuro\Models\Users
 * All the users registered in the application
 */
class tbl_reward_task extends Model
{

    /**
     *
     * @var integer
     */
    public $task_id;

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
    public $big_catagory;

    /**
     *
     * @var integer
     */
    public $small_catagoryy;

    /**
     *
     * @var integer
     */
    public $task_name;

    /**
     *
     * @var integer
     */
    public $task_remark;

    /**
     *
     * @var integer
     */
    public $reward_type;

    /**
     *
     * @var integer
     */
    public $pay_reward;

    /**
     *
     * @var integer
     */
    public $other_remark;

    /**
     *
     * @var integer
     */
    public $task_status;

    /**
     *
     * @var string
     */
    public $time_limit;

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

    /**
     *
     * @var string
     */
    public $file1_path;

    /**
     *
     * @var string
     */
    public $file2_path;

    /**
     *
     * @var string
     */
    public $file3_path;

    public function initialize()
    {
        $this->belongsTo('user_id', 'Vokuro\Models\mst_user', 'user_id', array(
            'alias' => 't_user',
            'reusable' => true
        ));
        $this->belongsTo('reward_type', 'Vokuro\Models\m_common', 'id', array(
            'alias' => 'm_common',
            'reusable' => true
        ));
        $this->hasOne('user_id', 'Vokuro\Models\tbl_order_dtl', 'order_id', array(
            'alias' => 't_order',
            'reusable' => true
        ));
        $this->belongsTo('user_id', 'Vokuro\Models\mst_user_service', 'ps_user_id', array(
            'alias' => 'user_service',
            'reusable' => true
        ));
    }
}
