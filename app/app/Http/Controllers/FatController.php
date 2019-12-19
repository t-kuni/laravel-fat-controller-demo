<?php

namespace App\Http\Controllers;

use App\FatDbAccess;
use App\Http\Requests\FatActionRequest;
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
//        $user = Auth::user();

        // DBにアクセスする
        $records = FatDbAccess::get(1);
        foreach ($records as $record) {
            $record->name = 'fat-man';
            $record->save();
        }

        // ファイルを保存する
        $content = 'fat-content';
        file_put_contents('/tmp/fat-file.json', json_encode($content));

        // メールを送信する
        Mail::send(['text' => 'fat-email'], ['message' => 'I\'m fat email!'], function($message) {
            $message->to('example@example.com')
                ->subject('I\'m fat email!');
        });

        // レンダリングする
        return view('fat-view');
    }
}
