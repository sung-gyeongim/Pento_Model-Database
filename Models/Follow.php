<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

class Follow extends Model
{
    protected $table = 'followlists';

    // 会員の友人リスト返還
    static public function getFollowList($userNum)
    {
        //友達の電話番号、友達のニックネーム返還
        $FollowList     =     DB::table('followlists as fl')
                                ->join('user_profiles as up', 'up.user_no', '=', 'fl.follow_user_no')
                                ->join('user_profiles as u', 'u.user_no', '=', 'fl.follower_user_no')
                                ->select
                                (
                                    'fl.follower_user_no',
                                    'u.user_nickname'
                                )
                                ->where('up.user_no', $userNum)
                                ->get();

        // //因子の価格が正しい値がない場合
        if ($FollowList == "[]")
        {
            return "not exist userNum";
        }

        return $FollowList;
    }


    // 友達検索
    static public function findFollowerID($findFollowerId)
    {
        $followerResult     =     DB::table('user_profiles')
                            ->select('user_no', 'user_nickname', 'user_intro')
                            ->where('user_nickname', 'regexp', $findFollowerId)
                            ->get();

        // select 結果がない場合
        if ($followerResult == "[]")
        {
            return "select fail";
        }

        return $followerResult;
    }

    // 友達追加
    static public function addFollow($userNum, $addFollowerNum)
    {
        try
        {
             Follow::insert(
                            [
                                'follow_user_no'           => $userNum,
                                'follower_user_no'         => $addFollowerNum,
                                'registered_date'          => Carbon::now()->format('Y-m-d H:i:s'),
                            ]);

        }

        catch (QueryException $e)
        {
            $errorCode = $e->errorInfo[1];

            // 既に友達登録されている場合
            if ($errorCode == 1062)
            {
                return 'already follower!';
            }
            // 因子の値が有効な値がない場合
            else if ($errorCode == 1452)
            {
                return 'Invalid Number';
            }
            else
            {
                return $errorCode;
            }
        }
        return "true";

    }

    // 友達削除
    static public function deleteFollow($userNo, $deleteFollowerNum)
    {
        $deleteResult     =     Follow::where('follow_user_no', $userNo)
                                ->where('follower_user_no', $deleteFollowerNum)
                                ->delete();

        // 存在しない友達を削除する場合
        if ($deleteResult == 0)
        {
            return "not exist friend";
        }

        return "true";
    }
}


?>