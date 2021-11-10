<?php
/**
 * Created by PhpStorm.
 * User: LG
 * Date: 2019/4/9
 * Time: 16:28
 */

namespace Yiyu\Conf;

class CodeConf
{
    const SUCCESS = 10000;
    const MYSQL_WRITE_FAIL      = 30002;
    const EXCEPTION             = 30005;
    const CONF_NOT_EXIST        = 50010;




    /**
     * @param $code
     * @param $other
     * @return array
     * code 段说明 10000到19999 代表: 各种成功的状态
     * code 段说明 20000到29999 代表: 部分成功,部分失败，如 写入mysql成功，写入缓存失败
     * code 段说明 30000到39999 代表: 服务端异常
     * code 段说明 40000到49999 代表: 客户端异常
     * code 段说明 50000到59999 代表: 业务异常，如权限问题
     * 不允许直接返回msg
     *
     */
    public static function getConf($code, $other = array())
    {
        $config =  array(
            self::SUCCESS => '成功！',
            self::EXCEPTION => '服务端异常',
            self::CONF_NOT_EXIST => '配置不存在',
            self::MYSQL_WRITE_FAIL      => '数据库写入失败！',
        );
        if (is_array($other) && count($other) > 0) {
            return (array('code'=> $code, 'msg'=> $config[$code]) + $other);
        }
        return array('code'=> $code, 'msg'=> $config[$code]);
    }
}
