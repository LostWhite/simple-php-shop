   <?php
       /**
     * Define some useful constants
     */
     	use Vokuro\Common\Online;
     	echo session.save_path;
     $timeover =5000;
    define('BASE_DIR', dirname(__DIR__));
    define('APP_DIR', BASE_DIR . '/app');
    define('DEFINE_SITE_ID', 1);
	$config = include APP_DIR . '/config/config.php';
	
   $redis = new Redis();
    $redis->connect($config->redis->host,  $config->redis->port );
    $redis->select(1);

    $userset = $redis->HGETALL('_usetime');
    print_r($userset);
    foreach ($userset as $k => $v) { 
		//if  ( time() - $v >$timeover){
			echo  $k. "*<br>"; 
			  $redis ->HDEL('_use',$k);
      		  $redis->HDEL('_usename',$k);
        	  $redis ->HDEL('_usetime',$k);
        
		//} 
		echo "*<br>"; 
	} 
   // print_r($userset);
    echo "**";