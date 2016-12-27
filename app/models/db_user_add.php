<?php
namespace Vokuro\Models;

use Vokuro\DataBase\PdoController;

/**
 * Vokuro\Models\Users
 * All the users registered in the application
 */
class db_user_add extends PdoController
{
    private $tablename1 = 'mst_user_add';//表名1
    private $tablename2 = 't_online';//表名2

    public function test(){//测试数据库事务
        try{
            $this->begin();
            $sql = "insert into  t_online(user_id,site_id,status,sessionid) values(3, 1, 1, 1)  ";
            $this->query($sql);
            $sql1 = "update mst_user_add set reg_site_id = 2 where user_id = 3";
            $this->query($sql1);
            $sql1 = "update mst_user_add set laslogin_time = 'a' where user_id = 3";
            $this->query($sql1);
            $this->commit();
            return 0;
        }catch (\Exception $e){
            $this->rollback();
            return 1;
        }
    }
}
