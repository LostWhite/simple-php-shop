<?php
namespace Vokuro\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;
use Vokuro\Auth\Exception;
use Vokuro\Forms\ArticleForm;
use Vokuro\Models\tbl_title;

/**
 * Vokuro\Controllers\UsersCo ntroller
 * CRUD to manage users
 */
class ArticleController extends ControllerBase
{
    /**
     * Default action, shows the search form
     */
    public function indexAction()
    {
       // $this->view->setVar('logged_in',$this->sessi on->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';
    }

    /**
     * 预测师文章浏览
     */
    public function tarticleAction($id)
    {
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $where = "id = ".$id;
        $note = tbl_title::findFirst($where);
        $this->view->setVar('note',$note);

        $user_id = $this->session->get("user_id");
        if($user_id && $user_id == $note->ps_user_id){
            $this->view->setVar('editor',1);
        }
    }

    /**
     * 预测师文章上传
     */
    public function particleAction()
    {
       // $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $form = new ArticleForm();
        $this->view->form=$form;

        if ($this->request->isPost()) {
            if($form->isValid($this->request->getPost()) == false){
                //check
                $messages = CheckTable::getMessage($form);
                
                foreach($messages as $key => $value){
                    $this->view->setVar($key,$value);
                }
            }else{
                //保存文章
                $ps_user_id = $this->session->get("user_id");
                $article = new tbl_title();
                $article->assign(array(
                    'ps_user_id' => $ps_user_id,
                    'site_id' => DEFINE_SITE_ID,
                    'type' => 1,
                    'title' => $this->request->getPost('title'),
                    'sub_title' => $this->request->getPost('sub_title'),
                    'date' => date('Y-m-d H:i:s',time()),
                    'page_text' => $this->request->getPost('page_text'),
                    'r_date' => date('Y-m-d H:i:s',time()),
                    'u_date' => date('Y-m-d H:i:s',time()),
                    'art_type' => 1,
                ));
                if($article->save()){
                    $this->view->setVar('flg','保存成功！');
                }else{
                    $this->db->rollback();
                }
            }
        }
    }

    /**
     * 预测师文章编辑
     */
    public function editorAction($id){
        $this->view->setVar('logged_in',$this->session->get("user_name") );
        $this->view->setTemplateBefore('public');
        $config = include APP_DIR . '/config/config.php';

        $form = new ArticleForm();
        $this->view->form=$form;

        $where = "id = ".$id;
        $note = tbl_title::findFirst($where);
        $this->view->setVar('note',$note);

        if ($this->request->isPost()) {
            if($form->isValid($this->request->getPost()) == false){
                //check
                $messages = CheckTable::getMessage($form);
                foreach($messages as $key => $value){
                    $this->view->setVar($key,$value);
                }
            } else{
                //保存文章
                $note->assign(array(
                    'title' => $this->request->getPost('title'),
                    'sub_title' => $this->request->getPost('sub_title'),
                    'page_text' => $this->request->getPost('page_text'),
                    'u_date' => date('Y-m-d H:i:s',time()),
                ));
                if($note->save()){
                    $this->view->setVar('flg','保存成功。');
                }else{
                    $this->db->rollback();
                }
            }
        }
    }

}
