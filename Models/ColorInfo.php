<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class ColorInfo extends Model
{
    // color_infoテーブル使用
    protected $table = 'color_info';


    //色の名前、RGB持って来て
    static public function getColorRGB()
    {

        try
        {
            $colorResult = ColorInfo::select()->get();
        }
        catch (QueryException $e)
        {
            $errorCode = $e->errorInfo[1];

            if ($errorCode == 1064)
            {
                return "SQL syntax error";
            }
            else
            {
                return $errorCode;
            }
        }
        return $colorResult;
    }
}

?>
