<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Vokuro\Models\Users
 * All the users registered in the application
 */
class mst_user_site extends Model
{
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

    public function getSource()
    {
        return "mst_user_site";
    }

}
