<?php
namespace Vokuro\Common;
use Phalcon\Logger\Adapter\File as FileAdapter;
use Phalcon\Mvc\User\Component;
/**
 * Vokuro\DataBase\DbController
 */
class Comchat extends Component
{
 /**
     * 生成文件
     * @param $fname
     * @param $strArray
     */
    public function  writeChatfile($strArray, $recordid,  $siteid,$subpath ="test"){
        $config = include APP_DIR . '/config/config.php';
        $file_name=$siteid.'\\'.$recordid . ' .txt';
        $fname = $config->application->chat_backup.$file_name;
        $fp=fopen($fname,"w");
        
        echo "<br>";
        echo $fname ;
       
         fputs($fp,$strArray);
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
}
