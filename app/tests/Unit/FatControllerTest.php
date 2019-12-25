<?php

namespace Tests\Unit;

use App\FatDbAccess;
use App\Http\Controllers\FatController;
use App\Http\Requests\FatActionRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class FatControllerTest extends \Tests\TestCase
{
    /**
     * @test
     */
    public function fatAction_()
    {
        #
        # 事前状態設定
        #
        // 現在時刻を設定
        Carbon::setTestNow(Carbon::create(2020, 1, 1, 0, 0, 0));

        // ログインユーザを設定
        $user = factory(User::class)->create([
            'name' => 'test-user',
            'email' => 'test@test.test'
        ]);
        Auth::setUser($user);

        // DBのレコードを用意する
        $record = factory(FatDbAccess::class)->create([
            'text' => 'not modified',
        ]);

        // メール送信をモック化する
        $mailHeads = [];
        $mailBody  = [];
        Mail::shouldReceive('send')->andReturnUsing(function ($view, array $data, $callback, $queue = null) use (&$mailHeads, &$mailBody) {
            $mailHeads[] = $message = $this->createMessageMock();
            $callback($message);
            $mailBody[] = view($view['text'], $data)->render();
            return null;
        });

        #
        # 処理実行
        #
        $request = FatActionRequest::create('https://example.com/', 'GET', [
            'new_text' => 'updated'
        ]);
        $controller = new FatController();
        $controller->fatAction($request);

        #
        # 事後状態確認
        #
        // DBのレコードが更新されているか？
        $this->assertDatabaseHas('fat_db_accesses', [
            'text' => 'updated'
        ]);
        // メールが送信されているか？
        $this->assertEquals('test@test.test', $mailHeads[0]->to);
        $this->assertEquals('I\'m fat email!', $mailHeads[0]->subject);
    }

    private function createMessageMock()
    {
        return new class
        {
            public $to;
            public $bcc;
            public $subject;

            public function to($to)
            {
                $this->to = $to;
                return $this;
            }

            public function bcc($bcc)
            {
                $this->bcc = $bcc;
                return $this;
            }

            public function subject($s)
            {
                $this->subject = $s;
                return $this;
            }
        };
    }
}
