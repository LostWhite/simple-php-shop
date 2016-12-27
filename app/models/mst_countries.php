<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Vokuro\Models\Users
 * All the users registered in the application
 */
class mst_countries extends Model
{
    /**
     *
     * @var integer
     */
    public $t_id;

    /**
     *
     * @var string
     */
    public $t_c_id;

    /**
     *
     * @var string
     */
    public $t_c_name;

    /**
     *
     * @var integer
     */
    public $t_c_english;

    /**
     *
     * @var string
     */
    public $t_c_abbreviatio;

    /**
     *
     * @var integer
     */
    public $t_c_time;
}
