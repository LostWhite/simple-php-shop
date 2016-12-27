<?php
namespace Vokuro\Phpmailer;

use Phalcon\Mvc\User\Component;
require_once 'PHPMailSend.php';
class Mail extends Component
{
    /* 发送确认邮件 */
    public function ConfirmMail($toaddr, $data){
        /* 解析邮件数据 */
        /* 发送邮件 */
        return $this->_SendMail('', '', '', '');
    }
    /* 发送邮件 */
    protected function _SendMail($addr, $name, $sub, $content)
    {
        /* 这里的参数说明请参照phpmailer的文档 */
        $mail = new PHPMailSend;
        $mail->setLanguage('zh_cn');
        $mail->CharSet = "UTF-8";
        $mail->isSMTP();
        $mail->SMTPDebug = 2;
        //$mail->Debugoutput = 'html';
        $mail->Host = "smtp.163.com";
        $mail->Port = 25;
        $mail->SMTPAuth = true;
        $mail->Username = "cjs.1989@163.com";
        $mail->Password = "365218944cjs";
        //$mail->setFrom('no-reply@xxxx.com', '发件人');
        $mail->addReplyTo('cjs.1989@163.com', 'cjs');
        $mail->addAddress('651244272@qq.com');
        $mail->Subject = "phpmailer测试标题";
        $mail->Body = "<h1>phpmail演示</h1>这是php点点通（<font color=red>www.phpddt.com</font>）对phpmailer的测试内容";
        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; //当邮件不支持html时备用显示，可以省略
        $mail->WordWrap   = 80; // 设置每行字符串的长度
        $mail->IsHTML(true);

        if (!$mail->send()) {
            echo "邮件发送错误: " . $mail->ErrorInfo;
            return false;
        } else {
            echo "邮件发送成功!";
            return true;
        }
    }

}

?>