<?php
namespace Vokuro\DataBase;
use Phalcon\Mvc\User\Component;
/**
 * Vokuro\DataBase\DbController
 */
class DbController extends Component
{
    /**
     * The DbController Object
     *
     * @var \Phalcon\Acl\Adapter\Memory
     */
    /**
     * Checks if a controller is private or not
     *
     * @param string $controllerName
     * @return boolean
     */
    private function getConnection()
    {
        $config = include APP_DIR . '/config/config.php';
        $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => $config->database->host,
            "username" =>  $config->database->username,
            "password" =>  $config->database->password,
            "dbname" => $config->database->dbname,
        ));
        $connection->query('set names utf8');
        return $connection;
    }

    /**
     * Checks if the current profile is allowed to access a resource
     *
     * @param string $profile
     * @param string $controller
     * @param string $action
     * @return boolean
     */
    public function QueryAll($sql)
    {
        return $this->getConnection()->fetchAll($sql);
    }

    public function Query($sql)
    {
        return $this->getConnection()->query($sql);
    }

    /*
     * 绑定参数，防sql注入；
     * 例：// 用指定的占位符绑定参数
            $sql     = "INSERT INTO `robots`(name`, year) VALUES (:name, :year)";
            $success = $connection->query($sql, array("name" => "Astro Boy", "year" => 1952));
     */
    public function QueryPar($sql, $array){
        return $this->getConnection()->query($sql, $array);
    }
}
