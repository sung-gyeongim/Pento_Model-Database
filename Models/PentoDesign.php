<?php




namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

class PentoDesign extends Model
{
    protected $table = 'pento_designs';

    // 図案のテーブルの図案番号と登録日持ってくる
    static public function getDesignData($coordinateValue)
    {

        $designNumObject        =   PentoDesign::select('design_no', 'registered_date')
            ->where('coordinate_value', $coordinateValue)
            ->get();

        // 図案番号と登録日
        $designData             =   [$designNumObject[0]->design_no, $designNumObject[0]->registered_date];

        // 図案番号、登録日の返還
        return $designData;

    }


    // 図案リスト(ウェブ)
    static public function getPentoListWeb()
    {
        // すべての図案のイメージを保存した経路もたらす
        $routeName          =   ImageRoute::getImageRoute('everyPento');

        // 図案番号、タイトル、難易度、イメージもたらす
        $designInfo         =   DB::table('pento_designs as pd')
            ->join('user_profiles as up', 'pd.user_no', '=', 'up.user_no')
            ->select
            (
                'pd.design_no',
                'pd.design_title',
                DB::raw('concat( "' . $routeName . '", pd.design_image) as design_image'),
                'pd.identifier as level',
                'up.user_nickname'

            )
            ->where('pd.identifier', 'every')
            ->orderBy('pd.registered_date')
            ->get();


        if ($designInfo == "[]")
        {
            return "select Fail";
        }

        // 図案の一覧返還
        return $designInfo;

    }


    // 図案詳細説明(ウェブ)
    static public function getPentoInfo($designNum)
    {

        // 図案イメージ経路もたらす
        $routeName              =   ImageRoute::getImageRoute('everyPento');


        // 図案の詳細な説明の返還
        // 図案番号、タイトル、説明、作成者、イメージ、座標値
        $designInfo             =   DB::table('pento_designs as pd')
                                    ->join('user_profiles as up', 'up.user_no', '=', 'pd.user_no')
                                    ->select
                                    (
                                        'pd.design_no',
                                        'pd.design_title',
                                        DB::raw('concat( "' . $routeName . '", pd.design_image) as design_image'),
                                        'pd.design_explain',
                                        'up.user_nickname',
                                        'pd.registered_date'
                                    )
                                    ->where('pd.design_no', $designNum)
                                    ->get();


        // 当該設計番号を持った作品の推薦の改修総合返還
        $designRecommendSum     = ImitatedPento::getRecommendNum($designNum);


        if ($designInfo == "[]")
        {
            return "false";
        }

        // 図案の詳細情報と総合返還
        $total =
            [
                'design_info'       =>  $designInfo,
                'recommendNumSum'   =>  $designRecommendSum
            ];

        return $total;

    }

    // 創作したドアンイル場合の図案そのものを削除, 購読したコレクションの場合購読解除(ウェブ)
    static public function deletePento($userNum, $designNum)
    {


        try {

            // 創作した作品の場合図案そのものの削除
            $deleteResult               = DB::table('pento_designs')
                                        ->where('user_no', $userNum)
                                        ->where('design_no', $designNum)
                                        ->delete();

            if ($deleteResult == 0)
            {

                // 購読したコレクションの場合購読解除
                try
                {

                     Collection::where('user_no', $userNum)
                    ->where('design_no', $designNum)
                    ->delete();
                }

                    // queryエラー時エラーコードの返還
                catch (QueryException $e)
                {
                    $errorCode = $e->errorInfo[1];

                    return $errorCode;
                }

                // 削除成功市trueの返還
                return "true";
            }
        }
        catch (QueryException $e)
        {
            // エラーの場合、エラーコードの返還
            $errorCode = $e->errorInfo[1];

            return $errorCode;

        }

        return "true";
    }


    // 図案座標取得します(ユニティ)
    static public function getPentoCoordinate($design_no)
    {

        // 該当図案の座標値を返還
        $coordinateResult       =   PentoDesign::select('coordinate_value')
                                    ->where('design_no', $design_no)
                                    ->get();


        // 結果値がない場合
        if ($coordinateResult == "[]")
        {
            return "Invalid design_no!";
        }

        return $coordinateResult;

    }



    // 段階別モードリストの返還(ユニティ)
    static public function getLevelDesignList($level)
    {

        // 段階別の図案経路もたらす
        $routeName          =   ImageRoute::getImageRoute('everyPento');

        // ペントミノの図案のタイトルと図案、座標値リストもたらす
        $designList         =   PentoDesign::select
        (
            'design_no',
            'design_title',
            DB::raw('concat( "' . $routeName . '", design_image) as design_image'),
            'design_explain'
        )
            ->where('identifier', $level)
            ->get();

        // 段階別の図案リスト返還
        return $designList;

    }



    // 段階別補償ポイント情報持ってくる
    static public function getRewardPoint($designNum)
    {

        try
        {

            // 該当図案番号のポイントもたらす
            $pointResult        =   PentoDesign::select('reward_point')
                                    ->whereIn('identifier', [1, 2, 3, 4, 5])
                                    ->where('design_no', $designNum)
                                    ->get();
        }

        catch (QueryException $e)
        {
            // queryエラー時エラーコードの返還
            $errorCode = $e->errorInfo[1];

            return "Invalid Value error code : $errorCode";

        }

	if($pointResult =='[]')
            {
                return 'false';
            }

        // クリアポイント転換
        return $pointResult[0]->reward_point;

    }

    // 段階別の図案番号もたらす
    static public function getLevelDesignNum($userGrade)
    {

        // この会員のレベルを持ってきて
        $designNum      =   DB::table('pento_designs')
                            ->select('design_no')
                            ->where('identifier', $userGrade)
                            ->get();

        if ($designNum == "[]")
        {
            return "select fail";
        }

        // レベルの返還
        return $designNum;
    }



    // 創作したペントミノ図案のテーブル(pento_designs)に保存
    static public function savePentoDesign($designArray)
    {

        try {

            PentoDesign::insert
            (
                [
                    'user_no'               =>  $designArray['user_no'],
                    'identifier'            =>  'every',
                    'design_title'          =>  $designArray['design_title'],
                    'design_explain'        =>  $designArray['design_explain'],
                    'coordinate_value'      =>  $designArray['coordinate_value'],
                    'design_image'          =>  $designArray['image_name'],
                    'registered_date'       =>  Carbon::now()
                ]
            );

            // 先ほど保存した図案の番号と登録日持ってくる
            $dataResult         =   PentoDesign::getDesignData($designArray['coordinate_value']);

            // コレクションテーブルに保存
            Collection::saveDesign($designArray['user_no'], $dataResult[0], $dataResult[1]);

            // 作品のテーブルに保存
            ImitatedPento::saveMakeDesign($designArray['user_no'], $dataResult[0], $designArray['image_name'], $dataResult[1]);

        }
        catch (QueryException $e)
        {
            $errorCode = $e->errorInfo[1];

            // 登録時、登録された値の場合
            if ($errorCode == 1062)
            {
                return 'Duplicate Coordinate Values!';
            }
            else
            {
                return $errorCode;
            }
        }

        // 登録に成功
        return "true";
    }


    // DBに保存されている座標値をイメージに変更
   public static function makeTestDesign($level)
    {
        return PentoDesign::select('coordinate_value','design_title')
                ->where('identifier','=',$level)
                ->get();
    }


}

?>

