<?php
namespace phpbase\lib\util;

/**
 * Class Common
 * @package phpbase\lib\util
 * @author qian lei
 */
class Common
{
    /**
     * 数据类型转换
     * @param mixed $v
     * @param string $toType
     * @return mixed
     */
    public static function typeConvert($v, $toType)
    {
        switch ($toType) {
            case 'int':
                $v = (int)$v;
                break;
            case 'float':
                $v = (float)$v;
                break;
            case 'string':
                $v = (string)trim($v);
                break;
            case 'bool':
                $v = (bool)$v;
                break;
        }
        return $v;
    }
    
    /**
     * @param string|array $data
     * @return string
     */
    public static function toJson($data)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 获取ip地址
     * @return string
     */
    public static function getIp()
    {
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                /* 取X-Forwarded-For中第x个非unknown的有效IP字符? */
                foreach ($arr as $ip)  {
                    $ip = trim($ip);
                    if ($ip != 'unknown') {
                        $realIp = $ip;
                        break;
                    }
                }
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $realIp = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                if (isset($_SERVER['REMOTE_ADDR'])) {
                    $realIp = $_SERVER['REMOTE_ADDR'];
                } else {
                    $realIp = '0.0.0.0';
                }
            }
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR')) {
                $realIp = getenv('HTTP_X_FORWARDED_FOR');
            } elseif (getenv('HTTP_CLIENT_IP')) {
                $realIp = getenv('HTTP_CLIENT_IP');
            } else {
                $realIp = getenv('REMOTE_ADDR');
            }
        }

        if (isset($realIp)) {
            if (preg_match('/[\d\.]{7,15}/', $realIp, $onlineIp)) {
                $realIp = $onlineIp[0];
            }
        }

        return isset($realIp) ? $realIp : '0.0.0.0';
    }
}