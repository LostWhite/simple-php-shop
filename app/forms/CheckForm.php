<?php
namespace Vokuro\Forms;

class CheckForm
{
    /*
    public function validate($validator, $attribute)	{
        $value = $validator->getValue($attribute);
        if ($value) {
            return true;
        }
        return false;
    }
    */


    //不为空check
    Static function addEmpty2(&$obj,$label){
        $obj->addValidators(array(
            new \Phalcon\Validation\Validator\PresenceOf(array(
                'message' => ''
            )),
        ));
    }

    //不为空check
    Static function addEmpty(&$obj,$label){
        $obj->addValidators(array(
            new \Phalcon\Validation\Validator\PresenceOf(array(
                'message' => $label.'不能为空'
            )),
        ));
    }
    //长度check
    Static function addLength(&$obj,$label){
        $obj->addValidators(array(
            new \Phalcon\Validation\Validator\StringLength(array(
                'max' => 12,
                'min' => 4,
                'messageMaximum' => $label.'长度不能大于12',
                'messageMinimum' => $label.'长度不能小于4'
            )),
        ));
    }
    //邮箱格式check
    Static function addMail(&$obj,$label){
        $obj->addValidators(array(
            new \Phalcon\Validation\Validator\Email(array(
                'message' => $label.'格式不正确'
            )),
        ));
    }
    //数字check
    Static function addNum(&$obj,$label){
        $obj->addValidators(array(
            new \Phalcon\Validation\Validator\Regex(array(
                'pattern' => '/^[0-9\.]*$/',
                'message' => $label.'不是数字'
            )),
        ));
    }
    //检测两个值是否相等
    Static function addMatch(&$obj,$label1,$label2,$label3){
        $obj->addValidators(array(
            new \Phalcon\Validation\Validator\Confirmation(array(
                'message' => $label1.'和'.$label2.'不匹配',
                'with' => $label3,
            )),
        ));
    }
    //检测参数的值是否为正确的中国手机号码格式
    Static function addMobile(&$obj,$label){
        $obj->addValidators(array(
            new \Phalcon\Validation\Validator\Regex(array(
                'pattern' => '/^(?:13|15|18)[0-9]{9}$/',
                'message' => $label.'不是正确的手机格式'
            )),
        ));
    }
    //检测值是否位于两个值之间
    Static function addBetween(&$obj,$label){
        $obj->addValidators(array(
            new \Phalcon\Validation\Validator\Between(array(
                'minimum' => 0,
                'maximum' => 100,
                'message' => $label.'不在指定的范围'
            )),
        ));
    }
    //检测值是否在列举的范围内
    Static function addInclusionIn(&$obj,$label){
        $obj->addValidators(array(
            new \Phalcon\Validation\Validator\InclusionIn(array(
                'message' => $label.'不在指定的范围',
                'domain' => array('A', 'B')
            )),
        ));
    }
}
