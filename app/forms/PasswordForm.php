<?php
namespace Vokuro\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;

class PasswordForm extends Form
{

    public function initialize()
    {

        // Password1
        $password1 = new Password('password1', array(
            'placeholder' => 'Password'
        ));

        $password1->addValidators(array(
            new \Phalcon\Validation\Validator\PresenceOf(array(
                    'message' => '旧密码不能为空'
            ))
        ));

        $this->add($password1);

        // Password2
        $password2 = new Password('password2', array(
            'placeholder' => 'Password'
        ));

        $password2->addValidators(array(
            new PresenceOf(array(
                'message' => '新密码不能为空'
            )),
            new StringLength(array(
                'min' => 8,
                'messageMinimum' => '长度不能小于8'
            )),
            new Confirmation(array(
                'message' => '密码确认错误',
                'with' => 'password3'
            ))
        ));

        $this->add($password2);

        // Password3
        $password3 = new Password('password3', array(
            'placeholder' => 'Password'
        ));

        $password3->addValidators(array(
            new PresenceOf(array(
                'message' => '密码确认不能为空'
            ))
        ));

        $this->add($password3);
    }
}
