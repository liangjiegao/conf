<?php


namespace Yiyu\Conf;


class UtilsClass
{

    public static $codeConf;
    static function getCallbackJson($code, $other = array()){
        if (empty(self::$codeConf)){
            return json_encode(CodeConf::getConf($code, $other), JSON_UNESCAPED_UNICODE);
        }else{
            return json_encode(self::$codeConf::getConf($code, $other), JSON_UNESCAPED_UNICODE);
        }
    }
}
