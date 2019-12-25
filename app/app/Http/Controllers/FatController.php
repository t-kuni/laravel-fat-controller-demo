<?php

namespace App\Http\Controllers;

use App\FatDbAccess;
use App\Http\Requests\FatActionRequest;
use Carbon\Carbon;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class FatController extends Controller
{
    //

    public function fatAction(FatActionRequest $request)
    {
        // ログインユーザを取得する
        $user = Auth::user();

        // 現在日時を取得する
        $now = Carbon::now();

        // DBのデータを更新する
        $records = FatDbAccess::all();
        foreach ($records as $record) {
            $record->text = $request->input('new_text');
            $record->save();
        }

        // ファイルを保存する
        $content = 'fat-content';
        file_put_contents('/tmp/fat-file.json', json_encode($content));

        // メールを送信する
        Mail::send(['text' => 'fat-email'], ['message' => 'I\'m fat email!'], function($message) use ($user) {
            $message->to($user->email)
                ->subject('I\'m fat email!');
        });

        // レンダリングする
        return view('fat-view');
    }
}
