<?php
namespace Vokuro\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;

class LoginForm extends Form
{

    public function initialize()
    {
        // Email
        $name = new Text('name', array(
            'placeholder' => '用户名'
        ));
        /*
        $this->add('name', new \Vokuro\Forms\IpValidator (array(
            'message' => 'not a ip'
        )));
        */
        CheckForm::addEmpty($name,'用户名');
        /*
        $name->addValidators(array(
            new \Phalcon\Validation\Validator\PresenceOf(array(
                'message' => '用户名不能为空'
            )),
        ));
         */
        $this->add($name);

        // Password
        $password = new Password('password', array(
            'placeholder' => '密码'
        ));
        CheckForm::addEmpty($password,'密码');
        $this->add($password);

        /*
        // Remember
        $remember = new Check('remember', array(
            'value' => 'yes'
        ));

        $remember->setLabel('Remember me');

        $this->add($remember);

        // CSRF
        $csrf = new Hidden('csrf');

        $csrf->addValidator(new Identical(array(
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation failed'
        )));

        $this->add($csrf);

        $this->add(new Submit('go', array(
            'class' => 'btn btn-success'
        )));
        */
    }
}
