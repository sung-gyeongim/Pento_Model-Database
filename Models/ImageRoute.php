<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageRoute extends Model
{
    protected $table = 'image_routes';

    static public function getImageRoute($where)
    {
        // 因子値によって配列で経路番号を保存
        $whereArray = array
        (
            'storyPage'     =>  1,
            'userPage'      =>  2,
            'imitatedPento' =>  3,
            'everyPento'    =>  4
        );

        // 経路番号でパス名探し、返還
        $result             =   ImageRoute::select('route_name')
                                           ->where('route_no',$whereArray[$where])
                                           ->get();

        if($result == "[]")
        {
            echo "Invalid where";
        }
        // イメージ経路返還
        return $result[0]->route_name;

    }
    //
}

?>

