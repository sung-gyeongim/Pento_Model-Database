<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

class Recommend extends Model
{
    protected $table = 'recommends';

    // 작품 추천하기
    static public function recommend($userNum, $imitatedNum)
    {

        try
        {
            // 推薦した会員番号、推薦した図案番号、推薦の日付登録
            DB::table('recommends')
                ->insert(
                    [
                        'user_no'           => $userNum,
                        'imitated_no'       => $imitatedNum,
                        'registered_date'   => Carbon::now(),
                    ]
                );
        }

        catch (QueryException $e)
        {

            $errorCode = $e->errorInfo[1];

            // 推薦をしていた作品である場合、推薦の解除(=レコード削除)
            if ($errorCode == 1062)
            {
                DB::table('recommends')
                    ->where('user_no', $userNum)
                    ->where('imitated_no', $imitatedNum)
                    ->delete();
            }
            else
            {
                return $errorCode;
            }
        }

        return DB::table('recommends')->select(DB::raw('count(*) as recommendNum'))->where('imitated_no', $imitatedNum)->get();
    }

}

?>