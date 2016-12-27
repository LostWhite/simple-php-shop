<?php
namespace Vokuro\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Vokuro\Models\t_teacher_detail
 * All the users registered in the application
 */
class mst_user_service extends Model
{
    /**
     * 用户ID
     * @var integer
     */
    public $ps_user_id;

    /**
     * 用户名
     * @var string
     */
    public $user_name;

    /**
     * 真实姓名
     * @var string
     */
    public $real_name;

    /**
     * 身份证号码
     * @var integer
     */
    public $identif_id;

    /**
     * 身份证正面图片路径
     * @var string
     */
    public $identif_img_front;

    /**
     * 身份证反面图片路径
     * @var string
     */
    public $identif_img_back;

    /**
     * 联系地址
     * @var string
     */
    public $address;

    /**
     * 手机
     * @var string
     */
    public $mobile_num;

    /**
     * 擅长的预测方式
     * @var string
     */
    public $expert_content;

    /**
     * 用户类型
     * @var integer
     */
    public $flg;

    public function getSource()
    {
        return "mst_user_service";
    }
}
