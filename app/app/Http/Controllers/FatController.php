<?php

namespace App\Http\Controllers;

use App\Http\Requests\FatActionRequest;
use App\TableA;
use Illuminate\Support\Facades\Auth;

class FatController extends Controller
{
    //

    public function fatAction(FatActionRequest $request)
    {
        // ログインユーザを取得
        $user = Auth::user();

        // DBへのアクセス＆更新
        $t = TableA::find(1);
        $t->name = 'aaa';
        $t->save();

        // ファイルの保存
        $content = 'test';
        file_put_contents('/tmp/aaa', $content);

        // メール送信

        // レンダリング
        return view('aaa');
    }
}