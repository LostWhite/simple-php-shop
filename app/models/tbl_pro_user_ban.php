<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Vokuro\Models\Users
 * All the users registered in the application
 */
class tbl_pro_user_ban extends Model
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
    public $to_user_id;
    /**
     *
     * @var string
     */
    public $site_id;
    /**
     *
     * @var string
     */
    public $start_time;
    /**
     *
     * @var string
     */
    public $status;

}
