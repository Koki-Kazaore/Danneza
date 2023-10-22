<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GoogleUser;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class GoogleFitController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('google')
            ->scopes(['https://www.googleapis.com/auth/fitness.activity.read'])
            ->redirect();
    }

    public function handleProviderCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        // すでに登録されているか確認
        $user = User::whereEmail($googleUser->getEmail())->first();
        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
            ]);
        }

        // google_usersテーブルに情報を保存
        $googleUserData = [
            'user_id' => $user->id,
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
            'token' => $googleUser->token,
            'refresh_token' => $googleUser->refreshToken,
            'expires_at' => Carbon::now()->addSeconds($googleUser->expiresIn)
        ];

        $googleAccount = GoogleUser::updateOrCreate(
            ['user_id' => $user->id],
            $googleUserData
        );

        // ログイン処理
        Auth::login($user, true);
        
        // 歩数データを取得して表示するページにリダイレクト
        return redirect('/steps');
    }

    public function showSteps()
    {
        $user = Auth::user();
        $googleUser = GoogleUser::where('user_id', $user->id)->first();

        // Google Fit APIを使用して歩数データを取得
        // アクセストークンを取得
        $token = $googleUser->token;

        // 今日の日付を取得
        $startTime = Carbon::today()->startOfDay()->timestamp . '000'; // 開始時刻（ミリ秒単位）
        $endTime = Carbon::today()->endOfDay()->timestamp . '000'; // 終了時刻（ミリ秒単位）

        $url = "https://www.googleapis.com/fitness/v1/users/me/dataset:aggregate";

        $body = [
            "aggregateBy" => [
                ["dataTypeName" => "com.google.step_count.delta"]
            ],
            "bucketByTime" => ["durationMillis" => 86400000], // 1日のミリ秒
            "startTimeMillis" => $startTime,
            "endTimeMillis" => $endTime
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json'
        ])->post($url, $body);

        $stepsData = $response->json();

        $steps = 0;

        if (isset($stepsData['bucket'][0]['dataset'][0]['point'][0]['value'][0]['intVal'])) {
            $steps = $stepsData['bucket'][0]['dataset'][0]['point'][0]['value'][0]['intVal'];
        }

        return view('steps', compact('steps'));
    }
}
