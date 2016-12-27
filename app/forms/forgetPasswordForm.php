<?php
namespace Vokuro\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Check;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;

class ForgetPasswordForm extends Form
{

    public function initialize($entity = null, $options = null)
    {
        $name = new Text('username');
        $name->setLabel('用户名');
        CheckForm::addLength($name,'用户名');
        CheckForm::addEmpty($name,'用户名');
        $this->add($name);

        // Email
        $email = new Text('email');
        $email->setLabel('E-Mail');
        CheckForm::addMail($email,'邮箱');
        CheckForm::addEmpty($email,'邮箱');
        $this->add($email);
    }
}
