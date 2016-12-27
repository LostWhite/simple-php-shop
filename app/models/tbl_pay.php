<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Vokuro\Models\Users
 * All the users registered in the application
 */
class tbl_pay extends Model
{
    /**
     *
     * @var integer
     */
    public $id;
    /**
     *
     * @var string
     */
    public $user_id;
    /**
     *
     * @var string
     */
    public $pay_method;
    /**
     *
     * @var string
     */
    public $pay_number;
    /**
     *
     * @var string
     */
    public $remark;
    /**
     *
     * @var string
     */
    public $is_active;

}
