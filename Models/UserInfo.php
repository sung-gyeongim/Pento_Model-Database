<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserInfo extends Model
{
    protected $table = 'user_info';
    public $timestamps = false;


    // ログイン(会員認証)
    static public function loginCheck($mode, $userId, $userPw)
    {
        // user_infoテーブルで入力を受けた・アイディの情報をもたらす
        $userArray          =   UserInfo::where('user_id', '=', $userId)->get();

        // ID有効検査
        if ($userArray == "[]")
        {
            return 'Invalid id';
        }
        // 暗証番号有効検査
        else
        {

            // アイディ-が事実だが、パスワードが間違っている場合
            if (!password_verify($userPw, $userArray[0]->user_pw))
            {
                return 'Invalid password';
            }

            // ハンドルネームや暗証番号が全部正しい場合
            else
            {
                // この会員番号
                $userNum     =  $userArray[0]->user_no;
                // ログインする時に、必要な会員の情報を返還するメソッド呼び出し
                if($mode == 'web')
                {

                    return UserProfile::loginUserInfoWeb($userNum);
		
                }
                else if($mode == 'unity')
                {

                    return UserProfile::loginUserInfoUnity($userNum);

                }
            }
         }
    }


    // 会員の暗証番号修正
    static public function modifyPassword($userNum, $modifyPassword)
    {

        // 暗証番号のアップデート
        $updatePWResult = DB::table('user_info')->where('user_no', $userNum)
            ->update
            (
                [
                    'user_pw' => bcrypt($modifyPassword), // 비밀번호 암호화
                    'updated_date' => Carbon::now()->format('Y-m-d H:i:s'),
                ]
            );

        if($updatePWResult == 0)
        {
            return "update fail";
        }

        else return "true";
    }
}

?>


