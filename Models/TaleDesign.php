<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaleDesign extends Model
{
    protected $table = 'tale_designs';


    // 童話の図案番号もたらす
    static public function getStoryDesignNum($taleNum)
    {

        // 童話の図案番号を保存する配列
        $taleNumResult          =    array();


        $taleNumObject          =    TaleDesign::select('design_no')
                                    ->where('fairy_tale_no', $taleNum)
                                    ->get();

        // 該当の童話の図案番号がないこと
        if($taleNumObject == "[]")
        {
            return "select fail!";
        }

        for($i = 0 ; $i < count($taleNumObject) ; $i++)
        {
            $taleNumResult[$i]  =   $taleNumObject[$i]->design_no;

        }

        // 童話の図案番号返還
        return $taleNumResult;

    }

}


?>