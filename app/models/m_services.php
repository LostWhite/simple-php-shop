<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Vokuro\Models\Users
 * All the users registered in the application
 */
class m_services extends Model
{
    //服务ID
    public $service_id;
    //服务分类
    public $service_type;
}
