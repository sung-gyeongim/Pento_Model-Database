<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArduinoInfo extends Model
{
    protected $table     = 'arduino_info';

    static public function getArduinoNum($serialNum)
    {

        // 当該シリアル番号のアルドゥイーノ番号を探す
        $arduinoResult   =        ArduinoInfo::select('arduino_no')
                                                ->where('serial_num', $serialNum)
                                                ->get();

        // 存在しないシリアル番号である場合
        if ($arduinoResult == "[]")
        {
            return "false";
        }

        // アルドゥイーノ番号返還
        return "true";
    }
}

?>