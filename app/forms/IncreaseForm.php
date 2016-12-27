<?php

namespace Vokuro\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Element\Select;

class IncreaseForm extends Form
{
    public function initialize()
    {
        //email
        $email = new Text('email', array(
            'placeholder' => '邮箱'
        ));
        CheckForm::addMail($email,'邮箱');
        CheckForm::addEmpty($email,'邮箱');
        $this->add($email);

        //name
        $login_id = new Text('login_id', array(
            'placeholder' => '用户名'
        ));
        //CheckForm::addLength($login_id,'用户名');
        //CheckForm::addEmpty($login_id,'用户名');
        $this->add($login_id);

        $name1 = new Text('name1', array(
            'placeholder' => '姓'
        ));
        $this->add($name1);

        $name2 = new Text('name2', array(
            'placeholder' => '名'
        ));
        $this->add($name2);

        //zipcode
        $zipcode = new Text('zipcode', array(
            'placeholder' => '邮政编码'
        ));
        $this->add($zipcode);
        /*
        $countries = array(
            '1' => '日本',
            '2' => '美国',
            '37' => '中国'
        );
        $address1 = new Select('addr_id1', $countries);
        $this->add($address1);

        $address2 = new Select('addr_id2', array(

        ));
        $this->add($address2);

        $address3 = new Select('addr_id3', array(

        ));
        $this->add($address3);

        $address4 = new Select('addr_id4', array(

        ));
        $this->add($address4);
        */

        //address5
        $address5 = new Text('address5', array(
            'placeholder' => '详细地址'
        ));
        $this->add($address5);

        //tel_number
        $tel_number = new Text('tel_number', array(
            'placeholder' => '电话号码'
        ));
        $this->add($tel_number);

        //mobile_number
        $mobile_number = new Text('mobile_number', array(
            'placeholder' => '手机号码'
        ));
        /*
        CheckForm::addEmpty($mobile_number,'手机号码');
        $name = $mobile_number->getName();
        $message = $mobile_number->getMessages('mobile_number');
        var_dump($message);exit;
        $messages = $mobile_number->getMessagesFor('mobile_number');
        var_dump($messages);exit;
        */
        $this->add($mobile_number);

        //qqno
        $qqno = new Text('qqno', array(
            'placeholder' => 'QQ号码'
        ));
        $this->add($qqno);

        //birth
        $birth = new Date('birth', array(
            'placeholder' => '出生年月'
        ));
        $this->add($birth);
    }
}