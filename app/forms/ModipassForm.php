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
use Phalcon\Validation\Validator\PresenceOf;

class ModipassForm extends Form
{

    public function initialize()
    {

        // Password1
        $password1 = new Password('password1', array(
            'placeholder' => '旧密码'
        ));
        CheckForm::addEmpty($password1,'旧密码');
        $this->add($password1);

        // Password2
        $password2 = new Password('password2', array(
            'placeholder' => '新密码'
        ));
        CheckForm::addLength($password2,'新密码');
        CheckForm::addEmpty($password2,'新密码');
        $this->add($password2);

        // Password3
        $password3 = new Password('password3', array(
            'placeholder' => '密码确认'
        ));
        CheckForm::addMatch($password3,'重复密码','新密码','password2');
        CheckForm::addEmpty($password3,'重复密码');
        $this->add($password3);
    }
}
