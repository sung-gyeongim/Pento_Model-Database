<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Buylist extends Model
{
    protected $table    =   'buylists';

    // ！童話買う時、積立金を差し引く

    // 童話買う
    static public function buyStory($userNum, $taleNum)
    {

        // 童話の値段をもたらす。
        $talePrice = FairyTale::getStoryPrice($taleNum);

        // 会員ポイントもたらす。
        $userPoint = UserProfile::getUserPoint($userNum);

        // 会員のポイントが童話の値段だけあっている場合、童話購入可能
        if($userPoint >= $talePrice)
        {
            try
            {

                // 購買テーブルに会員番号と購買した童話番号、購入日 insert
                Buylist::insert(
                                    [
                                        'user_no'           => $userNum,
                                        'fairy_tale_no'     => $taleNum,
                                        'registered_date'   => Carbon::now()->format('Y-m-d H:i:s'),
                                    ]
                                );




                // 現在、会員のポイントで、補償のポイントを加えた値で update
                $updateResult       =   UserProfile::where('user_no', $userNum)
                    ->update(
                        [
                            'user_point' => $userPoint - $talePrice
                        ]
                    );

                // update 失敗
                if ($updateResult == 0)
                {
                    return "update fail";
                }





                // 童話の図案番号を持ってくる
                $taleDesignNum = TaleDesign::getStoryDesignNum($taleNum);

                // 童話購入の際、童話の図案をコレクションテーブルに追加
                for($i = 0; $i < count($taleDesignNum) ; $i++)
                {
                    Collection::subscribePento($userNum, $taleNum[$i]);
                }

            } // すでに購入したドンファイル場合
            catch (QueryException $e)
            {
                $errorCode = $e->errorInfo[1];

                // 制約条件違反
                if ($errorCode == 1452)
                {
                    return 'Cannot add or update a child row: a foreign key constraint fails';
                }
                // query column error
                if ($errorCode == 1054)
                {
                    return 'Unknown column';
                }
                // 購入した童話の場合
                if ($errorCode == 1062)
                {
                    return 'Duplicate entry';
                }
            }
            return "true";
        }
        // 会員のポイントが童話の価格より不足する場合
        else
        {
            return "Money is scarce";
        }
    }


    // ウェブマイページ購買の一覧
    static public function getBuyList($userNum)
    {
        // 会員イメージ保存経路selectメソッド呼び出し
        $routeName      =   ImageRoute::getImageRoute('storyPage');


        // 購買のテーブルでの会員番号を利用し、おとぎ話番号をもたらす。
        // 童話番号を利用して童話のテーブルのタイトルをもたらす。
        // 購買テーブルの購買日をもたらす。
        $buyList         =     DB::table('fairy_tales as ft')
                                ->join('buylists as bl', 'ft.fairy_tale_no', '=', 'bl.fairy_tale_no')
                                ->join('tale_images as ti', 'bl.fairy_tale_no', '=', 'ti.fairy_tale_no')
                                ->select
                                ('ft.fairy_tale_no',
                                    'ft.tale_title',
                                    DB::raw('concat( "' . $routeName . '", ti.tale_image) as tale_image'),
                                    'bl.registered_date'
                                )
                                ->where('bl.user_no', '=', $userNum)
                                ->where('ti.tale_image', 'like', '%_1.jpg')
                                ->orderBy('ft.tale_title')
                                ->get();

        // ユーザナンバーがない場合
        if ($buyList == "[]") {
            return "fail select!";
        }

        return $buyList;
    }

    // 該当メンバーが購買した童話番号返還
    static public function getBuyStoryNum($userNum)
    {
        $buyNumResult   = Buylist::select('fairy_tale_no')
                                ->where('user_no', $userNum)
                                ->get();

        // 空いたオブジェクトの場合
        if($buyNumResult == "[]")
        {
            return "select fail";
        }

        // 購入した童話番号返還
        return $buyNumResult;
    }

}


?>

