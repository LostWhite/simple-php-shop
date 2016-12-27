<?php

namespace Vokuro\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Textarea;

class ArticleForm extends Form
{
    public function initialize()
    {
        //name
        $title = new Text('title', array(
            'placeholder' => '文章标题'
        ));
        //CheckForm::addLength($login_id,'用户名');
        CheckForm::addEmpty($title,'文章标题');
        $this->add($title);

        $sub_title = new Textarea('sub_title', array(
            'placeholder' => '副标题'
        ));
        $this->add($sub_title);

        $page_text = new Textarea('page_text', array(
            'placeholder' => '文章内容'
        ));
        CheckForm::addEmpty($page_text,'文章内容');
        $this->add($page_text);

    }
}