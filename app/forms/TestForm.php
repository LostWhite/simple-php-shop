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
use Vokuro\Models\Profiles;
use Vokuro\Models\m_common;

class TestForm extends Form
{

    public function initialize($entity = null, $options = null)
    {

        // In edition the id is hidden
//        if (isset($options['edit']) && $options['edit']) {
//            $id = new Hidden('id');
//        } else {
//            $id = new Text('id');
//        }
        $id = new Text('user_id');
        $this->add($id);

        $task_name = new Text('task_name', array(
            'placeholder' => '任务名'
        ));

        $task_name->addValidators(array(
            new PresenceOf(array(
                'message' => 'The name is required'
            ))
        ));

        $this->add($task_name);

        $task_remark = new Textarea('task_remark', array(
            'placeholder' => '任务介绍'
        ));
        $this->add($task_remark);

        $this->add(new Select('pay_type', m_common::find('type_id = "102"'), array(
            'using' => array(
                'id',
                'item_name'
            ),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => ''
        )));

        $pay_reward = new Text('pay_reward', array(
            'placeholder' => '赏金'
        ));
        $this->add($pay_reward);


         $remark = new Textarea('other_remark', array(
              'placeholder' => '备注'
          ));
        $this->add($remark);

        $date = new Date('time_limit', array(
            'placeholder' => '期限'
        ));
        $this->add($date);

//        $email = new Text('email', array(
//            'placeholder' => 'Email'
//        ));

//        $email->addValidators(array(
//            new PresenceOf(array(
//                'message' => 'The e-mail is required'
//            )),
//            new Email(array(
//                'message' => 'The e-mail is not valid'
//            ))
//        ));

//        $this->add($email);

        $this->add(new Select('big_catagory', m_common::find('type_pid = "0" AND type_id = "101"'), array(
            'using' => array(
                'id',
                'item_name'
            ),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => ''
        )));
        $this->add(new Select('small_catagory', m_common::find('type_pid != "0" AND type_id = "101"'), array(
            'using' => array(
                'id',
                'item_name'
            ),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => ''
        )));

        $file = new File('fileName');
        $this->add($file);
        $file2 = new File('fileName2');
        $this->add($file2);
        $file3 = new File('fileName3');
        $this->add($file3);

        $textArea = new Textarea("remark");
        $this->add($textArea);

        $this->add(new Select('banned', array(
            'Y' => 'Yes',
            'N' => 'No'
        )));

        $this->add(new Select('suspended', array(
            'Y' => 'Yes',
            'N' => 'No'
        )));

        $this->add(new Select('active', array(
            'Y' => 'Yes',
            'N' => 'No'
        )));
    }
}
