<?php
namespace Vokuro\Models;

use Vokuro\DataBase\PdoController;

/**
 * Vokuro\Models\Users
 * All the users registered in the application
 */
class db_reward_answer extends PdoController
{
    private $tablename = 'tbl_reward_answer';//表名

    //获取最外层answer总数
    public function countByTaskid($conditiong){
        return $this->total($this->tablename,$conditiong);
    }

    //获取最外层answer
    public function getByTaskId($task_id,$begin=0,$rows=5){
        $sql = "select a.*,m.user_name,m.sale_total,m.sale_point,m.eval_percent,d.laslogin_time from ".$this->tablename." a
                left join mst_user_service m on a.user_id = m.ps_user_id
                left join mst_user_add d on a.user_id = d.user_id
                where a.level = 0 and
                a.task_id = ".$task_id."
                order by a.c_time
                limit ".$begin.",".$rows;
        return $this->query($sql);
    }

    //获取内层answer
    public function getByLevel($task_id,$answer_id1){
        $condition = "a.task_id = ".$task_id." and a.answer_id1 = ".$answer_id1." and a.level != 0";
        $order = "a.answer_id1,a.answer_id2,a.answer_id3,a.answer_id4,a.answer_id5";
        $sql = "select a.*,m.user_name AS user_name from ".$this->tablename." a
                left join mst_user m on a.user_id = m.user_id
                where ".$condition." order by ".$order;
        return $this->query($sql);
    }

    //插入数据后更新answer_id
    public function updateAnId($id,$answer_id){
        $fieldVal = array(
            $answer_id => $id
        );
        $condition = "answer_id = ".$id;
        $this->update($this->tablename,$fieldVal,$condition);
    }

    //任务结算获取参与预测师
    public function getEnd($task_id){
        $sql = "select a.user_id,m.user_name,LEFT(a.content,50) AS content from ".$this->tablename." a
                left join mst_user_service m on m.ps_user_id = a.user_id
                where a.task_id = ".$task_id."
                and a.level = 0
                group by a.user_id";
        return $this->query($sql);
    }

    //查看结算
    public function getEndPro($task_id){
        $sql = "select a.user_id,m.user_name,LEFT(a.content,50) AS content,t.t_order_id AS flg,t.ps_price from ".$this->tablename." a
                left join mst_user_service m on m.ps_user_id = a.user_id
                left join tbl_order_dtl t on t.pay_to_user_id = a.user_id
                where a.task_id = ".$task_id."
                and a.level = 0
                and t.task_id = ".$task_id."
                group by a.user_id";
        return $this->query($sql);
    }
}
