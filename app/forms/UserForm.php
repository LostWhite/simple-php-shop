<?php
namespace Vokuro\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\date;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\File;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;

use Phalcon\Forms\Element\Textarea;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;
use Vokuro\Models\Profiles;

class UserForm extends Form
{

    public function initialize($entity = null, $options = null)
    {
        // 真实姓名
        $real_name= new Text('real_name', array(
            'placeholder' => '小丽',
        ));
        $real_name->addValidator(new PresenceOf(array(
            'message' => '真实姓名必须填写'
        )));
        $this->add($real_name);

        // 姓
        $user_name1= new Text('user_name1', array(
            'placeholder' => '姓',
        ));
        $user_name1->addValidator(new PresenceOf(array(
            'message' => '真实姓名必须填写'
        )));
        $this->add($user_name1);

        // 真实姓名
        $user_name2= new Text('user_name2', array(
            'placeholder' => '名',
        ));
        $user_name2->addValidator(new PresenceOf(array(
            'message' => '真实姓名必须填写'
        )));
        $this->add($user_name2);

        // 身份证号码
        $identif_id = new Text('identif_id', array(
            'placeholder' => '211014199102018888',
        ));
        $identif_id->addValidator(new PresenceOf(array(
            'message' => '身份证号码必须填写'
        )));
        $this->add($identif_id);

        //身份证正面
        $identif_img_front = new File('identif_img_front');
        $this->add($identif_img_front);

        //身份证反面
        $identif_img_back = new File('identif_img_back');
        $this->add($identif_img_back);

        // 联系地址
        $address = new Text('address', array(
            'placeholder' => '辽宁省大连市',
        ));
        $address->addValidator(new PresenceOf(array(
            'message' => '联系地址必须填写'
        )));
        $this->add($address);

        // 手机
        $mobile_num = new Text('mobile_num', array(
            'placeholder' => '13900158888',
        ));
        $mobile_num->addValidator(new PresenceOf(array(
            'message' => '手机必须填写'
        )));
        $this->add($mobile_num);

        // 擅长的预测方式：
        $expert_content = new Textarea('expert_content', array(
            'placeholder' => '事业，爱情，风水',
            'maxLength'=>'500'
        ));
        $expert_content->addValidator(new PresenceOf(array(
            'message' => '擅长的预测方式必须填写'
        )));
        $this->add($expert_content);
    }
}
