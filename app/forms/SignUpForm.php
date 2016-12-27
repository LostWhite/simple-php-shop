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

class SignUpForm extends Form
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

        // Password
        $password = new Password('password');
        $password->setLabel('Password');
        CheckForm::addLength($password,'密码');
        CheckForm::addEmpty($password,'密码');
        $this->add($password);

        // Confirm Password
        $confirmPassword = new Password('confirmPassword');
        $confirmPassword->setLabel('Confirm Password');
        CheckForm::addMatch($confirmPassword,'密码确认','密码','password');
        CheckForm::addEmpty($confirmPassword,'密码确认');
        $this->add($confirmPassword);

        // Remember
//        $terms = new Check('terms', array(
//            'value' => 'yes'
//        ));

        //    $terms->setLabel('Accept terms and conditions');

//        $terms->addValidator(new Identical(array(
//            'value' => 'yes',
//            'message' => 'Terms and conditions must be accepted'
//        )));

        //      $this->add($terms);

        // CSRF
        $csrf = new Hidden('csrf');

        $csrf->addValidator(new Identical(array(
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation failed'
        )));

        $this->add($csrf);

        // Sign Up
        $this->add(new Submit('Sign Up', array(
            'class' => 'btn btn-success'
        )));
    }

    /**
     * Prints messages for a specific element
     */
    public function messages($name)
    {
        if ($this->hasMessagesFor($name)) {
            foreach ($this->getMessagesFor($name) as $message) {
                $this->flash->error($message);
            }
        }
    }
}
