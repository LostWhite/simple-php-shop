<?php
//适用环境： PHP5.2.x  / mysql 5.0.x
//代码作者： smiling
//联系方式： www.04ie.com
/**
 * Check检测类
 *
 *
 * 1 非空check
 * 2 数字
 * 3 半角英数
 *
 */
Class Check{
    /**
     * 检测是否为空
     */
    Static function IsNull($Argv){
        if(isset($Argv)){
            if($Argv == ""){
                return false;
            }else{
                return $Argv;
            }
        }else{
            return false;
        }
    }

    /*
    *
    * 1 非空check
    * 2 数字
    * 3 半角英数
    * 4 长度检查
    * 5 邮箱格式检查
    *
    */

    Static function CheckValue( $value, $chkfields, $default = '' ){

        foreach ( $chkfields['chk'] as $val ) {

            switch( $val ){
                case 1:
                    if (is_array($value)) {
                        if (count($value) <=0) {
                            return  $chkfields['txt']. '不能为空！';
                        }

                    } else {
                        if( $default != '' ){
                            if( trim($value) == '' || $value == $default ){
                                return  $chkfields['txt']. '不能为空！';
                            }

                        }else{
                            if( trim($value) == '' ){

                                return  $chkfields['txt']. '不能为空！';
                            }
                        }
                    }
                    break;
                case 2:
                    /*
                        if ($this->number_check( $value )) {
                            return  $chkfields['txt']. '请输入数字！';
                        }
                        */
                    break;

                case 3:
                    //半角英数チェック
                    /*
                       if ($this->number_check( $value )) {
                           return  $chkfields['txt']. '请输入英文或数字！';
                       }
                       */
                    break;

                case 4:
                    //长度检查
                    $vallen = strlen( $value );
                    if (isset($chkfields['len'][0])  and $chkfields['len'][0]>0) {
                        if ($vallen < $chkfields['len'][0]) {
                            return  $chkfields['txt']. '请至少输入'. $chkfields['len'][0] .'个文字！';
                            break;
                        }

                    }
                    if (isset($chkfields['len'][0])  and $chkfields['len'][0]>0) {
                        if ($vallen < $chkfields['len'][0]) {
                            return  $chkfields['txt']. '请输入'. $chkfields['len'][0] .'以内个文字！';
                            break;
                        }

                    }
                    break;


                case 5:
                    //邮箱格式检查
                    if(!self::IsMail($value)){
                        return '请输入正确的邮箱格式，例：123@163.com';
                    }
                    break;
            }

        }
        return false;
    }

    /**
     * IsUsername函数:检测是否符合用户名格式
     * $Argv是要检测的用户名参数
     * $RegExp是要进行检测的正则语句
     * 返回值:符合用户名格式返回用户名,不是返回false
     */
    Static function IsUsername($Argv){
        $RegExp='/^[a-zA-Z0-9_]{3,16}$/'; //由大小写字母跟数字组成并且长度在3-16字符
        return preg_match($RegExp,$Argv)?$Argv:false;
    }

    /**
     * IsMail函数:检测是否为正确的邮件格式
     * 返回值:是正确的邮件格式返回邮件,不是返回false
     */
    Static function IsMail($Argv){
        //$RegExp='/^[a-z0-9][a-z\.0-9-_] @[a-z0-9_-] (?:\.[a-z]{0,3}\.[a-z]{0,2}|\.[a-z]{0,3}|\.[a-z]{0,2})$/i';
        $RegExp='/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/';
        return preg_match($RegExp,$Argv)?$Argv:false;
    }

    /**
     * IsSmae函数:检测参数的值是否相同
     * 返回值:相同返回true,不相同返回false
     */
    Static function IsSame($ArgvOne,$ArgvTwo,$Force=false){
        return $Force?$ArgvOne===$ArgvTwo:$ArgvOne==$ArgvTwo;
    }

    /**
     * IsQQ函数:检测参数的值是否符合QQ号码的格式
     * 返回值:是正确的QQ号码返回QQ号码,不是返回false
     */
    Static function IsQQ($Argv){
        $RegExp='/^[1-9][0-9]{5,11}$/';
        return preg_match($RegExp,$Argv)?$Argv:false;
    }

    /**
     * IsMobile函数:检测参数的值是否为正确的中国手机号码格式
     * 返回值:是正确的手机号码返回手机号码,不是返回false
     */
    Static function IsMobile($Argv){
        $RegExp='/^(?:13|15|18)[0-9]{9}$/';
        return preg_match($RegExp,$Argv)?$Argv:false;
    }

    /**
     * IsTel函数:检测参数的值是否为正取的中国电话号码格式包括区号
     * 返回值:是正确的电话号码返回电话号码,不是返回false
     */
    Static function IsTel($Argv){
        $RegExp='/[0-9]{3,4}-[0-9]{7,8}$/';
        return preg_match($RegExp,$Argv)?$Argv:false;
    }

    /**
     * IsNickname函数:检测参数的值是否为正确的昵称格式(Beta)
     * 返回值:是正确的昵称格式返回昵称格式,不是返回false
     */
    Static function IsNickname($Argv){
        $RegExp='/^\s*$|^c:\\con\\con$|[%,\*\"\s\t\<\>\&\'\(\)]|\xA1\xA1|\xAC\xA3|^Guest|^\xD3\xCE\xBF\xCD|\xB9\x43\xAB\xC8/is'; //Copy From DZ
        return preg_match($RegExp,$Argv)?$Argv:false;
    }

    /**
     * IsChinese函数:检测参数是否为中文
     * 返回值:是返回参数,不是返回false
     */
    Static function IsChinese($Argv,$Encoding='utf8'){
        $RegExp = $Encoding=='utf8'?'/^[\x{4e00}-\x{9fa5}] $/u':'/^([\x80-\xFF][\x80-\xFF]) $/';
        Return preg_match($RegExp,$Argv)?$Argv:False;
    }
}
?>
