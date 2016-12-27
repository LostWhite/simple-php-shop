<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Vokuro\Models\Users
 * All the users registered in the application
 */
class tbl_title extends Model
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
    public $ps_user_id;
    /**
     *
     * @var string
     */
    public $site_id;
    /**
     *
     * @var string
     */
    public $status;
    /**
     *
     * @var string
     */
    public $type;
    /**
     *
     * @var string
     */
    public $title;
    /**
     *
     * @var string
     */
    public $art_type;

}
