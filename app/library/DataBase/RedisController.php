<?php
namespace Vokuro\DataBase;
use Phalcon\Mvc\User\Component;
use Vokuro\Controllers\redis_cli;
use Vokuro\Controllers\rediss;
/**
 * Vokuro\DataBase\DbController
 */
class RedisController extends Component
{
    /**
     * Checks if a controller is private or not
     * @param string $controllerName
     * @return boolean
     */
    public function getConnection()
    {
        $config = include APP_DIR . '/config/config.php';
        $redisConnection = new redis_cli (  $config->redis->host,  $config->redis->port );

        return $redisConnection;
    }
}
