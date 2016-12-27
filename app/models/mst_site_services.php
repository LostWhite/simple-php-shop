<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Vokuro\Models\Users
 * All the users registered in the application
 */
class mst_site_services extends Model
{

    /**
     *
     * @var integer
     */
    public $ps_site_id;

    /**
     *
     * @var integer
     */
    public $ps_user_id;

    /**
     *
     * @var integer
     */
    public $ps_id;

    /**
     *
     * @var integer
     */
    public $site_id;

    /**
     *
     * @var integer
     */
    public $ps_name;

    /**
     *
     * @var integer
     */
    public $ps_type;

    /**
     *
     * @var integer
     */
    public $ps_price;

    /**
     *
     * @var integer
     */
    public $ps_money;

    /**
     *
     * @var string
     */
    public $buy_total;

}
