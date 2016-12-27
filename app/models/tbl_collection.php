<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Vokuro\Models\Users
 * All the users registered in the application
 */
class tbl_collection extends Model
{
    /**
     *
     * @var integer
     */
    public $collection_id;

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     *
     * @var integer
     */
    public $site_id;

    /**
     *
     * @var integer
     */
    public $ps_user_id;
}
