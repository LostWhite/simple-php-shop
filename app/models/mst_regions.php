<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Vokuro\Models\Users
 * All the users registered in the application
 */
class mst_regions extends Model
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
    public $t_r_id;

    /**
     *
     * @var string
     */
    public $t_r_name;

    /**
     *
     * @var integer
     */
    public $t_s_id;

    /**
     *
     * @var integer
     */
    public $t_s_name;

    /**
     *
     * @var string
     */
    public $t_q_id;

    /**
     *
     * @var integer
     */
    public $t_q_name;

}
