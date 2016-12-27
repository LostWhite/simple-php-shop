<?php
namespace Vokuro\Models;

use Vokuro\DataBase\PdoController;

/**
 * Vokuro\Models\Users
 * All the users registered in the application
 */
class db_reward_task extends PdoController
{
    private $tablename = 'tbl_reward_task';//表名

    //$condition=''
    public function count($condition=''){
        return $this->total($this->tablename,$condition);
    }

    public function getAllUser($fields='*',$condition,$order,$limit,$flg){
        if($flg){
            $order = $order." desc";
        }
        if(is_array($limit)){
            $limit = $limit[0].",".$limit[1];
        }
        return $this->getAll($this->tablename,$fields,$condition,$order,$limit);
    }

    public function searchAll($order,$limit,$flg){
        if($flg){
            $order = " order by ".$order." desc";
        }
        if(is_array($limit)){
            $limit = " limit ".$limit[0].",".$limit[1];
        }
        $sql = "select task.*,big.big_catagory AS big_catagory_name,sm.small_catagory AS small_catagory_name from ".$this->tablename." task
                left join tbl_big_catagory big on big.big_catagory_id = task.big_catagory and big.site_id = ".DEFINE_SITE_ID."
                left join tbl_small_catagory sm on sm.small_catagory_id = task.small_catagory and sm.site_id = ".DEFINE_SITE_ID."
                where task.site_id = ".DEFINE_SITE_ID.$order.$limit;
        return $this->query($sql);
    }

    public function searchOne($task_id){
        $sql = "select DISTINCT ta.*,m.user_name AS user_name,big.big_catagory AS big_catagory_name,sm.small_catagory AS small_catagory_name from ".$this->tablename." ta
                left join mst_user m on m.user_id = ta.user_id
                left join tbl_big_catagory big on big.big_catagory_id = ta.big_catagory and big.site_id = ".DEFINE_SITE_ID."
                left join tbl_small_catagory sm on sm.small_catagory_id = ta.small_catagory and sm.site_id = ".DEFINE_SITE_ID."
                left join tbl_order_dtl o on o.task_id = ta.task_id
                where ta.task_id = ".$task_id;
        return $this->query($sql);
    }

    //获取完成此任务的预测师
    public function getTaskPro($task_id){
        $sql = "select o.user_id,m.user_name from tbl_order_dtl o LEFT JOIN mst_user_service m on m.ps_user_id = o.pay_to_user_id
              where o.status = 2 and o.task_id = ".$task_id;
        return $this->query($sql);
    }
}
