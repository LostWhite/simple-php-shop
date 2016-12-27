<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Vokuro\Models\tbl_apply_message
 * All the users registered in the application
 */
class tbl_apply_message extends Model
{
    /**
     *
     * @var integer
     */
    public $message_id;

    /**
     *
     * @var integer
     */
    public $task_id;

    /**
     *
     * @var integer
     */
    public $ps_user_id;

    /**
     *
     * @var string
     */
    public $apply_memo;

    /**
     *
     * @var datetime
     */
    public $apply_time;

    public function initialize()
    {
        $this->belongsTo('ps_user_id', 'Vokuro\Models\mst_user', 'user_id', array(
            'alias' => 'mst_user',
            'reusable' => true
        ));
    }
}
