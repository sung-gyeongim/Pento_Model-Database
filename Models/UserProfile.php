<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class UserProfile extends Model
{
    protected $table = 'user_profiles';

    public $timestamps = false;

    // ウェブ、ログインした後、必要な会員の情報を返還
    static public function loginUserInfoWeb($userNum)
    {

        // 会員のイメージが保存されているファイル経路もたらす
        $routeName          =   ImageRoute::getImageRoute('userPage');


        // この会員の写真、積立金、ニックネーム返還
        $result             =   UserProfile::select
                                (
                                    'user_no',
                                    'user_nickname',
                                    DB::raw('concat( "' . $routeName . '", user_photo) as image'),
                                    'user_point'
                                )
                                ->where('user_no', '=', $userNum)
                                ->get();

        if ($result == "[]")
        {
            return "Invalid User Number";
        }

        return $result;

    }



    // ユニティでログイン
    static public function loginUserInfoUnity($userNum)
    {

        // 会員番号の返還
        $result             =   UserProfile::select('user_no')
                                ->where('user_no', '=', $userNum)
                                ->get();

        return $result;

    }



    // マイページで必要な会員情報select
    static public function myPageUserInfo($userNum)
    {

        // 会員のイメージが保存されている経路もたらす
        $routeName          =   ImageRoute::getImageRoute('userPage');

        // 会員プロフィールのテーブルの別名、紹介文章や写真、レベルポイント転換
        $result             =   UserProfile::select
                                (
                                    'user_nickname',
                                    'user_intro',
                                    DB::raw('concat ("' . $routeName . '", user_photo) as image'),
                                    'user_grade',
                                    'user_point'
                                )
                                ->where('user_no', '=', $userNum)
                                ->get();


        // 空いたオブジェクトの場合, select fail
        if ($result == "[]")
        {
            return "select fail";
        }

        // 会員情報の返還
        return $result;

    }



    // 利用者暗証番号、プロフィールアップデート
    static public function modifyUserInfo($modifyUserInfoArray)
    {

        // ユーザプロフィルアップデート
        $updateProfileResult    =   UserProfile::where('user_no', $modifyUserInfoArray['user_no'])
                                    ->update(
                                        [
                                            'user_photo'    =>  $modifyUserInfoArray['user_photo'],
                                            'user_intro'    =>  $modifyUserInfoArray['user_intro'],
                                            'user_nickname' =>  $modifyUserInfoArray['user_nickname'],
                                            'updated_date'  =>  Carbon::now()->format('Y-m-d H:i:s'),
                                        ]
                                    );


        // 暗証番号のアップデート・メソッド呼び出し
        $updatePWResult         =   UserInfo::odifyPassword($modifyUserInfoArray['user_no'], $modifyUserInfoArray['user_pw']);

        // updateが失敗した場合
        if ($updateProfileResult == 0 || $updatePWResult == 0)
        {
            return "update Fail";
        }

        return "true";

    }



    // 会員レベルもたらす
    static public function getUserLevelNum($userNum)
    {

        // この会員のレベルをもたらす
        $userGrade              =   UserProfile::select('user_grade')
                                    ->where('user_no', $userNum)
                                    ->get();


        // 空いているオブジェクトの場合selectの失敗
        if ($userGrade == "[]")
        {
            return "select fail";
        }

        // 会員レベルの返還
        return $userGrade[0]->user_grade;

    }



    // 該当段階のレベルをすべてクリア時のユーザレベルアップ
    static public function updateUserGrade($userNum)
    {

        // 会員レベルもたらす
        $userGrade          =    UserProfile::getUserLevelNum($userNum);

        // 段階別の図案番号もたらす
        $levelDesignNum     =    PentoDesign::getLevelDesignNum($userGrade);

        // 会員がプレーした図案番号もたらす
        $reDesignNum        =    ImitatedPento::getRecordDesignNum($userNum);




        // 段階別の図案番号とプレーした図案番号が同じ場合の回数を入れる変数
        $count = 0;

        if ($userGrade <= 5)
        {
            // 段階別の図案番号($levelDesignNum)のキーの値($value1)と
            // プレーした図案番号($reDesignNum)のキーの値($value2)を抽出
            foreach ($reDesignNum as $key1 => $value1)
            {
                foreach ($levelDesignNum as $key2 => $value2)
                {
                    // 段階別の図案番号とプレーした図案番号が同じ場合
                    if ($value1->design_no == $value2->design_no)
                    {
                        // count 増加
                        $count++;
                    }
                }
            }

            // ような場合、回数や段階別の図案番号の個数が同じだ時
            if ($count == count($levelDesignNum))
            {
                // 会員レベルアップデート
               UserProfile::where('user_no', $userNum)
                    ->update
                    (
                        [
                            'user_grade'    =>  $userGrade + 1,
                        ]
                    );


               // レベルアップ
                return "true";
            }
            else
            {
                // レベルアップ失敗
                return "false";
            }
        }

        // 最大レベルは5です
        else return "user level is 5";
    }



    // この会員のポイント取得します
    static public function getUserPoint($userNum)
    {
        // 会員の今持っているポイント情報をもたらす
        $userPointObject    =   UserProfile::select('user_point')
            ->where('user_no', $userNum)
            ->get();

        return   $userPointObject[0]->user_point;
    }



    // 段階別ゲームクリア時にポイントupdate
    static public function updateUserPoint($designNum, $userNum)
    {

        try {

            // 該当図案のポイントを持ってくる
            $point              =    PentoDesign::getRewardPoint($designNum);

            // 会員の今持っているポイント情報を持ってくる

            $userPoint          =   UserProfile::getUserPoint($userNum);


            // 現在、会員のポイントで、補償のポイントを加えた値で update
            $updateResult       =   UserProfile::where('user_no', $userNum)
                                                ->update
                                                (
                                                    [
                                                        'user_point' => $userPoint + $point
                                                    ]
                                                );

            // update 失敗
            if ($updateResult == 0)
            {
                return "update fail";
            }

        }
        // queryエラー時、エラー文返還
        catch (QueryException $e)
        {
            $errorCode          =    $e->errorInfo[1];

            return "Invalid Value error code : $errorCode";
        }

        // アップデート成功の時、trueの返還
        return "true";
    }


}


?>