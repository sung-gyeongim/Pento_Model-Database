<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Collection extends Model
{

    protected $table        =   'collections';


    // ウェブの私だけのペントミノリスト
    static public function getCollectionListWeb($userNum)
    {
        // 図案のイメージ経路もたらす
        $routeName          =      ImageRoute::getImageRoute('everyPento');

        // 図案番号、タイトル、イメージ、作成者、作った日付
        $webCollectionList  =       DB::table('collections as co')
                                        ->join('pento_designs as pd','co.design_no', '=', 'pd.design_no')
                                        ->select(
                                            'pd.design_no',
                                            DB::raw('concat( "' . $routeName . '", pd.design_image) as design_image')
                                        )
                                        ->where('co.user_no', $userNum)
                                        ->get();

        if($webCollectionList == "[]")
        {
            return "Invalid Value!";
        }

        return $webCollectionList;
    }



    // ユニティコレクションのリスト
    static public function getCollectionListUnity($userNum)
    {
        // 図案のイメージ経路もたらす
        $routeName       =      ImageRoute::getImageRoute('everyPento');

        //　図案番号、図案イメージ、タイトル、作成者
        $unityCollectionList    =     DB::table('collections as co')
                                        ->join('pento_designs as pd','co.design_no', '=', 'pd.design_no')
                                        ->join('user_profiles as up', 'pd.user_no', '=', 'up.user_no')
                                        ->select(
                                            'pd.design_no',
                                             DB::raw('concat( "' . $routeName . '", pd.design_image) as design_image'),
                                            'pd.design_title',
                                            'up.user_nickname'
                                        )
                                        ->where('co.user_no', $userNum)
                                        ->get();


        if($unityCollectionList == "[]")
        {
            return "Invalid Value!";
        }
        return $unityCollectionList;
    }


    // 図案購読する
    static public function subscribePento($userNum, $designNum)
    {
        try
        {
            Collection::insert(
                [
                    'user_no' => $userNum,
                    'design_no' => $designNum,
                    'registered_date' => Carbon::now(),
                ]
            );
        }
        catch (QueryException $e)
        {
            $errorCode = $e->errorInfo[1];

            // 購読した図案を再び購読しようとする場合
            if ($errorCode == 1062)
            {
                // Duplicate Value返還
                return 'Duplicate Value';
            }
            else
            {
                return $errorCode;
            }

        }
        return "true";
    }


    // コレクションテーブルに図案追加する
    static public function saveDesign($userNum, $designNum, $registeredDate)
    {
        // コレクションテーブルに図案番号、会員番号登録
        try
        {
            Collection::insert
            (
                [
                    'user_no'           =>  $userNum,
                    'design_no'         =>  $designNum,
                    'registered_date'   =>  $registeredDate
                ]
            );
        }
        catch (QueryException $e)
        {
            $errorCode = $e->errorInfo[1];

            // 購読した図案を再び購読しようとする場合
            if ($errorCode == 1062)
            {
                // Duplicate Value返還
                return 'Duplicate Value';
            }
            else
            {
                return $errorCode;
            }

        }
        return "true";
    }



    // ユニティ自由モード、段階別モード、ストーリーモードプレイ時保存
    static public function saveImitatedDesign($userNum, $designNum, $putNumber, $imitatedImage, $clearTime)
    {
        try
        {
        // 現在の時間保存
        $currentTime = Carbon::now();

        // コレクションテーブルに図案の保存
            Collection::saveDesign($userNum, $designNum, $currentTime);

        // 作品のテーブルに図案と記録の保存
        ImitatedPento::saveImitatedDesign($userNum, $designNum, $putNumber, $imitatedImage, $clearTime, $currentTime);
        }
        catch (QueryException $e)
        {
            $errorCode = $e->errorInfo[1];

                return $errorCode;

        }
        return "true";
    }
}

?>