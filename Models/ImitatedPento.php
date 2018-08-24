<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\MockObject\MockObject;

class ImitatedPento extends Model
{
    protected $table = 'imitated_pentos';



    // 推薦が多い順に作品一覧返還
    static public function getReImitatedPentoList($designNum)
    {
        // ペントミノイメージが保存された経路selectメソッド呼び出し
        $routeName           =    ImageRoute::getImageRoute('imitatedPento');

        // 作品番号、作品タイトル、作成者いわゆる推薦の個数返還
        $imitatedResult      =    DB::table('imitated_pentos as ip')
            ->join('pento_designs as pd', 'pd.design_no', '=', 'ip.design_no')
            ->leftJoin('recommends as rm', 'rm.imitated_no', '=', 'ip.imitated_no')
            ->join('user_profiles as up','ip.user_no', '=', 'up.user_no')
            ->select
            (
                'ip.imitated_no',
                'pd.design_title',
                'up.user_nickname',
                DB::raw('concat ("' . $routeName .'", ip.imitated_image) as imitated_image'),
                DB::raw('count(rm.imitated_no) as reNum')
            )
            ->where('ip.design_no', $designNum)
            ->orderBy('reNum', 'desc')
            ->groupBy('ip.imitated_no')
            ->get();

        return $imitatedResult;
    }


    // 創作したペント、遊ぶ作品のテーブルに保存
    static public function saveMakeDesign($userNum, $designNum, $imitatedImage, $registeredDate)
    {
        try
        {

            // 作品のテーブルに図案番号、会員番号、作品イメージ、登録日登録
            ImitatedPento::insert
            (
                [
                    'user_no'           =>  $userNum,
                    'design_no'         =>  $designNum,
                    'division_no'       =>  1,
                    'imitated_image'    =>  $imitatedImage,
                    'put_number'        => 0,
                    'clear_time'        => 'null',
                    'registered_date'   =>  $registeredDate
                ]
            );
        }
        catch (QueryException $e)
        {
            $errorCode = $e->errorInfo[1];

            if ($errorCode == 1452)
            {
                return 'Cannot add or update a child row: a foreign key constraint fails';
            }
            else if ($errorCode == 1054)
            {
                return 'Unknown column';
            }
            else if ($errorCode == 1062)
            {
                return 'Duplicate entry';
            }
            else
            {
                return $errorCode;
            }
        }
        return "true";
    }

    // 自由モード、ストーリーモード、段階別モード作品のテーブルに保存
    static public function saveImitatedDesign($userNum, $designNum, $putNumber, $imitatedImage, $clearTime, $registeredDate)
    {
        try
        {

            // 作品のテーブルに図案番号、会員番号、作品イメージ、登録日登録
            ImitatedPento::insert
            (
                [
                    'user_no'           =>  $userNum,
                    'design_no'         =>  $designNum,
                    'division_no'       =>  1,
                    'put_number'        =>  $putNumber,
                    'imitated_image'    =>  $imitatedImage,
                    'clear_time'        =>  $clearTime,
                    'registered_date'   =>  $registeredDate
                ]
            );
        }
        catch (QueryException $e)
        {
            $errorCode = $e->errorInfo[1];

            if ($errorCode == 1452)
            {
                return 'Cannot add or update a child row: a foreign key constraint fails';
            }
            else if ($errorCode == 1054)
            {
                return 'Unknown column';
            }
            else if ($errorCode == 1062)
            {
                return 'Duplicate entry';
            }
            else
            {
                return $errorCode;
            }
        }
        return "true";
    }



    // 作品のテーブルの該当図案の登録日持ってくる
    static public function getImitatedData($userNum, $designNum, $imitatedImage)
    {
        // 登録日持ってくる
        $registeredDateObject       =   ImitatedPento::select('registered_date')
            ->where('design_no', $designNum)
            ->where('user_no', $userNum)
            ->where('imitated_image', $imitatedImage)
            ->get();

        // 登録日の返還
        return $registeredDateObject[0]->registered_date;
    }


    // 作品の推薦の数返還
    static public function getRecommendNum($designNum)
    {
        // 当該デザイン番号を持つ作品の推薦の個数総合返還
        $designRecommendSum     =    DB::table('imitated_pentos as ip')
                                    ->join('recommends as rc', 'ip.imitated_no', '=', 'rc.imitated_no')
                                    ->select(DB::raw('count(ip.imitated_no) as reNumSum'))
                                    ->where('ip.design_no', $designNum)
                                    ->get();

        return $designRecommendSum[0]->reNumSum;
    }


    // 記録のテーブルでユーザがプレーした図案番号を持ってくる
    static public function getRecordDesignNum($userNum)
    {


        $reDesignNumObject = ImitatedPento::select('design_no')
            ->where('user_no', $userNum)
            ->groupBy('design_no')
            ->get();



        return $reDesignNumObject;
    }



    // ウェブの記録作品一覧
    static public function getImitatedPentolist($userNum)
    {

        // ペント、のイメージが保存されたイメージ経路select
        $routeName          =       ImageRoute::getImageRoute('imitatedPento');

        // 作品のテーブルと記録のテーブルの図案番号が同じ市に当該設計番号と図案の写真を返還

        $recordPentoList   =       DB::table(DB::raw('imitated_pentos as a, '.
                                                    '(select design_no, max(registered_date) as maxdate '.
                                                    'from imitated_pentos '.
                                                    'where user_no = '.$userNum.' and put_number != 0 '.
                                                    'group by design_no) as b'))
                                ->select
                                ('a.design_no',
                                    DB::raw('concat ("' . $routeName .'", a.imitated_image) as imitated_image'),
                                    'a.registered_date'
                                )
                                ->where('a.design_no', DB::raw('b.design_no'))
                                ->where('a.registered_date', DB::raw('b.maxdate'))
                                ->groupBy('a.design_no')
                                ->orderBy('a.registered_date', 'desc')
                                ->get();


        // 空いている値の場合selectの失敗
        if(!isset($recordPentoList[0]))
        {
            return "select Fail";
        }

        return $recordPentoList;

    }



    // 記録ページで該当ペントミノのプレー記録を検索してリストを持ってくる
    static public function findImitatedPentoList($userNum, $pentoTitle)
    {

        // 作品の図案イメージが保存されている経路もたらす
        $routeName = ImageRoute::getImageRoute('imitatedPento');

        $searchResult = DB::table('imitated_pentos as ip')
            ->join('pento_designs as pd', 'ip.design_no', '=', 'pd.design_no')
            ->select
            (
                'ip.design_no',
                DB::raw('concat ("' . $routeName .'", ip.imitated_image) as imitated_image')
            )
            ->where('ip.user_no', $userNum)
            ->where('pd.design_title', 'regexp', $pentoTitle)
            ->where('ip.put_number', '>', 0)
            ->groupby('ip.design_no')
            ->orderby('ip.registered_date', 'desc')
            ->get();

        // select結果がない場合
        if ($searchResult == "[]")
        {
            return "select fail";
        }

        return $searchResult;

    }




    // 웹 마이페이지 기록반환
    static public function getRecordList($userNum, $designNum)
    {

        $title              = ImitatedPento::join('pento_designs', 'imitated_pentos.design_no', '=', 'pento_designs.design_no')
            ->select('pento_designs.design_title')
            ->where('imitated_pentos.design_no', $designNum)
            ->where('put_number', '>', 0)
            ->get();
        // 会員の記録がある作品リスト
        // クリア時間転換        
	     $userRecord         =   ImitatedPento::select('clear_time', 'registered_date', 'put_number')
            ->where('user_no', $userNum)
            ->where('design_no', $designNum)
            ->where('put_number', '>', 0)
            ->get();

       // 当該デザインを供給した使用者たちの平均通過時間転換
        $avgTime            =   ImitatedPento::select
        (
            DB::raw('sec_to_time(floor(avg(time_to_sec(clear_time)))) as avgTime')
        )
            ->where('design_no', $designNum)
            ->where('put_number', '>', 0)
            ->get();


	// 該当図案のユーザーランキング情報の返還
        $userRank           =     DB::table(DB::raw('imitated_pentos as ip join user_profiles as up on ip.user_no = up.user_no,(select @rnum :=0) clear_time'))
            ->select(DB::raw('@rnum := @rnum + 1 as rank, up.user_nickname, ip.clear_time, cast(ip.clear_time as unsigned) as int_clearTime, ip.put_number'))
            ->where('ip.design_no', $designNum)
            ->where('put_number', '>', 0)
            ->orderby('ip.clear_time')
            ->get();


        // key値とオブジェクトに保存
        $total =
            [
                'title'         =>  $title,
                'userRecord'    =>  $userRecord,
                'avgTime'       =>  $avgTime,
                'userRank'      =>  $userRank

            ];

        // selectの失敗市
        if ($title = "[]" && $userRecord == "[]" && $avgTime == "[]" && $userRank == "[]")
        {
            return "select Fail";
        }

        return $total;

    }

}
?>