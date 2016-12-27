<?php
namespace Vokuro\Logging;
use Phalcon\Logger\Adapter\File as FileAdapter;
use Phalcon\Mvc\User\Component;
use Vokuro\Controllers\redis_cli;
/**
 * Vokuro\DataBase\DbController
 */
class Logging extends Component
{
    private $logger;
   /**
     * Checks if a controller is private or not
     *
     * @param string $controllerName
     * @return boolean
     */
    public function InfoLog($controller,$action,$log)
    {
        $userId=$this->session->get("user_id");
        $userName=$this->session->get("user_name");
        if(isset($userId)==false){
            //guest
            $userId="-99";
            $userName="guest";
        }
        if(is_string($log)){
            $log=sprintf("%s (%s ):Controller=>%s ,Action=>%s ,log=>%s ",$userId,$userName,$controller,$action,$log);
        }else{
            $log=sprintf("%s (%s ):Controller=>%s ,Action=>%s ,log=>%s ",$userId,$userName,$controller,$action,json_encode($log));
        }

       $this->getLogging()->log($log);
    }
    private function getLogging(){
        if(isset($logger)==false){
            $config = include APP_DIR . '/config/config.php';
            $logger = new FileAdapter( $config->log->path);
        }
        return $logger;
    }

}
