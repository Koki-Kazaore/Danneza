<?php

namespace App\Http\Controllers;

use App\Models\GoogleUser;
use Carbon\Carbon;
use GuzzleHttp\Client;
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
        // "error"キーが存在するかチェック
        if (array_key_exists("error", $stepsData)) {
            // "error"キーが存在する場合、ログイン画面にリダイレクト
            return redirect()->route('login.google');
        }

        $steps = 0;

        if (isset($stepsData['bucket'][0]['dataset'][0]['point'][0]['value'][0]['intVal'])) {
            $steps = $stepsData['bucket'][0]['dataset'][0]['point'][0]['value'][0]['intVal'];
        }

        // 緯度と経度を設定
        $latitude = '36.12';  // 例: 福井市の緯度
        $longitude = '136.08'; // 例: 福井市の経度

        $client = new Client();
        // Open-Meteo
        $url = "https://api.open-meteo.com/v1/forecast?latitude={$latitude}&longitude={$longitude}&hourly=cloudcover&timezone=Asia%2FTokyo&past_days=3&forecast_days=1";
        // $url = "https://api.open-meteo.com/v1/forecast?latitude={$latitude}&longitude={$longitude}&hourly=temperature_2m";
        
        try {
            $response = $client->get($url);
            $data = $response->getBody()->getContents();
            $weatherData = json_decode($data, true);

            // cloudcoverの抽出
            $cloudcoverData = $weatherData['hourly']['cloudcover'];
            $timeData = $weatherData['hourly']['time'];

            $today = now()->format('Y-m-d');  // 現在の日付を'Y-m-d'形式で取得
            $todayCloudcover = [];

            foreach ($timeData as $index => $time) {
                if (strpos($time, $today) === 0) {  // 時間文字列が今日の日付で始まるかチェック
                    $todayCloudcover[] = $cloudcoverData[$index];
                }
            }

            if (count($todayCloudcover) > 0) {
                $average = array_sum($todayCloudcover) / count($todayCloudcover);
            }

            $points = round($steps * (1 - $average / 100));
            return view('steps', compact('steps', 'points'));
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return response()->json(['error' => 'API request failed: ' . $e->getMessage()]);
        }

        // return view('steps', compact('steps'));
    }
}
