<?php

namespace Vokuro\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Element\Textarea;
use Phalcon\Forms\Element\Select;

class ModifyForm extends Form
{
    public function initialize()
    {
        //name
        $login_id = new Text('login_id', array(
            'placeholder' => '用户名'
        ));
        CheckForm::addLength($login_id,'用户名');
        CheckForm::addEmpty($login_id,'用户名');
        $this->add($login_id);

        $user_content = new Textarea('user_content', array(
            'placeholder' => '用户简介'
        ));
        $this->add($user_content);
        /*
        $user_type = new Text('user_type', array(
            'placeholder' => '服务类型'
        ));
        $this->add($user_type);
        */
        $types = array(
            '1' => '服务',
            '2' => '商品',
        );
        $user_type = new Select('user_type', $types);
        $this->add($user_type);

        $types = array(
            '1' => '人生咨询',
        );
        $category_id = new Select('category_id', $types);
        $this->add($category_id);

        $expert_content = new Textarea('expert_content', array(
            'placeholder' => '擅长的预测方式'
        ));
        $this->add($expert_content);
    }
}