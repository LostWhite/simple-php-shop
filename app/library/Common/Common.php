<?php
namespace Vokuro\Common;
use Phalcon\Logger\Adapter\File as FileAdapter;
use Phalcon\Mvc\User\Component;
use Vokuro\Controllers\redis_cli;
/**
 * Vokuro\DataBase\DbController
 */
class Common extends Component
{


    /**
     * 生成文件
     * @param $fname
     * @param $strArray
     */
    public function  writefile($strArray,$strHeader){
        $config = include APP_DIR . '/config/config.php';
        $file_name=time();
        $fname = $config->application->chat_backup.$file_name;

        $fp=fopen($fname,"w");

        //写在最前title
        if(isset($strHeader)){
            fputs($fp,$strHeader);
            fputs($fp, "\n");
        }
        for ($i = 0; $i < count($strArray); $i++) {
            fputs($fp,$strArray[$i]);
            fputs($fp, "\n");
        }
        fclose($fp);
        return $file_name;
}
 /**
     * 生成文件
     * @param $fname
     * @param $strArray
     */
    public function  writeChatfile($strArray, $recordid,  $siteid,$subpath ="test"){
        $config = include APP_DIR . '/config/config.php';
        $file_name=time();
        $fname = $config->application->chat_backup.$file_name;
        $fp=fopen($fname,"w");
        //写在最前title
        if(isset($strHeader)){
            fputs($fp,$strHeader);
            fputs($fp, "\n");
        }
        for ($i = 0; $i < count($strArray); $i++) {
            fputs($fp,$strArray[$i]);
            fputs($fp, "\n");
        }
        fclose($fp);
        return $file_name;
}
    /**
     * 文件下载
     *
     * @param string $file_path 文件路径
     */
    public function downloadFileForBackUp($file_path)
    {

        if (!file_exists($file_path)) {
            $this->flash->warning("文件不存在.");
            exit;
        }
        $fp = fopen($file_path, "r");
        $file_size = filesize($file_path);
        $buffer = 1024;
        $file_count = 0;
        echo fread($fp, $file_size);
        fclose($fp);
    }


    /**
     * 文件下载
     *
     * @param string $file_path 文件路径
     */
    public function downloadFile($file_path)
    {

        if (!file_exists($file_path)) {
            $this->flash->warning("文件不存在.");
            exit;
        }
        $fp = fopen($file_path, "r");
        $file_size = filesize($file_path);
//         echo $file_path;
//        echo "####";
//        exit;


        //下载文件需要用到的头
        header("Content-type: image/jpeg");
        header("Accept-Ranges: bytes");
        header("Accept-Length:" . $file_size);
        header("Content-Disposition: attachment; filename=" . basename($file_path));
        $buffer = 1024;
        $file_count = 0;
       echo fread($fp, $file_size);
       fclose($fp);
//        //向浏览器返回数据
//        while (!feof($fp) && $file_count < $file_size) {
//            $file_con = fread($fp, $buffer);
//            $file_count += $buffer;
//            echo $file_con;
//        }
//        fclose($fp);
       // exit;
    }

    /**
     * 文件名check
     *
     * @param string $file
     * @return 文件名
     */
    public function checkfilename($file)
    {

        if (!$file) return "";
        $file = trim($file);
        $a = substr($file, -1);

        $arr = array("../", "./", "/", "\\", "..\\", ".\\");
        $file = str_replace($arr, "", $file);
        return $file;
    }

    /*
     * ip取得
     */
    public function get_ip()
    {
        global $_SERVER;
        if ($_SERVER) {
            if ($_SERVER[HTTP_X_FORWARDED_FOR])
                $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            else if ($_SERVER["HTTP_CLIENT_ip"])
                $realip = $_SERVER["HTTP_CLIENT_ip"];
            else
                $realip = $_SERVER["REMOTE_ADDR"];
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR'))
                $realip = getenv('HTTP_X_FORWARDED_FOR');
            else if (getenv('HTTP_CLIENT_ip'))
                $realip = getenv('HTTP_CLIENT_ip');
            else
                $realip = getenv('REMOTE_ADDR');
        }
        return $realip;
    }

    /*
     * array->json
     */
     public function array2json($arr)
    {
        $keys = array_keys($arr);
        $isarr = true;
        $json = "";
        for ($i = 0; $i < count($keys); $i++) {
            if ($keys[$i] !== $i) {
                $isarr = false;
                break;
            }
        }
        $json = $space;
        $json .= ($isarr) ? "[" : "{";
        for ($i = 0; $i < count($keys); $i++) {
            if ($i != 0) $json .= ",";
            $item = $arr[$keys[$i]];
            $json .= ($isarr) ? "" : $keys[$i] . ':';
            if (is_array($item))
                $json .= $this->array2json($item);
            else if (is_string($item))
                $json .= '"' . str_replace(array("\r", "\n"), "", $item) . '"';
            else $json .= $item;
        }
        $json .= ($isarr) ? "]" : "}";
        return $json;
    }

    /*
     * 字符串format
     */
    public function format() {

        $args = func_get_args();

        if (count($args) == 0) { return;}

        if (count($args) == 1) { return $args[0]; }

        $str = array_shift($args);

        $str = preg_replace_callback('/\\{(0|[1-9]\\d*)\\}/', create_function('$match', '$args = '.var_export($args, true).'; return isset($args[$match[1]]) ? $args[$match[1]] : $match[0];'), $str);

        return $str;

    }
    public function GetHeadUrl($user_id){
        include(APP_DIR."/config/link.php");
       return "{$site_url}public/img/head_{$user_id}_40_40.jpg";
    }
    public function getParam($str){
        $data = array();
        $SS = explode('?',$str);
        $aa = end($SS);
        $parameter = explode('&',$aa);
        foreach($parameter as $val){
            $tmp = explode('=',$val);
            $data[$tmp[0]] = $tmp[1];
        }
        return $data;
    }

    /*
    public function sendMail($to_mail){
        ini_set("magic_quotes_runtime",0);
        require_once 'PHPMailer.php';
        //require_once 'class.phpmailer.php';
        try {
            //
            var_dump(111);
            $mail = new PHPMailer(true);
            var_dump(222);
            $mail->IsSMTP();
            $mail->CharSet='UTF-8'; //设置邮件的字符编码，这很重要，不然中文乱码
            $mail->SMTPAuth   = true;                  //开启认证
            $mail->Port       = 25;
            $mail->Host       = "smtp.163.com";
            $mail->Username   = "cjs.1989@163.com";
            $mail->Password   = "365218944cjs";
            //$mail->IsSendmail(); //如果没有sendmail组件就注释掉，否则出现“Could  not execute: /var/qmail/bin/sendmail ”的错误提示
            $mail->AddReplyTo("cjs.1989@163.com","mckee");//回复地址
            $mail->From       = "cjs.1989@163.com";
            $mail->FromName   = "www.huasi.com";
            $to = $to_mail;
            $mail->AddAddress($to);
            $mail->Subject  = "phpmailer测试标题";
            $mail->Body = "<h1>phpmail演示</h1>这是php点点通（<font color=red>www.phpddt.com</font>）对phpmailer的测试内容";
            $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; //当邮件不支持html时备用显示，可以省略
            $mail->WordWrap   = 80; // 设置每行字符串的长度
            //$mail->AddAttachment("f:/test.png");  //可以添加附件
            $mail->IsHTML(true);
            $mail->Send();
            return '邮件已发送';
        } catch (\Exception $e) {
            return "邮件发送失败：".$e->errorMessage();
        }
    }
    */
}
