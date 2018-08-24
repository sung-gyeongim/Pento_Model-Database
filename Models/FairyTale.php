<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class FairyTale extends Model
{
    protected $table = 'fairy_tales';



    // ウェブの童話の一覧
    static public function getStoryListWeb()
    {
        // 童話のイメージの経路検索
        $routeName      =   ImageRoute::getImageRoute('storyPage');

        // ウェブで童話のリストを表示する時、童話番号、タイトル、イメージ返還
        $webTaleList    =   DB::table('fairy_tales as ft')
                                ->leftJoin('tale_images as ti', 'ti.fairy_tale_no', '=', 'ft.fairy_tale_no')
                                ->select
                                (
                                    'ft.fairy_tale_no',
                                    'ft.tale_title',
                                    DB::raw('concat( "' . $routeName . '", ti.tale_image) as tale_image')
                                )
                                ->where('ti.tale_image', 'regexp', '_[1].jpg$')
                                ->orderBy('ft.tale_title')
                                ->get();

        // 結果が空いたオブジェクトの場合
        if ($webTaleList == "[]")
        {
            return "select fail";
        }

        // 童話の一覧返還
        return $webTaleList;

    }



    // unityで童話のリストを返還
    static public function getStoryListUnity()
    {

        // 童話のイメージの経路検索
        $routeName           =      ImageRoute::getImageRoute('storyPage');

        // ユニティのリストを表示するとき童話番号、タイトル、イメージ、説明の返還
        $unityTaleList       =      DB::table('fairy_tales as ft')
                                            ->leftJoin('tale_images as ti', 'ti.fairy_tale_no', '=', 'ft.fairy_tale_no')
                                            ->select
                                            (
                                                'ft.fairy_tale_no',
                                                'ft.tale_title',
                                                DB::raw('concat( "' . $routeName . '", ti.tale_image) as tale_image'),
                                                'ft.tale_explain'
                                            )
                                            ->where('ti.tale_image', 'regexp', '_[1]')
                                            ->orderBy('ft.tale_title')
                                            ->get();



        if ($unityTaleList == "[]")
        {
            return "fail select!";
        }


        return $unityTaleList;
    }



    // 童話の詳細な説明
    static public function getStoryInfo($taleNum)
    {
        // 童話のイメージ保存経路selectメソッド呼び出し
        $routeName       =      ImageRoute::getImageRoute('storyPage');

        // タイトル、イメージ、価格、詳細な説明の返還
        $taleInfo       =       DB::table('fairy_tales as ft')
                                    ->leftJoin('tale_images as ti', 'ti.fairy_tale_no', '=', 'ft.fairy_tale_no')
                                    ->select
                                    ('ft.fairy_tale_no',
                                        'ft.tale_title',
                                        DB::raw('concat( "' . $routeName . '", ti.tale_image) as tale_image'),
                                        'ft.tale_explain',
                                        'ft.tale_price')
                               //     ->where('ti.tale_image', 'regexp', '_[12345]$')
                                    ->where('ft.fairy_tale_no', $taleNum)
                                    ->get();

        if ($taleInfo == "[]")
        {
            return "fail select!";
        }
        return $taleInfo;
    }



    // 童話の価格もたらす
    static public function getStoryPrice($taleNum)
    {
        $talePrice      =       DB::table('fairy_tales')->select('tale_price')->where('fairy_tale_no', $taleNum)->get();

        if(!isset($talePrice[0]))
        {
            return "false";
        }
        else
        {
            return $talePrice[0]->tale_price;
        }
    }
}

?>

