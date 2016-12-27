<?php
/**
 * Created by PhpStorm.
 * User: cp1
 * Date: 2015-09-20
 * Time: 17:18
 */

namespace Vokuro\Phpmailer;


class mailException extends Exception {
    public function errorMessage() {
        $errorMsg = '<strong>' . $this->getMessage() . "</strong><br />\n";
        return $errorMsg;
    }
} 