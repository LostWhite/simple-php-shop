<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Vokuro\Models\Users
 * All the users registered in the application
 */
class tbl_message extends Model
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
    public $send_id;

    /**
     *
     * @var integer
     */
    public $receive_id;

    /**
     *
     * @var integer
     */
    public $message_content;

    /**
     *
     * @var integer
     */
    public $message_status;

    /**
     *
     * @var integer
     */
    public $insert_time;

    /**
     *
     * @var integer
     */
    public $insert_user_id;

    /**
     *
     * @var integer
     */
    public $update_time;

    /**
     *
     * @var integer
     */
    public $update_user;
    public $skg_flg=0;

    /**
     *
     * @var string
     */
    public $site_id;

    public function initialize()
    {
        $this->belongsTo('send_id', 'Vokuro\Models\mst_user', 'user_id', array(
            'alias' => 't_user',
            'reusable' => true
        ));

        $this->belongsTo('receive_id', 'Vokuro\Models\mst_user', 'user_id', array(
            'alias' => 'receive',
            'reusable' => true
        ));
    }
}
