<?php
namespace Vokuro\Forms;
//适用环境： PHP5.2.x  / mysql 5.0.x 
//代码作者： smiling
//联系方式： www.04ie.com
use Phalcon\Validation\Validator,
    Phalcon\Validation\ValidatorInterface,
    Phalcon\Validation\Message;
Class Check extends Validator implements ValidatorInterface
{
    public function validate($validator, $attribute)	{
        $value = $validator->getValue($attribute);
        if ($value) {
            return true;
        }
        return false;
    }
}
?>
