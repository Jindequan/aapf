<?php

namespace AF\Tool;

class SnowFlake extends BaseTool
{
    const EPOCH = 1479533469655;//开始时间,固定一个小于当前时间的毫秒数

    const max12bit = 1024;

    const max41bit = 1099511627888;

    static $machineId = null;
    public static function machineId($mId = 0)
    {
        self::$machineId = $mId;

    }

     public static function id()
    {
        $time = floor(microtime(true) * 1000);
        $time -= self::EPOCH;
        $base = decbin(self::max41bit + $time);
        if (!self::$machineId) {
            $machineid = self::$machineId;
        } else {
            $machineid = str_pad(decbin(self::$machineId), 10, "0", STR_PAD_LEFT);
        }
        $random = str_pad(decbin(mt_rand(0, self::max12bit)), 12, "0", STR_PAD_LEFT);

        $base = $base . $machineid . $random;
        return bindec($base);
    }
}