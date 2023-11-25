@extends('layouts.default', ['documentTitle' => __('だんねポイント.com | ダッシュボード')])

@section('content')
<h1 class="title">ダッシュボード</h1>
<div class="dashboard-info">
    <p>今日の歩数: {{ $steps }}歩</p>
    <p>獲得ポイント: {{ $points }}ポイント</p>
    <!-- <p>今日の日照時間: 5時間</p> -->
</div>
@endsection