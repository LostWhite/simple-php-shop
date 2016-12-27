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

class SupdateForm extends Form
{
    public function initialize()
    {
        //name
        $t_ps_name = new Text('t_ps_name', array(
            'placeholder' => '初始服务名'
        ));
        //CheckForm::addEmpty($t_ps_name,'初始服务名');
        $this->add($t_ps_name);

        //name
        $ps_name = new Text('ps_name', array(
            'placeholder' => '本站服务名'
        ));
        CheckForm::addEmpty($ps_name,'本站服务名');
        $this->add($ps_name);

        //name
        $t_ps_content = new Textarea('t_ps_content', array(
            'placeholder' => '服务简介'
        ));
        $this->add($t_ps_content);

        $ps_price = new Text('ps_price', array(
            'placeholder' => '价格'
        ));
        CheckForm::addNum($ps_price,'价格');
        CheckForm::addEmpty($ps_price,'价格');
        $this->add($ps_price);

        /*
        $t_ps_type = new Text('t_ps_type', array(
            'placeholder' => '服务类型'
        ));
        CheckForm::addNum($t_ps_type,'服务类型');
        CheckForm::addEmpty($t_ps_type,'服务类型');
        $this->add($t_ps_type);
        */
        $t_ps_type = new Select('t_ps_type', array(
            '1' => '服务项',
            '2' => '商品',
        ));
        $this->add($t_ps_type);

        $category_id = new Text('category_id',array(
            'placeholder' => '大项目分类'
        ));
        $this->add($category_id);

        $category_sub_id = new Text('category_sub_id	', array(
            'placeholder' => '中项目分类'
        ));
        $this->add($category_sub_id);
    }
}