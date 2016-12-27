<?php
namespace Vokuro\Models;

use Vokuro\DataBase\PdoController;

/**
 * Vokuro\Models\Users
 * All the users registered in the application
 */
class db_mst_user extends PdoController
{
    private $tablename = 'mst_user';//表名

    public function getAllUser(){
        return $this->getAll($this->tablename);
    }
}
