<?php

namespace App\Http\Controllers;

use App\Models\GoogleUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GoogleFitController extends Controller
{
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
